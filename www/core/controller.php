<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 06.03.15
 * Time: 19:47
 */
abstract class controller extends base
{
    protected $vars = array();
    protected $args;
    protected $system_header;
    protected $header;
    protected $footer;
    protected $system_footer;
    protected $controller_name;
    protected $action_name;
    public  $check_auth;
    protected $scripts = array();

    function __construct($controller, $action)
    {
        registry::set('log', array());
        $this->controller_name = $controller;
        $this->check_auth = $this->checkAuth();
        $this->action_name = $action;
    }

    /**
     * @param string $template
     * @return string
     * @throws Exception
     */

    public function fetch($template)
    {
        $template_file = ROOT_DIR . 'templates' . DS . $template . '.php';
        if(!file_exists($template_file)) {
            throw new Exception('cannot find template in ' . $template_file);
        }
        foreach($this->vars as $k => $v) {
            $$k = $v;
        }
        ob_start();
        @require($template_file);
        return ob_get_clean();
    }

    /**
     * @param string $template
     * @throws Exception
     */

    protected function view($template)
    {
        $this->render('log', registry::get('log'));
        $template_file = ROOT_DIR . 'templates' . DS . $template . '.php';
        if(!file_exists($template_file)) {
            throw new Exception('cannot find template in ' . $template_file);
        }
        $this->render('scripts', $this->scripts);
        foreach($this->vars as $k => $v) {
            $$k = $v;
        }
        if($this->system_header !== false) {
            require_once(!$this->system_header ? ROOT_DIR . 'templates' . DS . 'system_header.php' : ROOT_DIR . 'templates' . DS . $this->system_header . '.php');
        }

        if($this->header !== false) {
            require_once(!$this->header ? ROOT_DIR . 'templates' . DS . 'header.php' : ROOT_DIR . 'templates' . DS . $this->header . '.php');
        }
        if($template_file !== false) {
           require_once($template_file);
        }
        if($this->footer !== false) {
            require_once(!$this->footer ? ROOT_DIR . 'templates' . DS . 'footer.php' : ROOT_DIR . 'templates' . DS . $this->footer . '.php');
        }
        if($this->system_footer !== false) {
            require_once(!$this->system_footer ? ROOT_DIR . 'templates' . DS . 'system_footer.php' : ROOT_DIR . 'templates' . DS . $this->system_footer . '.php');
        }
    }

    /**
     * @param string $template
     * @param bool $parse
     * @throws Exception
     */

    protected function view_only($template, $parse = false)
    {
        $template_file = ROOT_DIR . 'templates' . DS . $template . '.php';
        if(!file_exists($template_file)) {
            throw new Exception('cannot find template in ' . $template_file);
        }
        foreach($this->vars as $k => $v) {
            $$k = $v;
        }
        if($parse) {
            ob_start();
        }
        require_once($template_file);
        if($parse) {
            $tplContent = ob_get_clean();
            echo $this->parseOutput($tplContent);
        }

    }

    abstract function index();
    public function index_na()
    {
        header('Location: ' . SITE_DIR);
    }

    /**
     * @param string $key
     * @param mixed $value
     */

    protected function render($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function not_found() {
        $this->view('404');
    }

    /**
     * @return bool
     */
    protected function checkAuth()
    {
        if($_SESSION['auth']) {
            if ($user = $this->model('user_management')->getByFields(array(
                'user_id' => $_SESSION['user']['user_id'],
                'user_name' => $_SESSION['user']['user_name'],
                'user_passw' => $_SESSION['user']['user_passw']
            ))
            ) {
                registry::set('auth', true);
                registry::set('user', $user);
                return true;
            } else {
                return false;
            }
        } elseif($_COOKIE['auth']) {
            if ($user = $this->model('user_management')->getByFields(array(
                'user_id' => $_COOKIE['user_id'],
                'user_name' => $_COOKIE['user_name'],
                'user_passw' => $_COOKIE['user_passw']
            ))
            ) {
                registry::set('auth', true);
                registry::set('user', $user);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $user
     * @param string $password
     * @param bool $remember
     * @return bool
     */

    protected function auth($user, $password, $remember = false)
    {
        if(!$password) return false;
        if($user = $this->model('user_management')->getByFields(array(
            'user_name' => $user,
            'user_passw' => $password
        ))) {
            if(!$remember) {
                $_SESSION['user']['user_id'] = $user['user_id'];
                $_SESSION['user']['user_name'] = $user['user_name'];
                $_SESSION['user']['user_passw'] = $user['user_passw'];
                $_SESSION['auth'] = 1;
            }
            else {
                setcookie('user_id', $user['user_id'], time() + 3600*24*7);
                setcookie('user_name', $user['user_name'], time() + 3600*24*7);
                setcookie('user_passw', $user['user_passw'], time() + 3600*24*7);
                setcookie('auth', 1, time() + 3600*24*7);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return void
     */

    protected function logOut()
    {
        unset($_SESSION['user']);
        unset($_SESSION['auth']);
        setcookie('user_id', "", time() - 3600);
        setcookie('user_name', "", time() - 3600);
        setcookie('user_passw', "", time() - 3600);
        setcookie('auth', "", time() - 3600);
    }

    public function getDataTable($params, $print = null)
    {
        $search = get_object_vars(json_decode($_REQUEST['params']));
        foreach($search as $k=>$v)
        {
            $params['where'][$k] = array(
                'sign' => $v->sign,
                'value' => $v->value,
            );
            if($v->sign == 'IN') {
                $params['where'][$k]['noquotes'] = true;
            }
        }
        $params['limits'] = isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'].','.$_REQUEST['iDisplayLength'] : '';
        $params['order'] = $_REQUEST['iSortCol_0'] ? $params['select'][$_REQUEST['iSortCol_0']].($_REQUEST['sSortDir_0'] ? ' '.$_REQUEST['sSortDir_0'] : '') : '';
        $res = $this->model('default')->getFilteredData($params, 'clients c');
        if($print) {
            print_r($res);
        }
        $rows['aaData'] = $res['rows'];
        $rows['iTotalRecords'] = $this->model('clients')->countByField();
        $rows['iTotalDisplayRecords'] = $res['count'];
        return($rows);
    }

    /**
     * @param mixed $value
     */

    protected function log($value)
    {
        $log = registry::get('log');
        registry::remove('log');
        $log[] = print_r($value,1);
        registry::set('log', $log);
    }

    /**
     * @param mixed $file_name
     */

    protected function addScript($file_name) {
        if(is_array($file_name)) {
            foreach($file_name as $file) {
                $this->scripts[] = $file;
            }
        } else {
            $this->scripts[] = $file_name;
        }
    }

    protected function tools()
    {
        return tools_class::run();
    }

    /**
     * @param int $day
     * @param array $user
     */

    protected function sendEmail($day, array $user)
    {
        if($data = $this->model('email_data')->getByField('mailing_day', $day)) {
            $this->render('user', $user);
            $this->render('data', $data);
            $email_text = $this->fetch('mails' . DS . $data['template']);
            $this->tools()->mail($data['subject'], $email_text, $user['email'], $user['name']);
            $user['sent'] = $day;
            $user['sdate'] = date('Y-m-d H:i:s');
            $this->model('users')->insert($user);
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 06.03.15
 * Time: 19:34
 */
class index_controller extends controller
{
    public function index()
    {
        if(isset($_POST['sign_in_btn'])) {
            $user['id'] = $this->model('users')->insert($_POST['user']);
            $this->sendEmail(0, $user);
            setcookie('auth', 3600 * 28);
            setcookie('user_id', $user['id']);
        }
        if(!$this->auth) {
            $this->view_only('sign_in_page');
        } else {
            $this->render('skip_nav', true);
            $this->view('index');
        }
    }
}
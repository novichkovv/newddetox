<header class="navbar navbar-fixed-top docs-nav" id="top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo SITE_DIR; ?>"><img src="<?php echo SITE_DIR; ?>images/logo.png" /></a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12 text-right">
                    <h3 style="color: #666; margin: 10px;">Questions About the Detox?<br>
                        Call <span style="color: black; font-size: 30px;">407-732-6952<span></h3>
                </div>
            </div>
        </nav>
    </div>
</header>
<div id="page-container">
    <?php if(!$skip_nav): ?>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav" style="margin: 0 auto;">
                        <li><a href="<?php echo SITE_DIR; ?>">Home</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>ebook/">E-Booklet</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>recipes/soups/">Soup Recipes</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>recipes/salads/">Salad Recipes</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>recipes/smoothies/">Smoothie Recipes</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>tips/">Tips</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>

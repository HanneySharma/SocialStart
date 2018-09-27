<?php $cakeDescription = 'Socialstarts'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <link rel="shortcut icon" href="<?php echo $this->Url->build('/') ?>favicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $cakeDescription ?>:<?= $this->fetch('title') ?></title>
    <!-- Bootstrap -->
    <?= $this->Html->css('bootstrap/dist/css/bootstrap.min.css') ?>
    <!-- Font Awesome -->
    <?= $this->Html->css('font-awesome/css/font-awesome.min.css') ?>
    <!-- NProgress -->
    <?= $this->Html->css('nprogress/nprogress.css') ?>
    <!-- bootstrap-daterangepicker -->
    <?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css') ?>
    <!-- Custom Theme Style -->
    <?= $this->Html->css('build/custom.min.css') ?>
    <!-- Theme built by team -->
    <?= $this->Html->css('animate.css/animate.min.css') ?>
    <!-- Theme built by team -->
    <?= $this->Html->css('socialstarts.css') ?>
  </head>
  <body class="login">
    <div class="login-left-div">
    <?php echo $this->Html->image('login_logo.png', ['class'=>'logo_left', 'alt' => 'CakePHP']);?>
    </div>
    <div class="login-right-div">
        <div class="login_wrapper">
          
        </div>
          <?= $this->Flash->render('resendemail') ?>
        <div class="login_wrapper">
          <?= $this->fetch('content') ?>
        </div>
    </div>

    <?= $this->Html->script('/js/jquery/dist/jquery.min.js');?>
    <?= $this->Html->script('/js/jquery-validation/dist/jquery.validate.min.js');?>
    <?= $this->Html->script('/js/front.js');?>
  </body>
</html>

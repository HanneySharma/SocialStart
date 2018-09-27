<?php
$cakeDescription = 'Socialstarts';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
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
        <style type="text/css">
        .login_wrapper h5 {
          text-align: center;
          color: #fff;
        }
        </style>
  </head>

  <body class="login">
    <div>
        <div class="login_wrapper">
        <h1><?php echo $this->Html->image('login_logo.png', ['class'=>'logo_left', 'alt' => 'CakePHP']);?></h1>
        <h5>Welcome to Tiresias V 1.0</h5> 
        </div>
      
      <?= $this->Flash->render('resendemail') ?>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php
            echo  $this->Flash->render();
            echo $this->Form->create(NULL, ['url' => ['action' => '/login/'], 'role' => 'form', 'label' => false]);
            ?>
      
              <h1>Login Form</h1>
              <div>
                <?php echo $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Username', 'type' => 'email', 'required' => true, 'label' =>false]);?>
              </div>
              <div>
                <?php echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true, 'label' =>false ]);?>
              </div>
              <div class="checkbox">
                    
              </div>
              <div>
                    <?php
                    echo $this->Form->submit('Log in', ['class' => 'login_button']);
                    echo '<label class="socialstarts_padding_login"><input type="checkbox"> Remember me</label>';
                    
                    ?>
              </div>
              <div class="socialstarts_marginleftnil">
                  <?php 
                    echo $this->Html->link(
                            'Lost your password?',
                            '/users/forgotpassword',
                            ['class' => 'reset_pass']
                        );
                    ?>
              
              </div>
              <div class="clearfix"></div>

              <div class="separator">

                  <div class="footer_text">
                  <p>©<?php echo date('Y');?> All Rights Reserved.</p>
                </div>
              </div>
            <?php echo $this->Form->end();?>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>


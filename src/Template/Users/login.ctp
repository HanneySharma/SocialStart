<div class="animate form login_form">
  <section class="login_content">
    <?php
    echo  $this->Flash->render();
    echo $this->Form->create(NULL, ['id'=>'login','url' => ['action' => '/login/'], 'role' => 'form', 'label' => false,'novalidate'=>true]);
    ?>
    <h1 class="welcome">Welcome to Tiresias V 1.4</h1>
    <h1 class="login-text">Login Form</h1>
    <?php echo $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Username', 'type' => 'email', 'required' => true, 'label' =>false]);?>
    <?php echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true, 'label' =>false ]);?>

    <div class="checkbox"></div>

    <?php echo '<label class="socialstarts_padding_login"><input type="checkbox"> Remember me</label>'; ?>
    <div class="main_login">
      <div class="socialstarts_marginleftnil">
          <?php echo $this->Html->link('Lost your password?','/users/forgotpassword',['class' => 'reset_pass']);?>
      </div>
      <?php echo $this->Form->submit('Log in', ['class' => 'login_button']);?>
    </div>
    <?php echo $this->Form->end();?>
  </section>
</div>
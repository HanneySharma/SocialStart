<div class="animate form login_form">
    <section class="login_content">
        <?php
        echo  $this->Flash->render();
        echo $this->Form->create(NULL, ['id'=>'resetpassword','url' => ['action' => 'resetpassword',$token], 'role' => 'form', 'label' => false,'novalidate'=>true]);?>
        <h1>Reset Password</h1>
        <div>
        <?php
        echo $this->Form->input('confirm_password', [
                  'class' => 'form-control',
                  'placeholder' => 'Confirm Password',
                  'type' => 'password',
                  'required' => true,
                  'label' =>false
            ]);?>

        </div>
        <div>
        <?php
        echo $this->Form->input('password', [
                  'class' => 'form-control',
                  'placeholder' => 'Password',
                  'type' => 'password',
                  'required' => true,
                  'label' =>false
            ]);?>
        </div>
        <div class="checkbox"></div>
        <div class="main_login">
            <?php echo $this->Form->submit('Reset', ['class' => 'login_button']); ?>
        </div>
        <div class="clearfix"></div>
        <div class="separator">
            <div class="footer_text">
                <p>© <?php echo date('Y');?> All Rights Reserved.</p>
            </div>
        </div>
        <?php echo $this->Form->end();?>
    </section>
</div>
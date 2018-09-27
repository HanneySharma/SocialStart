<div class="animate form login_form">
    <section class="login_content">
        <?php
        echo  $this->Flash->render();
        echo $this->Form->create(NULL, ['id'=>'forgotpassword','url' => ['action' => 'forgotpassword'], 'role' => 'form', 'label' => false,'novalidate'=>true]);?>
        <h1>Forget Password</h1>
        <div class="col-md-12">
          <?php echo $this->Form->input('email',['class' =>'form-control','placeholder'=>'Email','type'=>'email','required'=>true,'label'=>false]);?>
        </div>
        <div class="checkbox"></div>
        <div>
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
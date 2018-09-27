<?php
    echo $this->Html->css('vendors/datapickerwatch/bootstrap-material-datetimepicker');
    echo $this->Html->script('vendors/datapickerwatch/moment-with-locales.min');
    echo $this->Html->script('vendors/datapickerwatch/bootstrap-material-datetimepicker');
?>
<div class="x_panel">
<div class="x_content">
    <?= $this->Flash->render() ?>
    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Security</a>
          </li>
          <!--<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Cron Settings</a>
          </li> -->         
        </ul>
        <div id="myTabContent" class="tab-content">
          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                <!-- start form password change -->
                <?php
                echo $this->Form->create(NULL, ['url' => ['action' => '/settings/'], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false, 'name' => 'password_change', 'id' => 'password_change', 'data-parsley-validate']);
                ?>
                
                
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $this->Form->password('current_password', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->password('password', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
				
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm New Password <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->password('confirm_password', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                   
</div>
					
				
                    <div class="form-group">
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
                            <?php echo $this->Form->button('Submit', ['name'=>'submit_password_change', 'value'=>'password_change','div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>               
                        </div>
                    </div>

                <?php echo $this->Form->end();?>
                <!-- end form for password change -->

        
          </div>
          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                <div id="divUpdate">
                    <?php echo $this->element('users/settings');?>   
                </div>                    
          </div>        </div>    
        </div></div>
    </div>

<!-- start form for setting cron-->
<?php
echo $this->Form->create($cron_settings, ['url' => ['controller'=>'users','action' => 'settings'], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false, 'id' => 'cron_settings', 'data-parsley-validate', 'method'=>'post']);
?>
    <div class="col-xs-12 text-center"><h4>Cron will run on 11:30 pm for selected days</h4></div>
    <div class="ln_solid"></div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php
            $services = ['CrunchBase' => 'CrunchBase','BaseCRM' => 'BaseCRM','NewsEmail'=>'NewsEmail','ProductHunt'=>'ProductHunt'];
            echo $this->Form->select('service_type', $services, ['id'=>'service_type','default' => $servicve_type, 'class' => 'form-control']);
            ?>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Day <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
           <?php echo $this->Form->input('week_day',['id' => 'daysOfWeek']); ?>           
        </div>
    </div>
   <!--  <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Select Hour <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-6">
        <?php echo $this->Form->input('time_hour',['id' => 'rangeHour']); ?>
        </div>        
    </div>
    <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Select Min <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-6">
        <?php echo $this->Form->input('time_minute',['id' => 'rangeTime']); ?>
        </div>
    </div> -->
    <div class="ln_solid"></div>

    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
            <?php echo $this->Form->button('Submit', ['name'=>'submit_cron_settings', 'value'=>'cron_settings', 'div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>               
        </div>
    </div>

<?php echo $this->Form->end();?>
<!-- end form for setting cron -->

<div class="page-title">
  <div class="title_left"><h3>Transom Detail</h3></div>
  <div class="title_right">
    <?php  echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Transom List',['controller' => 'users','action' =>'transom'],['class' => 'btn btn-success pull-right','escape' => false] ); ?>
  </div>       
</div>
<div class="clearfix"></div>
<div class="x_panel">
  <div class="x_content">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-12" style="text-align: center;">
        <div>
          <span class="img-circle img-responsive">
            <?php 
            $acronym = "NA";
            if(!empty($transom['company'])){
              $acronym = "";
              $words = explode(" ", $transom['company']);
              foreach ($words as $w) {
                if(isset($w[0])){
                  $acronym .= $w[0];
                }
              }
            }
            echo $acronym;
            ?>
          </span>
        </div>
        <h1 title="<?php echo $transom['name']; ?>" class="head-logo-name" ><?php echo $transom['company']; ?></h1>
      </div>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <div id="smainb" style="">
          <div class="project_detail">
            <h3>Information</h3>
            <p class="col-sm-6 col-xs-12 "><i class="fa fa-user"></i><?php echo $transom['name'];  ?></p>
            <p class="col-sm-6 col-xs-12 "><i class="fa fa-envelope"></i>Email: <?php echo $transom['email'];  ?></p>
            <p class="col-sm-6 col-xs-12 "><i class="fa fa-phone"></i>Contact: <?php echo (!empty($transom['contact']))? $transom['contact'] : 'N/A';  ?></p>
            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-bell"></i>Vertical: <?php  echo (!empty($transom['vertical']))? $transom['vertical'] : 'N/A'; ?></p>
            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-flag"></i>Founded: <?php  echo (!empty($transom['founded']))? date('d/m/Y', strtotime($transom['founded'])) : 'N/A'; ?></p>
            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-credit-card"></i>Funds Raised: <?php  echo (!empty($transom['funds_raised'])) ? $transom['funds_raised'] : 'N/A'; ?></p>
            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-eye"></i>Revenue: <?php  echo (!empty($transom['revenue']))? $transom['revenue'] : 'N/A'; ?></p>
            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-users"></i>Contact On: <?php  echo date('d/m/Y h:i A', strtotime($transom['submitted_on'])) ?></p>
            <p  class="col-sm-12 col-xs-12 "><i class="fa fa-globe"></i>Source: Contact Form</p>
            <br/>
          </div>
        </div>
      </div>
        <div class="clearfix"></div>
        <hr/>
        <p class="col-sm-12 col-xs-12 "><?php echo nl2br($transom['message']); ?></p> 
    </div>
  </div>
</div>

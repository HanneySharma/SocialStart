<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Socialstarts';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <link rel="shortcut icon" href="<?php echo $this->Url->build('/') ?>favicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $cakeDescription ?> : <?php if(isset($title_update) && !empty($title_update) && ($title_update=='Manage Filter' || $title_update=='Manage Date Format' || $title_update=='Reading List'  || $title_update=='Manage Categories' || $title_update=='Setting' || $title_update=='Dashboard' || $title_update=='Business Intelligence' || $title_update=='Processed Leads')){
        echo $title_update;
    }
    else {
         echo $this->fetch('title');
    }
    
   ?></title>
    <?php
        echo $this->Html->css('bootstrap/dist/css/bootstrap.min.css');
        echo $this->Html->css('font-awesome/css/font-awesome.min.css');
        echo $this->Html->css('nprogress/nprogress.css');
        echo $this->Html->css('bootstrap-daterangepicker/daterangepicker.css');
        echo $this->Html->css('build/custom.min.css');
        echo $this->Html->css('socialstarts.css');
        echo $this->Html->css('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
        echo $this->Html->css('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
        echo $this->Html->css('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');
        echo $this->Html->css('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
        echo $this->Html->css('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');    
        echo $this->Html->css('custom');  
       //css for multi select
        echo $this->Html->css('style');  
        echo $this->Html->css('chosen');  
        //end of css
        echo $this->Html->css('../js/vendors/pnotify/dist/pnotify');  
        echo $this->Html->script('jquery/dist/jquery.min');  
        echo $this->Html->script('vendors/sweetalert/sweetalert.min');  
        echo $this->Html->css('vendors/sweetalert/sweetalert');  
    ?>
<style>
    .notificatonsCon {width: 600px;position: fixed;left: 50%;z-index: 99;margin-left: -175px;}
    .ui-pnotify-closer, .ui-pnotify-sticker {float: right;margin-left: 0.2em;}
    .ui-pnotify-icon, .ui-pnotify-icon span {display: block;float: left;margin-right: 0.2em;}
    .alert1 h4 {color: inherit;margin-top: 0;}
    .ui-pnotify-title {display: block;margin-bottom: 0.4em;margin-top: 0;}
    .alert1 {border: 1px solid transparent;border-radius: 4px;margin-bottom: 20px;padding: 15px;}
    .nav.side-menu small {padding-left: 30px;}
    .ui-pnotify-closer {cursor: pointer;}
</style>
<script>
var siteURL = '<?php echo $siteURL;?>';
</script>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <?php echo $this->Html->image('00_socialstarts_logo_black.png', ['class'=>'logo_left', 'alt' => 'CakePHP']);?>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                    <?php 
                  if(isset($loggeinuserdata['avtar']) && !empty($loggeinuserdata['avtar']) ){
                    echo $this->Html->image('../avtar/'.$loggeinuserdata['avtar'], ['class'=>'img-circle profile_img','alt' => $loggeinuserdata['name']]);
                  } else {
                    echo $this->Html->image('no-image-icon.png', ['class'=>'img-circle profile_img','alt' => $loggeinuserdata['name']]);
                  }
                  
                  ?>      
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $loggeinuserdata['name'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                
                <ul class="nav side-menu">
                  
                  <!-- <li> <?php // echo $this->Html->link('<i class="fa fa-dashboard"></i> Dashboard', '/users/dashboard', array('escape'=>false,'title'=>'Dashboard') ); ?>
                  </li> -->
                  <li><?php echo $this->Html->link( '<i class="fa fa-newspaper-o"></i> Leads', '/organizations/index', array('escape'=>false,'title'=>'Organizations') );?></li>

                  <!-- <li> <?php // echo $this->Html->link( '<i class="fa fa-binoculars"></i> Transom',['controller' => 'Users','action' => 'transom'], array('escape'=>false,'title'=>'Transom') ); ?></li> -->
                 <?php 
                      if($this->request->session()->read('Auth.Admin.role') == 1){
                  ?>
                  <li> <?php echo $this->Html->link( '<i class="fa fa-bookmark-o"></i> Portfolio Companies',['controller' => 'Users','action' => 'portfolio_companies'], array('escape'=>false,'title'=>'Portfolio Companies ') ); ?></li>

                 <li> <?php echo $this->Html->link( '<i class="fa fa-user-secret"></i> Business Intelligence <br><small>Next Phase</small>',['controller' => 'Users','action' => 'businessIntelligence'], array('escape'=>false,'title'=>'Business Intelligence ') ); ?></li>
                 <li><?php echo $this->Html->link( '<i class="fa fa-spotify"></i> Sales Funnel <br><small>Next Phase</small>',['controller' => 'Organizations','action' => 'processed_leads'], array('escape'=>false,'title'=>'Categories') ); ?> </li>
                  
                  <li><?php echo $this->Html->link( '<i class="fa fa-resistance"></i> Opportunities<br><small>Next Phase</small>',['controller' => 'Opportunities','action' => 'index'], array('escape'=>false,'title'=>'Categories') ); ?> </li>

                  <li><?php echo $this->Html->link('<i class="fa fa-asl-interpreting"></i> Run Cron',['controller' => 'Organizations','action' =>'cronRun'],['escape'=>false,'title'=>'Cron','target' => '__blank','id' => 'CronRunAnchor']); ?></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <?php
                if($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'businessIntelligence'){
              ?>
              <div class="notificatonsCon">
              <div class="ui-pnotify  ui-pnotify-fade-normal ui-pnotify-in ui-pnotify-fade-in ui-pnotify-move"  aria-live="assertive" aria-role="alertdialog"><div class="alert1 ui-pnotify-container alert-success ui-pnotify-shadow"><div class="ui-pnotify-closer" aria-role="button" tabindex="0" title="Close"><span class="glyphicon glyphicon-remove"></span></div><div class="ui-pnotify-icon"><span class="glyphicon glyphicon-star-empty"></span></div><h4 class="ui-pnotify-title">Opportunity</h4><div class="ui-pnotify-text" aria-role="alert"> FaceBook inc. seems to be an interesting opportunity to invest. They recently closed a deal with xyz company of 15 million dollars. </div></div></div>
              </div>
              <?php } ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                   <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php
                     if(isset($loggeinuserdata['avtar']) && !empty($loggeinuserdata['avtar']) ){
                    echo $this->Html->image('../avtar/'.$loggeinuserdata['avtar'], ['alt' => $loggeinuserdata['name']]);
                  } else {
                    echo $this->Html->image('no-image-icon.png', ['alt' => $loggeinuserdata['name']]);
                  }
                    echo $loggeinuserdata['name'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">  
                    <li>
                      <?php echo $this->Html->link('<i class="fa fa-edit"></i> Edit Profile', array('controller' =>'users','action' =>'profile'), array('escape' => false)); ?> 
                    </li>
                   <li>
                        <?php echo $this->Html->link('<i class="fa fa-user"></i> Reading List',['controller' => 'Users','action' => 'reading_list'],array('escape'=>false,'title'=>'Users Management')); ?>
                  </li>
                     <?php 

                  if($this->request->session()->read('Auth.Admin.role') == 1){

                  ?>
                  <li> <?php echo $this->Html->link( '<i class="fa fa-list"></i> Verticals', '/users/categories', array('escape'=>false,'title'=>'Categories') );?>
                  </li>

                   <li>
                        <?php echo $this->Html->link('<i class="fa fa-user"></i> Users Management',['controller' => 'Users','action' => 'index'],array('escape'=>false,'title'=>'Users Management')); ?>
                  </li> 
                    <li>
                      <?php echo $this->Html->link( '<i class="fa fa-filter"></i> Manage Filters', '/users/add-filter', array('escape'=>false,'title'=>'Manage Filters')); ?>
                      
                  </li>
                  <li><?php echo $this->Html->link( '<i class="glyphicon glyphicon-import"></i> Import Pitch Book Leads', '/organizations/import-upload', array('escape'=>false,'title'=>'Organizations') );?></li>
                 
                
                  <?php }
                   
                  ?> 
                <li>
                      <?php echo $this->Html->link( '<i class="fa fa-calendar"></i> Manage Date Format', '/users/add-date', array('escape'=>false,'title'=>'Manage Date Format')); ?>
                      
                  </li>
                  
                   <li>
                      <?php echo $this->Html->link( '<i class="fa fa-cog"></i> Settings', '/users/settings', array('escape'=>false,'title'=>'Settings')); ?>
                      
                  </li>
                    <li>
                        <?php echo $this->Html->link('<i class="fa fa-sign-out"></i> Log Out', array('controller' =>'users','action' =>'logout'), array('escape' => false)); ?> 
                    </li>
                  </ul>
                </li>

                
              </ul>
                
              <span style="position: absolute;top: 20px; color:#5C90BA;">Current Date: <strong><?php 
                if($dataformat==3){
                    echo  date('l d-m-Y');
                }
                else if($dataformat==2){
                    echo  date('l Y-m-d');
                }
                else if($dataformat==1){
                    echo  date('l m-d-Y');
                }
               else {
                   echo  date('l d-m-Y');
               }
              
              ?></strong></span>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
       
                <?php echo $this->fetch('content') ?>
            </div>
        </div>
        <!-- /page content -->


<!-- footer content -->
        <footer>
          <div class="pull-right">
              Copyright © <?php echo date('Y'); ?> Social Starts. All rights reserved.
          
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->

    <?php
  
    //for muti select js
    echo $this->Html->script('chosen.jquery');
    echo $this->Html->script('prism');
    echo $this->Html->script('init');
    
    //Bootstrap 
    echo $this->Html->script('bootstrap/dist/js/bootstrap.min');
    //FastClick
    echo $this->Html->script('fastclick/lib/fastclick');
    //NProgress
    echo $this->Html->script('nprogress/nprogress');  
    //Chart.js 
    echo $this->Html->script('Chart.js/dist/Chart.min');
    //jQuery Sparklines 
    echo $this->Html->script('jquery-sparkline/dist/jquery.sparkline.min');
    //Flot 
    echo $this->Html->script('Flot/jquery.flot');
    echo $this->Html->script('Flot/jquery.flot.pie');
    echo $this->Html->script('Flot/jquery.flot.time');
    echo$this->Html->script('Flot/jquery.flot.stack');
    echo $this->Html->script('Flot/jquery.flot.resize');
    //Flot plugins 
    echo $this->Html->script('flot.orderbars/js/jquery.flot.orderBars');
    echo $this->Html->script('flot-spline/js/jquery.flot.spline.min');
    echo $this->Html->script('flot.curvedlines/curvedLines');
    //DateJS 
    echo $this->Html->script('DateJS/build/date');
    //bootstrap-daterangepicker 
    echo $this->Html->script('moment/min/moment.min');
    echo $this->Html->script('bootstrap-daterangepicker/daterangepicker');    
    //Custom Theme Scripts 
    echo $this->Html->script('socialstarts');
    echo $this->Html->script('custom');
    echo $this->Html->css('../rangeSlider/css/rangeSlider');
    echo $this->Html->css('../rangeSlider/css/rangeSlider.skinFlat');
    echo $this->Html->script('../rangeSlider/js/rangeSlider');
    echo $this->Html->script('custom.min');  
    echo $this->Html->script('validator');  
    echo $this->Html->script('form-validations');
  
    //Datatables
    echo $this->Html->script('vendors/datatables.net/js/jquery.dataTables.min');
    echo $this->Html->script('vendors/datatables.net-bs/js/dataTables.bootstrap.min');
    echo $this->Html->script('vendors/datatables.net-buttons/js/dataTables.buttons.min');
    echo $this->Html->script('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min');
    echo $this->Html->script('vendors/datatables.net-buttons/js/buttons.flash.min');
    echo $this->Html->script('vendors/datatables.net-buttons/js/buttons.html5.min');
    echo $this->Html->script('vendors/datatables.net-buttons/js/buttons.print.min');
    echo $this->Html->script('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min');
    echo $this->Html->script('vendors/datatables.net-keytable/js/dataTables.keyTable.min');
    echo $this->Html->script('vendors/datatables.net-responsive/js/dataTables.responsive.min');
    echo $this->Html->script('vendors/datatables.net-responsive-bs/js/responsive.bootstrap');
    echo $this->Html->script('vendors/datatables.net-scroller/js/dataTables.scroller.min');    
    ?>    
    <script type="text/javascript">
      
      $(document).on('click','#CronRunAnchor', function(evt){
        evt.preventDefault();
        if(confirm('Are you sure to run manually cron?')){
          var siteURL = '<?php echo $siteURL;?>';
          siteURL = siteURL.toString().slice(0,-1);
          var win = window.open(siteURL+$(this).attr('href'), '_blank');
          if (win) {
              win.focus();
          }
        }
      });





     $('.country_filter').on('change',function() {
        
        var val =$(this).val();
        ajaxPagination('index','paginationCountChange',val);
        
    });
     
     
    function ajaxPagination(ajaxURL, typepage,val) {
        
    
       
        if (typeof(typepage)==='undefined') typepage = '';

        if(typepage == 'paginationCountChange'){
            var paginationCountChange = $('#pageListCount option:selected').val();
            var searchtext = $("#search_text").val();
            var sortstr = $("#sortstr").val();
            var country = $("#country").val();
            var funding_type = $("#funding-type").val();
            var source = $("#source").val();
            var verticals = $(".verticals_text").val();
            var recently_funded = $("#recently-funded").val();
            var funding_type_any = $("#funding-type-any").val();
            var directionstr = $("#directionstr").val();
            var timeStamp = Math.floor(Date.now() / 1000);
            var isString = 0;
            val=$(".country_filter").val();
            var filter_type = $("#any").val();
           
            
            if(paginationCountChange != ""){
                isString = 1;
                ajaxURL = ajaxURL + '?paginationCountChange='+paginationCountChange;
            }else{
                ajaxURL = ajaxURL + '?const='+timeStamp;
            }
            
            if(searchtext != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&searchstring='+searchtext;
            }
            
       
            if(sortstr != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&sort='+sortstr;
            }
            
            if(directionstr != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&direction='+directionstr;
            }  
            
            if(isString){
                ajaxURL = ajaxURL + '&const='+timeStamp;
            }
           
             
         }
          if(country){
                ajaxURL = ajaxURL + '&country='+country;
            }
            if(source){
                ajaxURL = ajaxURL + '&source='+source;
            }
            if(verticals){
                ajaxURL = ajaxURL + '&verticals='+verticals;
            }
            if(recently_funded){
                ajaxURL = ajaxURL + '&recently_funded='+recently_funded;
            }
            if(funding_type){
                 ajaxURL = ajaxURL + '&funding_type='+funding_type;
            }
          
            if(val){
                 ajaxURL = ajaxURL + '&funding_type_any='+val;
            }
            if(filter_type>0){
                 ajaxURL = ajaxURL + '&filter_type='+filter_type;
            }
            else if(filter_type!='' &&  filter_type==0) {
                 ajaxURL = ajaxURL + '&filter_type=any';
            }
       
       
            
            
           
            
        if(typepage == 'search' || typepage == 'delete'){
            var paginationCountChange = $('#pageListCount option:selected').val();
            var searchtext = $("#search_text").val();
            var sortstr = $("#sortstr").val();
            var directionstr = $("#directionstr").val();
            var timeStamp = Math.floor(Date.now() / 1000);

            var isString = 0;
            
            if(searchtext != ""){
                isString = 1;
                ajaxURL = ajaxURL + '?searchstring='+searchtext;
            }else{
                ajaxURL = ajaxURL + '?const='+timeStamp;
            }
            
            if(paginationCountChange != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&paginationCountChange='+paginationCountChange;
            }
       
            if(sortstr != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&sort='+sortstr;
            }
            
            if(directionstr != ""){
                isString = 1;
                ajaxURL = ajaxURL + '&direction='+directionstr;
            }  
            
            
            if(isString){
                ajaxURL = ajaxURL + '&const='+timeStamp;
            }
             
         }
         
            $.ajax({
                url: ajaxURL,
                beforeSend: function(){
                       $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
                   },
                success :  function(data){
                    $("#divUpdate").html(data);  
                    $('#UploadOnBaseCRM').show();
                    $('#UploadOnBaseCRMbutton').hide();
                }
            })
        }

        $(document).on('click','.ui-pnotify-closer', function(){
            $(this).parents('.ui-pnotify').fadeOut('slow');
        });
</script>
  </body>
</html>

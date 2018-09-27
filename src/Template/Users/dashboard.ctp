 <div class="clearfix"></div>
 <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
              <!--<div class="dashboard_graph">-->
 <div class="x_panel tile">
                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Inbound Leads</h3>
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i><span></span> <b class="caret"></b>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
                  <input id="crunchBaseCount" type="hidden" value="<?php echo isset($sourceCount['crunchbase'])? $sourceCount['crunchbase'] : 0; ?>">
                  <input id="pitchBaseCount" type="hidden" value="<?php echo isset($sourceCount['pitchbase'])? $sourceCount['pitchbase'] : 0 ; ?>">
                </div>
            </div>
            </div>   <!--</div>-->           
             <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile">
                <div class="x_title">
                  <div class="col-md-6">
                  <h2>Votes Cast This Week</h2>
                  </div>
                  <div class="col-md-6">
                   
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                    <div class="sidebar-widget gauge">
                        <div class="goal-wrapper-head" id="userTotalComments"><?php echo $organiationCmt; ?></div>
                        <canvas id="chart_gauge_01" class="" height="191"></canvas>
                        <div class="goal-wrapper">
                          <span id="gauge-text" class="gauge-value pull-left" >0</span>
                          <span class="gauge-value pull-left" ></span>
                          <span id="goal-text" class="goal-value pull-right"><?php echo $organiation; ?> </span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            </div>
           
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12" id="voteUpDown">
              <div class="x_panel tile  overflow_hidden">
                <div class="x_title">
                  <h2>Votes UP / Down <small>Per Month</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table class="" style="width:100%">
                    <tr>
                      <td>
                        <canvas class="canvasDoughnut" height="234" width="234" style="margin: 15px 10px 10px 0"></canvas>
                      </td>
                      <td>
                        <table class="tile_info">
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Votes UP </p>
                            </td>
                            <td id="upVotesCount"><?php echo $upVote; ?></td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square red"></i>Votes Down </p>
                            </td>
                            <td id="downVotesCount"><?php echo $downVote; ?></td>
                          </tr>                         
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">Note*: This Show Total Votes Up/Down based on Current User.</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
           

                <div class="col-md-6 col-sm-12 col-xs-12" id="ReadingList">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Reading List</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><span class="pull-right"><?php echo $this->Html->link('Read All',['controller' => 'Users','action' => 'readingAllList']); ?></span></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                    <div class="">
                        <ul class="to_do">
                        <?php
                        if(!empty($ReadingList)){
                          foreach ($ReadingList as $key => $list) {
                           @$tagsMeta = get_meta_tags($list['link']);
                            ?>
                            <li><h2><a title="<?php echo $list['link']; ?>" href="<?php echo $list['link']; ?>" target="_blank"><?php echo $list['title']; ?></a></h2>
                            <?php
                            if(!empty($tagsMeta) && isset($tagsMeta['description'])){
                              ?>
                              <p> <?php echo $tagsMeta['description']; ?></p>
                              <?php
                            }
                            ?>
                            <p></p>
                            <p>Added By: <strong><?php echo ucfirst($list['user']['name']); ?> </strong> On <?php 
                             
                               if($dataformat==3){
                                                 $date_added =  date('l d-m-Y',strtotime($list['created']));
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d',strtotime($list['created']));
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y',strtotime($list['created']));
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y',strtotime($list['created']));
                                                }
                                        echo $date_added; 
                            ?></p></li>
                            <?php
                          }
                        } else {
                          ?>
                          No Record Found.
                          <?php 
                        }
                        ?>
                        
                   
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
             
             
             
               </div>
          <div class="row">
             
             
            
             
        <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
                    <div class="x_title">
                      <h2>Clocks</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
           <div class="col-md-2"><div id="clock1"></div></div>    
           <div class="col-md-2"><div id="clock2"></div></div>    
           <div class="col-md-2"><div id="clock3"></div></div>    
           <div class="col-md-2"><div id="clock4"></div></div>    
           <div class="col-md-2"><div id="clock5"></div></div>
           <div class="col-md-2"><div id="clock6"></div></div>
        </div>
        </div>
        </div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>SOCIAL STARTS INVESTMENT AREAS OF FOCUS</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
          if($this->request->Session()->read('Auth.Admin.role') == 1){
            ?>
            <div class="col-md-12">
              <textarea id="theses" class="ckeditor"><?php echo (!empty($theses)) ? $theses['theses'] : ''; ?></textarea>
              <button id="addTheses" class="btn btn-success pull-right" style="margin-top:20px;">Save</button>
            </div>
          <?php } else {
            if(!empty($theses)){
              echo $theses['theses'];
      
               
                               if($dataformat==3){
                                                 $date_added =  date('l d-m-Y H:i A' ,strtotime($theses['created']));
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d H:i A',strtotime($theses['created']));
                                                }
                                                else if($dataformat==1){ 
                                                $date_added =  date('l m-d-Y H:i A',strtotime($theses['created']));
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y H:i A',strtotime($theses['created']));
                                                }
                                        
              echo "<p> Added On : <strong>".$date_added."</strong></p>";
            } else {
              echo "No Record Found";
            }
          }
         ?>          
      </div>
    </div>
  </div>
</div>


                </div>

            <!-- <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Leads <small>geo presentation</small> (May be For Next Phase)</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="dashboard-widget-content">
                        <div class="col-md-4 hidden-small">
                          <h2 class="line_30">125.7k Views from 60 countries</h2>

                          <table class="countries_list">
                            <tbody>
                              <tr>
                                <td>United States</td>
                                <td class="fs15 fw700 text-right">33%</td>
                              </tr>
                              <tr>
                                <td>France</td>
                                <td class="fs15 fw700 text-right">27%</td>
                              </tr>
                              <tr>
                                <td>Germany</td>
                                <td class="fs15 fw700 text-right">16%</td>
                              </tr>
                              <tr>
                                <td>Spain</td>
                                <td class="fs15 fw700 text-right">11%</td>
                              </tr>
                              <tr>
                                <td>Britain</td>
                                <td class="fs15 fw700 text-right">10%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
                      </div>
                    </div>
                  </div>
                </div> 
                </div>-->

                 <!-- start of weather widget -->
              <?php
   echo $this->Html->script('vendors/fastclick/lib/fastclick');
    echo $this->Html->script('vendors/nprogress/nprogress');
    echo $this->Html->script('vendors/Chart.js/dist/Chart.min');
    echo $this->Html->script('vendors/gauge.js/dist/gauge.min');
    echo $this->Html->script('vendors/bootstrap-progressbar/bootstrap-progressbar.min');
    echo $this->Html->script('vendors/iCheck/icheck.min');
    echo $this->Html->script('vendors/skycons/skycons');
    echo $this->Html->script('vendors/Flot/jquery.flot');
    echo $this->Html->script('vendors/Flot/jquery.flot.pie');
    echo $this->Html->script('vendors/Flot/jquery.flot.time');
    echo $this->Html->script('vendors/Flot/jquery.flot.stack');
    echo $this->Html->script('vendors/Flot/jquery.flot.resize');
    echo $this->Html->script('vendors/flot.orderbars/js/jquery.flot.orderBars');
    echo $this->Html->script('vendors/flot-spline/js/jquery.flot.spline.min');
    echo $this->Html->script('vendors/flot.curvedlines/curvedLines');
    echo $this->Html->script('vendors/DateJS/build/date');
    echo $this->Html->script('vendors/jqvmap/dist/jquery.vmap');
    echo $this->Html->script('vendors/jqvmap/dist/maps/jquery.vmap.world');
    echo $this->Html->script('vendors/jqvmap/examples/js/jquery.vmap.sampledata');
    echo $this->Html->script('vendors/moment/min/moment.min');
    echo $this->Html->script('vendors/bootstrap-daterangepicker/daterangepicker');
    /*echo $this->Html->script('FeedEk');
    echo $this->Html->script('FeedEk');*/
  echo $this->Html->css('jClocksGMT');
  echo $this->Html->script('jClocksGMT');
  echo $this->Html->script('jquery.rotate');
  echo $this->Html->script('ckeditor/ckeditor');
  echo $this->Html->script('dashboard');

?>
<style type="text/css">
  #ReadingList .x_panel {
   overflow-x: hidden;
    overflow-y: scroll;
  }
</style>
<script>
  $(document).ready(function(){
    $('div#ReadingList .x_panel').height( $('div#voteUpDown .x_panel').height() );
  });
</script>
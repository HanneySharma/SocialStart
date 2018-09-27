<div class="page-title">
        <div class="title_left"><h3>Opportunities PipeLine</h3></div>
        <div class="title_right">
          <a class="btn btn-success pull-right">Add Opportunities</a>
        </div>
    </div>
    <div class="col-sm-8">	
    <div class="x_panel">
		<div class="x_content">
			
			
    		<?php echo $this->Flash->render(); ?>
            <div class="col-sm-12 no-padding"> 
              <div class="col-sm-3 col-xs-6 no-padding"> 
               <select  class="form-control">
                  <option>All</option>
                  <option>Recent Viewed</option>
                  
                </select>
              </div>
              <div class="col-sm-3 col-xs-6"> 
                <select  class="form-control">
                  <option value="">All Opportunities</option>
                  <option value="">Recently Viewed</option>
                  <option value="">Closing Next Month</option>
                  <option value="">Closing This Month</option>
                  <option value="">My Opportunities</option>
                  <option value="">New Last Week</option>
                  <option value="">New This Week</option>
                  <option value="">Opportunity Pipeline</option>
                  <option value="">Private</option>
                  <option value="">Won</option>
                </select>
              </div>
              <div class="col-sm-6 col-xs-12 text-right OpportunitiesEditIcon"> 
                <a><i class="fa fa-sliders"></i></a>
                <a><i class="fa fa-refresh"></i></a>
                <a><i class="fa fa-edit"></i></a>
              </div>
            </div>
            <div class="col-sm-8 no-padding"  style="margin-top:10px;"> 
                10 Opportunities, Updated 8 hours Ago
              </div>
              
              <div class="col-lg-12 col-sm-12 col-xs-12 ProcessedLeadsCards">
                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 ProcessedLeadsCardsImg">
                  <img alt="Demo Company" src="/socialstarts/img/logo1.png">
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8 ProcessedLeadsCardsRight">
                      <div class="cardcon">
                          <a href="<?php echo $this->Url->build(['controller' => 'Opportunities','action' => 'detail']); ?>"><h4 class="compname">Demo Company</h4></a>
                          <div class="detailcmp">
                          <h5 class="compname">Admin Admin</h5>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                              <li><i class="fa fa-building"></i> Close Date: <?php 
                                    if($dataformat==3){
                                                 $date_added =  date('l d-m-Y');
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d');
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y');
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y');
                                                }
                                        echo $date_added; 
                              ?></li>
                              <li><i class="fa fa-sun-o"></i> Stage : hold</li>
                              <li><i class="fa fa-signing"></i> Staff Associalted : Abc</li>
                            </ul>
                            </div>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                           
                              <li><i class="fa fa fa-envelope"></i> <a href="mailto:demo@demo.com">demo@demo.com</a></li>
                              <li><i class="fa fa fa-globe"></i> <a href="www.demo.com">www.demo.com</a></li>
                              <li><i class="fa fa-phone"></i> Phone : 9632587410</li>
                            </ul>
                            </div>
                         </div>
                      </div>
                      </div>
                      <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 bottom">
                          
                          <div class="col-xs-12">
                            <a class="btn btn-success btn-xs  form-control " type="button" href="#">Edit</a>                          
                          </div>
                          <div class="col-xs-12">
                            <a class="btn btn-danger btn-xs  form-control " type="button" href="#">Archive</a>                          
                          </div>
                          <div class="col-xs-12">
                            <a class="btn btn-warning btn-xs  form-control " type="button" href="#">On Hold</a>                          
                          </div>
                        </div>  
                     </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 ProcessedLeadsCards">
                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 ProcessedLeadsCardsImg">
                  <img alt="Demo Company" src="/socialstarts/img/logo2.png">
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8 ProcessedLeadsCardsRight">
                      <div class="cardcon">
                          <a href="<?php echo $this->Url->build(['controller' => 'Opportunities','action' => 'detail']); ?>"><h4 class="compname">Demo Company</h4></a>
                          <div class="detailcmp">
                          <h5 class="compname">Admin Admin</h5>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                              <li><i class="fa fa-building"></i> Close Date: <?php 
                                    if($dataformat==3){
                                                 $date_added =  date('l d-m-Y');
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d');
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y');
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y');
                                                }
                                        echo $date_added; 
                              ?></li>
                              <li><i class="fa fa-sun-o"></i> Stage : hold</li>
                              <li><i class="fa fa-signing"></i> Staff Associalted : Abc</li>
                            </ul>
                            </div>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                           
                              <li><i class="fa fa fa-envelope"></i> <a href="mailto:demo@demo.com">demo@demo.com</a></li>
                              <li><i class="fa fa fa-globe"></i> <a href="www.demo.com">www.demo.com</a></li>
                              <li><i class="fa fa-phone"></i> Phone : 9632587410</li>
                            </ul>
                            </div>
                         </div>
                      </div>
                      </div>
                      <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 bottom">
                          
                          <div class="col-xs-12">
                            <a class="btn btn-success btn-xs  form-control " type="button" href="#">Edit</a>                          
                          </div>
                          <div class="col-xs-12">
                            <a class="btn btn-danger btn-xs  form-control " type="button" href="#">Archive</a>                          
                          </div>
                          <div class="col-xs-12">
                           <a class="btn btn-warning btn-xs  form-control " type="button" href="#">On Hold</a>                                                  
                          </div>
                        </div>  
                     </div>


<div class="col-lg-12 col-sm-12 col-xs-12 ProcessedLeadsCards">
                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 ProcessedLeadsCardsImg">
                  <img alt="Demo Company" src="/socialstarts/img/logo3.png">
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8 ProcessedLeadsCardsRight">
                      <div class="cardcon">
                          <a href="<?php echo $this->Url->build(['controller' => 'Opportunities','action' => 'detail']); ?>"><h4 class="compname">Demo Company</h4></a>
                          <div class="detailcmp">
                          <h5 class="compname">Admin Admin</h5>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                              <li><i class="fa fa-building"></i> Close Date:<?php 
                                    if($dataformat==3){
                                                 $date_added =  date('l d-m-Y');
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d');
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y');
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y');
                                                }
                                        echo $date_added; 
                              ?></li>
                              <li><i class="fa fa-sun-o"></i> Stage : hold</li>
                              <li><i class="fa fa-signing"></i> Staff Associalted : Abc</li>
                            </ul>
                            </div>
                            <div class="col-sm-6">
                              <ul class="CompanyInfo">
                           
                              <li><i class="fa fa fa-envelope"></i> <a href="mailto:demo@demo.com">demo@demo.com</a></li>
                              <li><i class="fa fa fa-globe"></i> <a href="www.demo.com">www.demo.com</a></li>
                              <li><i class="fa fa-phone"></i> Phone : 9632587410</li>
                            </ul>
                            </div>
                         </div>
                      </div>
                      </div>
                      <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 bottom">
                          
                          <div class="col-xs-12">
                            <a class="btn btn-success btn-xs  form-control " type="button" href="#">Edit</a>                          
                          </div>
                          <div class="col-xs-12">
                            <a class="btn btn-danger btn-xs  form-control " type="button" href="#">Archive</a>                          
                          </div>
                          <div class="col-xs-12">
                          <a class="btn btn-warning btn-xs  form-control " type="button" href="#">On Hold</a>                                                
                          </div>
                        </div>  
                     </div>



    	</div>	
    </div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Activities <small>Sessions</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div><div class="clearfix"></div>


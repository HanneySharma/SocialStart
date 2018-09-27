    <div class="page-title">
        
        
              <div class="title_left">
                <h3><?php 
                //pr($Organizations);
              $activeCmt = (!empty($Organizations["comment_by_user"]))? "active" : "";
              $activeText = (!empty($Organizations["comment_by_user"]))? "Edit " : "Add ";
                if(!empty($this->request->session()->read('Config.funding_type_any'))){
                     $string_any_filter =implode($this->request->session()->read('Config.funding_type_any'),',');
                }
                else {
                    $string_any_filter='';
                }
                echo $this->Html->link('<i class="glyphicon glyphicon-backward"></i> Back',['controller' => 'Organizations/index','action' =>'index','page'=>$this->request->session()->read('Config.pageno'),'paginationCountChange'=>$this->request->session()->read('Config.paginationCountChange'),'country'=>$this->request->session()->read('Config.country'),'source'=>$this->request->session()->read('Config.source'),'verticals'=>$this->request->session()->read('Config.verticals'),'recently_funded'=>$this->request->session()->read('Config.recently_funded'),'funding_type'=>$this->request->session()->read('Config.funding_type'),'funding_type_any'=>$string_any_filter],['class' => '','escape' => false] );
                ?></h3>
                <h3>Lead Detail</h3>
              </div>
              <div class="title_right">
                <?php 
                
                echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Organization List','/organizations/index',['class' => 'btn btn-success pull-right','escape' => false] );
                ?>
              </div>
        
        
        
            </div>
            
            <div class="clearfix"></div>
           
                <div class="x_panel">
                  

                  <div class="x_content">
                      <!-- start project-detail sidebar -->
                      <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                     <?php if(!empty($Organizations['image'])){ ?>
                        <div class="flights"><img src="<?php echo $Organizations['image']; ?>" class="cmpLogo"></div>
                        <?php } ?>
                           <h1 title="<?php echo $Organizations['formal_company_name']; ?>" class="head-logo-name" ><?php echo $Organizations['formal_company_name']; ?></h1>
                          <div class="clearfix"></div>
                          <p><?php echo $Organizations['description']; ?>.</p>
                          <br/>
                          <div class="project_detail">
                              <span class="pull-left" style="padding: 13px;font-weight: bold;">Your Vote: </span>
                              <div class="emphasis">        
                               <?php

                             if( strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'both' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'social starts' ){
                             ?>                       
                              <span oid="<?php echo $Organizations['id']; ?>" id="<?php echo (!empty($userReview)) ? $userReview['id'] : '';  ?>" class="thump tiresias oicons thump_details up fa fa-thumbs-up <?php echo (!empty($userReview) && $userReview['review'] == 1)? 'active' : '';  ?>" title="Up Vote Social Starts"></span>
                              <?php } 
                             if( strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'both' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'joyance' ){
                             
                             ?>
                              <span oid="<?php echo $Organizations['id']; ?>" id="<?php echo (!empty($userReview)) ? $userReview['id'] : '';  ?>" class="thump joyance oicons thump_details up fa fa-thumbs-up <?php echo (!empty($userReview) && $userReview['review_joyance'] == 1 )? 'active' : '';  ?>" title="Up Vote Joyance"></span>
                              <?php } ?>

                               <span oid="<?php echo $Organizations['id']; ?>" id="<?php echo (!empty($userReview)) ? $userReview['id'] : '';  ?>" class="thump oicons thump_details down fa fa-thumbs-down <?php echo (!empty($userReview) && $userReview['review'] == 0 &&  $userReview['review_joyance'] != 1)? 'active' : '';  ?>" title="Down Vote"></span>
                               <span data-toggle="modal" data-target="#myModal<?php echo  $Organizations['id']; ?>" title="<?php echo  $activeText; ?> Comments" class="thump_2 comments fa fa-commenting <?php echo  $activeCmt; ?>" oid="<?php echo  $Organizations['id']; ?>"></span>
                              </div>

                        </div>

                      

                    </div>
                    <!-- end project-detail sidebar -->
                    <div class="col-md-9 col-sm-9 col-xs-12">
              <div id="smainb" style="">
              <div class="project_detail">
                          <h3>CEO Information</h3>
                            <p class="col-sm-6 col-xs-12 "><i class="fa fa-user"></i>
                           <?php
                            if(!empty($Organizations['first_name'])){
                              echo $Organizations['first_name']. ' '.$Organizations['last_name']; 
                            } else {
                              echo 'Not Available';
                            }
                           ?></p>
                            <p  class="col-sm-6 col-xs-12 ">Source:
                            <?php
                             if($Organizations['source']=='manual') {
                                $text_source ="Self Entered";
                                $urlStr = $Organizations['web_path'];
                                $link = $Organizations['web_path'];
                                $parsedUrl = parse_url($Organizations['web_path']);
                                   if (empty($parsedUrl['scheme'])) {
                                        $link = 'http://' . ltrim($Organizations['web_path'], '/');
                                    }
                                
                                $target='';
                             }
                               else if($Organizations['source']=='crunchbase' && !empty($Organizations['web_path']))
                             { 
                                 $link= 'https://www.crunchbase.com/'.$Organizations['web_path'];   
                                 
                                 $target='_blank';
                                 $text_source ="Crunchbase";
                             }
                               else if($Organizations['source']=='pitchbook')
                             { 
                                 $link= 'https://my.pitchbook.com?c='.ltrim($Organizations['companyid']);   
                                 
                                 $target='_blank';
                                 $text_source ="PitchBook";
                             }
                                else if($Organizations['source']=='producthunt')
                             { 
                                 $link= $Organizations['web_path'];   
                                 
                                 $target='_blank';
                                 $text_source ="ProductHunt";
                             } else if($Organizations['source']=='directinquiry')
                             { 
                                 $link= '';   
                                 $target='';
                                 $text_source ="Transom";
                             }
                                  
                                    
                                 ?>
                                <a href="<?php echo $link ?>" target="_blank"><?php echo $text_source ?></a>
                            </p>
                            <?php 
                                if($Organizations['source']!='producthunt'){
                            ?>
                            <p  class="col-sm-6 col-xs-12 ">Total Funding : <?php 
                            echo '$'.$this->Custom->nice_number($Organizations['total_funding_usd']);
                            //echo  '$'.$Organizations['total_funding_usd'] 
                                    
                                } ?> </p>
                             
                            <!--<p  class="col-sm-6 col-xs-12 "><i class="fa fa-envelope"></i>
                            <?php
                            //if(!empty($Organizations['email'])){
                              ?>
                              <a href="mailto:<?php //echo $Organizations['email']; ?>"><?php //echo $Organizations['email']; ?></a> 
                              <?php
                            //} else {
                             // echo 'Not Available';
                            //}
                              
                            ?></p>

                            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-phone"></i>
                               <?php 
                                //if(!empty($Organizations['phone'])){
                                //echo $Organizations['phone']; 
                              //} else {
                                //echo 'Not Available';
                             // }
                                ?></p>-->
                           

                            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-map-marker"></i>
                             <?php 
                             if(!empty($Organizations['city'])){
                              echo $Organizations['city'].', '.$Organizations['state'].', '.$Organizations['country']; 
                             } else {
                            echo 'Not Available';
                           }
                             ?></p>
                           
                            
                            <p  class="col-sm-6 col-xs-12 "><i class="fa fa-globe" aria-hidden="true"></i>
                            <?php 
                                if(!empty($Organizations['website'])){
                                    $urlStr = $Organizations['website'];
                                    $parsed = parse_url($Organizations['website']);
                                    if (empty($parsed['scheme'])) {
                                        $urlStr = 'http://' . ltrim($Organizations['website'], '/');
                                    }
                                ?>
                              <a href="<?php echo $urlStr; ?>" target="_blank">Website<?php //echo $urlStr; ?></a>
                              <?php } else {
                                echo 'Not Available';
                                } ?>
                              </p>                       

                        </div>
                  
   
                            
                             <?php 
                          
                                if($Organizations['source']='crunchbase' && !empty($Organizations['web_path']))
                                { 
                                    $link= 'https://www.crunchbase.com/'.$Organizations['web_path'];   

                                    $target='_blank';
                                }
                                else {
                                   $link='javascript:void(0)';
                                   $target='';
                                }
                             
                             ?>
               
                       

                       
              </div>
              <!--       <div id="smainb" style="">
                        <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-12 ">
                        <div class="well profile_view profile-detail founded-box">
                            <h4>Founded On</h4>
                            <h2>28 May 1955 </h2>
                           
                          
                        </div>                  
                    </div> 
                        <div class="col-lg-4 col-sm-4 col-xs-12 ">
                        <div class="well profile_view profile-detail owner-box">
                            <h4>Owner</h4>
                          <h2>John Smith</h2>
                          
                        </div>                  
                    </div> 
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="well profile_view profile-detail teams-box">
                            <h4>Teams</h4>
                         
                          <h2>12</h2>
                         
                        </div>                  
                    </div></div>


                    </div> -->

                      <div class="col-sm-12 col-xs-12">
                        <h4>Comments</h4>
                                                 <!-- end of user messages -->
                         <ul class="messages">
                             

                             <?php if(isset($Organizations['all_comments']) && !empty($Organizations['all_comments']) ){  ?>
                                         
                                         <?php
                                         foreach ($Organizations['all_comments'] as $key => $comment) {
                                           ?>

                                           <li>
                             <div class="message_date">
                               <?php 
                               $dataformat = $getDate['date_format'];
                                 if($dataformat==3){
                
                
                  $this_week_ed = date("d-m-Y",strtotime($comment['created']));
                }
                else if($dataformat==2){
                  
             
                  $this_week_ed = date("Y-m-d",strtotime($comment['created']));
                }
                else if($dataformat==1){
                    
          
                  $this_week_ed = date("m-d-Y",strtotime($comment['created']));
                }
                else {
              
                  $this_week_ed = date("d-m-Y",strtotime($comment['created']));
                }
                               echo $this_week_ed
                               //echo date('l d M Y', strtotime($comment['created'])); ?>
                             </div>
                             <div class="message_wrapper">
                               <h4 class="heading"><?php echo ucwords($comment['user']['name']);?></h4>
                               <blockquote class="message"><?php echo ucwords($comment['comment']); ?></blockquote>
                               <br />
                               
                             </div>
                           </li>
                                           <?php
                                         }
                                     } else {
                                      ?>
                                      <li>
                                          <div class="message_wrapper">
                              <h4 class="heading"></h4>
                               <blockquote class="message">No comment Yet</blockquote>
                               <br />
                               
                             </div>
                                          
                                          </li>
                                      <?php
                                     }
                                  ?>
                                  </ul>
                   
                        <!-- end of user messages -->


                      </div>
              
              
              

                        <div  class="col-sm-12 col-xs-12 ">
                        <h4>Votes</h4>
                                                
                                                 <!-- end of user messages -->
                         <ul class="messages">
                        <?php
                          if(isset($Organizations['all_reviews']) && !empty($Organizations['all_reviews']) ){ 
                            foreach ($Organizations['all_reviews'] as $key => $comment) {
                        ?>
                        <li>
                          <div class="message_date">
                          <?php
                            $dataformat = $getDate['date_format'];
                            if($dataformat==3) {
                              $this_week_ed = date("d-m-Y",strtotime($comment['created']));
                            } else if($dataformat==2){
                               $this_week_ed = date("Y-m-d",strtotime($comment['created']));
                             } else if($dataformat==1) {
                              $this_week_ed = date("m-d-Y",strtotime($comment['created']));
                            } else {
                              $this_week_ed = date("d-m-Y",strtotime($comment['created']));
                            }
                            echo $this_week_ed;//date('l d M Y', strtotime($comment['created'])); ?>
                          </div>
                             <div class="message_wrapper">
                               <h4 class="heading"><?php echo ucwords($comment['user']['name']);?></h4>
                               <blockquote class="message" style="position: relative;">
                                <?php 
                                if($comment['review'] == 1 ) { ?>
                               <span class="thump up fa fa-thumbs-up <?php echo ($comment['user_id'] == $this->request->Session()->read('Auth.Admin.id'))? ' userVote ' : '' ?> active tiresias" title="Up Vote"></span>
                                
                                <?php
                                } 
                                if($comment['review_joyance'] == 1 ) { ?>
                                <span class="thump up fa fa-thumbs-up <?php
                                  echo ($comment['user_id'] == $this->request->Session()->read('Auth.Admin.id'))? ' userVote ' : '' ?> active joyance" title="Up Vote"></span>
                                <?php } 
                                if($comment['review_joyance'] == 0 && $comment['review'] == 0) { ?>
                                <span class="thump down fa fa-thumbs-down <?php echo ($comment['user_id'] == $this->request->Session()->read('Auth.Admin.id'))? ' userVote ' : '' ?> active tiresias" title="Up Vote"></span>
                                <?php } ?>

                               </blockquote>
                               <br />
                             </div>
                           </li>
                                           <?php
                                         }
                                     } else {
                                      ?>
                                      <li><strong>No vote yet</strong></li>
                                      <?php
                                     }
                                  ?>
                                  </ul>
                        <!-- end of user messages -->


                      </div>


                    </div>

                  
</div>
                      <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12 news_details"><h1>News</h1> 
                              <?php
                               
                               if(!empty($Organizations['all_news'])){
                                   foreach($Organizations['all_news'] as $news){
                             
                                       $news_id = $news['id'];
                                       $newsId= $news['id'];
                                       $postedDate = date('Y-m-d',strtotime($news['posted_on']));
                                       echo '<p><b>'.$news['title'].'</b></p>';
                                       //echo '<p>'.'Posted On:'.$postedDate.'</p>';
                                       echo '<p><a target="_blank" href="'.$news['url'].'">Read More</a></p>';
                                       
                                   }
                                   
                               }
                        
                            
                               ?>
                              
                          </div></div>
                      
                      
                  </div>
                </div>
         
<div id="myModal<?php  echo $Organizations['id']; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Add Comment for <strong><?php echo strtoupper($Organizations['formal_company_name']); ?></strong></h4>
</div>
<div class="modal-body">

        <?php 
       
        echo $this->Form->create('',['url' => ['controller' => 'Organizations','action' => 'addComments'],'class' =>'addCommentForm details_form_comment']);
        //if(!empty($Organizations["all_comments"])) {
            //echo $this->Form->input('id',['type' =>'hidden','value' => $Organizations["all_comments"][0]['id']]);
               
        //}
         echo $this->Form->input('organization_id',['type' =>'hidden','value' => $Organizations['id']]);
    ?>
        <div class="form-group">
        <div class="col-sm-12">
        <?php
        $disc = (!empty($Organizations["comment_by_user"]))? $Organizations["comment_by_user"]['comment'] : '';
        echo $this->Form->input('comment',['type' =>'textarea','class' => 'form-control commentTextatea','label' => false,'value' => $disc,'placeholder' => 'Add Comment']); ?>
        <span class="errorShow"></span>
        </div>
        </div>

        <div class="col-sm-12">
        <?php echo $this->Form->input('Add',['type' =>'submit','class' => 'btn btn-success' ,'style' => 'margin-top:15px;','label' => false]); ?>
        </div>
        <?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer" style="border: none;"></div>
</div>
</div>
</div>
            
            
            
           <?php 
           $previousUrl = $siteURL.'organizations/index?page='.$this->request->session()->read('Config.pageno').'&country='.$this->request->session()->read('Config.country').'&source='.$this->request->session()->read('Config.source').'&verticals='.$this->request->session()->read('Config.verticals').'&recently_funded='.$this->request->session()->read('Config.recently_funded').'&paginationCountChange='.$this->request->session()->read('Config.paginationCountChange').'&funding_type='.$this->request->session()->read('Config.funding_type').'&funding_type_any='.$string_any_filter;
         //  echo $this->Html->link('<i class="glyphicon glyphicon-backward"></i> Back',['controller' => 'Organizations/index','action' =>'index','page'=>$this->request->session()->read('Config.pageno'),'country'=>$this->request->session()->read('Config.country'),'source'=>$this->request->session()->read('Config.source'),'verticals'=>$this->request->session()->read('Config.verticals'),'recently_funded'=>$this->request->session()->read('Config.recently_funded')],['class' => '','escape' => false] );
               
            ?>
    <script type="text/javascript">

        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
        window.location.assign("<?php echo $previousUrl; ?>");
        });
        $(document).ready(function(){
    $(document).on('click','.show_more',function(){
        var ID = $(this).attr('id');
        var organization_id ='<?php echo $Organizations['id'] ?>';
        $('.show_more').hide();
        $('.loding').show();
        $.ajax({
            type:'POST',
            url:'<?php echo $siteURL.'socialstart/organizations/loadMoreNews' ?>',
            data:{'id':ID,'organization_id':organization_id},
            success:function(html){
                $('#show_more_main'+ID).remove();
                $('.tutorial_list').append(html);
            }
        }); 
    });
});
    </script>
    <style type="text/css">
      .fa-thumbs-up.joyance::after {
          bottom: -6px;
          color: #5c90ba;
          content: "JO";
          font-size: 12px;
          font-weight: bold;
          left: 60px;
          position: absolute;
        }
        .fa-thumbs-up.tiresias::after {
          bottom: -6px;
          color: #5c90ba;
          content: "SS";
          font-size: 12px;
          font-weight: bold;
          left: 18px;
          position: absolute;
        }
        .project_detail .emphasis {
          float: left;
          position: relative;
        }
        .project_detail .emphasis .fa-thumbs-up.joyance::after {
            left: 10px;
        }
        .project_detail .emphasis .fa-thumbs-up.tiresias::after {
            left: 10px;
        }
        .fa-thumbs-up.joyance:first-child::after {
            left: 20px;
          }
    </style>
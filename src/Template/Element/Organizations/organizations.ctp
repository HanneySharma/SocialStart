
<!--Saving these fields for ajax pagination and sorting-->
  <!--   <div class="dataTables_info paginate_info_div paddingtop5" aria-live="polite">
        <?php echo $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} entries');?>
    </div> -->
<?php
/*$this->Paginator->templates([
'sort' => '<a class="tableColumnHeading" href="#" onclick="javascript:ajaxPagination(\'{{url}}\');return false;">{{text}}</a>',  
'sortAsc' => '<a class="tableColumnHeading" href="#" onclick="javascript:ajaxPagination(\'{{url}}\');return false;">{{text}}</a>',  
'sortDesc' => '<a class="tableColumnHeading" href="#" onclick="javascript:ajaxPagination(\'{{url}}\');return false;">{{text}}</a>',  
]);*/

?>

<div class="row">
<?php
                   // pr($this->Paginator->params());
                    if(!empty($this->Paginator->params()) && ($this->Paginator->params()['count'] > 0)){
                      
                        foreach ($OrganizationsList as $key => $Organization) {
                            $reviewId = (!empty($Organization['review_by_user']))? $Organization['review_by_user']['id'] : "";
                            $Upclass = (!empty($Organization['review_by_user']) && $Organization['review_by_user']['review'] == 1 )? 'active' : '';
                            $Upclassjoyance = (!empty($Organization['review_by_user']) && $Organization['review_by_user']['review_joyance'] == 1 )? 'active' : '';
                            $Dowbclass = (!empty($Organization['review_by_user']) && $Organization['review_by_user']['review'] == 0 && $Organization['review_by_user']['review_joyance'] == 0 )? 'active' : '';
                            $activeCmt = (!empty($Organization["comment_by_user"]))? "active" : "";
                            $activeText = (!empty($Organization["comment_by_user"]))? "Edit " : "Add ";
                            
                            if(!empty($Organization)){
                        ?>
                     <div class="col-lg-4 col-sm-6 col-xs-12 profile_details">
                     <!--<p class="topCorner"><span>
                            
                             <?php 
                            /* if($Organization['source']='crunchbase' && !empty($Organization['web_path']))
                             { 
                                 $link= 'https://www.crunchbase.com/'.$Organization['web_path'];   
                                 
                                 $target='_blank';
                             }
                             else {
                                $link='javascript:void(0)';
                                $target='';
                             }*/
                             
                             ?>
                <a href='<?php //echo $link ?>' target="<?php //echo $target; ?>" style="color:#ffffff"><?php
                      //if($Organization['source'] == 'crunchbase'){
                        //echo "Crunchbase";

                      //} else if($Organization['source'] == 'pitchbase'){ 
                       // echo "Pitchbook";
                      //} else {
                        //echo "Manual";
                      //}
                      ?>
                     </a>-->
                       

                     <!--</span></p>-->
                        <div class="well profile_view">
                            <a href="<?php echo $this->Url->build(['controller' => 'Organizations','action' => 'detail',$Organization['id']]); ?>" class="" title="<?php echo $Organization['formal_company_name']; ?>"><h4 class="brief"><?php echo (strlen($Organization['formal_company_name']) >30) ? substr($Organization['formal_company_name'],0,30)."..." : $Organization['formal_company_name']; ?></h4></a>
                            <input type="checkbox" id="<?php echo $Organization['id']; ?>" class="OrganizationsInput pull-right">
                           
                            <div class="left-img-card">
                              <a href="<?php echo $this->Url->build(['controller' => 'Organizations','action' => 'detail',$Organization['id']]); ?>" class="" title="Lead Image">
                                <span  class="img-circle img-responsive">
                                <?php 
                                $acronym = "NA";
                                if(!empty($Organization['first_name'])){
                                  $acronym = "";
                                  $words = explode(" ", $Organization['first_name']." ".$Organization['last_name']);
                                  foreach ($words as $w) {
                                    if(isset($w[0])){
                                      $acronym .= $w[0];
                                    }
                                  }
                                }
                                echo $acronym;
                                ?></span> </a>
                              
                          </div>
                           <div class="right-text-card">
                              <h2><a href="<?php echo $this->Url->build(['controller' => 'Organizations','action' => 'detail',$Organization['id']]); ?>" class="" title="CEO Name"><?php echo (!empty($Organization['first_name']))? $Organization['first_name']." ".$Organization['last_name'] : 'Not Available'; ?></a></h2>
                              <p> 
                           
                              </p>
                              <ul class="list-unstyled source_link">
                                   <li><i class="fa fa-external-link"></i> Source: <?php
                                
                             
                            if($Organization['source']=='manual') {
                                $text_source ="Self Entered";
                                $urlStr = $Organization['web_path'];
                                $link = $Organization['web_path'];
                                $parsedUrl = parse_url($Organization['web_path']);
                                   if (empty($parsedUrl['scheme'])) {
                                        $link = 'http://' . ltrim($Organization['web_path'], '/');
                                    }
                                
                                $target='';
                             }
                               else if($Organization['source']=='crunchbase' && !empty($Organization['web_path']))
                             { 
                                 $link= 'https://www.crunchbase.com/'.$Organization['web_path'];   
                                 
                                 $target='_blank';
                                 $text_source ="Crunchbase";
                             }
                              else if($Organization['source']=='pitchbook' )
                             { 
                                 $link= 'https://my.pitchbook.com?c='.ltrim($Organization['companyid']);   
                                 
                                 $target='_blank';
                                 $text_source ="PitchBook";
                             }
                                else if($Organization['source']=='producthunt' )
                             { 
                                 $link= $Organization['web_path'];   
                                 $target='_blank';
                                 $text_source ="Product Hunt";
                             } else if($Organization['source']=='directinquiry' )
                             { 
                                 $link= '';   
                                 $target='';
                                 $text_source ="Transom";
                             }
                             else {
                                 
                                  $link= '';   
                                 
                                 $target='_blank';
                                 $text_source ="";
                                 
                             }
                                  
                                    
                              ?>
                              <a  href="<?php echo $link ?>" title="<?php echo $link; ?>" target="_blank"><?php echo $text_source ?></a>
                                
                                </li>
                                <li><i class="fa fa-globe"></i> Website:<?php 
                                if(!empty($Organization['website'])){
                                    $urlStr = $Organization['website'];
                                    $parsed = parse_url($Organization['website']);
                                    if (empty($parsed['scheme'])) {
                                        $urlStr = 'http://' . ltrim($Organization['website'], '/');
                                    }
                                ?>
                                    <a  title="<?php echo $urlStr; ?>" href="<?php echo $urlStr; ?>" target="_blank"> <?php echo $urlStr; ?></a>
                              <?php 
                            } else {
                              ?>
                              Not Available
                              <?php
                              }?> </li>
                                <li><i class="fa fa-map-marker"></i> Address: <span title="<?php echo (!empty($Organization['city']))? $Organization['city'].", ".$Organization['state'].", ".$Organization['country'] : 'Not Available'; ?>"><?php echo (!empty($Organization['city']))? $Organization['city'].", ".$Organization['state'].", ".$Organization['country'] : 'Not Available'; ?></span> </li>
                                
                                 <!--<li><i class="fa fa-phone"></i> Phone #: <?php //echo (!empty($Organization['phone']))? $Organization['phone'] : 'Not Availabe'; ?></li>-->
                              </ul>
                            </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-8 emphasis">
							             
                             <?php

                             if( strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'both' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'social starts' ){
                             ?> 
							 
                             <span title="Up Vote Social Starts" class="oicons thump up fa fa-thumbs-up <?php echo  $Upclass; ?> tiresias" id="<?php echo  $reviewId; ?>" oid="<?php echo  $Organization['id']; ?>"></span>
                             <?php } 
                             if( strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'both' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'joyance' ){
                             
                             ?>
                             <span title="Up Vote Joyance" class="oicons thump up fa fa-thumbs-up <?php echo  $Upclassjoyance; ?> joyance" id="<?php echo  $reviewId; ?>" oid="<?php echo  $Organization['id']; ?>"></span>
                             
                             <?php } ?>

                             <?php

                             if( strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'both' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'social starts' || strtolower($this->request->session()->read('Auth.Admin.users_group.name')) == 'joyance' ){
                             ?>
                             <span title="Down Vote" class="oicons thump down fa fa-thumbs-down <?php echo  $Dowbclass; ?>" id="<?php echo  $reviewId; ?>" oid="<?php echo  $Organization['id']; ?>"></span>

                             <span data-toggle="modal" data-target="#myModal<?php echo  $Organization['id']; ?>" title="<?php echo  $activeText; ?> Comments" class="oicons thump_2 up comments fa fa-commenting <?php echo  $activeCmt; ?>" oid="<?php echo  $Organization['id']; ?>"></span>
                             
                             <?php } ?>
                             
                            


                             <a class="oicons thump_2" title="Edit" href="<?php echo  $this->Url->build(['controller' => 'Organizations','action' => 'organization',$Organization['id']]); ?>"><i class="pens fa fa-pencil-square"></i></a>
                             <?php if($loggeinuserdata['role'] == 1){ ?>
                             <a class="oicons thump_2 organisationDelete" title="Edit" href="<?php echo  $this->Url->build(['controller' => 'Organizations','action' => 'delete',$Organization['id'] ] ); ?>"><i class="pens fa fa-trash" style="color: #8e0505;"></i></a>
                           <?php } ?>
                             <?php   

                              if(isset($duplicateids) && !empty($duplicateids) && ($Organization['source']=='crunchbase')){
                                echo  (array_key_exists($Organization['formal_company_name'],$duplicateids))? '<span title="Reconcile" class="reconcile oicons" id1="'.$duplicateids[$Organization['formal_company_name']][0].'" id2="'.$duplicateids[$Organization['formal_company_name']][1].'" ></span>' : '' ;
                              }
                             ?>
                            </div>
                            <div class="col-xs-12 col-sm-4 emphasis">
                              <a href="<?php echo $this->Url->build(['controller' => 'Organizations','action' => 'detail',$Organization['id']]); ?>" type="button" class="btn btn-primary btn-xs pull-right">
                                <i class="fa fa-user"> </i> View Profile
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                            <div id="myModal<?php  echo $Organization['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Comment for <strong><?php echo strtoupper($Organization['formal_company_name']); ?></strong></h4>
      </div>
      <div class="modal-body">

<?php echo $this->Form->create('',['url' => ['controller' => 'Organizations','action' => 'addComments'],'class' =>'addCommentForm']);
    if(!empty($Organization['comment_by_user'])) {
        echo $this->Form->input('id',['type' =>'hidden','value' => $Organization['comment_by_user']['id']]);        
    }
    echo $this->Form->input('organization_id',['type' =>'hidden','value' => $Organization['id']]); ?>
  <div class="form-group">
    <div class="col-sm-12">
      <?php
      $disc = (!empty($Organization['comment_by_user']))? $Organization['comment_by_user']['comment'] : '';
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

                        <?php }  }
} else {
    echo "<span class='text-center'>No record found</span>";
  } ?>
    </div>                  
<?php 
 if(!empty($this->Paginator->params()) && ($this->Paginator->params()['count'] > 0)){
        echo $this->element('pagination/pagination');
    }
?>

<style type="text/css">
.profile_details p.topCorner::before {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: transparent transparent #662121;
  border-image: none;
  border-style: solid;
  border-width: 17px;
  content: "";
  height: 0;
  position: absolute;
  right: 52px;
  top: -27px;
  width: 0;
  z-index: -1;
}

.profile_details p.topCorner::after {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: #662121 transparent transparent;
  border-image: none;
  border-style: solid;
  border-width: 17px;
  content: "";
  height: 0;
  position: absolute;
  right: -6px;
  top: 55px;
  width: 0;
  z-index: -2;
}
.profile_details p.topCorner {
  display: inline;
}
.profile_details p.topCorner span {
  background: #d93131 none repeat scroll 0 0;
  border-radius: 5px 5px 0 1px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2), 0 5px 30px rgba(255, 255, 255, 0.2) inset;
  display: inline-block;
  padding: 3px 0;
  position: absolute;
  right: -20px;
  text-align: center;
  text-transform: full-width;
  top: 8px;
  transform: rotate(45deg);
  width: 100px;
  z-index: 1;
}
.profile_details {
  z-index: 5;
  color: #fff;
  font-weight: bold;
}
.profile_details .profile_view h2 {
  margin: 5px 0;
  color: #3e3e3e;
}

</style>
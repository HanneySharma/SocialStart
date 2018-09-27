<div class="row">
<?php
                    if(!empty($users)){
                      foreach ($users as $key => $user) {
                        ?>
                         
                     <div class="col-lg-4 col-sm-6 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <a href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'addUser',$user['id']]); ?>">  <h4 class="brief"><?php 
                           
                            
                            echo ($user['role'] == 1)? 'Super Admin':$user['name']; ?></h4> </a>
                           
                            <div class="left-img-card">
                              
                                <span  class="img-circle img-responsive">
                                <?php 
                                $acronym = "NA";
                                if(!empty($user['name'])){
                                  $acronym = "";
                                  $words = explode(" ", $user['name']);
                                  foreach ($words as $w) {
                                    if(isset($w[0])){
                                      $acronym .= $w[0];                                      
                                    }
                                  }
                                }
                                echo $acronym;
                                ?></span> 
                              
                          </div>
                           <div class="right-text-card">
                              <h2><?php echo (!empty($user['name']))? $user['name']: 'Not Availabe'; ?></h2>
                              <p><?php echo (!empty($user['username']))? $user['username'] : '';?></p>
                            </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-12 emphasis">                             

                              <span style="padding-top:7px;padding-right:17px;" class="oicons pull-right"><a class="oicons" title="Delete" href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'delete',$user['id']]); ?>"><i class="fa fa-trash"></i></a></span>                             
                              <span style="padding-top:7px;padding-right:17px;" class="oicons pull-right"><a class="oicons" title="Edit" href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'addUser',$user['id']]); ?>"><i class="fa fa-pencil"></i></a></span>

                            </div>                            
                          </div>
                        </div>
                        </div>
                
<?php } 
} else {
    echo "<span class='text-center'>No record found</span>";
  } ?>
    </div>                  
<?php echo $this->element('pagination/pagination');?>

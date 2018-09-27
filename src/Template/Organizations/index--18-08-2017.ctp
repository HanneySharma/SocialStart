 
            <div class="page-title">
              <div class="title_left">
                <h3>Leads</h3>
                <span class="text-center">
                  <?php
                  $monday = strtotime("last monday");
                  $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;                   
                  $sunday = strtotime(date("Y-m-d",$monday)." +6 days");                   
                  $this_week_sd = date("d-m-Y",$monday);
                  $this_week_ed = date("d-m-Y",$sunday);
                  ?>
                  Leads list from <strong><?php echo $this_week_sd; ?></strong> to <strong><?php echo $this_week_ed; ?></strong>.
                </span>
              </div>

              <div class="title_right">
              
              
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for..." id="orgListSearchInput">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" id="orgListSearch">Go!</button>
                    </span>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- Crons job temparary work-->
              <!--   <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success cronButton" type="button" divs="PitchBookDiv">PitchBook</button>
                        <button class="btn btn-success cronButton" type="button" divs="CrunchBookDiv">CrunchBase</button>
                         <a href="#" class="btn btn-success" id="UploadOnBaseCRM">Select Organization to Upload On Base CRM</a>
                        <a href="#" class="btn btn-success" id="UploadOnBaseCRMbutton">Upload On Base CRM</a>
                    </div>
                   
                </div>  -->
                
                <div class="col-md-12 crondivs" id="CrunchBookDiv"  style="margin-bottom: 50px; display: none;">
                <?php
                    echo $this->Form->create(NULL, ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'search_organizations_crunch', 'data-parsley-validate','novalidate']);
                    echo $this->Form->input('call_type', ['type' => 'hidden', 'name' => 'call_type','value' => 'crunchBook' ]);
                    ?>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-3">
                            <?php echo $this->Form->input('categories', ['type' =>'select','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false,'options' =>  $category,'empty' => '-- Select Category --']); ?>
                    </div>
                    <div class="col-md-3">
                            <?php echo $this->Form->input('organization_type', ['type' =>'select','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false,'options' =>  ['company'=> 'Company','investor'=> 'Investor','school'=> 'School','group'=> 'Group'],'empty' => '-- Select Organization Type --']); ?>
                    </div>
                    <div class="col-md-3">
                            <?php echo $this->Form->input('deal_date', ['value' => '7 Days','placeholder' => '7 Days', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false, 'readonly' ]);
                                ?>  
                    </div>    
                    <div class="col-md-3">
                        <?php echo $this->Form->button('Search', ['id'=>'search_button_crunch', 'div'=>false, 'type' => 'button', 'class' => 'btn btn-success']);?>
                    </div>
                </div>

                    <?php echo $this->Form->end();?>
                </div>


                 <div class="col-md-12 crondivs" id="PitchBookDiv" style="margin-bottom: 50px; display: none;">
                     <?php
                echo $this->Form->create(NULL, ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'search_organizations', 'data-parsley-validate','novalidate']);
                echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
                 echo $this->Form->input('call_type', ['type' => 'hidden', 'name' => 'call_type','value' => 'pitchbook' ]);
                ?>
            <div class="row">
                <div class="col-md-3">
                        <?php echo $this->Form->input('verticals', ['type' =>'select','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false,'options' =>  $vertical_options]);?>
                </div>
                
                <div class="col-md-3">
                        <?php $options = ['' => 'Choose Deal Type','SEED' => 'Seed','ANG' => 'Angel','PAI' => 'Pre/Accelerator/Incubator','BYSTG' => 'All VC Stages'];                 
                            echo $this->Form->input('deal_type', ['type' =>'select','class' => 'select2_multiple form-control', 'multiple'=>'multiple', 'required' => true, 'label' =>false,'options' =>  $options]);
                            ?> 
                </div>
                <div class="col-md-3">
                        <?php echo $this->Form->input('deal_date', ['value' => '700 Days', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false, 'readonly' ]);
                            ?>  
                </div>
                
                <div class="col-md-3">
                    <?php echo $this->Form->button('Search', ['id'=>'search_button', 'div'=>false, 'type' => 'button', 'class' => 'btn btn-success']);?>
                </div>
            </div>

                <?php echo $this->Form->end();?>
                 </div>

            

            <!-- Crons job temparary work-->
                <?php echo $this->Flash->render() ?>
               <div class="x_panel">
                <div class="row">  
                    <div class="col-md-3 col-sm-3 col-xs-12">  
                        <?php echo $this->element('pagination/page_count_dropdown');?>
                    </div>
                  
                 <div class="col-md-9 col-sm-9 col-xs-12 pull-right"> 
                   <?php
                       echo $this->Form->create(null,['url' => ['controller' => 'Organizations','action' => 'index'],'method' => 'post','id'=>'organizationFilter']);
                    ?>
                    <div class=" col-sm-3">
                            <?php echo $this->Form->input('verticals', ['type' =>'select','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false,'options' =>  $vertical_options]);?>
                    </div>    
                    <div class=" col-sm-3">
                            <?php  echo $this->Form->input('source', ['type' =>'select','class' => 'select2_multiple form-control', 'label' =>false,'options' => ['both' => 'Both','crunchbase'=> 'Crunch Base','pitchbase'=> 'Pitch Book']]); ?> 
                    </div>
                     <div class="col-sm-6">
                        <?php echo $this->Form->button('Search', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>
                         <a href="<?php echo$this->Url->build(['controller' => 'Organizations','action' => 'organization']); ?>" class="btn btn-success "><i class="fa fa-plus"></i> Add Organizatons</a>
                    </div>
                   
                <?php echo $this->Form->end(); ?>
                  </div>
                  </div>
                  </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                
                    <div id="divUpdate">
                        <?php echo $this->element('Organizations/organizations');?>                  
                </div>
              </div>
            </div>
          

<div class="reconcilecon"></div>
<div class="reconcileconOverlay"></div>
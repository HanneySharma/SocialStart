 <div class="page-title">
        <?php 

        ?>
            <div class="title_left">
                <h3>Leads</h3>
                <span class="text-center">
                  <?php
                  $monday = strtotime("last monday");
                  $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;                   
                  $sunday = strtotime(date("Y-m-d",$monday)." +6 days");                   
                  //echo $dataformat;
                if($dataformat==3){
                
                   $this_week_sd = date("d-m-Y",$monday);
                  $this_week_ed = date("d-m-Y",$sunday);
                }
                else if($dataformat==2){
                  
                  $this_week_sd = date("Y-m-d",$monday);
                  $this_week_ed = date("Y-m-d",$sunday);
                }
                else if($dataformat==1){
                    
                   $this_week_sd = date("m-d-Y",$monday);
                  $this_week_ed = date("m-d-Y",$sunday);
                }
                else {
                    $this_week_sd = date("d-m-Y",$monday);
                  $this_week_ed = date("d-m-Y",$sunday);
                }
              
              
              ?>
                  
                  Leads list from <strong><?php echo $this_week_sd; ?></strong> to <strong><?php echo $this_week_ed; ?></strong>.
                </span>
              </div>

              <div class="title_right">
                   
                           <a href="<?php echo$this->Url->build(['controller' => 'Organizations','action' => 'organization']); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Organizatons</a>
                   
             
                    
                  <?php 
                  /*if($this->request->session()->read('Auth.Admin.role') == 1){
                            echo $this->Html->link('Export Last Week leads', array(
                            'controller' => 'organizations', 
                            'action' => 'export',

                          ));
                    
                  }*/
                    ?>
                           <a class="btn btn-default export" title="export last week leads" href="<?php echo$this->Url->build(['controller' => 'Organizations','action' => 'export']); ?>"><i class="glyphicon glyphicon-export" aria-hidden="true"></i>
</a>
                       
              
                     
     </div>
            </div>

<div class="x_panel x_panel-top-p">
    <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">  
                        <?php echo $this->element('pagination/page_count_dropdown');?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right top_search">
                  <div class="input-group">
                      
                    <input type="text" class="form-control" placeholder="Search for..." id="orgListSearchInput">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" id="orgListSearch">Go!</button>
                    </span>
                  </div>
                  <button class="btn btn-success add-filter" style="display: none;">
                    <span class="fa fa-filter"></span> Filter</button>
                    
                  
                </div>
    </div>    
         
     <?php
                   
                   
                       echo $this->Form->create(null,['url' => ['controller' => 'Organizations','action' => 'index'],'method' => 'post','id'=>'organizationFilter']);
                    ?>
                    
              
                     
                    
                    
                    
         
                  
           
                    <!--<div class="col-sm-6">
                            <?php //echo $this->Form->input('verticals', ['default'=>$this->request->session()->read('Config.verticals'),'type' =>'select','class' => 'form-control verticals_text', 'required' => true, 'label' =>false,'onchange'=>'javascript:ajaxPagination($functionName,"paginationCountChange")','options' =>  $vertical_options]);?>
                    </div> -->   
                    <div class="row"> 
                    <div class="col-sm-4 ">
                        
                        <div class="form-group">     
                            <label  class="control-label">Select Source</label>     
                            <?php
                           
                $options = [
              
                ['text' => 'Manually Added', 'value' => 'manual'],
                ['text' => 'Transom', 'value' => 'directinquiry'],
                ['text' => 'Pitch Book', 'value' => 'pitchbook'],
                ['text' => 'Crunch Base', 'value' => 'crunchbase'],
                ['text' => 'Product Hunt', 'value' => 'producthunt']
                
                ];

                $source =  $this->request->session()->read('Config.source');  
                if(empty($source)){
                  $source =  'manual';
                  $this->request->session()->write('Config.source','');
                }
                echo $this->Form->select('source', $options,['class'=>'form-control','id'=>'source','onchange'=>'javascript:ajaxPagination("'.$functionName.'","paginationCountChange")','default'=> $source]);
                
                ?> 
                        <?php  
                            
                           // echo $this->Form->input('source', ['disabled'=>'disabled','default'=>$this->request->session()->read('Config.source'),'type' =>'select','class' => 'select2_multiple form-control', 'label' =>false,'onchange'=>'javascript:ajaxPagination($functionName,"paginationCountChange")','options' => ['crunchbase'=> 'Crunch Base']]); ?> 
                        </div>
                        </div>
                  
                    
                       

    
    <div class="filter_div">
          <div class="col-sm-4 country_div">
                        <div class="form-group"> 
                            <label class="control-label"  >Select Country</label> 
                     <?php 
                                       
                                      //echo $this->Form->select('country', ['default'=>$this->request->session()->read('Config.country'),'class' => 'form-control','id'=>'country', 'label' =>false,'options' =>  $country_options_all,'onchange'=>'javascript:ajaxPagination("index","paginationCountChange")']);
                                      echo $this->Form->select('country', $country_options_all,['default'=>'United States','class'=>'form-control','id'=>'country','onchange'=>'javascript:ajaxPagination("'.$functionName.'","paginationCountChange")']);
                     ?>
                        </div>
                    </div>
                   
                   
                     
                     <div class="col-md-4 funding_type">
                          <div class="form-group"> 
                            <label class="control-label" >Rules Type</label>
                          
                                    <?php 
                                       echo $this->Form->select('funding_type', ['0'=>'Include Any','4'=>'Does not include'],['default'=>$this->request->session()->read('Config.funding_type'),'class'=>'form-control','id'=>'any','onchange'=>'javascript:ajaxPagination("'.$functionName.'","paginationCountChange")']);
                                    
                                        // echo $this->Form->input('funding_type', ['default'=>$this->request->session()->read('Config.funding_type'),'type' =>'select','class' => 'select2_multiple form-control', 'label' =>false,'onchange'=>'javascript:ajaxPagination("index","paginationCountChange")','options' =>['any'=>'Include Any']]);
                                     //echo $this->Form->input('funding_type', ['default'=>$this->request->session()->read('Config.funding_type'),'type' =>'select','class' => 'select2_multiple form-control', 'label' =>false,'onchange'=>'javascript:ajaxPagination("index","paginationCountChange")','options' =>$funding_type_all]);
                                    ?> 
                            </div>

                    </div>
                   
                     
                
                                 
                                <?php if($this->request->session()->read('Config.funding_type')=='any'){?>
                                    <div class="col-md-4 funding_type_any">
                                        <div class="form-group"> 
                                         <label class="control-label" >Funding Type </label>
                                            <?php
                                            $defaultAny = explode(",",$this->request->query('funding_type_any'));
                                           // $getFundingTypes1=array('angel','seed','grant');
                                           // echo $this->Form->control('funding_type_any', ['options' => $getFundingTypes1, 'escape' => false, 'label' => false, 'class' => 'select2_multiple chosen-select country_filter form-control', 'data-placeholder' => "Choose Any  ...", 'multiple tabindex' => 4,'multiple' => true,'default'=>$defaultAny]);
                                            ?>
                                        </div>
                                        <?php
                                         
                                        echo $this->Form->control('funding_type_any', ['options' => $getFundingTypes1, 'escape' => false, 'label' => false, 'class' => 'select2_multiple chosen-select country_filter', 'data-placeholder' => "angel", 'multiple tabindex' => 4,'multiple' => true,'default'=>array('angel','seed')]);
                                        
                                        ?>
                                    </div>
                        
                                <?php } else {?>
                                <div class="col-md-4 funding_type_any">
                                     <div class="form-group"> 
                            <label class="control-label" >Funding Type</label>
                                       <?php
                                      //$getFundingTypes1=array('angel','seed','grant');
                                       //echo $this->Form->control('funding_type_any', ['options' => $getFundingTypes1, 'escape' => false, 'label' => false, 'class' => 'select2_multiple chosen-select country_filter form-control', 'data-placeholder' => "Choose Any  ...", 'multiple tabindex' => 4,'multiple' => true,'default'=>'']);
                                       echo $this->Form->control('funding_type_any', ['options' => $getFundingTypes1, 'escape' => false, 'label' => false, 'class' => 'select2_multiple chosen-select country_filter', 'data-placeholder' => "Choose Any  ...", 'multiple tabindex' => 4,'multiple' => true,'default'=>array('angel','seed')]);
                                      
                                       ?>
                                      </div>
                                     
                                   </div>
                                <?php } ?>
                               
                                    <?php 
                                $funding_annouce_date=[1=>'funded in last 90 days',2=>'funded in last 60 days',3=>'funded in last 30 days'];
                               
                                ?>
                                <div class="col-sm-4 recently-funded-div">
                                    <div class="form-group"> 
                            <label class="control-label" >Duration </label>
                                    <?php 
                          echo $this->Form->control('recently_funded', ['options' => $funding_annouce_date, 'default'=>'3','escape' => false, 'label' => false, 'class' => 'form-control','onchange'=>'javascript:ajaxPagination("'.$functionName.'","paginationCountChange")']);
                                                 
                //echo $this->Form->input('recently_funded', ['default'=>$this->request->session()->read('Config.recently_funded'),'type' =>'select','class' => 'select2_multiple form-control', 'label' =>false,'onchange'=>'javascript:ajaxPagination("index","paginationCountChange")','options' =>$funding_annouce_date]); 
                                    ?> 
                                    </div>
                                   
                                </div>
                               
                              
                          
                            
                            <div class="col-sm-4">
                                
                                 <a href="<?php echo $siteURL;?>organizations/index" class="btn btn-success reset_default">Reset To Default</a>
                                    <?php //echo $this->Form->button('Search', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>
                            </div>
                           

                            
                      
                        </div> 
                     
                      </div>
    </div>
<?php echo $this->Form->end(); ?>
            <!-- Crons job temparary work-->
         
                
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
                 <div class="col-sm-4">    
                                   <a href="<?php echo$this->Url->build(['controller' => 'Organizations','action' => 'organization']); ?>" class="btn btn-success "><i class="fa fa-plus"></i> Add Organizatons</a>
                   </div>
                   
                </div>

                <?php echo $this->Form->end();?>
        </div>

            

            <!-- Crons job temparary work-->
                <?php echo $this->Flash->render() ?>
            
            
            
            
            
              
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

<script type="text/javascript">
 $(document).ready(function(){
    /* $(document).on('click','.add-filter',function(){
       //$(".filter_div").css('display','block');  
     });*/
      $(".add-filter").click(function(e) {
        $(".filter_div").toggle().toggleClass("active");
       // e.stopPropagation();
    });
     
    /*$(document).on('click','.remove_filter',function(){
        $(".filter_div").css('display','none');    
     });*/
     
    
 });
</script>

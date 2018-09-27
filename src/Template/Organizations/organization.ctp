   <div class="page-title">
              <div class="title_left">
                <h3><?php echo isset($this->request->data['id'])? 'Edit Organization' : 'Add Organization'; ?></h3>
              </div>
              <div class="pull-right">
                <?php echo $this->Html->link( '<i class="glyphicon glyphicon-import"></i> Import Manual', '/organizations/import-manual', array('class' => 'btn btn-success','escape'=>false,'title'=>'Organizations') );?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Organisation List','/organizations/index',['class' => 'btn btn-success ','escape' => false] ); ?>
              </div>
              </div>
<div class="x_panel">
<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                echo $this->Form->create($organizationsObj, ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'add_organization', 'data-parsley-validate','novalidate']);
                  echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
                  echo $this->Form->input('source', ['type' => 'hidden', 'name' => 'source', 'value' => isset($this->request->data['source'])? $this->request->data['source'] : 'manual'  ]);
                ?>
                <div class="row m-t-md">
                      <div class="col-sm-6">
                    
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Company Name <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('formal_company_name', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Legal Company Name
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('legal_company_name', ['class' => 'form-control col-md-7 col-xs-12',  'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    </div>

                    <div class="row m-t-md">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Website
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('website', ['class' => 'form-control col-md-7 col-xs-12',  'label' =>false ]);?>
                        </div>
                    </div>
</div>
                    <div class="col-sm-6">

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">First Name 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('first_name', ['class' => 'form-control col-md-7 col-xs-12', 'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row m-t-md">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Last Name
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('last_name', ['class' => 'form-control col-md-7 col-xs-12', 'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Email 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('email', ['class' => 'form-control col-md-7 col-xs-12', 'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row m-t-md">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Linkedin 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('linkedin', ['class' => 'form-control col-md-7 col-xs-12','label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Phone 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('phone', ['class' => 'form-control col-md-7 col-xs-12', 'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row m-t-md">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">City 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('city', ['class' => 'form-control col-md-7 col-xs-12',  'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">State 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('state', ['class' => 'form-control col-md-7 col-xs-12',  'label' =>false]);?>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row m-t-md">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Country 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php 
                             echo $this->Form->control('country', ['options' => $country_options_all, 'escape' => false, 'label' => false, 'class' => 'form-control col-md-7 col-xs-12 ' ]);
               
                          //echo $this->Form->input('country', ['class' => 'form-control col-md-7 col-xs-12',  'label' =>false ]);?>
                        </div>
                    </div></div>
                     
                       <div class="col-sm-6">
                            <div class="form-group">
                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Source  
                            </label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                            <?php  
                            
                           
                $options = [
                ['text' => 'Manual', 'value' => 'manual'],
                ['text' => 'Transom', 'value' => 'directinquiry'],
                ['text' => 'Pitch Book', 'value' => 'pitchbook'],
                ['text' => 'Crunch Base', 'value' => 'crunchbase'],
                ['text' => 'Product Hunt', 'value' => 'producthunt'],
                ];
                echo $this->Form->select('source', $options,['default'=>'manual','class'=>'form-control','id'=>'source']);
             
                                ?>
                                
                            </div>
                            </div>
                        </div>                      
                                             
                          </div>
                    
                    <div class="row m-t-md">                   
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Source Link 
                            </label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                            <?php                               
                echo $this->Form->input('web_path', ['class'=>'form-control','id'=>'source','label' =>false]);
                                ?>
                                
                            </div>
                            </div>
                        </div>
                 
                                             <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Category <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php 
                            echo $this->Form->input('category', ['id'=>'category-name','placeholder'=>'Select Category','type' =>'text','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false,'autocomplete'=>"off"]);                            
                          ?>
                          <div class="autoComplete">
                              <ul>
                                
                              </ul>
                          </div>
                        </div>
                    </div>
                    </div>
                          </div>
                    
                    <div class="row m-t-md">                      
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Description 
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                          <?php echo $this->Form->input('description', ['type' =>'textarea','class' => 'form-control col-md-7 col-xs-12','label' =>false]);?>
                        </div>
                    </div> </div>
 </div>
                    
             
            
<div class="col-sm-12">
</div>
        
                      <div class="col-sm-6">
                      <div class="col-md-5 col-sm-5 col-xs-12"></div>
                    <div class="form-group col-md-7 col-sm-7 col-xs-12">
                      
                            <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
                            <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>
                      
                    </div>  </div>

</div>
        
                <?php echo $this->Form->end();?>
                <!-- end form for add category -->
</div>
</div>
<style type="text/css">
    textarea#description {
      min-height: 125px !important;
    }
</style>

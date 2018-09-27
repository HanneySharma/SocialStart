   <div class="page-title">
              <div class="title_left">
                <h3><?php echo isset($this->request->data['id'])? 'Edit Reading List' : 'Add Reading List'; ?></h3>
              </div>
              <div class="title_right">
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Reading List',['controller' => 'Users','action' =>'readingList'],['class' => 'btn btn-success pull-right','escape' => false] ); ?>
              </div>
              </div>
<div class="x_panel">
<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                echo $this->Form->create($ReadingListEnt, ['url' => ['action' => 'addReadList'], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'addReadList', 'data-parsley-validate','novalidate']);
                echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
                ?>
                
				
					<div class="col-sm-6">
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                          <?php echo $this->Form->input('title', ['placeholder'=>'Title','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
                    </div>
					<div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">Link <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                          <?php echo $this->Form->input('link', ['placeholder'=>'http://www.exaple.comss','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
					</div>
          </div>

 
            
<div class="col-sm-12">
</div>
        
                      <div class="col-sm-6">
					  
                    <div class="form-group">
                       <div class="col-md-9 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-4">
                            <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
                            <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>
                        </div>
                    </div>  </div>

</div>
        
                <?php echo $this->Form->end();?>
                <!-- end form for add category -->
</div>
</div>
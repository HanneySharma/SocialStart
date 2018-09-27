<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                echo $this->Form->create($categories, ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false, 'name' => 'add_category', 'id' => 'add_category', 'data-parsley-validate']);
                ?>
                
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $this->Form->input('name', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            $status = [0 => 'Active', 1 => 'In-Active'];
                            echo $this->Form->select('status', $status, ['default' => 0, 'class' => 'form-control']);
                            ?>
                            
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
                            <?php echo $this->Form->button('Submit', ['name'=>'submit_add_category', 'value'=>'add_category','div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>               
                        </div>
                    </div>

                <?php echo $this->Form->end();?>
                <!-- end form for add category -->
</div>
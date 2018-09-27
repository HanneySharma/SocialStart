<div class="page-title">
    <div class="title_left">
        <h3>
            User Groups
        </h3>
    </div>
    <div class="title_right">
        <?php echo $this->Html->link('
        <i class="glyphicon glyphicon-list">
        </i>
        Users List',['controller' => 'Users','action' =>'index'],['class' => 'btn btn-success pull-right','escape' => false] ); ?>
    </div>
</div>
<div class="x_panel">
    <div class="x_content">
        <?php 
                echo $this->Flash->render(); 
               // echo $this->Form->create($groupEnt, ['url' => ['controller' => 'Users','action' => 'groups'], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'usersGroup', 'data-parsley-validate','novalidate']);
                
              ?>
        <!-- <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">
                    Name
                    <span class="required">
                        *
                    </span>
                </label>
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <?php 
                    echo $this->Form->input('name', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);
                    echo $this->Form->input('id', ['type' => 'hidden','class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'label' =>false ]);

                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <?php echo $this->Form->reset('Reset', ['div' => false, 'class' => 'btn btn-primary']);?>
                    <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);?>
                </div>
            </div>
        </div> -->
<?php // echo $this->Form->end(); ?>
    </div>
</div>
<div class="row">
  <div class="col-sm-12">
  <?php
    if(!empty($groups)){
        foreach ($groups as $key => $group) {
            ?>
            <div class="col-lg-4 col-sm-6 col-xs-12 profile_details">
                <div class="well profile_view">
                    <h4 class="brief"><?php echo $group['name']; ?></h4>                           
                  <div class="col-xs-12 bottom text-center">
                    <div class="col-xs-12 col-sm-12 emphasis">                             
                      <!-- <span style="padding-top:7px;padding-right:17px;" class="oicons pull-right"><a class="oicons" title="Delete" href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'group_delete',$group['id']]); ?>"><i class="fa fa-trash"></i></a></span>                             
                      <span style="padding-top:7px;padding-right:17px;" class="oicons pull-right"><a class="oicons" title="Edit" href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'groups',$group['id']]); ?>"><i class="fa fa-pencil"></i></a></span> -->

                    </div>                            
                  </div>
                </div>
                </div>
            <?php
        }
    }
  ?>                   
    
  </div>
  
</div>

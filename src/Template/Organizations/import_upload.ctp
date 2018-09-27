   <div class="page-title">
              <div class="title_left">
                <h3>Import PitchBook Leads</h3>
              </div>
              <div class="title_right">
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Organisation List','/organizations/index',['class' => 'btn btn-success pull-right','escape' => false] ); ?>
              </div>
              </div>
<div class="x_panel">
<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                echo $this->Form->create('', ['enctype'=>'multipart/form-data','url' => ['action' => 'import'], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => 'add_organization2', 'data-parsley-validate','novalidate']);
                  echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
                  echo $this->Form->input('source', ['type' => 'hidden', 'name' => 'source', 'value' => isset($this->request->data['source'])? $this->request->data['source'] : 'manual'  ]);
                ?>
                
        <div class="row m-t-md">
        <div class="col-md-7 col-sm-7 col-xs-12">

            <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12 lbl" for="first-name">Upload Excel File  </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
			
			<span class="upload-btn-wrapper b-btn"> 
  <button class="btn ">Browse...</button>
   <input type="file" name="file">
</span>
			
		<span class="b-btn"> <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'add_filter  btn btn-success']);?> </span>	
          
			
			 
            </div>
            </div>
			
        </div>
        <div class="col-md-5 col-sm-5 col-xs-12 ltf-bdr">
         <div class="form-group">
		<a class="xl-btn" title="Download Xl Format Sample" href="<?php echo $siteURL; ?>demo.xlsx"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> <span class="dowlodtxt"> Download Xl Format Sample </span> </a> 
            
        </div>
 </div>







        </div>
        
                     <?php echo $this->Form->end();?>
                <!-- end form for add category -->
</div>
</div>


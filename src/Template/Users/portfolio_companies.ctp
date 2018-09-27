<?php
   echo $this->Flash->render();
?>
<div class="page-title">
  <div class="title_left"><h3>Portfolio Companies</h3></div>
</div>
<div class="x_panel">
  <div class="x_content">
    <div class="col-sm-6">
    <?php
     
      echo $this->Form->create($portfolioCompaniesEnt, ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left pull-left', 'role' => 'form', 'label' => false,'id' => 'addUsers', 'data-parsley-validate','novalidate']);
      echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
    ?>
    <div class="col-sm-10">
      <div class="form-group">
        <label class="control-label col-md-6 col-sm-6 col-xs-12 namegap" for="first-name">Company Name <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?php
            echo $this->Form->input('company', ['class' => 'form-control col-md-7 col-xs-12 smtxt', 'required' => true, 'label' =>false, 'placeholder' => 'Company Name' ]);
          ?>
        </div>
      </div>
      
    </div>
    <div class="col-sm-1">
      <div class="form-group">
          <?php
            echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'btn btn-success']);
          ?>
        
      </div>
    </div>
  <?php echo $this->Form->end();?>
</div>
    <div class="col-sm-6">
      <div class="col-sm-10 filegap">
          <?php
          echo $this->Form->create(null, ['url' => ['action' => 'importportfolio'], 'class' => 'form-horizontal form-label-left mrtop', 'role' => 'form', 'label' => false,'id' => 'importPortfolio', 'data-parsley-validate','novalidate', 'enctype' => "multipart/form-data"]);
          ?>
          <label class="control-label col-md-6 col-sm-6 col-xs-12 importnone gpanone" for="first-name">Import File</label>
          <input id="importPortfolioFile" type="file" name="import" class="inputfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
          <?php echo $this->Form->end();?>
      </div>
      <div class="col-sm-2 ltf-bdr">
        <a style="font-size: 25px;" href="<?php echo $this->url->build('/'); ?>portfolio.xlsx" download title="Download Sample"><i class="fa fa-download"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="x_panel1">
  <div class="x_content1 row">
  <?php
    if(!empty($portfolioCompanies)) { 
      foreach($portfolioCompanies as $portfolioCompanyId => $portfolioCompany)
      {
    ?>
    <div class="col-lg-4 col-sm-6 col-xs-12 profile_details">
      <div class="well profile_view">
        <h4 class="brief"><?php echo $portfolioCompany; ?></h4>
        <div class="col-xs-12 bottom text-center">
          <div class="col-xs-12 col-sm-8 emphasis">
            <a class="oicons thump_2" title="Edit" href="<?php echo  $this->Url->build(['controller' => 'Users','action' => 'portfolioCompanies',$portfolioCompanyId ]); ?>"><i class="pens fa fa-pencil-square"></i></a>
            
            <?php echo $this->Form->postLink('<i class="pens fa fa-trash" style="color: #a80d0d;"></i>',
                      ['controller' => 'Users','action' => 'portfolioCompanies',$portfolioCompanyId ,'trash' ], 
                      ['escape' => false,'confirm' => __('Are you sure, you want to delete {0}?', $portfolioCompany), 'class'=>'oicons thump_2', "title"=>"Delete" ]
                    )

            ?>


          </div>
        </div>
      </div>
    </div>
    <?php    
      }
    } else {
      echo "No records found";
    }
  ?>

  </div>
</div>
<div class="">
 <div class="paging_simple_numbers paginate_div">
    <ul class="pagination">        
            <?php
                echo $this->Paginator->prev('« Previous', array('escape'=>false));
                echo $this->Paginator->numbers(['modulus' => 5]);
                // echo $this->Paginator->numbers();
                echo $this->Paginator->next('Next »');
            ?>
    </ul>
</div>
</div>
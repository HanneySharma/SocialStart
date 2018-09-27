<div class="page-title">
  <div class="title_left"><h3>Transom</h3></div>
  <div class="title_right"><a class="btn btn-success pull-right" href="<?php echo $this->Url->build(['controller'=>'users','action' => 'transomRefreshList']); ?>">Refresh List</a></div>
</div>
<div class="x_panel1">
  <div class="x_content">
    <div class="row">
    <?php
    echo $this->Flash->render(); 

    if(!empty($transoms)) { 
      foreach($transoms as $key => $transoms)
      {
        
        if($key % 3 == 0){ ?>
        </div><div class="row">
       <?php }
    ?>
    <div class="col-lg-4 col-sm-6 col-xs-12 profile_details">
      <div class="well profile_view">
        <h4 class="brief"><?php echo $transoms['company']; ?></h4>
        <div class="left-img-card">
          <span class="img-circle img-responsive">
            <?php 
              $acronym = "NA";
              if(!empty($transoms['company'])){
                $acronym = "";
                $words = explode(" ", $transoms['company']);
                foreach ($words as $w) {
                  if(isset($w[0])){
                    $acronym .= $w[0];
                  }
                }
              }
              echo $acronym;
              ?>
            </span>
        </div>
        <div class="right-text-card">
          <h2><a href="#"><?php echo $transoms['name']; ?></a></h2>
          <ul class="list-unstyled source_link">
               <li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $transoms['email']; ?>" ><?php echo $transoms['email']; ?></a>
               </li>
               <li><i class="fa fa-phone"></i> <?php echo (!empty($transoms['contact']))? $transoms['contact']: 'N/A'; ?></li>
               <li><i class="fa fa-bell"></i> <?php echo (!empty($transoms['vertical']))? $transoms['vertical']: 'N/A'; ?></li>               
             </ul>
        </div>

        <div class="col-xs-12 bottom text-center" style="color: #637182">
            <div class="col-xs-12 col-sm-6 col-sm-offset-6 emphasis">
              <?php
              echo $this->Html->link('<i class="fa fa-user"> </i> View Profile',['controller' => 'users','action' => 'transom_detail' , $transoms['id']],["type"=>"button", "class"=>"btn btn-primary btn-xs pull-right","escape" => false]);
              ?>                
            </div>
          <?php //echo $transoms['message']; ?>
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
<div class="row">
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
  </div>
</div>

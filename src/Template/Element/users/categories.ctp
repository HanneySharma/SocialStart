<?php
$catSelect = array();
    if(!empty($cronSetting)){
      foreach ($cronSetting as $cronStg) {
        if($cronStg['cron_type'] == 'category'){
          $catSelect = json_decode($cronStg['data'], true);
        }
      }
    }
    if(!empty($categories)){
      foreach ($categories as $cId => $categorie) {
        ?>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 verticals  <?php echo (in_array($cId,$catSelect))? 'active' : ''; ?>">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-bullseye"></i></div>
            <h4><?php echo $categorie; ?></h4>
           <input type="hidden" name="categorie[]" class="categoryInp" value="<?php echo $cId; ?>" <?php echo (in_array($cId,$catSelect))? '' : 'disabled'; ?>>
           <input type="hidden" name="categorie_removed[]" class="categoryInprm" value="<?php echo $cId; ?>" disabled>
          </div>
        </div>
        <?php
      }
    }
  ?>   
  <div class="clearfix"></div>
   <div class="col-lg-6 col-md-6 col-sm-12">
      <button class="btn btn-success saveCronSetting"  sec="category">Save Categories</button>         
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12">
  <div class="pull-right" id="categoryPaginations">
   <?php echo $this->element('pagination/pagination',['frm' => 'Categories'] );?>
   </div>
   </div>
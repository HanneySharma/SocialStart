<div class="page-title">
    
    <div class="row">
        <div class="col-lg-6"><h3>Manage Categories</h3></div>
    </div> 
</div>
<div class="clearfix"></div>
<div class="x_panel">
<div class="x_content">
    <?= $this->Flash->render() ?>
    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pitchbook</a>
          </li>
          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">CrunchBase</a>
          </li>          
        </ul>
        <div id="myTabContent" class="tab-content">
          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 20px 1%;">
                <?php echo $this->Html->link('Clear All',['controller' => 'Users', 'action' => 'clearAllCrons'  ],['class' => 'btn btn-success pull-right clearAllCron','sec' => 'vertical']); ?>

                <button class="btn btn-success saveCronSetting pull-right" sec="vertical">Save Verticals</button>
              
              </div>
              <div id="verticalsDiv">
              <?php
                $verSelect = array();
                $catSelect = array();
                if(!empty($cronSetting)){
                  foreach ($cronSetting as $cronStg) {
                    if($cronStg['cron_type'] == 'vertical'){
                      $verSelect = json_decode($cronStg['data'], true);
                    } elseif($cronStg['cron_type'] == 'category'){
                      $catSelect = json_decode($cronStg['data'], true);
                    }
                  }
                }
                if(!empty($verticals)){                  
                  foreach ($verticals as $vId => $vertical) {
                    ?>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 verticals <?php echo (in_array($vId,$verSelect))? 'active' : ''; ?>">
                      <div class="tile-stats">
                        <div class="icon"><i class="fa fa-bullseye"></i></div>
                        <h4><?php echo $vertical; ?></h4>
                       <input type="hidden" name="vertical[]" class="verticalsInp" value="<?php echo $vId; ?>" <?php echo (in_array($vId,$verSelect))? '' : 'disabled' ?>>
                       <input type="hidden" name="vertical_removed[]" class="verticalInprm" value="<?php echo $vId; ?>" disabled>
                      </div>
                    </div>
                    <?php
                  }
                }
              ?>
              </div>
               <div class="clearfix"></div>             
          </div> 
          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
              <div class="col-lg-6 col-md-6 col-sm-12" style="padding: 20px 1%;">
                <input type="text" class="form-control" placeholder="Search Categories" id="croncatSearch">
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12" style="padding: 20px 1%;">
                <?php echo $this->Html->link('Clear All',['controller' => 'Users', 'action' => 'clearAllCrons'  ],['class' => 'btn btn-success clearAllCron  pull-right','sec' => 'category']); ?>
                 <button class="btn btn-success saveCronSetting pull-right"  sec="category">Save Categories</button> 
              </div>

              <div class="clearfix"></div>
              <div id="updateDiv">
               <?php
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
              <div class="pull-right" id="categoryPaginations">
               <?php echo $this->element('pagination/pagination',['frm' => 'Categories']);?>
               </div>
               </div>
              </div>
               
               
          </div>    

        </div></div>
    </div>
</div>
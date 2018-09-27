   <div class="page-title">
              <div class="title_left">
                <h3>Reading List</h3>
              </div>
              <div class="title_right">
              </div>
              </div>
      <div class="x_panel">
        <div class="x_content">
            <ul class="to_do">
                        <?php
                        if(!empty($readingAllList)){
                          foreach ($readingAllList as $key => $list) {
                           @$tagsMeta = get_meta_tags($list['link']);
                            ?>
                            <li><h2><a title="<?php echo $list['link']; ?>" href="<?php echo $list['link']; ?>" target="_blank"><?php echo $list['title']; ?></a></h2>
                            <?php
                            if(!empty($tagsMeta) && isset($tagsMeta['description'])){
                              ?>
                              <p> <?php echo $tagsMeta['description']; ?></p>
                              <?php
                            }
                            ?>
                            <p></p>
                            <p>Added By: <strong><?php echo ucfirst($list['user']['name']); ?> </strong> On <?php 
                            //echo date('d/m/Y ',strtotime($list['created']));
                            
                               if($dataformat==3){
                                                 $date_added =  date('l d-m-Y',strtotime($list['created']));
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d',strtotime($list['created']));
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y',strtotime($list['created']));
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y',strtotime($list['created']));
                                                }
                                        echo $date_added; 
                            ?></p></li>
                            <?php
                          }
                        } else {
                          ?>
                          No Record Found.
                          <?php 
                        }
                        ?>
            <li>
            <ul class="pagination">
            <?= $this->Paginator->prev('« Previous') ?>
            <?= $this->Paginator->numbers(); ?>
            <?= $this->Paginator->next('Next »') ?>
            </ul>
            </li>
        </ul>
        </div>
      </div>
</div>

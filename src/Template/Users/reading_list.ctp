   <div class="page-title">
              <div class="title_left">
                <h3>Reading List</h3>
              </div>
              <div class="title_right">
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> Add Reading List',['controller' => 'Users','action' =>'add_read_list'],['class' => 'btn btn-success pull-right','escape' => false] ); ?>
              </div>
              </div>
      <div class="x_panel">
       <?= $this->Flash->render() ?>
        <div class="x_content">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th><?php echo $this->Paginator->sort('title'); ?></th>
                  <th>Link</th>
                  <th>Added By</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if(!empty($ReadingList)){
                  foreach ($ReadingList as $key => $value) {
                   ?>
                   <tr>
                      <td><?php echo $value['title']; ?></td>
                      <td><a href="<?php echo $value['link']; ?>" target="_blank"><?php echo $value['link']; ?></a></td>
                      <td><?php echo $value['user']['name']; ?></td>
                      <td><?php 
                      
                     // echo date('d/m/Y', strtotime($value['created'])); 
                      
                      ?>
                      <?php 
                             
                               if($dataformat==3){
                                                 $date_added =  date('l d-m-Y',strtotime($value['created']));
                                                }
                                                else if($dataformat==2){
                                                $date_added = date('l Y-m-d',strtotime($value['created']));
                                                }
                                                else if($dataformat==1){
                                                $date_added =  date('l m-d-Y',strtotime($value['created']));
                                                }
                                                else {
                                                $date_added =  date('l d-m-Y',strtotime($value['created']));
                                                }
                                        echo $date_added; 
                            ?>
                      </td>
                      <td>
                        <span style="padding:5px;"><a href="<?php echo $this->Url->build(['controller' => 'Users','action' => 'addReadList',$value['id']]); ?>" title="Edit"><i class="fa fa-pencil"></i></a></span>
                        <span  style="padding:5px;"><?php echo $this->Form->postLink('<i class="fa fa-trash" style="color:red;"></i>',['controller' => 'Users','action' => 'deleteReadList',$value['id']],['escape' => false,'confirm' => __('Are you sure, you want to delete {0}?',$value['title'])]); ?></span>
                      </td>
                    </tr>
                   <?php
                  }
                } else {
                  ?>
                  <tr>
                      <td colspan="4">No records found</td>
                    </tr>
                  <?php
                }
              ?>
              <tr>
                  <td colspan="5">
            <?php echo $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of{{count}} total, starting on record {{start}}, ending on {{end}}'); ?></td>
              </tr>
              </tbody>
            </table>

            <ul class="pagination">
            <?= $this->Paginator->prev('« Previous') ?>
            <?= $this->Paginator->numbers(); ?>
            <?= $this->Paginator->next('Next »') ?>
            </ul>
        </div>
      </div>
</div>

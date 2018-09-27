<div class="page-title">
           <div class="title_left">
             <h3><?php echo 'Manage Filter'  ?></h3>
           </div>

 </div>
<div class="x_panel">
    <!-- code for filter -->
      
    <!-- end of code -->
    
    
<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                  echo $this->Form->create('filter', ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => '', 'data-parsley-validate','novalidate']);
                  echo $this->Form->input('id', ['type' => 'hidden', 'name' => 'id' ]);
                  echo $this->Form->input('source', ['type' => 'hidden', 'name' => 'source', 'value' => isset($this->request->data['source'])? $this->request->data['source'] : 'manual'  ]);
                ?>
                
                <div class="row m-t-md">
					
		 <div class="col-sm-12 allcountry">
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">Country 
                            </label>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                             <?php
                                        $getCountryList1=array();
                                        $checked='';
                                                    if(!empty($getFilterCountry)){
                                                        foreach($getFilterCountry as $listCountry){
                                                        if($listCountry['filter_value']!='all'){
                                                                $checked=FALSE;
                                                               // echo $listCountry['filter_value'].',';
                                                                $getCountryList1[$listCountry['filter_value']]=$listCountry['filter_value'];

                                                        }
                                                        else {
                                                              $checked=TRUE;
                                                        }
                                                        }
                                                    }

                                        echo $this->Form->control('country', ['options' => $getCountryList, 'escape' => false, 'label' => false,'required'=>'required', 'class' => 'chosen-select country_filter', 'data-placeholder' => "Choose a Country ...", 'multiple tabindex' => 4,'multiple' => true,'default'=>$getCountryList1]);
                                ?>

                                  


                                </div>
                        
                        </div>
                    </div>
                 </div>
                 <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">List All  Countries
                            </label>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                  <?php
                                                    
                                      echo $this->Form->checkbox('check_all', ['class'=>'filter_all','hiddenField' => false,'checked'=>$checked,'escape'=>false ]);
                                    ?>

                                  <div>


                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-md-3 col-sm-4 col-xs-12"></div>		  
                        <div class="form-group col-md-9 col-sm-8 col-xs-12">


                                <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'add_filter  btn btn-success']);?>

                        </div>  
                        <div class="form-group error_message" style="color: red; ">
      
                              
                        </div>
                    </div>
                
                <!-- code to list allready applied filters -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Allready Applied Filter :
                            </label>
                                        <?php 
                                        if(!empty($allreadyAppliedFilter)){
                                            foreach($allreadyAppliedFilter as $apliedFilter ){
                                                 echo '<div class="remove_filter_div col-md-2" id="'.$apliedFilter['id'].'" >'.$apliedFilter['filter_value'].'<span class="remove_filter" id="'.$apliedFilter['id'].'"> X</span></div>';
                                            }
                                        }
                                            
                                        ?>

                    </div>
                <!-- end of code -->
                

</div>
        
                <?php echo $this->Form->end();?>
                <!-- end form for add category -->
</div>
</div>
<style type="text/css">
    textarea#description {
      min-height: 125px !important;
    }
    
</style>
<script type="text/javascript">
    $(document).on('click','.add_filter',function(){
        var country =$("#country").val();
        var chk = $(".filter_all").is(':checked');
        
        
        if(country==null && chk==false){
             $(".error_message").html('Please select atleast one country from filter or choose all country');
              return false;
        }
        //return false;
        //alert(country);
       
    });
    
 $(document).on('click','.filter_all',function(){
     
    
     $(".error_message").html('');
     var chk = $(this).is(':checked');
     
   if ($(this).is(':checked')) {
        alert('By checking this option, you are allowing the system to consider all the countries. Which when considered, may take lot of time to fetch results. Please be patient when this happens. For ideal performance, please be selective in countries. Thanks.');
        
       //$('#country').attr('multiple', false);
      $('.allcountry').css('display','none');
     
   }
   else if (!$(this).is(':checked')) {
           $('.allcountry').css('display','block');
           
        }
 });
 
    $('#country').on('change',function() {
        $(".error_message").html('');
        var val =$(this).val();
        if(val){
            $('.filter_all').prop('checked' , false);
        }
        
    });
    $(document).on('click','.remove_filter',function(){
        var self = $(this);
        var id = self.attr('id');
        if (confirm('Are you sure ?')) {
        $.ajax({
			url: siteURL+"Users/removeFilter",
			type: 'post',
			dataType: 'json',
			data: {id:id },
			success: function(data){
				if(data.status == 1){
                                  self.remove();
                                  $("#"+id).remove();
                                  
                                       
				}
                              
			}
		});
        }
       return false;
    });
    
 
</script>

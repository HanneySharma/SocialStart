<div class="page-title">
           <div class="title_left">
             <h3><?php echo 'Manage Date Format'  ?></h3>
           </div>

 </div>
<div class="x_panel">
    <!-- code for filter -->
      
    <!-- end of code -->
    
    
<div class="x_content">
    <?= $this->Flash->render() ?>
                <!-- start form add category -->
                <?php
                  echo $this->Form->create('date', ['url' => ['action' => ''], 'class' => 'form-horizontal form-label-left', 'role' => 'form', 'label' => false,'id' => '', 'data-parsley-validate','novalidate']);
                ?>
              
                <div class="row m-t-md">
					
		 <div class="col-sm-12 allcountry">
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-4 col-xs-12" for="first-name">
                                Date Format 
                            </label>
                            <div class="col-md-4 col-sm-8 col-xs-12">
                                 <?php 
                                 
                                 if(!empty($getDate['date_format'])){
                                     $default =$getDate['date_format'];
                                 }
                                 else {
                                     $default='3';
                                 }
                                        $options_all=array(''=>'Select Date Format','1'=>'MM-DD-YYYY',2=>'YYYY-MM-DD',3=>'DD-MM-YYYY');
                                        echo $this->Form->input('date_format', ['type' =>'select','class' => 'form-control', 'default'=>$default,'label' =>false,'options' =>  $options_all]);?>
                                     
                                  <div class="col-sm-6">


                                  </div>


                                </div>
                        </div>
                    </div>
                 </div>
                    
                    <div class="col-sm-12">
                        <div class="control-label col-md-3 col-sm-4 col-xs-12"></div>		  
                        <div class="form-group col-md-4 col-sm-8 col-xs-12">


                                <?php echo $this->Form->button('Submit', ['div'=>false, 'type' => 'submit', 'class' => 'valid_blank btn btn-success']);?>

                        </div>  
                    </div>

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
    
    $(document).on('click','.valid_blank',function(){
        var date_format = $("#date-format").val();
        if(date_format==''){
            $("#date-format").addClass('error');
            return false;
        }
    });
    $(document).on('change','#date-format',function(){
    
       var val =$(this).val();
       $(this).removeClass('error');
    });
 $(document).on('click','.filter_all',function(){
     
     var chk = $(this).is(':checked');
     
   if ($(this).is(':checked')) {
       //$('#country').attr('multiple', false);
      $('.allcountry').css('display','none');
     
   }
   else if (!$(this).is(':checked')) {
           $('.allcountry').css('display','block');
           
        }
 });
 
    $('#country').on('change',function() {
        var val =$(this).val();
        if(val){
            $('.filter_all').prop('checked' , false);
        }
        
    });
 
</script>
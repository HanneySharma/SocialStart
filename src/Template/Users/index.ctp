  
            <div class="page-title">
              <div class="title_left">
                <h3>Users Management</h3>
              </div>
              <div class="title_right">
                    <?php 
                    if($this->request->session()->read('Auth.Admin.role') == 1){
                      echo $this->Html->link('Users Groups',['controller' => 'Users','action' =>'groups'],['class' => 'btn btn-success pull-right','escape' => false] );
                      echo $this->Html->link('Add User',['controller' => 'Users','action' =>'addUser'],['class' => 'btn btn-success pull-right 	m-r-sm','escape' => false] ); 
                    }
                    ?>
              </div>
            </div>
           

            <!-- Crons job temparary work-->
                <?php echo $this->Flash->render() ?>
               <div class="x_panel">
                <div class="row">  
                    <div class="col-md-3">  
                        <?php echo $this->element('pagination/page_count_dropdown');?>
                    </div>
                  </div>
                  </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                
                    <div id="divUpdate">
                        <?php echo $this->element('users/users');?>                  
                </div>
              </div>
            </div>
          

          <!-- for pop use 
          
          <div class="row">
          <div class="col-md-12">
          	<div class="container-reconsile">
            	<div class="row">
                	<div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                    	<div class="form-heading"><h2>PitchBook</h2></div>
                    	<div class="form-group">
                        	<div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="Company Name"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="Country"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="State"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="City"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Name"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Linkedin"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Email"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Phone"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><textarea rows="4"  name="comment" form="usrform" class="form-control reconsile" placeholder="Description"></textarea></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                        	
                        
                        
                   	 	</div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                    	<div class="form-heading"><h2>CrunchBase</h2></div>
                        <div class="form-group">
                        	<div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="Company Name"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="Country"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="State"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="City"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Name"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Linkedin"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Email"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Phone"></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-10"><textarea rows="4"  name="comment" form="usrform" class="form-control reconsile" placeholder="Description"></textarea></div>
                                <div class="col-md-2"><input class="reconsile-radio" type="radio" name="" value=""></div>    
                            </div>
                        	
                        
                        
                   	 	</div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                    	<div class="form-heading"><h2>Final Prefrences</h2></div>
                        
                        <div class="form-group">
                        	<div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="Company Name"></div>
                                   
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="Country"></div>
                                
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="State"></div>
                                   
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="City"></div>
                                  
                            </div>
                            
                            <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Name"></div>
                                  
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Linkedin"></div>
                                   
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Email"></div>
                                    
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-11"><input type="text" class="form-control reconsile" id="InputText" placeholder="CEO Phone"></div>
                                
                            </div>
                            
                             <div class="row">
                            	<div class="col-md-11"><textarea rows="4"  name="comment" form="usrform" class="form-control reconsile" placeholder="Description"></textarea></div>
                                   
                            </div>
                        	
                        
                        
                   	 	</div>
                    </div>
                </div>
                <div class="row">
                <div class="col-lg-6">
                 <a href="#" class="btn btn-success pull-right"><i class="glyphicon glyphicon-list"></i> Reconsile</a></div>
                 </div>
            </div>
            </div>
            </div>
            
           
         
          
          -->
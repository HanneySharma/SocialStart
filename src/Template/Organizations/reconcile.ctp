 <div class="row">
          <div class="col-md-12">
            <div class="container-reconsile">
            <span class="reconsileClose">X</span>
              <div class="row">
                  <div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                      <div class="form-heading"><h2>PitchBook</h2></div>
                      <div class="form-group">
                          <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['formal_company_name']; ?>" type="text" class="form-control reconsile"  placeholder="Company Name"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rname" value="" ></div>    
                            </div>
                            
                            <div class="row">
                              <div class="col-md-10"><input readonly  value="<?php echo $reconcileOrg[0]['country']; ?>" type="text" class="form-control reconsile"  placeholder="Country"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rcountry" value=""></div>    
                            </div>
                            
                            <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['state']; ?>" type="text" class="form-control reconsile"  placeholder="State"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rstate" value=""></div>    
                            </div>
                            
                            <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['city']; ?>" type="text" class="form-control reconsile"  placeholder="City"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rcity" value=""></div>    
                            </div>
                            
                            <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['first_name']; ?>" type="text" class="form-control reconsile"  placeholder="First Name"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rfirst_name" value=""></div>    
                            </div>

                            <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['last_name']; ?>" type="text" class="form-control reconsile"  placeholder="Last Name"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rlast_name" value=""></div>    
                            </div>
                            
                             <div class="row">
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[0]['linkedin']; ?>" type="text" class="form-control reconsile"  placeholder="Linkedin"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rlinkedin" value=""></div>    
                            </div>
                            
                             <div class="row">
                              <div class="col-md-10"><input readonly  value="<?php echo $reconcileOrg[0]['email']; ?>" type="text" class="form-control reconsile"  placeholder="Email"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="remail" value=""></div>    
                            </div>
                            
                             <div class="row">
                              <div class="col-md-10"><input readonly  value="<?php echo $reconcileOrg[0]['phone']; ?>" type="text" class="form-control reconsile"  placeholder="Phone"></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rphone" value=""></div>    
                            </div>
                            
                             <div class="row">
                              <div class="col-md-10"><textarea readonly rows="4"  name="comment" form="usrform" class="form-control reconsile" placeholder="Description"><?php echo $reconcileOrg[0]['description']; ?></textarea></div>
                                <div class="col-md-1"><input class="reconsile-radio" type="radio" name="rdescription" value=""></div>    
                            </div>
                          
                        
                        
                      </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                      <div class="form-heading"><h2>CrunchBase</h2></div>
                        <div class="form-group">
                           <div class="row">
                               <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rname" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['formal_company_name']; ?>" type="text" class="form-control reconsile"  placeholder="Company Name"></div>
                            </div>
                            
                            <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rcountry" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['country']; ?>" type="text" class="form-control reconsile"  placeholder="Country"></div>
                            </div>
                            
                            <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rstate" value=""></div>    
                              <div class="col-md-10"><input readonly  value="<?php echo $reconcileOrg[1]['state']; ?>" type="text" class="form-control reconsile"  placeholder="State"></div>
                            </div>
                            
                            <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rcity" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['city']; ?>" type="text" class="form-control reconsile"  placeholder="City"></div>
                            </div>
                            
                            <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rfirst_name" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['first_name']; ?>" type="text" class="form-control reconsile"  placeholder="First Name"></div>
                            </div>

                            <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rlast_name" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['last_name']; ?>" type="text" class="form-control reconsile"  placeholder="Last Name"></div>
                            </div>
                            
                             <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rlinkedin" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['linkedin']; ?>" type="text" class="form-control reconsile"  placeholder="Linkedin"></div>
                            </div>
                            
                             <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="remail" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['email']; ?>" type="text" class="form-control reconsile"  placeholder="Email"></div>
                            </div>
                            
                             <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rphone" value=""></div>    
                              <div class="col-md-10"><input readonly value="<?php echo $reconcileOrg[1]['phone']; ?>" type="text" class="form-control reconsile"  placeholder="Phone"></div>
                            </div>
                            
                             <div class="row">
                              <div class="col-md-2"><input class="reconsile-radio" type="radio" name="rdescription" value=""></div>    
                              <div class="col-md-10"><textarea   readonly name="comment" rows="4" form="usrform" class="form-control reconsile" placeholder="Description"><?php echo $reconcileOrg[1]['description']; ?></textarea></div>
                            </div>
                          
                        
                        
                      </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12 reconsile">
                      <div class="form-heading"><h2>Final Prefrences</h2></div>
                        <?php 
                          echo $this->Form->create(null,['url' => ['controller' => 'Organizations', 'action' => 'reconcileSave'],'id' => 'finalReconsileForm']); 
                          echo $this->Form->input('id',['type' => 'hidden','value' => $reconcileOrg[1]['id']]); 
                          echo $this->Form->input('delete_id',['type' => 'hidden','value' => $reconcileOrg[0]['id']]); 
                          ?>
                        <div class="form-group" id="finalReconsile">
                          
                           <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="Company Name" name="formal_company_name"></div>
                              
                            </div>
                            
                            <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="Country" name="country"></div>
                              
                            </div>
                            
                            <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="State" name="state"></div>
                              
                            </div>
                            
                            <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="City" name="city"></div>
                              
                            </div>
                            
                            <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="First Name" name="first_name"></div>
                              
                            </div>

                            <div class="row">
                              <div class="col-md-12"><input value="" type="text" class="form-control reconsile"  placeholder="Last Name" name="last_name"></div>
                              
                            </div>
                            
                             <div class="row">
                              <div class="col-md-12"><input  value="" type="text" class="form-control reconsile"  placeholder="Linkedin" name="linkedin"></div>
                              
                            </div>
                            
                             <div class="row">
                              <div class="col-md-12"><input   value="" type="text" class="form-control reconsile"  placeholder="Email" name="email"></div>
                              
                            </div>
                            
                             <div class="row">
                              <div class="col-md-12"><input   value="" type="text" class="form-control reconsile"  placeholder="Phone" name="phone"></div>
                              
                            </div>
                            
                             <div class="row">
                              <div class="col-md-12"><textarea  name="description" rows="4" class="form-control reconsile" placeholder="Description"></textarea></div>
                              
                            </div>
                          
                          </div>
                          <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <div class="row">
                <div class="col-lg-8" id="reconsileMsg"></div>
                <div class="col-lg-2  pull-right">
                 <button href="#" class="btn btn-success" id="saveReconsile"><i class="glyphicon glyphicon-list"></i> Reconsile</button>
                 </div>
                 <div class="col-lg-2  pull-right" style="display:none;">
                  <button href="#" class="btn btn-success" id="checkForReconsile"><i class="glyphicon glyphicon-list"></i> Continue</button>
                 </div>
                 </div>
            </div>
            </div>
            </div>
var xhr;
var xhr1;
var xhr2;
var xhr3;
$(document).ready(function(){
	$(document).on('click','button.cronButton',function(){
		var id = $(this).attr('divs');
		var isvis = $(document).find('#'+id).is(':visible')
		$(document).find('.cronButton').removeClass('active');
		$(this).addClass('active');
		$(document).find('.crondivs').hide();
		if(isvis){
			$(document).find('#'+id).fadeOut();			
			$(document).find('.cronButton').removeClass('active');
		} else{
			$(document).find('#'+id).fadeIn();						
		}
	});
	$(document).on('click','span.thump',function(){
		var self = $(this);
	    if(self.hasClass('userVote')){
	        return false;
	    }
		var review = 1;
        var oId = self.attr('oid');
		var thumb_state = self.attr('thumb_state');                
                
		var id = self.attr('id');
        var review_id = $(".review_id").val();
        if(self.hasClass('active')){
			review = 2;
		} else if(self.hasClass('down')){
			review = 0;
		} 
        if(self.hasClass('active')){
			var active = 'active';
		}
		var platform = '';
		if(self.hasClass('joyance')){
			platform = 'joyance';
		} else if(self.hasClass('tiresias')){
			var platform = 'tiresias';
		}
		$.ajax({
			url: siteURL+"Organizations/reviews",
			type: 'post',
			dataType: 'json',
			data: {review : review,organization_id: oId,id:id,review_id:review_id,platform : platform},
			success: function(data){
				if(data.status == 1){
					$(".review_id").val(data.id);
					if(platform == 'joyance'){
						self.parents('.emphasis').find('span.thump').not('.tiresias').removeClass('active');
					} else if(platform == 'tiresias'){
						self.parents('.emphasis').find('span.thump').not('.joyance').removeClass('active');
					} else {
						self.parents('.emphasis').find('span.thump').removeClass('active');
					}
					self.parents('.emphasis').find('span.thump').attr('id','');
                    if(review != 2){
                        self.addClass('active');					
                        self.parents('.emphasis').find('span.thump').attr('id',data.id);
                    }
					if($(document).find('.thump_details').length > 0){
						/*if(review == 0){
							$(document).find('span.userVote').addClass('active');
							$(document).find('span.userVote.active').removeClass('up').addClass('down');
						} else if(review == 1){
							$(document).find('span.userVote').addClass('active');
							$(document).find('span.userVote.active').removeClass('down').addClass('up');
						} else if(review == 2){
							$(document).find('span.userVote.active').removeClass('active');
						}*/
						location.reload();
					}
				} else if(data.status == 2){
					self.parents('.emphasis').find('span.thump').removeClass('active');   
				}
			}
		});
	});

/*	  $(document).on('click','span.thump_details',function(){
		var self = $(this);
                if(self.hasClass('userVote')){
                    return false;
                }
		var review = 1;
                var oId = self.attr('oid');
		var thumb_state = self.attr('thumb_state');
                
                
		var id = self.attr('id');
                var review_id = $(".review_id").val();
                if(self.hasClass('active')){
			review = 2;
		} else if(self.hasClass('down')){
			review = 0;
		} 
                if(self.hasClass('active')){
			var active = 'active';
		}

		var platform = '';
		if(self.hasClass('joyance')){
			platform = 'joyance';
		} else if(self.hasClass('tiresias')){
			var platform = 'tiresias';
		}
		$.ajax({
			url: siteURL+"Organizations/reviews",
			type: 'post',
			dataType: 'json',
			data: {review : review,organization_id: oId,id:id,review_id:review_id},
			success: function(data){
				if(data.status == 1){
                                  
                                        $(".review_id").val(data.id);
					self.parents('.emphasis').find('span.thump_details').removeClass('active');
					self.attr('id','');
                                        if(review != 2){
                                            self.addClass('active');					
                                            self.attr('id',data.id);
                                              location.reload();
                                        }
					if($(document).find('.userVote').length > 0){
						if(review == 0){
                                                       // $(document).find('span.userVote').addClass('active');
							//$(document).find('span.userVote.active').removeClass('up').addClass('down');
						} else if(review == 1){
                                                        //$(document).find('span.userVote').addClass('active');
							//$(document).find('span.userVote.active').removeClass('down').addClass('up');
						} else if(review == 2){
							//$(document).find('span.userVote.active').removeClass('active');
						}
                                                location.reload();
					}
				}
                                else if(data.status == 2){
                                    // $(".review_id").val('');
                                 self.parents('.emphasis').find('span.thump').removeClass('active');   
                                location.reload();
                                  
                                        
					
				}
			}
		});
	});*/

	$(document).on('click','a.clearAllCron',function(evt){
		evt.preventDefault();
		var url = $(this).attr('href');
		var sec = $(this).attr('sec');
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {sec : sec},
			success: function(data){
				if(data.status == 1){
					if(sec == 'category'){
						$('div#updateDiv').find('.verticals').removeClass('active');
						$('div#updateDiv').find('.verticals').find('input[type="hidden"]').prop('disabled',true);
					} else {
						$('div#verticalsDiv').find('.verticals').removeClass('active');
						$('div#verticalsDiv').find('.verticals').find('input[type="hidden"]').prop('disabled',true);
					}
				}
			}
		});
	});


	$(document).on('click','div.verticals',function(){
		if($(this).hasClass('active')) {
			$(this).find('input:first').prop('disabled', true);
			$(this).find('input:last').prop('disabled', false);
			$(this).removeClass('temp');

		} else {
			$(this).find('input:first').prop('disabled', false);
			$(this).find('input:last').prop('disabled', true);
			$(this).addClass('temp');
		}
		$(this).toggleClass('active');
	});

	$(document).on('click','button.saveCronSetting',function(){
		var varticals = [];
		var removed = [];
		if($(this).attr('sec') == 'category'){
			var cron = 'category';
			$('input.categoryInp:enabled').each(function(){
				varticals.push($(this).val());
			});
			$('input.categoryInprm:enabled').each(function(){
				removed.push($(this).val());
			});
		} else {
			var cron = 'vertical';
			$('input.verticalsInp:enabled').each(function(){
				varticals.push($(this).val());
			});
			$('input.verticalInprm:enabled').each(function(){
				removed.push($(this).val());
			});
		}		
		if(varticals.length <= 0 &&  removed.length <= 0){
			swal('Select at least one '+cron);
			return false;
		}
		$.ajax({
			url: siteURL+"Users/saveCronCategories",
			type: 'post',
			dataType: 'json',
			data: { ids : varticals, cron : cron, remove: removed},
			success: function(data){
				if(data.status == 1){
					swal('Cron settings has been save successfully.');
					$(document).find('.verticals').removeClass('temp');
				} else {
					swal('Something gone wrong please try again.');
				}
			}
		});
	});

	$(document).on('click','#myTab li a', function (){
		var tab = $(this).attr('id');
		if(tab == 'home-tab'){
			var lnth = $('#tab_content2').find('.temp').length;
			if(lnth > 0){
				setTimeout(function(){
					$('div#tab_content1').removeClass('active').removeClass('in');
					$('div#tab_content2').addClass('active').addClass('in');
				},500);
				$('#home-tab').parent().removeClass('active');
				$('#profile-tab').parent().addClass('active');
				swal('Save selected categories.');
			}
		} else if(tab == 'profile-tab'){
			var lnth = $('#tab_content1').find('.temp').length;
			if(lnth > 0){
				setTimeout(function(){
					$('div#tab_content2').removeClass('active').removeClass('in');
					$('div#tab_content1').addClass('active').addClass('in');
				}, 500);
				$('#home-tab').parent().addClass('active');				
				$('#profile-tab').parent().removeClass('active');
				swal('Save selected verticals.');
			}
		}		
		
	});

	$(document).on('keyup','input#croncatSearch',function(){
		var selfElm = $(this);
		$.ajax({
			url: siteURL+"Users/categories",
			type: 'post',
			dataType: 'HTML',
			data: { keyword : selfElm.val() },
			success: function(data){
				$('div#updateDiv').html(data);
			}
		});
	});

	$(document).on('click','div#categoryPaginations div ul.pagination li  a',function(evt){
		evt.preventDefault();			
		var selfElm = $(this);
		if($.trim(selfElm.attr('href')) == ''){
			return false;
		}
		var varticals = [];
		var removed = [];
		var cron = 'category';
		$('input.categoryInp:enabled').each(function(){
			varticals.push($(this).val());
		});
		$('input.categoryInprm:enabled').each(function(){
				removed.push($(this).val());
			});
		if(varticals.length > 0 || removed.length > 0){
			$.ajax({
				url: siteURL+"/Users/saveCronCategories",
				type: 'post',
				dataType: 'json',
				data: { ids : varticals, cron : cron, remove: removed },
				success: function(data){
				}
			});
		}
		var url = selfElm.attr('href');
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'HTML',
			success: function(data){
				$('div#updateDiv').html(data);
			}
		});
	});
	setTimeout(function(){ $('div.alert').fadeOut(1000); }, 3000);
});

$(window).load(function(){
	$('div.right_col').css('min-height',($(window).height() - $('div.nav_menu').outerHeight()));
});

$("#UploadOnBaseCRM").on('click',function(e) {
	e.preventDefault();
	$('span.OrganizationsSrn,a#UploadOnBaseCRMbutton').toggle();
	$(this).toggle();
	$('input.OrganizationsInput').toggle().prop('checked', false);
});

$("a#UploadOnBaseCRMbutton").on('click',function(e) {
	if($('input.OrganizationsInput:checked').length < 1 ){
		alert('Please check at least one Organizaton');
		return false;
	}
	var org = [];
	$('input.OrganizationsInput:checked').each(function(){
		org.push($(this).attr('id'));
	});
	$.ajax({
		    type : 'POST',
		    url : siteURL+"Users/basecrmCreateOrganizaton",
		    data : {org : org},
		    dataType : 'json',
		    beforeSend: function(){                
                $("a#UploadOnBaseCRMbutton").after('<div class="fa fa-circle-o-notch fa-spin" id="wheel"></div>');
            },
		    success: function(data){
		    	$(document).find('div#wheel').remove();
		    	$('input.OrganizationsInput:checked').parents('tr').remove();
		    	$('span.OrganizationsSrn, a#UploadOnBaseCRM,input.OrganizationsInput,a#UploadOnBaseCRMbutton').toggle();				
		    }
		});
});


$("form#organizationFilter").on('submit',function(e) {
      e.preventDefault();
      var url = $(this).attr('action')+"?paginationCountChange="+$('select#pageListCount').val();
        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(), // serializes the form's elements.
               beforeSend: function(){                
                    $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
                },   
               success: function(data)
               {
                 $("#divUpdate").html(data);
               }
             });
         // avoid to execute the actual submit of the form.
    });

$("#orgListSearchInput").on('keyup',function(e) {
	  e.preventDefault();
      var url = $('form#organizationFilter').attr('action')+"?paginationCountChange="+$('select#pageListCount').val();
      xhr = $.ajax({
               type: "POST",
               url: url,
               data: {search: $('#orgListSearchInput').val()},
               beforeSend: function(){
               		if(xhr && xhr.readyState != 4){
            			xhr.abort();
				    }
                    $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
                },   
               success: function(data)
               {
                 $("#divUpdate").html(data);
               }
             });
         // avoid to execute the actual submit of the form.
    });

	$(document).on('submit','form.addCommentForm',function(evt){
		evt.preventDefault();
		var comment = $(this).find('textarea.commentTextatea').val();
		if( $.trim(comment) == '' ) {
                        $(".errorShow").html('');
			$(this).find('textarea.commentTextatea').after( '<span class="errorShow">Please Add Comment</span>' );
			return false;
		}
		var data = $(this).serialize( );
                
		var url = $(this).attr( 'action' );
		$.ajax({
		    type : 'POST',
		    url : url,
		    data : data,
		    dataType : 'json',
		    success: function(data) {
		    	$(document).find('span.errorShow').remove( );
		    	if( data.status == 1 ) {
					 $(".heading").html(data.name);	
                                         $(".message").html(data.comment);
					$( '.modal' ).modal( 'hide' );
		    	} else {
		    		alert( 'something went wrong try again' );
		    	}
		    }
		});
	});
	//for details page comment form
            $(document).on('submit','form.details_form_comment',function(evt){
		evt.preventDefault();
		var comment = $(this).find('textarea.commentTextatea').val();
		if( $.trim(comment) == '' ) {
                        $(".errorShow").html('');
			$(this).find('textarea.commentTextatea').after( '<span class="errorShow">Please Add Comment</span>' );
			return false;
		}
		var data = $(this).serialize( );
                
		var url = $(this).attr( 'action' );
		$.ajax({
		    type : 'POST',
		    url : url,
		    data : data,
		    dataType : 'json',
		    success: function(data) {
		    	$(document).find('span.errorShow').remove( );
		    	if( data.status == 1 ) {
                                              location.reload();
                                         //$(".message").html(data.comment);
                                        // $(".heading").html(data.name);
					$( '.modal' ).modal( 'hide' );
                                        
		    	} else {
		    		alert( 'something went wrong try again' );
		    	}
		    }
		});
	});
        //end of code
	$(document).on('keyup','input#category-name',function(evt){
		evt.preventDefault();
		xhr1 = $.ajax({
		    type : 'POST',
		    url : siteURL+'Organizations/categorySearch',
		    data : {keyword : $.trim($(this).val()) },
		    dataType : 'json',
		    beforeSend: function(){
           		if(xhr1 && xhr1.readyState != 4){
        			xhr1.abort();
			    }
			}, 
		    success: function(data) {
		    	var html = '';
		    	if(data.status == 1){
		    		$.each(data.data, function(key, value) {
		    			if(typeof value != 'undefined'){
		    				html += '<li id="'+key+'">'+value+'</li>';
		    			}
		    		});		    		
		    	} else {
		    		html += '<li>No Record Found</li>';
		    	}
		    	$('div.autoComplete ul').html(html);
		    	$('div.autoComplete').fadeIn('slow');
		    }
		});
	});
	
	$(document).on('click','div.autoComplete ul li',function(evt){
		evt.preventDefault();
		$('input#category-name').val($(this).text());
		$('div.autoComplete').fadeOut('slow');
	});

	$(document).on('click','span.reconsileClose',function(evt){
		evt.preventDefault();
		$(document).find('div.reconcilecon').fadeOut('slow');
		$(document).find('div.reconcileconOverlay').hide();
		location.reload();
		$('div.reconcilecon, div.reconcileconOverlay').fadeOut();
	});

	$(document).on('click','span.reconcile',function(evt){
		var id1 = $(this).attr('id1');
		var id2 = $(this).attr('id2');
		$(this).addClass('active');
		reconsile(id1,id2);
	});

	$(document).on('click','input.reconsile-radio',function(evt){
		var val = $(this).parent().parent().find('.reconsile').val();
		var ind = $(this).parent().parent().index();
		$('div#finalReconsile').find('div.row:eq('+ind+')').find('.reconsile').val(val).removeClass('error');
	});


	$(document).on('click','#saveReconsile',function(evt){
		evt.preventDefault();
		var chekced = $('.reconsile-radio:checked').length;
		if(chekced < 10){
			swal('Select all fields');
			return false;
		}
		xhr3 = $.ajax({
		    type : 'POST',
		    url : siteURL+'Organizations/reconcileSave',
		    data : $('form#finalReconsileForm').serialize(),
		    dataType : 'json',
		    beforeSend: function() {
           		if(xhr3 && xhr3.readyState != 4){
        			xhr3.abort();
			    }
			},
		    success: function(data) {
		    	if(data.status == 1){
		    		if(data.count > 1){
		    			$('div#reconsileMsg').text('Here '+data.count+' More Organizations to reconcile.');
		    			$('#checkForReconsile').attr({'reconcile':data.reconcile,'id1':data.id1,'id2':data.id2,}).parent().show();
		    			$('#saveReconsile').parent().hide();
		    		} else {

		    			$(document).find('span.reconcile.active').remove();
		    			$(document).find('div.reconcilecon').fadeOut('slow').html();
		    			$(document).find('div.reconcileconOverlay').hide();
		    		}
		    		swal('Reconsilation has been done.');
		    	} else {
		    		swal('Sonething Went wrong. Please try again.');
		    	}
		    }
		});
	});

	$(document).on('click','#checkForReconsile',function(evt){
		if($(this).attr('reconcile') == 0){
			swal('Record no found.');
			return false;
		}
		var id1 = $(this).attr('id1');
		var id2 = $(this).attr('id2');		
		reconsile(id1,id2);
	});

function reconsile(id1,id2){
	xhr2 = $.ajax({
		    type : 'POST',
		    url : siteURL+'Organizations/reconcile',
		    data : { id1 : id1, id2 : id2 },
		    dataType : 'HTML',
		    beforeSend: function() {
           		if(xhr2 && xhr2.readyState != 4){
        			xhr2.abort();
			    }
			},
		    success: function(data) {
		    	$(document).find('div.reconcilecon').fadeIn('slow').html(data);
		    	$(document).find('div.reconcileconOverlay').show();
		    }
		});
}
$(document).on('change','#organizationFilter #funding-type',function(eve) {

    if($(this).val()=='any') {
        $('.funding_type_any').css('display','block');
     
    }
    else {
        $('.funding_type_any').css('display','none');
    }
    });
$(document).on('change','#organizationFilter #source',function(eve) {

    if($(this).val()=='crunchbase') {
        $('.funding_type').css('display','block');
        $('.recently-funded-div').css('display','block');
        $('.funding_type_any').css('display','block');
        $('.country_div').css('display','block');
	$(".reset_default").css('display','block');
	$(".add-filter").css('display','block');
       // $('.recently-funded-div').show();
        ///$('#recently-funded').val(0);
    }else {
        $('.funding_type').css('display','none');
        $('.country_div').css('display','none');
        $('.funding_type_any').css('display','none');
        $('.recently-funded-div').css('display','none');
        $('.recently-funded-div').hide();
	$(".reset_default").css('display','none');
 	$(".add-filter").css('display','none');
        //$('#recently-funded').val(0);
    }
});

/*$(document).on('change','#organizationFilter #funding-type',function(eve) {
    $(".recently-funded-div").css('display','block');
});*/

$(document).on('click', 'a.organisationDelete', function(evt){
	evt.preventDefault();
	var selfD = $(this);
	var url = selfD.attr('href');
	if(confirm('Are you sure to delete company?')){
		$.ajax({
		    type : 'POST',
		    url : url,
		    dataType : 'JSON',
		    beforeSend: function() {
		    	selfD.fadeOut();
           	},
		    success: function(data) {
		    	if(data.status == 1){
		    		selfD.parents('.profile_details').remove();
		    	} else {
		    		alert('Try Again. Something went wrong.');
		    	}
		    }
		});
	}
});


$(document).on('change', '#importPortfolioFile', function(evt){
		$('#importPortfolio').submit();
});
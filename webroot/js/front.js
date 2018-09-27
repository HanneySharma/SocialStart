$(document).ready(function(){

	if($('#login').length != 0){

		$('#login').validate({
	        ignore: [],
	        rules: {
	            username: {
	            	required: true,
	            	email: true,
	            },
	            password: {
	            	required: true,
	            }
	        },
	        messages: {
	            username: {
	                required: "username is required.",
	            },
	            password: {
	                required: "Password is required.",
	            }
	        }
	    });
	}

	if($('#forgotpassword').length != 0){

		$('#forgotpassword').validate({
	        ignore: [],
	        rules: {
	            email: {
	            	required: true,
	            	email: true,
	            }
	        },
	        messages: {
	            email: {
	                required: "Email is required.",
	            }
	        }
	    });
	}

	if($('#resetpassword').length != 0){

		$('#resetpassword').validate({
	        ignore: [],
	        rules: {
	            password: {
	            	required: true,
	            },
	            confirm_password: {
	            	required: true,
	            	equalTo: "#password"
	            }
	        },
	        messages: {
	            password: {
	                required: "username is required.",
	            },
	            confirm_password: {
	                required: "Password is required.",
	            }
	        }
	    });
	}

});
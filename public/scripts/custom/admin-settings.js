var SettingsFormValidations = function () {

	var handleValidations = function() {

		$('#settings_form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
					notification_email: {
	                    required: true,
						email:true
	                },
					test_stripe_public_key: {
	                    required: true,
					
	                },
					test_stripe_secret_key: {
	                    required: true,
	                },
					live_stripe_public_key: {
	                    required: true,
					
	                },
					live_stripe_secret_key: {
	                    required: true,
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('#settings_form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            }
	        });
	}

    return {
        //main function to initiate the module
        init: function () {
            handleValidations();
        }
    };
}();

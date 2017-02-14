jQuery(document).ready(function($) {

	$.validator.addMethod("card_expiry", function(value, element) {
		return this.optional(element) || Stripe.card.validateExpiry(value);
	}, "Your card's expiration year is invalid.");

	$.validator.addMethod("card_number", function(value, element) {
		return this.optional(element) || Stripe.card.validateCardNumber(value);
	}, "Please enter a valid credit card number.");

	$.validator.addMethod("card_cvc", function(value, element) {
		return this.optional(element) || Stripe.card.validateCVC(value);
	}, "Your card's security code is invalid.");

    $('#add_card_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            card_number: {
                required: true,
                card_number: true
            },
            expiry: {
                required: true,
                card_expiry: true
            },
            card_cvc: {
            	required: true,
            	card_cvc: true
            },
            country: {
                required: true,
            }
        },
        invalidHandler: function(event, validator) { //display error alert on form submit
            $('.alert-danger', $('#add_card_form')).show();
        },
        highlight: function(element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        success: function(label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        submitHandler: function (form) {
            initStripeCardToken();
        }
    });

   	function initStripeCardToken() {
        $('#spinner').show();
        $('#error_add_card').hide();
		Stripe.card.createToken({
			number: $('#card_number').val(),
			cvc: $('#card_cvc').val(),
			exp: $('#expiry').val(),
			address_country: $('#country').val()
		}, stripeResponseHandler);
	}


    function stripeResponseHandler(status, response) {
        // Grab the form:
        if (response.error) { // Problem!
            // Show the errors on the form
            $('#error_add_card').html(response.error.message).show();
        } else { // Token was created!
            // Get the token ID:
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server:
            $('#add_card_form').append($('<input type="hidden" name="token">').val(token));
            $('#add_card_form').append($('<input type="hidden" name="brand">').val(response.card.brand));
            $('#add_card_form').append($('<input type="hidden" name="cardNumber">').val(response.card.last4));
            // Submit the form:
            $('#add_card_form').get(0).submit();
        }
    }
});
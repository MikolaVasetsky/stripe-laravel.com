var TableAjaxCustomerList = function () {



    var initPickers = function () {

        //init date pickers

        $('.date-picker').datepicker({

            rtl: App.isRTL(),

            autoclose: true

        });

    }



    var handleRecords = function() {



        var grid = new Datatable();

            grid.init({

                src: $("#datatable_ajax"),

                onSuccess: function(grid) {

                    // execute some code after table records loaded

                },

                onError: function(grid) {

                    // execute some code on network or other general error  

                },

                dataTable: {  // here you can define a typical datatable settings from http://datatables.net/usage/options 

                    /* 

                        By default the ajax datatable's layout is horizontally scrollable and this can cause an issue of dropdown menu is used in the table rows which.

                        Use below "sDom" value for the datatable layout if you want to have a dropdown menu for each row in the datatable. But this disables the horizontal scroll. 

                    */

                    //"sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>", 

                   

                    "aLengthMenu": [

                        [20, 50, 100, 150, -1],

                        [20, 50, 100, 150, "All"] // change per page values here

                    ],

                    "iDisplayLength": 20, // default record count per page

                    "bServerSide": true, // server side processing

                    "sAjaxSource": project_url+"/admin/customer/customerslist", // ajax source

                    "aaSorting": [[ 3, "desc" ]], // set first column as a default sort by asc
					

                }

            });



    }



    return {



        //main function to initiate the module

        init: function () {



            initPickers();

            handleRecords();

        }



    };



}();

var CustomerFormValidations = function () {

	var handleValidations = function() {

		$('.customer_details').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
					name: {
	                    required: true,
	                },
	                email: {
	                    required: true,
						email: true
	                },
	                password: {
	                    required: true,
						minlength: 6
	                },
					cpassword: {
	                    required: true,
						equalTo: "#password"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.customer_details')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },


	            submitHandler: function (form) {
	                form.submit(); // form validation success, call ajax form submit
	            }
	        });

	        $('.customer_details input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.customer_details').validate().form()) {
	                    $('.customer_details').submit(); 
	                }
	                return false;
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


var UpdateCustomerFormValidations = function () {

	var handleValidations = function() {

		$('.update_customer_details').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
					name: {
	                    required: true,
	                },
	                email: {
	                    required: true,
						email: true
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.update_customer_details')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },


	            submitHandler: function (form) {
	                form.submit(); // form validation success, call ajax form submit
	            }
	        });

	        $('.update_customer_details input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.update_customer_details').validate().form()) {
	                    $('.update_customer_details').submit(); 
	                }
	                return false;
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


var TableAjaxCustomerAccountsList = function () {



    var handleRecords = function(user_id) {



        var grid = new Datatable();

            grid.init({

                src: $("#user_accounts_datatable"),

                dataTable: {  

                    "aLengthMenu": [

                        [20, 50, 100, 150, -1],

                        [20, 50, 100, 150, "All"] // change per page values here

                    ],

                    "iDisplayLength": 20, // default record count per page

                    "bServerSide": true, // server side processing

                    "sAjaxSource": project_url+"/admin/customer/useraccounts/"+user_id, // ajax source

                    "aaSorting": [[ 7, "desc" ]] // set first column as a default sort by asc

                }

            });



    }



    return {



        //main function to initiate the module

        init: function (user_id) {



            handleRecords(user_id);

        }



    };



}();



var TableAjaxCustomerCardsList = function () {
    var handleRecords = function(user_id) {
        var grid = new Datatable();
            grid.init({
                src: $("#user_cards_datatable"),
                dataTable: {
                    "aLengthMenu": [
                        [20, 50, 100, 150, -1],
                        [20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "iDisplayLength": 20, // default record count per page
                    "bServerSide": true, // server side processing
                    "sAjaxSource": project_url+"/admin/customer/usercards/"+user_id, // ajax source
                    "aaSorting": [[ 5, "desc" ]] // set first column as a default sort by asc
                }
            });
    }
    return {
        //main function to initiate the module
        init: function (user_id) {
            handleRecords(user_id);
        }
    };
}();


var ChargeAmountFormValidations = function () {



	var handleValidations = function() {



		$('.charge_form').validate({

	            errorElement: 'span', //default input error message container

	            errorClass: 'help-block', // default input error message class

	            focusInvalid: false, // do not focus the last invalid input

	            rules: {

	                amount: {

	                    required: true,

						number: true

	                }

	            },



	            invalidHandler: function (event, validator) { //display error alert on form submit   

	                $('.alert-danger', $('.charge_form')).show();

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



/*Customer Account Payment History*/

var TableCustomerPaymentHistory = function () {



    var handleRecords = function(account_id) {



        var grid = new Datatable();

            grid.init({

                src: $("#customer_payment_history"),

                dataTable: {  

                    "aLengthMenu": [

                        [20, 50, 100, 150, -1],

                        [20, 50, 100, 150, "All"] // change per page values here

                    ],

                    "iDisplayLength": 20, // default record count per page

                    "bServerSide": true, // server side processing

                    "sAjaxSource": project_url+"/admin/customer/userpaymenthistory/"+account_id, // ajax source

                    "aaSorting": [[ 5, "desc" ]] // set first column as a default sort by asc

                }

            });



    }



    return {



        //main function to initiate the module

        init: function (account_id) {



            handleRecords(account_id);

        }



    };



}();


/*Customer Account Payment History*/
var TableCustomerAccountPaymentHistory = function () {

    var handleRecords = function(account_id) {

        var grid = new Datatable();
            grid.init({
                src: $("#account_payment_history"),
                dataTable: {  
                    "aLengthMenu": [
                        [20, 50, 100, 150, -1],
                        [20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "iDisplayLength": 20, // default record count per page
                    "bServerSide": true, // server side processing
                    "sAjaxSource": project_url+"/admin/customer/listpaymenthistory/"+account_id, // ajax source
                    "aaSorting": [[ 5, "desc" ]] // set first column as a default sort by asc
                }
            });

    }

    return {

        //main function to initiate the module
        init: function (account_id) {

            handleRecords(account_id);
        }

    };

}();
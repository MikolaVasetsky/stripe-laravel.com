



var ChargeCustomerFormValidations = function () {

	var handleValidations = function() {

		$('#customer_charge_form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
					customer_id: {
	                    required: true,
					
	                },
					account_id: {
	                    required: true,
	                },
	                amount: {
	                    required: true,
						// number: true
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('#customer_charge_form')).show();
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

var GetCustomerAccounts = function () {

    var handleCustomerAccounts = function(customer_id){
		jQuery.ajax({
		   url:project_url+'/admin/dashboard/customeraccounts',
		   type:'POST',
		   dataType:'json',
		   data:{customer_id:customer_id},
		   success:function(data){
			   var accounts_list="<option value=''>Select Account</option>";
			   if(data!=="")
			   {
				    $.each(data, function( id, value ) {
						accounts_list+='<option value='+value.id+' data-type='+value.type+'>'+value.text+'</option>';
					});
					jQuery('#account_id').html(accounts_list);
					jQuery(".dataTables_processing").hide();
			   }
		   },
		   beforeSend:function(){
			   jQuery(".dataTables_processing").show();
		   }
		  });
    }
	
	var handleAcccounts = function(){
		
		jQuery(document).ready(function(){
           var customer_id = jQuery('#customer_id').val();
           if(customer_id !=="")
           {
               handleCustomerAccounts(customer_id);
           }
        });       
        jQuery('#customer_id').change(function(){
           var customer_id = $(this).val();
           if(customer_id!="")
           {
			   //alert("dsfds"+customer_id);
               handleCustomerAccounts(customer_id);
           }
        });
	}
    return {
        //main function to initiate the module
        init: function () {
            handleAcccounts();
        }
    };
}()


/*Customer Account Payment History*/

var TablePaymentHistory = function () {



    var handleRecords = function() {



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

                    "sAjaxSource": project_url+"/admin/dashboard/listtransactions", // ajax source

                    "aaSorting": [[ 8, "desc" ]] // set first column as a default sort by asc

                }

            });



    }



    return {



        //main function to initiate the module

        init: function () {



            handleRecords();

        }



    };



}();
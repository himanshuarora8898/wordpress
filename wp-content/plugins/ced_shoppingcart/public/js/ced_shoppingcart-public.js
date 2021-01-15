(function( $ ) {
	'use strict';
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
			   var address =$('#address').val();
			   var state =$('#state').val();
			   var city =$('#city').val();
			   var pincode =$('#pincode').val();
			   $('#shipaddress').val(address);
			   $('#shipstate').val(state);
			   $('#shipcity').val(city);
			   $('#shippincode').val(pincode);

			}
			else{
				$('#shipaddress').val("");
			   $('#shipstate').val("");
			   $('#shipcity').val("");
			   $('#shippincode').val("");
			}
		});

		$("#addtocart").click(function(){
			alert("Product added successfully");
		});
		
		var invent=$("#invent").val();
		var quant=$("#quant").val();
		if(quant>invent){
			alert("Available stock is"+ invent);
		}
	});
	$(document).ready(function(){
		$('#checkout').click(function(){
			alert("Thanks for shopping with us");
			window.location.href="http://192.168.2.127/wordpress/thankyou/";

		});
	});
	$(document).ready(function(){
		var inventory = $('#error').val();
		if(inventory == '0'){
			$('#out').show();
			$("#out").html('*Out Of Stock');
		}
		else{
			$('#out').hide();
		}
	});

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

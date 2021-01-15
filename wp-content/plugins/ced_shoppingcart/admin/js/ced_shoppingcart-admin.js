(function( $ ) {
	'use strict';
	$(document).ready(function()
	{
		$('#dprice').focusout(function()
		{
			var dprice = $('#dprice').val();
			var price = $('#price').val();
			// console.log(dprice,price);
			if(dprice >price)
			{
				console.log(dprice,price);
				$('#dprice').val(" ");
				$('#derror').show();
				$('#derror').html("*Discounted price cannot be greater than regular price");
				$('#derror').css("color","red");
				
			}
			else{
				$('#derror').hide();
			}
		});
		
		

	});
	/**
	 * All of the code for your admin-facing JavaScript source
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

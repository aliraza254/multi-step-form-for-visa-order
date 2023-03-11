(function( $ ) {
	'use strict';

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

	// $(document).find(".single_add_to_cart_button").click(function(e){
	//     e.preventDefault();
	//     $('.sb_required').css('border', '1px solid #aaaaaa');
	//     var valid = 1;
	//     $(this).closest('.tab_parent').find('.sb_required').each(function (){
	//         if($(this).val() == ''){
	//             $(this).css('border', '1px solid red');
	//             valid = 0;
	//         }
	//     });
	//     if(valid == 1){
	//         $(this).closest('form').submit();
	//     }
	// });
	$(document).find(".next_step").click(function(e){
		$('.sb_required').css('border', '1px solid #30c7b5');
		var valid = 1;
		$(this).closest('.tab_parent').find('.sb_required').each(function (){
			if($(this).val() == ''){
				$(this).css('border', '1px solid red');
				valid = 0;
			}
		});
		var id = $(this).attr('data-next');
		if(valid == 1){
			if(id == 'submit'){
				$(this).closest('form').submit();
			}
			else{
				$('.tab_parent').hide();
				$('#'+id).show();
			}
		}
	});
	$(document).find(".prev_step").click(function(e){
		var id = $(this).attr('data-prev');
		$('.tab_parent').hide();
		$('#'+id).show();
	});
	$("#add_passenger").click(function(e){
		e.preventDefault();
		var count = $('.wts_passenger').length;
		$(document).find('.sb_qty').val(count);
		count = parseInt(count) + parseInt(1);
		$("#wts_passenger_added").append('<div class="wts_passenger"><label>Passenger '+ count +`:</label>
		<div class="d-flex-content">
			<p class="width-mar"><input type="text" placeholder="First name" name="first_name_p`+ count +`" required></p>
			<p class="width-mar"><input type="text" placeholder="Last name" name="last_name_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="date"  name="dob_p`+ count +`" required></p>
			<p class="width-mar"><input type="text" placeholder="Passport Number" name="pass_num_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="date" name="pass_issue_p`+ count +`" required></p>
			<p class="width-mar"><input type="date" name="pass_ex_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="file" name="passport_p`+ count +`" required></p>
			<p class="width-mar"><input type="file" name="profile_p`+ count +`" required></p>
		</div>
		<input type="hidden" name="passenger_count[]" /> </div>`);
	});

})( jQuery );


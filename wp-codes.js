(function($){
	$(document).ready(function() {
		/*----------------------------------------------------
		# Google Map Widget Disabler
		----------------------------------------------------*/
		/*
		This codes can be used to disable auto zoom when by any chance you hover on the wordpress google maps widget.

		Like for instance you added a google maps widget via visual composer or shortcode in a page such as contact page for example, by default whenever you scroll down and when the cursor touches the map it will stop scrolling down then it will zoom in the map. 

		So to prevent that from happening and for you or the visitor to not get annoyed add this in your script.js/functions.js

		NOTE: DON'T FORGET TO ADD THIS TO YOUR style.css in your theme, can be anywhere.

		.active-overlay {
			pointer-events: none;
		}

		*/
		$( '.wpb_gmaps_widget .wpb_map_wraper' ).addClass('active-overlay');

		$( '.wpb_gmaps_widget .wpb_wrapper' ).click(function() {
			$('.wpb_gmaps_widget .wpb_map_wraper').removeClass('active-overlay');
		});

		$( '.wpb_gmaps_widget .wpb_wrapper' ).mouseleave(function() {
			$('.wpb_gmaps_widget .wpb_map_wraper').addClass('active-overlay');
		});

		/*----------------------------------------------------
		# Lazy Hover, Target and Background
		----------------------------------------------------*/
		/*
			There's this client that loves making div's clickable and hoverable so I made this lines of codes for me to use whenever he wants it to be hoverable and when clicked redirects you to another location

			Usage:
			<div data-hover="true" data-target="http://location.to.com" data-bg="http://domina.com/path/to/image.jpg">
				// Whatever it is inside the div
			</div>
		*/
		$('*').find('[data-hover]').each(function(index, value) {
			if( $(this).data('hover') ) {
				$(this).css({cursor:'pointer'});
			}
		});

		$('*[data-target]').click(function() {
			window.location = $(this).data('target');
		});


		$('*').find('[data-bg]').each(function(index, value) {
			$(this).css({
				backgroundImage:'url('+$(this).data('bg')+')',
				backgroundSize:'cover',
				backgroundPosition:'center',
			});
		});
		

	});

	$(window).load(function() {

	});
})(jQuery);
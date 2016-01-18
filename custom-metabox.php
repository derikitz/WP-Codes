<?php

function custom_metaboxes() {

	add_meta_box( 
		'event_extra_fields_box_id', 
		__( 'Event Details' ), 
		'event_extra_fields_box_form', // Callback
		'event', 
		'normal', 
		'high'
	);

}

add_action( 'add_meta_boxes', 'custom_metaboxes' );



/*-----------------------------------------
# Metabox Callbacks
-----------------------------------------*/

// Event Metabox Callback
function event_extra_fields_box_form($post) { 
	wp_nonce_field( plugin_basename( __FILE__ ), 'event_extra_fields_box_nonce' );	?>
	<style type="text/css">
	.event_metabox table {width:100%;}
	.event_metabox td {width: 50%;}
	.event_metabox input {width:100%;}
	</style>
		<table border="0" style="width:100%" class="event_metabox">
			<tr>
				<td colspan="2">
					<p style="text-align:center"><strong>EVENT SCHEDULE</strong></p>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><label>Start Date:</label></td>
							<td><input type="text" name="event_start_date" id="event_start_date" class="datepicker" value="<?php echo get_post_meta( $post->ID, 'event_start_date', true ) ?>"></td>
						</tr>
						<tr>
							<td><label>Time:</label></td>
							<td><input type="text" name="event_start_time" id="event_start_time" class="timepicker" value="<?php echo get_post_meta( $post->ID, 'event_start_time', true ) ?>"></td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td><label>End Date:</label></td>
							<td><input type="text" name="event_end_date" id="event_end_date" class="datepicker" value="<?php echo get_post_meta( $post->ID, 'event_end_date', true ) ?>"></td>
						</tr>
						<tr>
							<td><label>Time:</label></td>
							<td><input type="text" name="event_end_time" id="event_end_time" class="timepicker" value="<?php echo get_post_meta( $post->ID, 'event_end_time', true ) ?>"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><label>Event Location:</label></td>
				<td><textarea cols="5" rows="3" name="event_location" id="event_location" style="width:445px;max-width:445px"><?php echo get_post_meta( $post->ID, 'event_location', true )?></textarea></td>
			</tr>
		</table>
<?php } //End of Event_extra_fields_box_form


/*-----------------------------------------
# Save Posts
-----------------------------------------*/
function metabox_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}

	if ( 'event' == $_POST['post_type'] ) {

		if ( !wp_verify_nonce( $_POST['event_extra_fields_box_nonce'], plugin_basename( __FILE__ ) ) )
			return;

		$start_date = $_POST['event_start_date'];
		$start_time = $_POST['event_start_time'];

		$end_date = $_POST['event_end_date'];
		$end_time = $_POST['event_end_time'];

		$location = $_POST['event_location'];


		update_post_meta( $post_id, 'event_start_date', $start_date );
		update_post_meta( $post_id, 'event_start_time', $start_time );

		update_post_meta( $post_id, 'event_end_date', $end_date );
		update_post_meta( $post_id, 'event_end_time', $end_time );

		update_post_meta( $post_id, 'event_location', $location );

	}
}
add_action( 'save_post', 'metabox_save' );

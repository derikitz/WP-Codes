<?php
// I had to add this PHP values because it was under a shared 
// server so the administrator didn't allow me to update the php values
// Uncomment if you want to use them
// ini_set('max_execution_time', 10000);
// ini_set('memory_limit', '128M');

// Including wordpress includes gives you everything wordpress has to offer
include('wp-load.php');

// This was needed for File operations 
require_once( './wp-admin/includes/file.php' );
// This was needed for Attachment operations 
require_once( './wp-admin/includes/image.php' );

// The HTML parser is a must have script for parsing HTML
include_once './get_html/simple_html_dom.php';
// The HTML content that you want to parse
/*
I saved the HTML content in the script for easy parsing, because there were some parts
that would make parsing complicated. So to get the important parts only I did this.

You can also parse html content without the file you just have to change the '$str'
to the url of that page http://pagetoparse.com
then instead of 'str_get_html' change it to 'file_get_html'
*/
include_once './get_html/html_content.php'; // HTML that you want to parse
$html_src = str_get_html( $str );

/*
<tr bgcolor="#990000" class="bodytext-white">
	<td colspan="2">
		<b>Most recent website developments</b> <--- The Section Name
	</td>
</tr>
<tr bgcolor="#ffffff">
	<td width="50%">
		<a href="http://www.swso.com.au/" target="_blank">
			<img src="http://yourpracticeonline.com.au/company/swso.jpg" width="199" height="182" border="0" style="border:'1px solid #000000';"> <-- Image Url what we'll get here is the value of the src attribute only
		</a>
	</td>
	<td align="center">
		<a href="http://www.swso.com.au/" target="_blank" class="header">
			South West Sydney Orthopaedics  <--- Item Name
		</a>
		<br><br>
		<a href="http://www.swso.com.au/" target="_blank" class="bodytext-bold">
			Liverpool, Australia <--- Item Location
		</a>
		<br><br>
		<a href="http://www.swso.com.au/" target="_blank" class="bodytext-link">
			http://www.swso.com.au/ <--- Item Link
		</a>
	</td>
</tr>
*/
//Variables that will be used
$tmp_block = ''; // The section for list of items
$src = ''; // Image Url
$to_seconds = 5;
$tmp_ul_header = ''; // Item name
$tmp_ul_location = ''; // Item Location
$tmp_ul_link = ''; // Item Link

// wp_insert_post $array
// Contains only the important values I need to publisha a post.
$post = array(
	'post_title' => '',
	'post_status' => 'publish',
	'post_type' => 'useful_link',
	'post_date' => date( 'Y-m-d H:i:s' ),
	'comment_status' => '',
);

// wp_upload_dir var initialize so I don't
// have to call the wp_upload_dir(); everytime I loop
// an upload process
$wp_upload_dir = wp_upload_dir();
// Overrides for the wp_handle_sideload recommended by WordPress
$overrides = array(
    'test_form' => false,
    'test_size' => true,
    'test_upload' => true,
);


foreach ( $html_src->find('tbody tr') as $row) {
	if ( $row->getAttribute('class') == 'bodytext-white' ) {
		$tmp_block = strip_tags( $row->innertext );
	} else {
		//*
		foreach( $row->find('a') as $link ) {

			foreach ($link->find('img') as $img) {
				$src = $img->src;
			}

			if ( $link->getAttribute( 'class' ) == 'header' )
				$post['post_title'] = $tmp_ul_header = html_entity_decode($link->innertext);
			if ( $link->getAttribute( 'class' ) == 'bodytext-bold' ) 
				$tmp_ul_location = $link->innertext;
			if ( $link->getAttribute( 'class' ) == 'bodytext-link' )
				$tmp_ul_link = $link->innertext;


		} //*/// End of foreach
		if( !empty($src) && !empty($tmp_ul_header) && !empty($tmp_ul_link) ) {
			if( $post_obj = get_page_by_title( $tmp_ul_header, 'OBJECT', 'useful_link' ) ) {
				$terms = array();
				// Current Terms of Object
				$current_terms = wp_get_object_terms( $post_obj->ID, 'section' );
				foreach ($current_terms as $term) {
					$terms[] = $term->name;
				}
				if ( in_array($tmp_block, $terms) ) {
					wp_set_object_terms( $post_obj->ID, $terms, 'section' );
				} else {
					$terms[] = $tmp_block;
					wp_set_object_terms( $post_obj->ID, $terms, 'section' );
				}
			} else {
				//*//
				// Insert post first
				$post_id = wp_insert_post($post);
				wp_set_object_terms($post_id, $tmp_block, 'section');
				// Add post meta
				add_post_meta( $post_id, 'ul_header', ($tmp_ul_header != '') ? $tmp_ul_header : '' );
				add_post_meta( $post_id, 'ul_location', ($tmp_ul_location != '') ? $tmp_ul_location : '' );
				add_post_meta( $post_id, 'ul_link', ($tmp_ul_link != '') ? $tmp_ul_link : '' );

				if ( $src != $tmp_ul_link ) {
					$temp_file = download_url($src, $to_seconds);

					if ( ! is_wp_error( $temp_file ) ) {

						$file = array(
					        'name' => basename( $src ),
					        'type' => 'image/'.pathinfo($src, PATHINFO_EXTENSION),
					        'tmp_name' => $temp_file,
					        'error' => 0,
					        'size' => filesize($temp_file)
					    );

					    // upload image
						$upload = wp_handle_sideload( $file, $overrides );

						$attachment = array(
							'guid' => $wp_upload_dir['url'] . '/' . basename( $upload['file'] ),
							'post_mime_type' => $upload['type'],
							'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
							'post_content' => '',
							'post_status' => 'inherit'
						);

						// Insert attachment
						$attached_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );

						// generating metadata and update attachment metadata
						$attach_data = wp_generate_attachment_metadata( $attached_id, $upload['file'] );
						wp_update_attachment_metadata( $attached_id, $attach_data );

						// set post thumbnail or featured image
						if(set_post_thumbnail( $post_id, $attached_id )) {
							echo 'added attachment for #' . $post_id . '<br><br>';
						} else {
							echo '<strong style="color:red">error</strong> attachment for #' . $post_id . '<br><br>';
						}
					} // End of If
				} // End of If
				//*/
			}// End of If - Else
		} // End of If
	}// End of If - Else
}
<?php

require get_template_directory() . '/inc/customizer/customizer_framework.php';

function customize_preview_js() {
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'customize_preview_js' );
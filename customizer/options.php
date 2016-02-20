<?php

$capability = 'edit_theme_options';

$options = array();

/* Panel/s
/*-------------------------------------*/
$options[] = array(

		'title' 			=> __( 'Theme Options', 'theme-domain' ),
		'description'		=> __( 'description', 'theme-domain' ),
		'id'				=> 'theme_options',
		'priority'			=> 10,
		'theme_supports'	=> '',
		'type'				=> 'panel'

	);


/* Section/s
/*-------------------------------------*/
$options[] = array(

		'title'				=> __( 'Section Title', 'theme-domain' ),
		'panel'				=> 'theme_options',
		'id'				=> 'section',
		'priority'			=> 10,
		'theme_supports'	=> '',
		'type'				=> 'section',

	);


/* Fields
/*-------------------------------------*/
$options[] = array(

	'title'				=> __( 'Field Title', 'theme-domain' ),
	'description'		=> '',
	'section'			=> 'field_section',
	'id'				=> 'field',
	'default'			=> '', // Default Value
	'option'			=> 'type_of_field',
	'sanitize_callback'	=> '',
	'type'				=> 'control'

);
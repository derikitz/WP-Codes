<?php

/*----------------------------------------------------
# Updating the logo of WP-login via functions.php
----------------------------------------------------*/
/*
If you're using Customizer for updating the logo in the wp-login
page.

change '/image/location/here.png' value to: <?php get_option( 'option_id' ) ?>

or

you can just set it manually if the logo is just sitting inside the themes directory folder /images

change '/image/location/here.png' to <?php get_template_directory_uri() ?>/images/login-logo.png

*/
function logo() { ?>
    <style type="text/css">
        .login h1 a {
            background-image: url('/image/location/here.png') !important;
            display: block;width: 100%;background-size: 100% !important;background: #9EC068;height: 100px;background-repeat: no-repeat; background-position: 0 7px;margin-bottom: 0;
        }
        body.login { background: #FFF; }
        .login input#wp-submit { background: #9EC068; border-radius: 0; border: 0; padding: 10px 30px; line-height: 20px; text-transform: uppercase; box-shadow: none; height: auto; }
        .login form { margin-top: 0 !important; background: #F1F1F1; box-shadow: none; }
        .login h1 { padding: 4%; background: #9EC068; }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'logo' );


/*----------------------------------------------------
# Custom Post Type 
----------------------------------------------------*/
function create_post_type() {
  register_post_type( 'post_type_slug',
    array(
        'label'         => __( 'post_type_label' ),
        'description'   => __( 'Post type Description' ),
        'labels'        => array(
            'name'               => _x( 'Post Types', 'post type general name'),
            'singular_name'      => _x( 'Post Type', 'post type singular name'),
            'menu_name'          => _x( 'Post Types', 'admin menu'),
            'name_admin_bar'     => _x( 'Post Type', 'add new on admin bar'),
            'add_new'            => _x( 'Add New', 'Post Type'),
            'add_new_item'       => __( 'Add New Post Type'),
            'new_item'           => __( 'New Post Type'),
            'edit_item'          => __( 'Edit Post Type'),
            'view_item'          => __( 'View Post Type'),
            'all_items'          => __( 'All Post Types'),
            'search_items'       => __( 'Search Post Types'),
            'parent_item_colon'  => __( 'Parent Post Types:'),
            'not_found'          => __( 'No post types found.'),
            'not_found_in_trash' => __( 'No post types found in Trash.')
        ),
        'public'        => true,
        'supports'      => array( 'title', 'thumbnail', 'editor' ), // post type supports here: https://codex.wordpress.org/Function_Reference/post_type_supports
        'hierarchical'  => false,
        'menu_icon'     => 'dashicons-calendar-alt', // icons can be found here:https://developer.wordpress.org/resource/dashicons/
        'show_in_menu'  => true,
        'menu_position' => 5
    )
  );
}

add_action( 'init', 'create_post_type', 0);


/*----------------------------------------------------
# Shortcode template
----------------------------------------------------*/
function shortcode_method( $atts, $content = "" ) {
    $atts = shortcode_atts( array(
        'attribute' => 'default_value',
    ), $atts, 'shortcode' );

    $html = ''; 

    /* whatever did you want to do here just do it */

    return $html;
}


/*---------------------------------------------------
# Fonts URL 
---------------------------------------------------*/
function plain_lands_fonts_url() {
    $fonts_url = '';
    $fonts     = array();

    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'plain-lands' )  ) {
        $fonts[] = 'Open+Sans:400,400italic,600,600italic,700,700italic,800,800italic,300italic,300';
    }

    if ( 'off' !== _x( 'on', 'Dosis font: on or off', 'plain-lands' )  ) {
        $fonts[] = 'Dosis:400,500,700,600';
    }

    if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'plain-lands' )  ) {
        $fonts[] = 'Raleway:400,300,500,600,700,800,900';
    }

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => str_replace(array( '%3A', '%2C' ), array( ':', ',' ), urlencode( implode( '|', $fonts ) )),
        ), 'https://fonts.googleapis.com/css' );
    }

    return $fonts_url;
}
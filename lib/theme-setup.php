<?php
/**
 * This file contains theme setup such as sidebars, widgets, enqueing, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

/**
 * Setup scripts, sidebars, menus, etc.
 */
function basetheme_setup() {

	load_theme_textdomain( 'basetheme', get_template_directory() . '/languages' );

	global $content_width;
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( $content_width, 9999, false );
	// add_image_size( 'another-image-size', '250', '250', true );
	// Bootstrap 4 Menu Walker.
	require_once get_template_directory() . '/lib/class-wp-bootstrap-breadcrumbs.php';
	require_once get_template_directory() . '/lib/class-wp-bootstrap-navwalker.php';

	// Register nav menus.
	register_nav_menus(
		array(
			'mainnav'   => __( 'Main Navigation', 'basetheme' ),
			'footernav' => __( 'Footer Navigation', 'basetheme' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	/*
	 * Example: add_theme_support( 'post-formats', array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat') );
	 *
	 */

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'basetheme_setup' );

/**
 *  Register widgetized areas.
 */
function basetheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar Widget Area', 'basetheme' ),
			'id'            => 'blog-sidebar-widget-area',
			'description'   => __( 'The blog widget area', 'basetheme' ),
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Page Sidebar Widget Area', 'basetheme' ),
			'id'            => 'page-sidebar-widget-area',
			'description'   => __( 'The page widget area', 'basetheme' ),
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'basetheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function basetheme_enqueue() {
	// add font enqueue here, before base-style.
	// wp_enqueue_style( 'fonts', '', array() );
	wp_enqueue_style( 'bt-base-style', get_template_directory_uri() . '/dist/css/style.css', array(), '1.0' );

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/dist/js/jquery.min.js', array(), '3.4.0', false );
	wp_enqueue_script( 'jquery' );

	// gravity forms throws errors without jquery-migrate
	wp_enqueue_script( 'jquery-migrate' );

	wp_enqueue_script( 'bt-head', get_template_directory_uri() . '/dist/js/head.min.js', array(), '1.0', false );

	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );}

	wp_enqueue_script( 'bt-scripts', get_template_directory_uri() . '/dist/js/scripts.min.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'basetheme_enqueue' );

/**
 * Enqueue scripts and styles in admin.
 */
function basetheme_enqueue_block_editor_assets() {
	wp_enqueue_style( 'bt-editor-styles', get_template_directory_uri() . '/dist/css/editor-styles.css', null, time() );
}
add_action( 'enqueue_block_editor_assets', 'basetheme_enqueue_block_editor_assets' );
<?php
/**
 * Подключение настроек OptionTree
 */
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_show_pages', '__return_true' );
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
require( trailingslashit( get_template_directory() ) . 'functions/theme-options.php' );
require( trailingslashit( get_template_directory() ) . 'functions/meta-boxes.php' );
add_filter( 'ot_theme_options_parent_slug', 'theme_options_parent', 20 );
function theme_options_parent( $parent ) {
	$parent = '';
	
	return $parent;
}

/**
 * Установки темы
 */
add_action( 'after_setup_theme', 'artbt_setup' );
function artbt_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'artbt' ),
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
}

/**
 * Регистраия сайдбаров
 */
add_action( 'init', 'artbt_widgets_init' );
function artbt_widgets_init() {
	register_sidebar( array(
		'name'          => 'Область виджетов',
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'artbt' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Подвал слева',
		'id'            => 'footer-left',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => 'Подвал центр',
		'id'            => 'footer-center',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => 'Подвал справа',
		'id'            => 'footer-right',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );
}

/**
 * Подключение скрипто и стилей
 */
add_action( 'wp_enqueue_scripts', 'artbt_style' );
function artbt_style() {
	wp_enqueue_style( 'grid', get_template_directory_uri() . '/css/grid.css' );
	wp_enqueue_style( 'artbt-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font', 'http://fonts.googleapis.com/css?family=Roboto:400,500,700' );
	wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'camera-style', get_template_directory_uri() . '/css/camera.css' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css' );
	wp_enqueue_style( 'colorScheme', get_template_directory_uri() . '/css/colorScheme-2.css' );
	wp_enqueue_style( 'carousel', get_template_directory_uri() . '/css/owl-carousel.css' );
}

add_action( 'wp_enqueue_scripts', 'artbt_scripts' );
function artbt_scripts() {
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rd-navbar', get_template_directory_uri() .
	                                '/js/jquery.rd-navbar.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'tmstickup', get_template_directory_uri() . '/js/tmstickup.js', array( 'jquery' ), '', true );
	if (is_page_template( 'main-page.php' )) {
	wp_enqueue_script( 'camera', get_template_directory_uri() . '/js/camera.js', array( 'jquery', 'easing'), '', true );
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery'), '', true );
	}
	wp_enqueue_script( 'magnific-popup-script', get_template_directory_uri() .
	                                            '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Добавление активного класса в меню
 */
add_filter( 'nav_menu_css_class', 'artbt_filter_current_item_menu_header' );
function artbt_filter_current_item_menu_header( $classes ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'active';
	}
	
	return $classes;
}

add_filter('body_class', 'artbt_remove_page_class' );

function artbt_remove_page_class ($classes) {
	if ( $key = array_search('page', $classes) ) {
		unset( $classes[$key] );
	}
	return $classes;
}
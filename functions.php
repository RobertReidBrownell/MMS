<?php
/**
 * MMS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MMS
 */

if ( ! function_exists( 'mms_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mms_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on MMS, use a find and replace
		 * to change 'mms' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mms', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mms' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mms_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'mms_setup' );

function mms_post_type() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name'          => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'menu_name'     => __( 'Events' ),
				'name_admin_bar'=> __( 'Event' ),
				'add_new'       => __( 'Add New'),
				'add_new_item'  => __( 'Add New Event'),
				'new_item'      => __( 'New Event' ),
				'edit_item'     => __( 'Edit Event' ),
				'view_item'     => __( 'View Event' ),
				'all_items'     => __( 'All Events' ),
				'search_items'  => __( 'Search Events' ),
				'not_found'     => __( 'No Events found' )
			),
			'public'            => true,
			'publicly_queryable'=> true,
			'has_archive'       => false,
			'show_ui'           => true,
			'menu_position'     => 5,
			'menu_icon'         => 'dashicons-calendar-alt',
			'query_var'         => true,
			'capability_type'   => 'post',
			'hierarchical'      => false,
			'taxonomies'        => array('category'),
			'supports'          => array('title', 'thumbnail'),
			'show_in_rest'      => true
		)
	);
	$post_type = 'events';
	remove_post_type_support($post_type, 'editor');
}
add_action( 'init', 'mms_post_type' );
/*
 * Adding in a custom Function to call in the Events post type
 *
 * */
function mms($query){
	if (!is_admin() && $query->is_main_query() ){
		if ($query->is_home() ){
			$query->set('post_type', 'events');
		}
	}
}
add_action( 'pre_get_posts', 'mms');

/*
 * Including ACF inline and lite mode so the plugin is not a visible part of the site.
 * Creating a Custom field group that cannot be edited by the end user using Advanced Custom fields (acf)
 *
*/
//
//define( 'ACF_LITE', true );
//include_once('advanced-custom-fields/acf.php');
//
//if(function_exists("register_field_group"))
//{
//	register_field_group(array (
//		'id' => 'acf_events',
//		'title' => 'Events',
//		'fields' => array (
//			array (
//				'key' => 'field_5a8472cdd07ae',
//				'label' => 'Multi Day Event',
//				'name' => 'multi_day_event',
//				'type' => 'radio',
//				'instructions' => 'Does the event last longer than a day?',
//				'required' => 1,
//				'choices' => array (
//					'yes' => 'Yes',
//					'no' => 'No',
//				),
//				'other_choice' => 0,
//				'save_other_choice' => 0,
//				'default_value' => 'no',
//				'layout' => 'vertical',
//			),
//			array (
//				'key' => 'field_5a846fa89f757',
//				'label' => 'Event Date',
//				'name' => 'single_event_date',
//				'type' => 'date_picker',
//				'instructions' => 'What day does the event take place?',
//				'required' => 1,
//				'conditional_logic' => array (
//					'status' => 1,
//					'rules' => array (
//						array (
//							'field' => 'field_5a8472cdd07ae',
//							'operator' => '==',
//							'value' => 'no',
//						),
//					),
//					'allorany' => 'all',
//				),
//				'date_format' => 'yymmdd',
//				'display_format' => 'mm/dd/yy',
//				'first_day' => 1,
//			),
//			array (
//				'key' => 'field_5a84747a1959a',
//				'label' => 'Event Start Date',
//				'name' => 'event_start_date',
//				'type' => 'date_picker',
//				'instructions' => 'What day does the event start?',
//				'required' => 1,
//				'conditional_logic' => array (
//					'status' => 1,
//					'rules' => array (
//						array (
//							'field' => 'field_5a8472cdd07ae',
//							'operator' => '==',
//							'value' => 'yes',
//						),
//					),
//					'allorany' => 'all',
//				),
//				'date_format' => 'yymmdd',
//				'display_format' => 'mm/dd/yy',
//				'first_day' => 1,
//			),
//			array (
//				'key' => 'field_5a84747919599',
//				'label' => 'Event End Date',
//				'name' => 'event_end_date',
//				'type' => 'date_picker',
//				'instructions' => 'What day does the event end?',
//				'required' => 1,
//				'conditional_logic' => array (
//					'status' => 1,
//					'rules' => array (
//						array (
//							'field' => 'field_5a8472cdd07ae',
//							'operator' => '==',
//							'value' => 'yes',
//						),
//					),
//					'allorany' => 'all',
//				),
//				'date_format' => 'yymmdd',
//				'display_format' => 'mm/dd/yy',
//				'first_day' => 1,
//			),
//			array (
//				'key' => 'field_5a84702e9f758',
//				'label' => 'Event Location',
//				'name' => 'event_location',
//				'type' => 'textarea',
//				'instructions' => 'Where will this event take place.',
//				'required' => 1,
//				'default_value' => '',
//				'placeholder' => '',
//				'maxlength' => '',
//				'rows' => '',
//				'formatting' => 'br',
//			),
//			array (
//				'key' => 'field_5a8469839f756',
//				'label' => 'General Description',
//				'name' => 'general_description',
//				'type' => 'textarea',
//				'instructions' => 'General Description of Event',
//				'required' => 1,
//				'default_value' => '',
//				'placeholder' => '',
//				'maxlength' => '',
//				'rows' => '',
//				'formatting' => 'br',
//			),
//			array (
//				'key' => 'field_5a84706e9f759',
//				'label' => 'Event Registration',
//				'name' => 'event_registration',
//				'type' => 'textarea',
//				'instructions' => 'Information on how to register for the event.',
//				'default_value' => '',
//				'placeholder' => '',
//				'maxlength' => '',
//				'rows' => '',
//				'formatting' => 'br',
//			),
//		),
//		'location' => array (
//			array (
//				array (
//					'param' => 'post_type',
//					'operator' => '==',
//					'value' => 'events',
//					'order_no' => 0,
//					'group_no' => 0,
//				),
//			),
//		),
//		'options' => array (
//			'position' => 'acf_after_title',
//			'layout' => 'default',
//			'hide_on_screen' => array (
//				0 => 'slug',
//			),
//		),
//		'menu_order' => 0,
//	));
//}
//



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mms_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mms_content_width', 640 );
}
add_action( 'after_setup_theme', 'mms_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */



function mms_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mms' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mms' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mms_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mms_scripts() {
	wp_enqueue_style( 'mms-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mms-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mms-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mms_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


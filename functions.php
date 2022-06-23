<?php
/**
 * wl-test-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wl-test-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wl_test_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wl-test-theme, use a find and replace
		* to change 'wl-test-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wl-test-theme', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'wl-test-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'wl_test_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'wl_test_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wl_test_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wl_test_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'wl_test_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wl_test_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wl-test-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wl-test-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wl_test_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wl_test_theme_scripts() {
	wp_enqueue_style( 'wl-test-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'wl-test-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wl-test-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wl_test_theme_scripts' );

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


/* создаем пост тайп */
function wporg_custom_post_type() {
    register_post_type('car',
        array(
            'labels'      => array(
                'name'          => __('Car'),
                'singular_name' => __('Car'),
            ),
                'supports' => array('title','editor','thumbnail','post-formats','excerpt', 'custom-fields'),
                'public'      => true,
                'has_archive' => true,
        )
    );
    register_taxonomy(
     'car_model',
     'car',
     array(
       'label' => ('Марка'),
       'rewrite' => array('slug' => 'model'),
        'hierarchical' => true
     )
    );
    register_taxonomy(
     'car_sity',
     'car',
     array(
       'label' => ('страна производитель'),
       'rewrite' => array('slug' => 'sity'),
       'hierarchical' => true
     )
    );
    

}
add_action('init', 'wporg_custom_post_type');




add_action( 'init', 'true_metaboxes_to_game' );
function true_metaboxes_to_game(){

	if( ! current_user_can('manage_options') )
		return;

	add_post_type_support( 'car', ['custom-fields'] );
}






/**
 * Theme customizer: add phone.
 *
 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
 */
function customize_register_action( $wp_customize ) {
    //All our sections, settings, and controls will be added here
    $a = $wp_customize;
    $wp_customize->add_setting(
            'customize-pane-parent_phone',
            array(
                'default' => '+8 (063) 777-77-77',
            )
        );
    $wp_customize->add_control(
        'customize-pane-parent_phone',
        array(
            'label'   => 'Телефон',
            'section' => 'title_tagline',
            'type'    => 'text',
        )
    );
}

add_action( 'customize_register', 'customize_register_action' );







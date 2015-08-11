<?php
/**
 * beautybelle functions and definitions
 *
 * @package beautybelle
 */

/**
 * This function sets the content width based on the theme
 */
if ( ! isset ( $content_width ) ) {
	$content_width = 600; /* pixels */
}
if ( ! function_exists( 'beautybelle_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function beautybelle_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on beautybelle, use a find and replace
	 * to change 'beautybelle' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'beautybelle', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */

	/*
	 * This theme uses wp_nav_menu() in one location.
	 * This also registers the social menu
	 */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'beautybelle' ),
		'social' => __ (' Social Menu ', 'beautybelle' ),
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

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'beautybelle_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // beautybelle_setup
add_action( 'after_setup_theme', 'beautybelle_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function beautybelle_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beautybelle_content_width', 640 );
}
add_action( 'after_setup_theme', 'beautybelle_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function beautybelle_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'beautybelle' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'beautybelle' ),
		'id'            => 'sidebar-2',
		'description'   => __('Footer widgets area appears in the footer section of the site.', 'beautybelle'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'beautybelle_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function beautybelle_scripts() {
	wp_enqueue_style( 'beautybelle-style', get_stylesheet_uri() );
	
	wp_enqueue_style ( 'beautybelle-content-sidebar', get_template_directory_uri() . '/layouts/content-sidebar.css');
	
	wp_enqueue_style( 'beautybelle-google-fonts', 'http://fonts.googleapis.com/css?family=Codystar|Lobster|Architects+Daughter'); 
	
	wp_enqueue_style( 'beautybelle-fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
	
	wp_enqueue_script( 'beautybelle-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'beautybelle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_style('beautybelle-flexslider', get_template_directory_uri() . '/js/flex/flexslider.css');
	
	wp_enqueue_script( 'beautybelle-flexsliderscript', get_template_directory_uri() . '/js/flex/jquery.flexslider.js', array('jquery'));
	
	wp_enqueue_script( 'beautybelle-flexslidermyscript', get_template_directory_uri() . '/js/myscript.js', array());
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'beautybelle_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// Call the file that controls the theme options page
require get_stylesheet_directory() .'/inc/options.php';

//Call the file that makes our new widget
//require get_stylesheet_directory() .'/inc/thewidget.php';


/***** My First Custom Post Type *****/
function my_post_type_slider() {
	register_post_type( 'slider',
                array( 
				'label' => __('Slides'), 
				'singular_label' => __('Slide', 'my_framework'),
				'_builtin' => false,
				'exclude_from_search' => true, // Exclude from Search Results
				'capability_type' => 'page',
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'rewrite' => array(
					'slug' => 'slide-view',
					'with_front' => FALSE,
				),
				'query_var' => "slide", // This goes to the WP_Query schema
				'menu_icon' => get_template_directory_uri() . '/inc/images/slides.png',
				'supports' => array(
						'title',
						'custom-fields',
						'editor',
            					'thumbnail')
					) 
				);
}

add_action('init', 'my_post_type_slider');

add_action( 'init', 'mytheme_setup' );
add_theme_support( 'post-thumbnails' );
function mytheme_setup() {
add_image_size ('slides', 760, 300, true); // Slider Thumbnail
}

/* Tried fixing the previous/next buttons
function my_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'beautybelle' ); ?></h2>
		<div class="nav-links">

			
			<div class="nav-previous"><?php next_posts_link( esc_html__( '&lt; &lt; Older posts', 'beautybelle' ) ); ?></div>
			

			
			<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts &gt; &gt;', 'beautybelle' ) ); ?></div>
			

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}*/

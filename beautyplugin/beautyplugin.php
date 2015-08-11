<?php
/* 1.0 Plugin Header
* Plugin Name: BeautyBelle Testimonials Plugin 
* Plugin URI: http://google.com 
* Description: A Plugin Template for Custom Testimonials
* Author: Sara Abu Allan, Dilpreet, and Geetha
* Version: 1.0 
* Author URI: http://google.com 
*/

/*--------------------------------------------------------------
1.1 Enqueue styles and scripts
--------------------------------------------------------------*/
/**
 * Add the testimonials widget
 */
include( dirname( __FILE__ ) . '/inc/thewidget.php' );

add_action( 'wp_enqueue_scripts', 'testimonials_stylesheet' );
/**
 * Enqueue the stylesheet and any JavaScript
 *
 * This functions is attached to the 'wp_enqueue_scripts' action hook.
 */
function testimonials_stylesheet() {
	wp_enqueue_style( 'testimonials_css', plugins_url( '/css/style.css', __FILE__ ) );
}
add_action( 'template_redirect', 'testimonials_page_redirect' );

function testimonials_script() {
	wp_enqueue_script( 'testimonials_java', plugins_url('/js/sliding-testimonials.js', __FILE__), array('jquery'), true);
}
add_action( 'wp_enqueue_scripts', 'testimonials_script' );

/*--------------------------------------------------------------
1.2 Plugin Set Up Here
--------------------------------------------------------------*/
/**
 * Redirect testimonials archive page to page template
 *
 * This functions is attached to the 'template_redirect' action hook.
 */
function testimonials_page_redirect() {
    if ( is_archive( 'testimonials' ) )
		include( dirname( __FILE__ ) . '/templates/archive-testimonials.php' );
}

add_action( 'init', 'testimonials_post_type' );
/**
 * Creating the custom post type
 *
 * This functions is attached to the 'init' action hook.
 */
function testimonials_post_type() {
	$labels = array(
		'name' => 'Beauty Testimonials',
		'singular_name' => 'Testimonial',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Testimonial',
		'edit_item' => 'Edit Testimonial',
		'new_item' => 'New Testimonial',
		'view_item' => 'View Testimonial',
		'search_items' => 'Search Testimonials',
		'not_found' =>  'No Testimonials found',
		'not_found_in_trash' => 'No Testimonials in the trash',
		'parent_item_colon' => '',
	);

	register_post_type( 'testimonials', array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'exclude_from_search' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 10,
		'supports' => array( 'editor' ),
		'register_meta_box_cb' => 'testimonials_meta_boxes',
	) );
}
 
/*--------------------------------------------------------------
1.3 Metabox
--------------------------------------------------------------*/ 
/**
 * Adding the necessary metabox for the plugin.
 *
 * This functions is attached to the 'testimonials_post_type()' meta box.
 */
function testimonials_meta_boxes() {
	add_meta_box( 'testimonials_form', 'Testimonial Details', 'testimonials_form', 'testimonials', 'normal', 'high' );
}

/**
 * Adding the necessary metabox
 *
 * This functions is attached to the 'add_meta_box()' callback.
 */
function testimonials_form() {
	$post_id = get_the_ID();
	$testimonial_data = get_post_meta( $post_id, '_testimonial', true );
	$client_name = ( empty( $testimonial_data['client_name'] ) ) ? '' : $testimonial_data['client_name'];
	$source = ( empty( $testimonial_data['source'] ) ) ? '' : $testimonial_data['source'];
	$link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];

	wp_nonce_field( 'testimonials', 'testimonials' );
	?>
<!--The testimonials will display the following information on the front-end of WordPress-->	
	<p>
		<label>Client's Name</label><br />
		<input type="text" value="<?php echo $client_name; ?>" name="testimonial[client_name]" size="40" />
	</p>
	<p>
		<label>Business Name</label><br />
		<input type="text" value="<?php echo $source; ?>" name="testimonial[source]" size="40" />
	</p>
	<p>
		<label>Link</label><br />
		<input type="text" value="<?php echo $link; ?>" name="testimonial[link]" size="40" />
	</p>
	<?php
}
/*--------------------------------------------------------------
1.4 Save Posts
--------------------------------------------------------------*/ 
add_action( 'save_post', 'testimonials_save_post' );
/**
 * The following will validate the testimonails and save it to WordPress.
 * Posts can be edited and as the option of editing the whole page as well.
 * This function is attached to the 'save_post' action hook.
 */
function testimonials_save_post( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( ! empty( $_POST['testimonials'] ) && ! wp_verify_nonce( $_POST['testimonials'], 'testimonials' ) )
		return;

	if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	}

	if ( ! wp_is_post_revision( $post_id ) && 'testimonials' == get_post_type( $post_id ) ) {
		remove_action( 'save_post', 'testimonials_save_post' );

		wp_update_post( array(
			'ID' => $post_id,
			'post_title' => 'Testimonial - ' . $post_id
		) );

		add_action( 'save_post', 'testimonials_save_post' );
	}

	if ( ! empty( $_POST['testimonial'] ) ) {
		$testimonial_data['client_name'] = ( empty( $_POST['testimonial']['client_name'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['client_name'] );
		$testimonial_data['source'] = ( empty( $_POST['testimonial']['source'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['source'] );
		$testimonial_data['link'] = ( empty( $_POST['testimonial']['link'] ) ) ? '' : esc_url( $_POST['testimonial']['link'] );

		update_post_meta( $post_id, '_testimonial', $testimonial_data );
	} else {
		delete_post_meta( $post_id, '_testimonial' );
	}
}
/*--------------------------------------------------------------
1.5 Editing Testimonials
--------------------------------------------------------------*/ 
add_filter( 'manage_edit-testimonials_columns', 'testimonials_edit_columns' );
/**
 * Modifying the list view columns
 *
 * This functions is attached to the 'manage_edit-testimonials_columns' filter hook.
 */
function testimonials_edit_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'testimonial' => 'Testimonial',
		'testimonial-client-name' => 'Client\'s Name',
		'testimonial-source' => 'Business',
		'testimonial-link' => 'Link',
		'author' => 'Posted by',
		'date' => 'Date'
	);

	return $columns;
}

add_action( 'manage_posts_custom_column', 'testimonials_columns', 10, 2 );
/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
function testimonials_columns( $column, $post_id ) {
	$testimonial_data = get_post_meta( $post_id, '_testimonial', true );
	switch ( $column ) {
		case 'testimonial':
			the_excerpt();
			break;
		case 'testimonial-client-name':
			if ( ! empty( $testimonial_data['client_name'] ) )
				echo $testimonial_data['client_name'];
			break;
		case 'testimonial-source':
			if ( ! empty( $testimonial_data['source'] ) )
				echo $testimonial_data['source'];
			break;
		case 'testimonial-link':
			if ( ! empty( $testimonial_data['link'] ) )
				echo $testimonial_data['link'];
			break;
	}
}
/*--------------------------------------------------------------
1.6 Testimonials Display
--------------------------------------------------------------*/ 
/**
 * Display a testimonial
 *
 * @param	int $post_per_page  The number of testimonials you want to display
 * @param	string $orderby  The order by setting  https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
 * @param	array $testimonial_id  The ID or IDs of the testimonial(s), comma separated
 *
 * @return	string  Formatted HTML
 * The backend user can choose how many posts to display on the front end.
 */
function get_testimonial( $posts_per_page = 1, $orderby = 'none', $testimonial_id = null ) {
	$args = array(
		'posts_per_page' => (int) $posts_per_page,
		'post_type' => 'testimonials',
		'orderby' => $orderby,
		'no_found_rows' => true,

	);
	if ( $testimonial_id )
		$args['post__in'] = array( $testimonial_id );

	$query = new WP_Query( $args  );

	$testimonials = '';
	if ( $query->have_posts() ) { 
	
	$testimonials .='<div id="wraptext">';
		while ( $query->have_posts() ) : $query->the_post();
			$post_id = get_the_ID();
			$testimonial_data = get_post_meta( $post_id, '_testimonial', true );
			$client_name = ( empty( $testimonial_data['client_name'] ) ) ? '' : $testimonial_data['client_name'];
			$source = ( empty( $testimonial_data['source'] ) ) ? '' : ' - ' . $testimonial_data['source'];
			$link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];
			$cite = ( $link ) ? '<a href="' . esc_url( $link ) . '" target="_blank">' . $client_name . $source . '</a>' : $client_name . $source;
			
			$testimonials .= '<aside class="testimonial">';
			$testimonials .= '<span class="quote">&lsquo;</span>';
			$testimonials .= '<div class="entry-testimonials">';
			$testimonials .= '<p class="testimonial-text">' . get_the_content() . '<span></span></p>';
			$testimonials .= '<p class="testimonial-client-name"><cite>' . $cite . '</cite>';
			$testimonials .= '</div>';
			$testimonials .= '</aside>';
			?>
			<?php
		endwhile;
	$testimonials .='</div>';
		wp_reset_postdata();
	}

	return $testimonials;
}


//tried to add featured image using this piece of code but itsnot working
/*function plugin_setup() {
		add_action( 'init', 'plugin_setup' );
set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
}		

if ( plugin_setup( 'add_theme_support' ) ) { 
add_theme_support( 'post-thumbnails' );

}
*/


//add_shortcode( 'testimonial', 'testimonial_shortcode' );

/**
 * Shortcode to display testimonials
 *
 * This functions is attached to the 'testimonial' action hook.
 *
 * [testimonial posts_per_page="1" orderby="none" testimonial_id=""]
 *
function testimonial_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'posts_per_page' => '1',
		'orderby' => 'none',
		'testimonial_id' => '',
	), $atts ) );

	return get_testimonial( $posts_per_page, $orderby, $testimonial_id );
}
*/

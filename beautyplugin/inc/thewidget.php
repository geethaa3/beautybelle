<?php
/**
 * Beauty Testimonials Widget
 */
 
//Creates the Widget
class Testimonials_Widget extends WP_Widget {
	//Initializing the widget or constructing it
	public function __construct() {
		$widget_ops = array('classname' => 'testimonials_widget', 'description' => __( 'A display of your clients testimonials') ); 
		parent::__construct('testimonials_widget', __('Client Testimonials', 'codediva'), $widget_ops);
		}
			//Declare what content the widget displays on the front end
			public function widget( $args, $instance ) {
				extract ($args);
				$title = apply_filters('widget_title', empty ($instance['title']) ? __('Client Testimonials', 'codediva') : $instance['title'], $instance, $this->id_base); 
				
				$posts_per_page = (int) $instance['posts_per_page'];
				$orderby = strip_tags( $instance['orderby'] );
				$testimonial_id = ( null == $instance['testimonial_id'] ) ? '' : strip_tags( $instance['testimonial_id'] );
		
				echo $args['before_widget']; 
				
				if ( ! empty( $title ) )
					echo $before_title . $title . $after_title;

				echo get_testimonial( $posts_per_page, $orderby, $testimonial_id );
				
				echo $args['after_widget']; 
				}
				
			//widget update to save widget data during edition
			public function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title'] = strip_tags( $new_instance['title'] );
				$instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
				$instance['orderby'] = strip_tags( $new_instance['orderby'] );
				$instance['testimonial_id'] = ( null == $new_instance['testimonial_id'] ) ? '' : strip_tags( $new_instance['testimonial_id'] );
				
				return $instance;
				}
				
			//widget form creation to create the widget form in the administration
			public function form( $instance ) {
				$instance = wp_parse_args( (array) $instance, array(
				'title' => '', 'posts_per_page' => '1', 'orderby' => 'none', 'testimonial_id' => null ) );
				$title = strip_tags($instance['title']);
				$posts_per_page = (int) $instance['posts_per_page'];
				$orderby = strip_tags( $instance['orderby'] );
				$testimonial_id = ( null == $instance['testimonial_id'] ) ? '' : strip_tags( $instance['testimonial_id'] );
				?>
				<p>
					<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"> Number of Testimonials: </label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>"/>					
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Order By</label>
						<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
							<option value="none" <?php selected( $orderby, 'none' ); ?>>None</option>
							<option value="ID" <?php selected( $orderby, 'ID' ); ?>>ID</option>
							<option value="date" <?php selected( $orderby, 'date' ); ?>>Date</option>
							<option value="modified" <?php selected( $orderby, 'modified' ); ?>>Modified</option>
							<option value="rand" <?php selected( $orderby, 'rand' ); ?>>Random</option>
						</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'testimonial_id' ); ?>">Testimonial ID</label>
						<input class="widefat" id="<?php echo $this->get_field_id( 'testimonial_id' ); ?>" name="<?php echo $this->get_field_name( 'testimonial_id' ); ?>" type="text" value="<?php echo $testimonial_id; ?>" />
				</p>				
			<?php 
				}
			
				
} // Closes the function we opened in step 1

	// Tells WordPress that this widget has been created and that it should display in the list of available widgets.
	add_action ( 'widgets_init', function(){
		register_widget( 'Testimonials_Widget' );
		
		
	});
	
	
?>
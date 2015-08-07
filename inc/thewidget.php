<?php

class CD Yearly Archives Widget extends WP_Widget {
	
	public function__construct() {
		$widget_ops=array('classname'=>'widget_archive', 'description'=>__( 'A yearly archive of your site&#8217;s Posts.') ); parent::__construct('yearly_archives', __('Yearly Archives', 'codediva'), $widget_ops);
		}
	
	public function widget( $args, $instance ) {
		$c=!empty( $instance['count'] ) ? '1' : '0'; 
		$d=!empty( $instance['dropdown'] ) ? '1' : '0';
		$title=apply_filters('widget_title', empty($instance['title']) ? __('Yearly Archives', 'codediva') : $instance['title'], $instance, $this->id_base); 
		echo $args['before_widget']; 
		if ( $title ) {
			echo $args['before_title'] .$title.$args['after_title'];
			}
		
	if ( $d ) {
			$dropdown_id="{$this->id_base}-dropdown-{$this->number}";
			?>
				<label class="screen-reader-text"for="<?php echoesc_attr( $dropdown_id ); ?>"> <?php echo $title; ?></label>
					<select id="<?php echo esc_attr( $dropdown_id ); ?>"name="archive-dropdown"onchange='document.location.href=this.options[this.selectedIndex].value;'>
						<?php
						$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
						'type'=>'yearly'
						'format'=>'option'
						'show_post_count'=>$c) ); ?>
						<option value="<?phpecho__( 'Select Year', 'codediva' ); ?>">
						<?php echo__( 'Select Year', 'codediva' ); ?>
						</option><?phpwp_get_archives( $dropdown_args ); ?>
					</select> 
				<?php } else { ?>
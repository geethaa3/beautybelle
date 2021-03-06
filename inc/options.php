
<?php
	//shows a submenu option in my dashboard under 'settings', which is not needed so it is commented out-> 
	//function cd_add_submenu() {add_submenu_page( 'options-general.php', 'Submenu', 'Submenu', 'manage_options', 'my-sub-menu', 'cd_display_submenu_options');} add_action( 'admin_menu', 'cd_add_submenu' );

	// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url [put in you own icon], $position [determine where on the page it should appear, bottom/top] );
	// this adds a major page level like settings
	function cd_add_admin_menu(){ add_menu_page( 'My Options Page', 'My Options Page', 'manage_options', 'my_options_page', 'my_theme_options_page', 'dashicons-hammer', 66 );}
	add_action( 'admin_menu', 'cd_add_admin_menu' );

	//creates our settings
	function cd_settings_init() 
	{ 
		//registering that setting
		register_setting( 'theme_options', 'cd_options_settings' );
		
		//adds a settings section within
		add_settings_section('cd_options_page_section', __( 'Your section description', 'codediva' ), 'cd_options_page_section_callback', 'theme_options');
		
		//describes our section
		function cd_options_page_section_callback() { echo __( 'A description and detail about the section.', 'codediva' );}
		
		//adds a text box as settings field
		add_settings_field( 'cd_text_field', __('Enter your text', 'codediva'), 'cd_text_field_render', 'theme_options', 'cd_options_page_section');
		
		//adds a check box as settings field
		add_settings_field( 'cd_checkbox_field', __( 'Check your preference', 'codediva' ), 'cd_checkbox_field_render', 'theme_options', 'cd_options_page_section');
		
		//adds a radio button as settings field
		add_settings_field( 'cd_radio_field', __( 'Choose an option', 'codediva' ), 'cd_radio_field_render', 'theme_options', 'cd_options_page_section');
		
		//adds a text area as settings field
		add_settings_field( 'cd_textarea_field', __( 'Enter content in the textarea', 'codediva' ), 'cd_textarea_field_render', 'theme_options', 'cd_options_page_section');
		
		//adds a select box as settings field
		add_settings_field( 'cd_select_field', __( 'Choose from the dropdown', 'codediva' ), 'cd_select_field_render', 'theme_options', 'cd_options_page_section');
		
		//create the callback function for the text box
		function cd_text_field_render() { 
			$options = get_option( 'cd_options_settings' );
			?>
			<input type="text" name="cd_options_settings[cd_text_field]"value="
				<?php if (isset($options['cd_text_field'])) 
				echo $options['cd_text_field']; 
				?>">
			<?php
		}

		//create the callback function for the checkbox
		function cd_checkbox_field_render() {
			$options = get_option( 'cd_options_settings' );
			?>
			<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" 
				<?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 1); 
				?> value= "1"> 
			<?php 
		}
		
		//create the callback function for the radio button
		function cd_radio_field_render() { 
			$options = get_option( 'cd_options_settings' );
			?>
			<input type="radio" name="cd_options_settings[cd_radio_field]" 
				<?php if (isset($options['cd_radio_field'])) checked( $options['cd_radio_field'], 1 ); 
				?> value= "1">
			<?php 
		}
		
		//create the callback function for the text area
		function cd_textarea_field_render() { 
			$options = get_option( 'cd_options_settings' );
			?>
			<textarea cols="40" rows="5" name="cd_options_settings[cd_textarea_field]">
				<?php if (isset($options['cd_textarea_field'])) echo $options['cd_textarea_field']; 
				?>
			</textarea>
			<?php 
		}
		
		//create the callback function for the select option
		function cd_select_field_render() { 
			$options = get_option( 'cd_options_settings' );
			?>
			<select name="cd_options_settings[cd_select_field]">
				<option value="1"
					<?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 1 ); 
					?> > Option 1 
				</option>
				<option value="2"
					<?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 2 ); 
					?> > Option 2 
				</option>
			</select> 
			<?php 
		}
		
	}

	//this creates the options page
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>My Awesome Options Page</h2>
			<?php settings_fields( 'theme_options' );
			do_settings_sections( 'theme_options' );
			submit_button();
			?>
		</form>
		<?php 
	}
	//this allows us to activate our plugin
	add_action( 'admin_init', 'cd_settings_init' );
	
	//$text = get_option('cd_options_settings');
	//echo $text['cd_text_field'];
	//echo '<br />';
	//echo $text['cd_checkbox_field'];
	//echo '<br />';
	//echo $text['cd_radio_field'];
	//echo '<br />';
	//echo $text['cd_select_field'];
	//echo '<br />';
	//echo $text['cd_textarea_field'];
?>
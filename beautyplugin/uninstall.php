<?php
/*--------------------------------------------------------------------------------
This is to allow the user to uninstall the plugin when they deactivate it from WordPress
--------------------------------------------------------------------------------*/

//If uninstall is not called from WordPress, then just exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
		exit;
	}
	// For site options in Multisite, delete the specified option
	if ( get_option( 'cd_op_array' ) != false ){
		delete_option( 'cd_op_array' ); //the option's name
	}
?>
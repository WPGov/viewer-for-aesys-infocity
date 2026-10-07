<?php
/*
Plugin Name:  Aesys MyInfo.City viewer
Description:  Viewer for Aesys MyInfoCity displays
Version:      2.2
Author:       Marco Milesi
Author URI: https://www.marcomilesi.com
Contributors: Milmor
*/

add_action('init', function() {
	require 'class-admin.php';
} );

function aesys_admininit_start() {
    
    $arraya_v = get_plugin_data ( __FILE__ );
	$new_version = $arraya_v['Version'];
	
	register_setting( 'viewer-for-aesys-infocity', 'aesys_panels' );
    
     if ( version_compare($new_version,  get_option('aesys_version_number') ) == 1 ) {
        update_option( 'aesys_version_number', $new_version );   
    }
    
} add_action('admin_init', 'aesys_admininit_start');

function aesys_short( $atts ) {
    ob_start();
    require 'class-shortcode.php';
    return ob_get_clean();
}
add_shortcode('aesys', 'aesys_short');

function aesys_get_url( $id, $refresh = false ) {
	
	$remote_url = '//www.myinfo.city/VMS/getCurrentPreviewGIF?VMSID='.$id;

	$old_timestamp = get_option( 'aesys_time_'.$id );
	$local_url = plugin_dir_path( __FILE__ ) . 'scrape/'.$id.'.gif';

	if ( $old_timestamp && ( $old_timestamp > ( current_time( 'timestamp' )-15*60) ) && file_exists ( $local_url ) ) {
		return plugins_url( 'scrape/'.$id.'.gif', __FILE__ );
	} else if ( @copy( $remote_url, $local_url) ) {
		update_option( 'aesys_time_'.$id, current_time( 'timestamp' ) );
		return plugins_url( 'scrape/'.$id.'.gif', __FILE__ );
	} else if ( @file_exists ( $local_url ) ){
		return plugins_url( 'scrape/'.$id.'.gif', __FILE__ );
	} else {
		return $remote_url;
	}
}
?>

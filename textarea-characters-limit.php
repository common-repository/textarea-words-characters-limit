<?php
/**
 * Plugin Name: Textarea Characters Limit
 * Version: 1.0.2
 * Description: A simple plugin that allows you to limit the characters of the textarea, also you can display the characters counter
 * Author: Muhammad Rehman
 * Author URI: https://muhammadrehman.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'cct-settings.php';

function cct_add_css_js() {
    wp_enqueue_style( 'count-details',  plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
    wp_enqueue_script( 'count-details', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array(), '1.0.2', true );

    wp_localize_script( 'count-details', 'cct_object',
        array( 
            'data' => get_option('cct_settings')
        )
    );
}
add_action( 'wp_enqueue_scripts', 'cct_add_css_js' );

function cct_on_activation(){

    if( get_option( 'cct_settings' ) == false ) {

        $default = array(
            'max_character' => '100',
            'counter_text'  => '%characters_count% / %max_count%'
        );
        update_option( 'cct_settings', $default );
    }
}
register_activation_hook( __FILE__, 'cct_on_activation' );

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a Characters Count page.
 */
function cct_register_menu() {
    add_submenu_page(
        'options-general.php',
        __( 'Characters Counts', 'textdomain' ),
        'Characters Count',
        'manage_options',
        'cct-characters-count',
        'cct_menu_page'        
    );
}
add_action( 'admin_menu', 'cct_register_menu' );

function cct_menu_page() {

    cct_save_settings();
    
    $data = get_option('cct_settings',false);  

    $nonce = wp_nonce_field( 'save-settings' );

    $html = '<div class="wrap">
    <h1>Characters Count</h1>
    
    <form method="post" action="#">';
    $html .= $nonce;
    $html .= '<table class="form-table">
    
    <tbody><tr>
    <th scope="row"><label for="cct-enable">Enable</label></th>
    <td><input name="cct-enable" type="checkbox" id="cct-enable" value="1" '. ( !empty( $data['enable'] ) ? 'checked' : '' ) .' class="regular-text">
    <p class="description" id="cct-classes">Enable Characters count.</p></td>
    </tr>
    
    <tr>
    <th scope="row"><label for="cct-display-progress-bar">Display Typing Bar</label></th>
    <td><input name="cct-display-progress-bar" type="checkbox" id="cct-display-progress-bar" value="1" '. ( !empty( $data['display_progress'] ) ? 'checked' : '' ) .' class="regular-text">
    <p class="description" id="cct-classes">Display typing bar when typing in textarea.</p></td>
    </tr>

    <tr>
    <th scope="row"><label for="cct-classes">Classes to Apply</label></th>
    <td><input name="cct-classes" type="text" id="cct-classes" placeholder=".cct-count, .new-class" value="'. ( isset( $data['classes_to_apply'] ) ? $data['classes_to_apply'] : '' ) .'" class="regular-text">
    <p class="description" id="cct-classes">Add comma separated classes to apply letter count functionality. The default class is <code>.cct-count</code></p></td>
    </tr>

    <tr>
    <th scope="row"><label for="cct-max-character">Max Character / Letter</label></th>
    <td><input name="cct-max-character" type="text" id="cct-max-character" placeholder="100" value="'. ( isset( $data['max_character'] ) ? $data['max_character'] : '' ) .'" class="regular-text">
    <p class="description" id="cct-max-character">Maximum number the textarea field allow to input.</p></td>
    </tr>

    <tr>
    <th scope="row"><label for="cct-counter-text">Counter Text</label></th>
    <td><input name="cct-counter-text" type="text" id="cct-counter-text" placeholder="%characters_count% / %max_count%" value="'. ( isset( $data['counter_text'] ) ? $data['counter_text'] : '' ) .'" class="regular-text">
    <p class="description" id="cct-counter-text">Text to show in each textarea, supported tags are <code>%characters_count%</code> <code>%max_count%</code></p></td>
    </tr>

    </tbody></table>
    
    
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p></form>
    
    </div>';

    $html_tags = array(
        'div' => array(
            'class' => array(),            
        ),
        'h1' => array(),
        'form' => array(
            'method' => array(),
            'action' => array(),
        ),
        'input' => array(
            'type' => array(),
            'id' => array(),
            'class' => array(),
            'placeholder' => array(),
            'name' => array(),
            'value' => array(),
            'checked' => array()
        )
    );

    $allowed_html = array_merge( $html_tags, wp_kses_allowed_html('post') );

    // var_dump( $allowed_html );
    echo wp_kses( $html, $allowed_html );

    // echo $html;
}

/**
 * Save Settings
 */
function cct_save_settings() {

    if( !empty( $_POST ) && current_user_can( 'edit_posts' ) && check_admin_referer( 'save-settings' )) {        

        $cct_data = array();

        $cct_data['enable'] = intval( $_POST['cct-enable'] );
        $cct_data['display_progress'] = intval( $_POST['cct-display-progress-bar'] );
        $cct_data['classes_to_apply'] = sanitize_text_field( $_POST['cct-classes'] );
        $cct_data['counter_text'] = sanitize_text_field( $_POST['cct-counter-text'] );
        $cct_data['max_character'] = intval( $_POST['cct-max-character'] );
        
        update_option( 'cct_settings', $cct_data );
    }
}
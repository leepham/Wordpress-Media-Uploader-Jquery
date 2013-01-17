<?php
/*
 * Author: Lee Pham
 * From: http://wp.tutsplus.com/author/leepham
 * Twitter: http://twitter.com/leephamj
 *
 */
add_action( 'after_setup_theme', 'wptuts_default_options' );
function wptuts_default_options() {
	// Check whether or not the 'wptuts_options' exists
	// If not, create new one.
    if ( ! get_option( 'wptuts_options' ) ) {
        $options = array(
            'logo' => '',
            'favicon' => '',
        );
        update_option( 'wptuts_options', $options );
    }     
}

add_action( 'admin_menu', 'wptuts_add_page' );
function wptuts_add_page() {
    $wptuts_options_page = add_menu_page( 'wptuts', 'WPTuts Options', 'manage_options', 'wptuts', 'wptuts_options_page' );
    add_action( 'admin_print_scripts-' . $wptuts_options_page, 'wptuts_print_scripts' );
} 
function wptuts_options_page() {
?>
    <div class='wrap'>
        <div id='icon-tools' class='icon32'></br></div>
        <h2>WPTuts+ Options Page</h2>
        <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) : ?>
        <div class='updated'><p><strong>Settings saved.</strong></p></div>
        <?php endif; ?>
        <form action='options.php' method='post'>
            <?php settings_fields( 'wptuts_options' ); ?>
            <?php do_settings_sections( 'wptuts' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php 
}

add_action( 'admin_init', 'wptuts_add_options' );
function wptuts_add_options() {
    register_setting( 'wptuts_options', 'wptuts_options', 'wptuts_options_validate' );
    add_settings_section( 'wptuts_section', 'WPTuts+ Options Section', 'wptuts_section_callback', 'wptuts' );
    add_settings_field( 'wptuts_logo', 'WPTuts+ Logo', 'wptuts_logo_callback', 'wptuts', 'wptuts_section' );
    add_settings_field( 'wptuts_favicon', 'WPTuts+ Favicon', 'wptuts_favicon_callback', 'wptuts', 'wptuts_section' );
}

function wptuts_options_validate($values) { 
    foreach ( $values as $n => $v ) 
        $values[$n] = esc_url($v);
    return $values; 
}

function wptuts_section_callback() { /* Print nothing */ };

function wptuts_logo_callback() {
    $options = get_option( 'wptuts_options' ); 
?>
    <span class='upload'>
        <input type='text' id='wptuts_logo' class='regular-text text-upload' name='wptuts_options[logo]' value='<?php echo esc_url($options["logo"]); ?>'/>
        <input type='button' class='button button-upload' value='Upload an image'/></br>
        <img style='max-width: 300px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
    </span>
<?php
}

function wptuts_favicon_callback() {
    $options = get_option( 'wptuts_options' ); 
?>
    <span class='upload'>
        <input type='text' id='wptuts_favicon' class='regular-text text-upload' name='wptuts_options[favicon]' value='<?php echo esc_url($options["favicon"]); ?>'/>
        <input type='button' class='button button-upload' value='Upload an image'/></br>
        <img style='max-width: 300px; display:block' src='<?php echo esc_url($options["favicon"]); ?>' class='preview-upload'/>
    </span>
<?php
}

function wptuts_print_scripts() {
    wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'wptuts-upload', get_template_directory_uri() . '/wptuts-upload.js', array( 'thickbox', 'media-upload' ) );
}

function wptuts_add_favicon() {
	$wptuts_options = get_option( 'wptuts_options' );
	$wptuts_favicon = $wptuts_options['favicon'];
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($wptuts_favicon); ?>">
<?php
}
add_action( 'wp_head', 'wptuts_add_favicon' );
?>

<?php
/*
Plugin Name: ESC Dashboard
Plugin URI:  http://eightsevencentral.com
Description: Eight Seven Central login page, dashboard, widgets and TinyMCE formats.
Version:     1.2
Author:      Eight Seven Central
Author URI:  http://eightsevencentral.com
License:     Not licensed for public use.
*/

/**
 * Load login.css on login page.
 */
function esc_login_css() {
  wp_register_style( 'esc_login', plugins_url( 'css/login.css', __FILE__ ), array(), '2013', 'all' );
  wp_enqueue_style( 'esc_login' );
}
add_action( 'login_enqueue_scripts', 'esc_login_css', 10 );

/**
 * Login URL and title
 *
 * @link http://primegap.net/2011/01/26/wordpress-quick-tip-custom-wp-login-php-logo-url-without-hacks/
 */
function esc_login_url() {
  return ('http://eightsevencentral.com');
}
add_filter( 'login_headerurl', 'esc_login_url', 10, 4 );

function esc_login_title() {
  return ('Eight Seven Central');
}
add_filter( 'login_headertitle', 'esc_login_title', 10, 4 );

/**
 * Add ESC News widget
 */
add_action('wp_dashboard_setup', 'esc_add_dashboard_widgets');
function esc_add_dashboard_widgets() {
  wp_add_dashboard_widget( 'dashboard_esc_feed', 'From the News Desk at Eight Seven Central', 'dashboard_esc_feed_output' );
}
function dashboard_esc_feed_output() {
  echo '<div class="rss-widget">';
  wp_widget_rss_output(array(
    'url'          => 'http://www.eightsevencentral.com/feed',
    'title'        => 'What\'s up at Eight Seven Central',
    'items'        => 3,
    'show_summary' => 1,
    'show_author'  => 0,
    'show_date'    => 1,
  ));
  echo "</div>";
}

/**
 * Remove default WP widgets
 */
function esc_dashboard_widgets() {
  global $wp_meta_boxes;

  //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}
add_action('wp_dashboard_setup', 'esc_dashboard_widgets' );

/**
 * Footer credits
 */
add_filter( 'admin_footer_text', 'esc_admin_footer_text' );
function esc_admin_footer_text( $default_text ) {
  return 'Design + Development by <a href="http://eightsevencentral.com">Eight Seven Central</a>';
}

/**
 * Disable 3.1 admin bar for all users
 *
 * @link http://www.snilesh.com/resources/wordpress/wordpress-3-1-enable-disable-remove-admin-bar/
 */
add_filter( 'show_admin_bar' , 'esc_admin_bar');
function esc_admin_bar(){
  return false;
}

/**
 * Remove the dashboard update link
 *
 * @link http://www.vooshthemes.com/blog/wordpress-tip/wordpress-quick-tip-remove-the-dashboard-update-message/
 */
add_action( 'admin_init', create_function('', 'remove_action( \'admin_notices\', \'update_nag\', 3 );') );

/**
 * Add custom styles in your posts and pages content using TinyMCE WYSIWYG editor.
 * This adds a Styles dropdown menu in the visual post editor.
 *
 * Based on TinyMCE Kit plug-in for WordPress
 * http://plugins.svn.wordpress.org/tinymce-advanced/branches/tinymce-kit/tinymce-kit.php
 *
 * Learn TinyMCE style format options: http://www.tinymce.com/wiki.php/Configuration:formats
 * More examples: http://www.wpexplorer.com/wordpress-tinymce-tweaks/
 */
/**
 * Apply styles to the visual editor. Commented out since theme should alreay be loading editor-style.css
 */
//function esc_editor_css() {
//  wp_enqueue_style('esc_editor', plugins_url( '/css/editor-style.css', __FILE__ ) );
//}
//add_action( 'admin_enqueue_scripts', 'esc_editor_css' );

/**
 * Add Formats Dropdown Menu To MCE
 */
function esc_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'esc_mce_editor_buttons' );

/**
 * Add new styles to the TinyMCE "formats" menu drop-down
 */
function esc_mce_before_init( $settings ) {

  // Create array of new styles
  $style_formats = array(
    array(
      'title' => 'Typography',
      'items' => array(
        array(
          'title' => 'Lead Paragraph',
          'selector' => 'p',
          'classes' => 'lead'
        ),
        array(
          'title' => 'Small Text',
          'inline' => 'small'
        ),
        array(
          'title' => 'Abbreviation',
          'inline' => 'abbr',
          'attributes' => array(
              'title' => ''
          ),
        ),
        array(
          'title' => 'Initialism',
          'inline' => 'abbr',
          'classes' => 'initialism',
          'attributes' => array(
              'title' => ''
          ),
        ),
      ),
    ),
    array(
      'title' => 'Contextual Colors',
      'items' => array(
        array(
          'title' => 'Muted Text',
          'selector' => 'p',
          'classes' => 'text-muted'
        ),
        array(
          'title' => 'Primary Text',
          'selector' => 'p',
          'classes' => 'text-primary'
        ),
        array(
          'title' => 'Success Text',
          'selector' => 'p',
          'classes' => 'text-success'
        ),
        array(
          'title' => 'Info Text',
          'selector' => 'p',
          'classes' => 'text-info'
        ),
        array(
          'title' => 'Warning Text',
          'selector' => 'p',
          'classes' => 'text-warning'
        ),
        array(
          'title' => 'Danger Text',
          'selector' => 'p',
          'classes' => 'text-danger'
        ),
      ),
    ),
    array(
      'title' => 'Contextual Backgrounds',
      'items' => array(
        array(
          'title' => 'Primary Background',
          'selector' => 'p',
          'classes' => 'bg-primary'
        ),
        array(
          'title' => 'Success Background',
          'selector' => 'p',
          'classes' => 'bg-success'
        ),
        array(
          'title' => 'Info Background',
          'selector' => 'p',
          'classes' => 'bg-info'
        ),
        array(
          'title' => 'Warning Background',
          'selector' => 'p',
          'classes' => 'bg-warning'
        ),
        array(
          'title' => 'Danger Background',
          'selector' => 'p',
          'classes' => 'bg-danger'
        ),
      ),
    ),
    array(
      'title' => 'Buttons',
      'items' => array(
        array(
          'title' => 'Type',
          'items' => array(
            array(
              'title' => 'Link',
              'selector' => 'a',
              'classes' => 'btn'
            ),
            array(
              'title' => 'Button',
              'inline' => 'button',
              'classes' => 'btn',
              'attributes' => array(
                  'type' => 'button'
              ),
            ),
          ),
        ),
        array(
          'title' => 'Options',
          'items' => array(
            array(
              'title' => 'Default',
              'selector' => 'a',
              'classes' => 'btn-default'
            ),
            array(
              'title' => 'Primary',
              'selector' => 'a',
              'classes' => 'btn-primary'
            ),
            array(
              'title' => 'Success',
              'selector' => 'a',
              'classes' => 'btn-success'
            ),
            array(
              'title' => 'Info',
              'selector' => 'a',
              'classes' => 'btn-info'
            ),
            array(
              'title' => 'Warning',
              'selector' => 'a',
              'classes' => 'btn-warning'
            ),
            array(
              'title' => 'Danger',
              'selector' => 'a',
              'classes' => 'btn-danger'
            ),
          ),
        ),
        array(
          'title' => 'Sizes',
          'items' => array(
            array(
              'title' => 'Large',
              'selector' => 'a',
              'classes' => 'btn-lg'
            ),
            array(
              'title' => 'Default',
              'selector' => 'a',
              'classes' => ''
            ),
            array(
              'title' => 'Small',
              'selector' => 'a',
              'classes' => 'btn-sm'
            ),
            array(
              'title' => 'Extra Small',
              'selector' => 'a',
              'classes' => 'btn-xs'
            ),
            array(
              'title' => 'Block',
              'selector' => 'a',
              'inline' => 'button',
              'classes' => 'btn-block'
            ),
          ),
        ),
      ),
    ),
    /* Examples
    array(
        'title' => 'Warning Box',
        'block' => 'div',
        'classes' => 'warning box',
        'wrapper' => true
    ),
    array(
        'title' => 'Red Uppercase Text',
        'inline' => 'span',
        'styles' => array(
            'color' => '#ff0000',
            'fontWeight' => 'bold',
            'textTransform' => 'uppercase'
        )
    )
    */
  );

  // Merge old & new styles
  //$settings['style_formats_merge'] = true;

  // Add new styles
  $settings['style_formats'] = json_encode( $style_formats );

  // Return New Settings
  return $settings;

}
add_filter( 'tiny_mce_before_init', 'esc_mce_before_init' );


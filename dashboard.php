<?php
/*
Plugin Name: ESC Dashboard
Plugin URI:  http://eightsevencentral.com
Description: Eight Seven Central login page, dashboard and widgets.
Version:     1.1
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

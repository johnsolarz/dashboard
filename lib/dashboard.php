<?php
/**
 * Login screen css
 */
function esc_login_css() {
  // adjust to match your theme structure
  echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/assets/css/login.css">';
}
add_action('login_head', 'esc_login_css');

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
 * Dashboard widget
 */
add_action('wp_dashboard_setup', 'esc_add_dashboard_widgets');
function esc_add_dashboard_widgets() {
  wp_add_dashboard_widget( 'dashboard_esc_feed', 'From the News Desk at Eight Seven Central', 'dashboard_esc_feed_output' );
}
function dashboard_esc_feed_output() {
  echo '<div class="rss-widget">';
  wp_widget_rss_output(array(
    'url'          => 'http://www.eightsevencentral.com/feed',
    'title'        => 'What\'s up at 8/7',
    'items'        => 3,
    'show_summary' => 1,
    'show_author'  => 0,
    'show_date'    => 1,
  ));
  echo "</div>";
}

/**
 * Footer credits
 */
add_filter( 'admin_footer_text', 'esc_admin_footer_text' );
function esc_admin_footer_text( $default_text ) {
  return '<span id="footer-thankyou">Design + Development by <a href="http://eightsevencentral.com">Eight Seven Central</a><span> &mdash; Powered by <a href="http://www.wordpress.org">WordPress</a>';
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
 * Remove default sidebar widgets
 *
 * @link http://www.everparent.com/lunaticfred/2011/05/05/how-to-remove-default-sidebar-widgets-in-wordpress/
 */
function esc_default_widgets() {
  //unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  //unregister_widget('WP_Widget_Text');
  //unregister_widget('WP_Widget_Categories');
  //unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
  //unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'esc_default_widgets' );

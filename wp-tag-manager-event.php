<?php
/*
Plugin Name: WP Tag Manager Event
Version: 1.0
Description: Save and Consult All Event on Google Analytics
Author: WP-Love
Author URI: https://wp-love.it/
*/

// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}

include 'wptme.php';

$WpTme = new WpTme();

function wptme_load_textdomain()
{
	$plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
	load_plugin_textdomain( 'wptme', false, $plugin_rel_path );
}
add_action('plugins_loaded', 'wptme_load_textdomain');


function wptme_activated()
{
   	global $wpdb;

		if($wpdb->get_var("SHOW TABLES like '{$wpdb->prefix}wptme'") != $wpdb->prefix . 'wptme')
		{
			$wpdb->query("CREATE TABLE {$wpdb->prefix}wptme ( id mediumint(9) NOT NULL PRIMARY KEY AUTO_INCREMENT, selector varchar(125) NOT NULL , element VARCHAR(125), eventCategory VARCHAR(125), eventAction VARCHAR(125), eventLabel VARCHAR(125) )");
		}
}


function wptme_deactivate()
{
	global $wpdb;
}


function wptme_uninstall()
{
	global $wpdb;

	$wpdb->query("DROP TABLE {$wpdb->prefix}wptme");
}

register_activation_hook(	__FILE__,	'wptme_activated'  );
register_deactivation_hook(	__FILE__,	'wptme_deactivate' );
register_uninstall_hook(	__FILE__,	'wptme_uninstall'  );


function wptme_add_script()
{
  wp_register_script('wp_tag_manager_event', plugins_url('wp-tag-manager-event/js/wp-tag-manager-event.js', dirname(__FILE__) ), array( 'jquery' ), '1.0');

  wp_enqueue_script( 'wp_tag_manager_event' );
}
add_action('wp_enqueue_scripts', 'wptme_add_script');


function wptme_add_backend_script()
{
  wp_enqueue_script('wp_tag_manager_backend', plugins_url( 'wp-tag-manager-event/js/wp-tag-manager-backend.js', dirname(__FILE__) ), array( 'jquery' ), '1.0');
}
add_action('admin_enqueue_scripts', 'wptme_add_backend_script');


function wptme_add_option_page()
{
  add_options_page('WP Tag Manager Event', 'WP Tag Manager Event', 'manage_options', 'wptme-page', 'wptme_index');
}
add_action('admin_menu', 'wptme_add_option_page');


function wptme_index()
{
  if (!current_user_can('manage_options'))
  {
    wp_die('You do not have sufficient permissions to access this page.');
  }

  include 'wptme_index.php';
}


function wptme_meta()
{
  $results = $GLOBALS['WpTme']->all();

  $html = '';

  foreach ($results as $key => $value)
  {
    $html .= "\n<meta name='wp_tag'  data-id='{$value->id}' data-eventcategory='{$value->eventCategory}' data-eventaction='{$value->eventAction}' data-eventlabel='{$value->eventLabel}' data-selector='{$value->selector}' data-element='{$value->element}' /> \n\t";
  }
  $html .= "\n<meta name='wp_tag_scroll' content='0' /> \n\t";

  echo $html;
}
add_action('wp_head', 'wptme_meta');

?>

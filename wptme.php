<?php

// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}

class WpTme
{
    public $results = array();

    function all()
    {
      global $wpdb;

			$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wptme ORDER BY id DESC");

			return $this->results = $results;
    }

    function save($selector, $element, $eventCategory, $eventAction, $eventLabel)
    {
			global $wpdb;

      $wpdb->show_errors();

			$wpdb->query("INSERT INTO {$wpdb->prefix}wptme SET selector = '{$selector}', element = '{$element}', eventCategory = '{$eventCategory}', eventAction = '{$eventAction}', eventLabel = '{$eventLabel}'");

      if($wpdb->last_error !== '')
      {
        $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
        $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

        echo "
        <div id='error'>
          <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
          <code>$query</code></p>
        </div>";
      }

		}

    function delete($id)
    {
			global $wpdb;

      $wpdb->show_errors();

			$wpdb->query("DELETE FROM {$wpdb->prefix}wptme WHERE id = '{$id}'");

			if($wpdb->last_error !== '')
      {
        $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
        $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

        echo "
        <div id='error'>
          <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
          <code>$query</code></p>
        </div>";
      }

		}
}
?>

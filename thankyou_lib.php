<?php
/* 
 * Thank You Counter Button plugin Lirary
 * general staff used in more than one .php file
 *
 */

if (! defined("WPLANG")) {
  echo 'Direct call is prohibited';
  die;
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$thanksPluginDirName = substr(dirname(__FILE__), strlen(WP_PLUGIN_DIR)+1, strlen(__FILE__)-strlen(WP_PLUGIN_DIR)-1);

define('THANKS_PLUGIN_URL', WP_PLUGIN_URL.'/'.$thanksPluginDirName);
define('THANKS_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.$thanksPluginDirName);

global $wpdb, $thanksCountersTable, $thanksPostReadersTable;

// MySQL tables to store 'thanks' information
$thanksCountersTable = $wpdb->prefix .'thanks_counters';
$thanksPostReadersTable = $wpdb->prefix .'thanks_readers';


function getThanksCaption($postId) {

global $wpdb, $thanksCountersTable;


$query = "select quant
            from $thanksCountersTable
            where post_id=$postId
            limit 0, 1";
$quant = $wpdb->get_var($query);
if ($wpdb->last_error) {
  echo 'error: '.$wpdb->last_error;
  return;
}

if (!$quant) {
  $quant = 0;
}
$caption = get_option('thanks_caption').": $quant";

return $caption;
}
// end of getThanksCaption()


?>

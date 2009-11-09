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

// returns client machine IP address
function thanks_getVisitorIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}
// end of thanks_getVisitorIP()


// check if post is thanked already from This IP
function thanks_checkVisitorIP($postId, $visitorIP, $register=false) {

  global $wpdb, $thanksPostReadersTable;

  $query = "select id, UNIX_TIMESTAMP(updated) as updated
              from $thanksPostReadersTable
              where post_id=$postId and ip_address='$visitorIP'
              limit 0, 1";
  $record = $wpdb->get_results($query);
  if ($wpdb->last_error) {
      echo 'error: '.$wpdb->last_error;
      exit;
  }
  $id = $record[0]->id;
  if ($id) {
    if ($register) {
      $query = "update $thanksPostReadersTable set updated=CURRENT_TIMESTAMP where id=$id";
      $wpdb->query($query);
      if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
        return false;
      }
    }
    $thanks_time_limit = get_option('thanks_time_limit');
    if ($thanks_time_limit[0]==1) { // forever
      $ipFound = true;
    } else {
      $thanks_time_limit_seconds = get_option('thanks_time_limit_seconds');
      $now = time();
      $diff = $now - $record[0]->updated;
      if ($diff>$thanks_time_limit_seconds) {
        $ipFound = false;
      } else {
        $ipFound = true;
      }
    }
  } else {
    if ($register) {
      $query = "insert into $thanksPostReadersTable (post_id, ip_address) values ($postId, '$visitorIP')";
      $wpdb->query($query);
      if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
        return false;
      }
    }
    $ipFound = false;
  }
  
  return $ipFound;
}
// end of thanks_checkVisitorIP()


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


function thanks_optionSelected($value, $etalon) {
  $selected = '';
  if ($value==$etalon) {
    $selected = 'selected="selected"';
  }

  return $selected;
}

?>

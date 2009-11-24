<?php
/* 
 * Thank You Counter Button plugin Lirary
 * general staff used in more than one .php file
 * Author: Vladimir Garagulya vladimir@shinephp.com
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


function getThanksCaption($postId, $thankyou_preview) {
	if ($thankyou_preview) {
		$quant = rand(0, 100);
	}	else {
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


function thanks_optionChecked($value, $etalon) {
  $checked = '';
  if ($value==$etalon) {
    $checked = 'checked="checked"';
  }

  return $checked;
}


function thanks_getButtonInputHTML($onButtonClick, $thanksCaption, $buttonSizeClass, $buttonColorClass,
                                   $imageURL, $thanks_custom_width, $thanks_custom_height, $thanks_caption_style,
                                   $thanks_caption_color, $thanksButtonId, $buttonTitle) {
  if ($thanks_caption_style) {
    $thanks_caption_style .= ';';
  }
  $thanks_caption_color = get_option('thanks_caption_color');
  if ($thanks_caption_color) {
    $thanks_caption_color = 'color:'.$thanks_caption_color.';';
  }
  if ($thanks_custom_width) {
    if (strpos($thanks_custom_width, 'px')===false) {
      $thanks_custom_width = trim($thanks_custom_width).'px';
    }
    $thanks_custom_width = 'width:'.$thanks_custom_width.';';
  }
  if ($thanks_custom_height) {
    if (strpos($thanks_custom_height, 'px')===false) {
      $thanks_custom_height = trim($thanks_custom_height).'px';
    }
    $thanks_custom_height = 'height:'.$thanks_custom_height.';';
  }

  $output = '<input type="button" onclick="'.$onButtonClick.'" value="'.$thanksCaption.'"
                class="thanks_button '.$buttonSizeClass.' '.$buttonColorClass.'"
                style="background-image:url('.$imageURL.');'.$thanks_custom_width.' '.$thanks_custom_height.' '.$thanks_caption_style.' '.$thanks_caption_color.'"
                id="thanksButton_'.$thanksButtonId.'" title="'.$buttonTitle.'"/>';

  return $output;

}
// end of thanks_getButtonInputHTML()


// returns the total quant of thanks for all posts
function thanks_get_Total() {
  global $wpdb, $thanksCountersTable;
	$query = "select SUM(quant)
	            from $thanksCountersTable";
	$quant = $wpdb->get_var($query);
	if ($wpdb->last_error) {
	  echo 'error: '.$wpdb->last_error;
	  return 0;
	}
  if (!$quant) {
    $quant = 0;
  }

  return $quant;
}
// end of get_thanksTotal()


// Increments postId's counter by one point
function thanks_add_count($postId) {
    global $wpdb, $thanksCountersTable, $thanksPostReadersTable;

    $checkIP = get_option('thanks_check_ip_address');
    if ($checkIP=='1') {
      $visitorIP = thanks_getVisitorIP();
      $ipFound = thanks_checkVisitorIP($postId, $visitorIP, true);  // id of the visitor record for this IP and post
    } else {
      $ipFound = false;
    }

    if (!$ipFound) {
      $query = "select id
                  from $thanksCountersTable
                  where post_id=$postId
                  limit 0, 1";
      $id = $wpdb->get_var($query);
      if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
        return;
      }
      if ($id) {
        $query = "update $thanksCountersTable set quant=quant+1, updated=CURRENT_TIMESTAMP
                    where id=$id
                    limit 1";
      } else {
        $query = "insert into $thanksCountersTable (post_id, quant) values ($postId, 1)";
      }
      $wpdb->query($query);
      if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
      }
    }

}
// end of function thanks_add_count()

?>

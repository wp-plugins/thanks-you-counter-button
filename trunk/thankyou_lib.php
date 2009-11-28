<?php
/* 
 * Thank You Counter Button plugin Lirary
 * general staff used in more than one .php file
 * Author: Vladimir Garagulya vladimir@shinephp.com
 *
 */

if (! defined("WPLANG")) {
  die;  // Silence is golden, direct call is prohibited
}

$thanks_siteURL = get_option( 'siteurl' );

// Pre-2.6 compatibility
if ( !defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', $thanks_siteURL . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$thanksPluginDirName = substr(dirname(__FILE__), strlen(WP_PLUGIN_DIR)+1, strlen(__FILE__)-strlen(WP_PLUGIN_DIR)-1);

define('THANKS_PLUGIN_URL', WP_PLUGIN_URL.'/'.$thanksPluginDirName);
define('THANKS_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.$thanksPluginDirName);
define('THANKS_WP_ADMIN_URL', $thanks_siteURL.'/wp-admin');

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


function getThanksQuant($postId) {
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

  return $quant;
}
// end of getThanksQuant()


function getThanksCaption($postId, $caption = "") {

  $quant = getThanksQuant($postId);
  if (!$caption) {
    $caption = get_option('thanks_caption');
  }
	$caption .= ': '.$quant;
	
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


function thanks_settingsToDefaults() {
  if (!current_user_can('activate_plugins')) {
    die(__('operation is prohibited', 'thankyou'));
  }
  update_option('thanks_display_page', 1);
  update_option('thanks_display_home', 1);
  update_option('thanks_not_display_for_categories', 0);
  update_option('thanks_not_display_for_cat_list', array());
  update_option('thanks_position_before', 0);
  update_option('thanks_position_after', 1);
  update_option('thanks_position_firstpageonly', 0);
  update_option('thanks_position_lastpageonly', 1);
  update_option('thanks_position_shortcode', 1);
  update_option('thanks_position_manual', 1);
  update_option('thanks_style', 'float: left; margin-right: 10px;');
  update_option('thanks_caption_style', 'font-family: Verdana, Arial, Sans-Serif; font-size: 14px; font-weight: normal;');
  update_option('thanks_caption_color', '#ffffff');
  update_option('thanks_size', 'large');
  update_option('thanks_color', 'blue');
  update_option('thanks_custom', 0);
  update_option('thanks_custom_url', '');
  update_option('thanks_custom_width', 100);
  update_option('thanks_custom_height', 26);
  update_option('thanks_check_ip_address', 1);
  update_option('thanks_time_limit', 1);
  update_option('thanks_time_limit_seconds', 60);
	update_option('thanks_show_last_date', 1);
	update_option('thanks_caption', __('Thank You','thankyou'));
  update_option('thanks_dashboard_rows_number', 5);
  update_option('thanks_dashboard_content', 'latest_thanked');
  update_option('thanks_dashboard_statistics_link_show', 1);
  update_option('thanks_dashboard_author_link_show', 1);

  return true;
}
// end of thanks_settingsToDefaults()


function resetCounterForPost() {
  global $wpdb, $thanksCountersTable;

  if (!current_user_can('edit_post', $postId)) {
    echo 'error: operation is prohibited.';
    return false;
  }
  $query = "update $thanksCountersTable set quant=0, updated=CURRENT_TIMESTAMP
              where post_id=$postId
              limit 1";
  $wpdb->query($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return false;
  }
  echo '<thankstat>thanks counter for post ID='.$postId.' is cleared.</thankstat>';
  
  return true;
}
// end of resetCounterForPost()


function thanks_resetAllCounters() {

  global $wpdb, $thanksCountersTable, $thanksPostReadersTable;

  if (!current_user_can('activate_plugins')) {
    die(__('operation is prohibited', 'thankyou'));
  }
  $query = "delete from $thanksCountersTable";
  $wpdb->query($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return false;
  }
  $query = "delete from $thanksPostReadersTable";
  $wpdb->query($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return false;
  }

  return true;
}
// end of thanks_resetAllCounters()



?>

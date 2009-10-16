<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (! (isset($_POST['post_id']) && $_POST['post_id'] && is_numeric($_POST['post_id']))) {
  echo 'error: wrong request, post Id is not defined';
  return;
}

require_once("../../../wp-config.php");

// check security
check_ajax_referer( "thanks-button" );

require_once('thankyou_lib.php');


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


// Increments postId's counter by one point
function thanks_add_count($postId) {
	global $wpdb, $thanksCountersTable, $thanksPostReadersTable;

  $checkIP = get_option('thanks_check_ip_address');
  if ($checkIP=='1') {
    $visitorIP = thanks_getVisitorIP();
    $query = "select id
              from $thanksPostReadersTable
              where post_id=$postId and ip_address='$visitorIP'
              limit 0, 1";
    $ipFound = $wpdb->get_var($query);
    if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
        return;
    }
    if (!$ipFound) {
      $query = "insert into $thanksPostReadersTable (post_id, ip_address) values ($postId, '$visitorIP')";
      $wpdb->query($query);
      if ($wpdb->last_error) {
        echo 'error: '.$wpdb->last_error;
        return;
      }
    }
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
      $query = "update $thanksCountersTable set quant=quant+1
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
//


$postId = $_POST['post_id'];
thanks_add_count($postId);
$result = getThanksCaption($postId);

echo '<thankyou>'.$result.'</thankyou>';


?>

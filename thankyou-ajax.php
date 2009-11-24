<?php
/* 
 * Thank You Counter Button WordPress plugin AJAX request processing staff
 * Author: Vladimir Garagulya vladimir@shinephp.com
 *
 */

if (! (isset($_POST['post_id']) && $_POST['post_id'] && is_numeric($_POST['post_id']))) {
  echo 'error: wrong request, post Id is not defined';
  return;
}

if (! (isset($_POST['action']) && $_POST['action'] && (($_POST['action']=='thankyou') || ($_POST['action']=='reset')))) {
  echo 'error: wrong request, action is not defined';
  return;
}


require_once("../../../wp-config.php");

// check security
check_ajax_referer( "thanks-button" );

require_once('thankyou_lib.php');

$postId = $_POST['post_id'];
$action = $_POST['action'];
if ($action=='thankyou') {
  thanks_add_count($postId);
  $result = getThanksCaption($postId);
  echo '<thankyou>'.$result.'</thankyou>';
} else if ($action=='reset') {
  global $wpdb, $thanksCountersTable;

  if (!current_user_can('edit_post', $postId)) {
    echo 'error: operation is prohibited.';
    return;
  }
  $query = "update $thanksCountersTable set quant=0, updated=CURRENT_TIMESTAMP
              where post_id=$postId
              limit 1";
  $wpdb->query($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return;
  }
  echo '<thankstat>thanks counter for post ID='.$postId.' is cleared.</thankstat>';
} else {
  echo 'error: unknown action '.$action;
}

?>

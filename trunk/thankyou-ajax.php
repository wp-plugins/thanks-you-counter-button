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

if (! (isset($_POST['action']) && $_POST['action'] && (($_POST['action']=='thankyou') || ($_POST['action']=='reset')
    || ($_POST['action']=='default') || ($_POST['action']=='resetall')))) {
  echo 'error: wrong request, action is invalid';
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
  resetCounterForPost();
} if ($action=='default') {
  if (thanks_settingsToDefaults()) {
    echo '<thankyou>0: settings to default, success</thankyou>';
  }
} else if ($action=='resetall') {
  if (thanks_resetAllCounters()) {
    echo '<thankyou>0: all counters are cleared, success</thankyou>';
  }
} else {
  echo '<thankyou>error: unknown action '.$action,'</thankyou>';
}

?>

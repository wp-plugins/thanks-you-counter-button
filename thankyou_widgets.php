<?php
/* 
*
* Thank You Counter Button WordPress plugin sidebar widgets staff
* Author: Vladimir Garagulya vladimir@shinephp.com
*
*/


// Latest Thanks widget class
class Thanks_Widget_Latest_Thanks extends WP_Widget {

	function Thanks_Widget_Latest_Thanks() {
		$widget_ops = array('classname' => 'thanks_widget_latest_thanks', 'description' => __('the latest or the most thanked post titles with total thanks quant', 'thankyou'));
		$this->WP_Widget('thanks-latest-thanks', __('Thanks Stat','thankyou'), $widget_ops);
		$this->alt_option_name = 'thanks_widget_latest_thanks';

	}

function widget($args, $instance) {
  global $wpdb, $thanksCountersTable;

	extract($args);

	$title = apply_filters('widget_title', empty($instance['title']) ? __('Thanks Stat', 'thankyou') : $instance['title']);
  // number of rows to show
	if ( !$number = (int) $instance['number'] ) {
		$number = 5;
  } else if ( $number < 1 ) {
		$number = 1;
  } else if ( $number > 15 ) {
		$number = 15;
  }
  // what content to show
  $content = $instance['content'];
  if ($content!='latest_thanked' && $content!='most_thanked') {
    $content = 'latest_thanked';
  }
  if ($content=='latest_thanked') {
   $order = 'counters.updated';
  } else {
   $order = 'counters.quant';
  }
  $query = "select posts.ID, posts.post_title, counters.quant, counters.updated
              from $wpdb->posts posts
                left join $thanksCountersTable counters on counters.post_id=posts.ID
              where counters.quant>0 and posts.post_type='post'
              order by $order desc limit 0, $number";
  $records = $wpdb->get_results($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return;
  }
  if (is_array($records) && count($records)) {
    $date_format = get_option('date_format').' '.get_option('time_format');
    $output = $before_widget;
		if ($title) {
      $output .= $before_title . $title . $after_title;
    }
		$output .= '<ul>';
		foreach ($records as $record) {
      $updated = mysql2date($date_format, $record->updated, true);
      $quant = ($record->quant) ? $record->quant : 0;
      $output .= '<li><a href="'.get_permalink($record->ID).'" title="'.$updated.'">'.$record->post_title.' ('.$quant.')</a></li>';
		}
		$output .= '</ul>';
		$output .= $after_widget;
    $output = apply_filters('thanks_stat_sidebar', $output);
    echo $output;
  }

}
// end of widget()

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
    $instance['content'] = strip_tags($new_instance['content']);

		return $instance;
	}

	function form( $instance ) {
		$title = esc_attr($instance['title']);
		if (!$number = (int) $instance['number']) {
			$number = 5;
    }
    $content = esc_attr($instance['content']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','thankyou'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:','thankyou'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e('(at most 15)','thankyou'); ?></small></p>
    <p><label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('What posts to show:', 'thankyou'); ?></label>
    <select id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" style="font-size: 0.9em;">
    <option value="latest_thanked" <?php echo thanks_optionSelected($content, 'latest_thanked'); ?>><?php _e('Latest thanked','thankyou');?></option>
    <option value="most_thanked" <?php echo thanks_optionSelected($content, 'most_thanked'); ?>><?php _e('Most thanked','thankyou');?></option>
  </select>
</p>
<?php
	}
}

function thanks_widgets_init() {
	if ( !is_blog_installed() )
		return;

	register_widget('Thanks_Widget_Latest_Thanks');

	do_action('widgets_init');
}

add_action('init', 'thanks_widgets_init', 1);


// dashboard widget staff
define(TD_ROWS_NUMBER, 'thanks_dashboard_rows_number');
define(TD_CONTENT, 'thanks_dashboard_content');
define(TD_STAT_LINK, 'thanks_dashboard_statistics_link_show');
define(TD_AUTHOR_LINK, 'thanks_dashboard_author_link_show');

// get from options what content to show
function thanks_get_dashboard_content_kind() {
  $content = get_option(TD_CONTENT);
  if ($content!='latest_thanked' && $content!='most_thanked') {
    $content = 'latest_thanked';
  }
  
  return $content;
}
// end of thanks_get_dashboard_content_kind()


// number of rows in result data set
function thanks_get_dashboard_rows() {
  $number = get_option(TD_ROWS_NUMBER);
  if (!is_numeric($number) || $number<0) {
    $number = 5;
  } else if ($number>15) {
    $number = 15;
  }

  return $number;
}
// end of thanks_get_dashboard_rows()


function thanks_dashboard_content() {

  global $wpdb, $thanksCountersTable;

  // number of rows in result data set
  $number = thanks_get_dashboard_rows();

  // what content to show
  $content = thanks_get_dashboard_content_kind();
  if ($content=='latest_thanked') {
   $order = 'counters.updated';
  } else {
   $order = 'counters.quant';
  }
  $ww_query = "select posts.ID, posts.post_title, counters.quant, counters.updated
                   from $wpdb->posts posts
                     left join $thanksCountersTable counters on counters.post_id=posts.ID
                   where counters.quant>0 and posts.post_type='post'
                   order by $order desc limit 0, $number";
  $ww_records = $wpdb->get_results($ww_query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return;
  }
  $ww_foundPosts = count($ww_records);
  if ($ww_foundPosts > 0) {
    $output ='
<div class="table">
  <table width="100%" cellpadding="0" cellspacing="0" class="widefat fixed">
        <tbody>';

    $date_format = get_option('date_format').' '.get_option('time_format');
    $i = 0;
    foreach ($ww_records as $ww_record) {
      if ($i & 1) {
        $class = 'class="alternate"';
      } else {
        $class = '';
      }
      $i++;
      $updated = mysql2date($date_format, $ww_record->updated, true);
      $quant = ($ww_record->quant) ? $ww_record->quant : 0;
      $output .= '<tr '.$class.'>
                    <td height="26" style="padding-left:8px;"><a class="rsswidget" href="'.get_permalink($ww_record->ID).'" title="'.$updated.'">'.$ww_record->post_title.'</a></td>
                    <td height="26" class="thanksquant" style="font-size:14px;" width="10%">'.$quant.'</td>
                  </tr>';
    }
    $output .= '</tbody>
          </table>
          <div>';
    $showStatLink = get_option('thanks_dashboard_statistics_link_show');
    if ($showStatLink==null || $showStatLink==1) {
      $output .= '<div style="float: right;margin-top:0px;font-size: 9px;"><a href="options-general.php?page=thankyou.php&paged=1">'.__('Check Full Statistics','thankyou').'</a></div>';
    }
    $showAuthorLink = get_option('thanks_dashboard_author_link_show');
    if ($showAuthorLink==null || $showAuthorLink==1) {
      $output .= '<div style="float: left;margin-top:0px;font-size: 9px;"><a target="_blank" href="http://www.shinephp.com/" title="'.__('Plugin author home page','thankyou').'">ShinePHP.com</a></div>';
    }
    $output .= '  </div>
                </div>';
    $output = apply_filters('thanks_stat_dashboard', $output);
    echo $output;
  } else {
    _e('No thanks yet', 'thankyou');
  }

}
// end of thanks_dashboard_content()



function thanks_dashboard_setup() {
  // update options
  if (isset($_POST['widget_id']) && $_POST['widget_id']=='dashboard_thanks') {
    if (isset($_POST[TD_ROWS_NUMBER])) {
      $option = stripslashes_deep($_POST[TD_ROWS_NUMBER]);
      if (!is_numeric($option) || $option<0) {
        $option = 5;
      } else if ($option>15) {
        $option = 15;
      }
      update_option(TD_ROWS_NUMBER, $option);
    }
    if (isset($_POST[TD_CONTENT])) {
      $option = stripslashes_deep($_POST[TD_CONTENT]);
      update_option(TD_CONTENT, $option);
    }

    if (isset($_POST[TD_STAT_LINK])) {
      $option = (int) stripslashes_deep($_POST[TD_STAT_LINK]);
    } else {
      $option = 0;
    }
    update_option(TD_STAT_LINK, $option);

    if (isset($_POST[TD_AUTHOR_LINK])) {
      $option = (int) stripslashes_deep($_POST[TD_AUTHOR_LINK]);
    } else {
      $option = 0;
    }
    update_option(TD_AUTHOR_LINK, $option);
  }

  $number = thanks_get_dashboard_rows();
  $content = get_option(TD_CONTENT);
  $statLinkChecked = get_option(TD_STAT_LINK);
  $authorLinkChecked = get_option(TD_AUTHOR_LINK);
?>

<label for="thanks_dashboard_rows_number">
  <?php _e('Posts number to show:', 'thankyou'); ?>
  <input type="text" id="thanks_dashboard_rows_number" name="thanks_dashboard_rows_number" value="<?php echo $number; ?>" />
</label><br/>
<label for="thanks_dashboard_content">
  <?php _e('What posts to show:', 'thankyou'); ?>
  <select id="thanks_dashboard_content" name="thanks_dashboard_content" style="font-size: 0.9em;">
    <option value="latest_thanked" <?php echo thanks_optionSelected($content, 'latest_thanked'); ?>><?php _e('Latest thanked','thankyou');?></option>
    <option value="most_thanked" <?php echo thanks_optionSelected($content, 'most_thanked'); ?>><?php _e('Most thanked','thankyou');?></option>
  </select>
</label><br/>
<label for="thanks_dashboard_statistics_link_show">
  <input type="checkbox" id="thanks_dashboard_statistics_link_show" name="thanks_dashboard_statistics_link_show" value="1"
    <?php echo thanks_optionChecked($statLinkChecked, 1); ?> />
  <?php _e('Display Full Statistics link', 'thankyou'); ?>
</label><br/>
<label for="thanks_dashboard_author_link_show">
  <input type="checkbox" id="thanks_dashboard_author_link_show" name="thanks_dashboard_author_link_show" value="1"
     <?php echo thanks_optionChecked($authorLinkChecked, 1); ?> />
  <?php _e('Display plugin author link', 'thankyou'); ?>
</label>

<?php

}
// end of thanks_dashboard_setup()

function add_thanks_dashboard_widget() {
  $content = thanks_get_dashboard_content_kind();
  if ($content=='latest_thanked') {
    $widget_title = __('Latest Thanks', 'thankyou');
  } else {
    $widget_title = __('Most Thanked', 'thankyou');
  }
  wp_add_dashboard_widget('dashboard_thanks', $widget_title, 'thanks_dashboard_content', 'thanks_dashboard_setup');

}
//  end of dashboard widget staff


function thanks_adminCssAction() {

  echo '<link rel="stylesheet" href="'.THANKS_PLUGIN_URL.'/css/thankyou_admin.css" type="text/css" media="screen" />'."\n";

}

if (is_admin()) {
  add_action('wp_dashboard_setup','add_thanks_dashboard_widget');
}
// end of thanks_cssAction()


?>

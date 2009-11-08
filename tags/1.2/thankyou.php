<?php
/*
Plugin Name: Thank You Counter Button
Plugin URI: http://www.shinephp.com/2009/10/05/thank-you-counter-button-wordpress-plugin/
Description: Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post.
Version: 1.2
Author: Vladimir Garagulya
Author URI: http://www.shinephp.com
*/

/*
Copyright 2009  Vladimir Garagulya  (email: vladimir@shinephp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if (!function_exists("get_option")) {
  echo 'Direct call is prohibited';
  die;
}

global $wp_version;

$exit_msg = __('Thank You Counter Button requires WordPress 2.7.1 or newer.').'<a href="http://codex.wordpress.org/Upgrading_WordPress">'.__('Please update!').'</a>';

if (version_compare($wp_version,"2.7.1","<"))
{
	exit ($exit_msg);
}

require_once('thankyou_lib.php');

load_plugin_textdomain('thankyou','', $thanksPluginDirName.'/lang');


function thanks_optionsPage() {
  
  global $thanksCountersTable, $thanksPostReadersTable;

  if (!session_id()) {
    session_start();
  }

  $thanks_caption = get_option('thanks_caption');
  $thanks_display_page = get_option('thanks_display_page');
  $thanks_display_home = get_option('thanks_display_home');
  $thanks_not_display_for_categories = get_option('thanks_not_display_for_categories');
  $thanks_not_display_for_cat_list = get_option('thanks_not_display_for_cat_list');
  $thanks_position = get_option('thanks_position');
  $thanks_style = get_option('thanks_style');
  $thanks_caption_style = get_option('thanks_caption_style');
  $thanks_caption_color = get_option('thanks_caption_color');
  $thanks_size = get_option('thanks_size');
  $thanks_color = get_option('thanks_color');
  $thanks_custom = get_option('thanks_custom');
  $thanks_custom_URL = get_option('thanks_custom_url');
  $thanks_custom_width = get_option('thanks_custom_width');
  $thanks_custom_height = get_option('thanks_custom_height');
  $thanks_check_ip_address = get_option('thanks_check_ip_address');
  $thanks_time_limit = get_option('thanks_time_limit');
  $thanks_time_limit_seconds = get_option('thanks_time_limit_seconds');
  $gotoStatisticsTab = isset($_GET['paged']) && (!isset($_GET['updated']));

?>

<div class="wrap">
  <div class="icon32" id="icon-options-general"><br/></div>
  <h2><?php _e('Thank You Counter Button Plugin', 'thankyou'); ?></h2>
  <p><?php _e('This plugin installs the Thank You Counter Button for each of your blog post.
                It can have custom style in your blog posts.','thankyou'); ?>
  </p>
  <script language="javascript" type="text/javascript">
		$j = jQuery.noConflict();
		$j(document).ready(function(){
			$tabs = $j("#optiontabs").tabs();
<?php
  if ($gotoStatisticsTab) {  // activate the Statistics tab
?>
   $tabs.tabs('select', 1);
<?php
  }
?>
		});
</script>
		<div id="optiontabs">
			<ul>
				<li><a href="#settings"><span><?php _e('Settings', 'thankyou'); ?></span></a></li>
				<li><a href="#statistics"><span><?php _e('Statistics', 'thankyou'); ?></span></a></li>
			</ul>


			<div id="settings"><br/>
				<p>
					<?php require ('thankyou_options.php'); ?>
				</p>
			</div>

			<div id="statistics" class="ui-tabs-hide"><br/>
				<p>
					<?php require ('thankyou_statistics.php'); ?>
				</p>
			</div>

		</div>

  </div>
<?php

}
// end of thanks_optionPage()


function thanks_settings_menu() {
	if ( function_exists('add_options_page') ) {
		add_options_page('Thank You Counter Button', 'Thanks CB', 9, basename(__FILE__), 'thanks_optionsPage');
	}
}
// end of thanks_settings_menu()


function thanks_buildButtonCode() {

  global $post;

  $thanks_custom = get_option('thanks_custom');
  if ($thanks_custom) {
    $thanks_custom_URL = get_option('thanks_custom_url');
    $thanks_custom_width = get_option('thanks_custom_width');
    if ($thanks_custom_width) {
      if (strpos($thanks_custom_width, 'px')===false) {
        $thanks_custom_width = trim($thanks_custom_width).'px';
      }
      $thanks_custom_width = 'width:'.$thanks_custom_width.';';
    }
    $thanks_custom_height = get_option('thanks_custom_height');
    if ($thanks_custom_height) {
      if (strpos($thanks_custom_height, 'px')===false) {
        $thanks_custom_height = trim($thanks_custom_height).'px';
      }
      $thanks_custom_height = 'height:'.$thanks_custom_height.';';
    }
    $imageURL = $thanks_custom_URL;
    $buttonSizeClass = 'thanks_custom_button';
    $buttonColorClass = '';
  } else {
    $thanks_custom_width = '';
    $thanks_custom_height = '';
    $thanks_size = get_option('thanks_size');
    $thanks_color = get_option('thanks_color');
    $imageName = 'thanks_'.$thanks_size.'_'.$thanks_color.'.png';
    $imageURL = THANKS_PLUGIN_URL.'/images/'.$imageName;
    $buttonSizeClass = 'thanks_'.$thanks_size;
    $buttonColorClass = 'thanks_'.$thanks_color;
  }
  $thanks_caption_style = get_option('thanks_caption_style');
  if ($thanks_caption_style) {
    $thanks_caption_style .= ';';
  }
  $thanks_caption_color = get_option('thanks_caption_color');
  if ($thanks_caption_color) {
    $thanks_caption_color = 'color:'.$thanks_caption_color.';';
  }

  $checkIP = get_option('thanks_check_ip_address');
  if ($checkIP=='1') {
    $visitorIP = thanks_getVisitorIP();
    $ipFound = thanks_checkVisitorIP($post->ID, $visitorIP);
  } else {
    $ipFound = false;
  }
  if ($ipFound) {
    $onButtonClick = 'return false;';
    $buttonTitle = 'You left &ldquo;Thanks&rdquo; already for this post';
  } else {
    $onButtonClick = 'thankYouButtonClick('.$post->ID.')';
    $buttonTitle = 'Click to left &ldquo;Thanks&rdquo; for this post';
  }

  $button = '<div class="thanks_button_div" style="'.get_option('thanks_style').'">
                <input type="button" onclick="'.$onButtonClick.'" value="'.getThanksCaption($post->ID).'"
                  class="thanks_button '.$buttonSizeClass.' '.$buttonColorClass.'"
                  style="background-image:url('.$imageURL.');'.$thanks_custom_width.' '.$thanks_custom_height.' '.$thanks_caption_style.' '.$thanks_caption_color.'"
                  id="thanksButton_'.$post->ID.'" title="'.$buttonTitle.'"/>
                <div id="ajax_loader_'.$post->ID.'" style="display:inline;visibility: hidden;"><img alt="ajax loader" src="'.THANKS_PLUGIN_URL.'/images/ajax-loader.gif" /></div>
             </div>';

  return $button;

}
// end of thanks_buildButtonCode()


function thanks_button_insert($content) {

  global $wpdb, $post;

  $thanks_position = get_option('thanks_position');
  // add the manual option, code added by kovshenin
  if ( ($thanks_position=='manual') ||
      (get_option('thanks_display_page')==null && is_page()) ||
      (get_option('thanks_display_home') == null && (is_home() || is_category() || is_tag()) ) ) {
    $html = $content;
  } else {
    $thanks_not_display_for_categories = get_option('thanks_not_display_for_categories');
    if ($thanks_not_display_for_categories) {
      $thanks_not_display_for_cat_list = get_option('thanks_not_display_for_cat_list');
      if ($thanks_not_display_for_cat_list) {
        $query = "select term_taxonomy.term_id
                    from $wpdb->term_taxonomy term_taxonomy
                      left join $wpdb->term_relationships term_relationships on (term_relationships.term_taxonomy_id=term_taxonomy.term_taxonomy_id)
                    where term_taxonomy.taxonomy='category' and term_relationships.object_id=$post->ID";
        $categories = $wpdb->get_results($query);
        if ($wpdb->last_error) {
           echo 'error: '.$wpdb->last_error;
           return;
        }
        if (is_array($thanks_not_display_for_cat_list)) {
          foreach ($thanks_not_display_for_cat_list as $categoryToSkip) {
            foreach ($categories as $category) {
              if ($category->term_id==$categoryToSkip) {
                return $content;
              }
            }
          }
        } else {
          foreach ($categories as $category) {
            if ($category==$thanks_not_display_for_cat_list) {
              return $content;
            }
          }
        }
      }
    }
    $button = thanks_buildButtonCode();
    
    global $page, $numpages, $multipage;
/*    
    if ( $multipage ) {
      $last_page = false;
      if ($page == $numpages) {
        $last_page = true;
      }
    } else {
	    $last_page = true;
    }
*/
    $html = '';
    if ($thanks_position=='shortcode') {
      $html .= str_replace('[thankyou]', $button, $content);
    } else if ($thanks_position=='beforeandafter') {
      if (!$multipage) {
        $html .= $button.$content.$button;
      } else if ($page==1) {
        $html .= $button.$content;
      } else if ($page==$numpages) {
        $html .= $content.$button;
      } else {
        $html .= $content;
      }
    } else if ($thanks_position=='before') {
      if (!$multipage || $page==1) {
        $html .= $button . $content;
      } else {
        $html .= $content;
      }
    } else if ($thanks_position=='after') {
      if (!$multipage || $page==$numpages) {
          $html .= $content.$button;
      } else {
        $html .= $content;
      }
    } else {
      $html .= $content;
    }
  }
  
  return $html;
  
}
// end of thanks_button_insert()


// Manual output
function thanks_button() {
  if (get_option('thanks_position')=='manual') {
    return thanks_buildButtonCode();
  } else {
    return false;
  }
}
// end of thanks_button()


// Install plugin
function thanks_install() {
	global $wpdb, $thanksCountersTable, $thanksPostReadersTable;

  $thanks_db_version = get_option('thanks_db_version');
  $query = "SHOW TABLES LIKE '$thanksPostReadersTable'";
  $table = $wpdb->get_var($query);
	if ($table!=$thanksPostReadersTable) {
    $query = "CREATE TABLE `$thanksPostReadersTable` (
                     `id` bigint(20) NOT NULL auto_increment,
                     `post_id` bigint(20) default NULL,
                     `ip_address` char(15) default NULL,
                     `updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
                     PRIMARY KEY  (`id`),
                     KEY `post_id` (`post_id`),
                     KEY `ip_address` (`ip_address`)
                   ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8";
		$wpdb->query($query);
	}

  $query = "SHOW TABLES LIKE '$thanksCountersTable'";
  $table = $wpdb->get_var($query);
	if ($table!=$thanksCountersTable) {
    $query = "CREATE TABLE `$thanksCountersTable` (
                      `id` bigint(20) NOT NULL auto_increment,
                      `post_id` bigint(20) NOT NULL,
                      `quant` bigint(20) default NULL,
                      `updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
                      PRIMARY KEY  (`id`),
                      UNIQUE KEY `post_id` (`post_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
		$wpdb->query($query);
	} else if ($thanks_db_version=='1.0') {
    $query = "alter table `$thanksCountersTable` add column `updated` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL after `quant`";
    $wpdb->query($query);
    $query = "update `$thanksCountersTable`
                set `$thanksCountersTable`.updated = (select MAX(readers.updated)
                                      from `$thanksPostReadersTable` readers
                                      where readers.post_id = `$thanksCountersTable`.post_id)";
    $wpdb->query($query);
  }
	add_option('thanks_db_version', '1.2');
  add_option('thanks_display_page', 1);
  add_option('thanks_display_home', 1);
  add_option('thanks_not_display_for_categories', 0);
  add_option('thanks_not_display_for_cat_list', array());
  add_option('thanks_position', 'after');
  add_option('thanks_style', 'float: left; margin-right: 10px;');
  add_option('thanks_caption_style', 'font-family: Verdana, Arial, Sans-Serif; font-size: 14px; font-weight: normal;');
  add_option('thanks_caption_color', '#ffffff');
  add_option('thanks_size', 'large');
  add_option('thanks_color', 'blue');
  add_option('thanks_custom', 0);
  add_option('thanks_custom_url', '');
  add_option('thanks_custom_width', 100);
  add_option('thanks_custom_height', 26);
  add_option('thanks_check_ip_address', 1);
  add_option('thanks_time_limit', 1);
  add_option('thanks_time_limit_seconds', 60);
	add_option('thanks_show_last_date', 1);
	add_option('thanks_caption', __('Thank You','thankyou'));
  
}
// end of thanks_install()


function thanks_init(){
  if(function_exists('register_setting')) {
    register_setting('thankyoubutton-options', 'thanks_caption');
    register_setting('thankyoubutton-options', 'thanks_display_page');
    register_setting('thankyoubutton-options', 'thanks_display_home');
    register_setting('thankyoubutton-options', 'thanks_not_display_for_categories');
    register_setting('thankyoubutton-options', 'thanks_not_display_for_cat_list');
    register_setting('thankyoubutton-options', 'thanks_position');
    register_setting('thankyoubutton-options', 'thanks_style');
    register_setting('thankyoubutton-options', 'thanks_caption_style');
    register_setting('thankyoubutton-options', 'thanks_caption_color');
    register_setting('thankyoubutton-options', 'thanks_size');
    register_setting('thankyoubutton-options', 'thanks_color');
    register_setting('thankyoubutton-options', 'thanks_custom');
    register_setting('thankyoubutton-options', 'thanks_custom_url');
    register_setting('thankyoubutton-options', 'thanks_custom_width');
    register_setting('thankyoubutton-options', 'thanks_custom_height');
    register_setting('thankyoubutton-options', 'thanks_check_ip_address');
    register_setting('thankyoubutton-options', 'thanks_time_limit');
    register_setting('thankyoubutton-options', 'thanks_time_limit_seconds');
  }
}
// end of thanks_init()


function thanks_cssAction() {

  if (is_admin() ||
      (get_option('thanks_display_page')==null && is_page()) ||
      (get_option('thanks_display_home') == null && is_home())) {
    return;
  }

  echo '<link rel="stylesheet" href="'.THANKS_PLUGIN_URL.'/css/thankyou.css" type="text/css" media="screen" />'."\n";

}
// end of thanks_cssAction()


function thanks_scriptsAction() {

  if (is_admin() ||
      (get_option('thanks_display_page')==null && is_page()) ||
      (get_option('thanks_display_home') == null && is_home())) {
    return;
  }

  wp_enqueue_script('thanks_script', THANKS_PLUGIN_URL.'/thankyou.js', array('jquery','jquery-form'));
  wp_localize_script('thanks_script', 'ThanksSettings', array('plugin_url' => THANKS_PLUGIN_URL, 'ajax_nonce' => wp_create_nonce('thanks-button')));
  
}
// end of thanks_scriptsAction()


function thanks_dashboard_content() {
    global $wpdb, $thanksCountersTable;
    // Just in case...
    if(is_admin()) {
        $ww_query = "select posts.ID, posts.post_title, counters.quant, counters.updated
                        from $wpdb->posts posts
                          left join $thanksCountersTable counters on counters.post_id=posts.ID
                        where counters.quant>0 and posts.post_type='post'
                        order by updated desc limit 0, 5";
        $ww_records = $wpdb->get_results($ww_query);
        if ($wpdb->last_error) {
           echo 'error: '.$wpdb->last_error;
           return;
        }
        $ww_foundPosts = count($ww_records);
        if ($ww_foundPosts > 0) {
?>
<div class="table">
  <table width="100%" cellpadding="0" cellspacing="0" class="widefat fixed">
        <tbody>
<?php
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
?>
              <tr <?php echo $class;?> >
                <td height="26" style="padding-left:8px;"><a class="rsswidget" href="<?php echo get_permalink($ww_record->ID);?>" title="<?php echo $updated;?>"><?php echo $ww_record->post_title; ?></a></td>
                <td style="text-align:right;padding-right:8px;" width="5%"><?php echo ($ww_record->quant) ? $ww_record->quant : 0; ?></td>
              </tr>
<?php
}

?>
            </tbody>
    </table>
</div>
<?php
        } else {
            _e('No thanks yet', 'thankyou');
        }
    }
}

function add_thanks_dashboard_widget() {
    wp_add_dashboard_widget('dashboard_thanks', __('Latest Thanks', 'thankyou'), 'thanks_dashboard_content');
}


function thanks_adminCssAction() {

  echo '<link rel="stylesheet" href="'.THANKS_PLUGIN_URL.'/css/thankyou_admin.css" type="text/css" media="screen" />'."\n";

}
// end of thanks_cssAction()


function thanks_settings_scriptsAction() {

  wp_enqueue_script('thanks_script', THANKS_PLUGIN_URL.'/iColorPicker.js.php?plugin_url='.THANKS_PLUGIN_URL, array('jquery', 'jquery-ui-tabs'));

}
// end of thanks_settings_scriptsAction()


if (is_admin()) {
  // activation action
  register_activation_hook(__FILE__, "thanks_install");

  add_action('admin_head', 'thanks_adminCssAction');
  add_action('admin_print_scripts', 'thanks_settings_scriptsAction');
  // add 'Thank You' item into WP Admin Settings menu to get access to the Thank You Button options page
  add_action('admin_menu', 'thanks_settings_menu');
  add_action('admin_init', 'thanks_init');
  add_action('wp_dashboard_setup','add_thanks_dashboard_widget');
}

add_action('wp_head', 'thanks_cssAction');
add_action('wp_print_scripts', 'thanks_scriptsAction');
add_filter('the_content', 'thanks_button_insert');




?>
<?php
/*
Plugin Name: Thank You Counter Button
Plugin URI: http://www.shinephp.com/2009/10/thank-you-wp-plugin
Description: Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post.
Version: 1.0
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

$exit_msg = 'Thank You Counter Button requires WordPress 2.7.1 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if (version_compare($wp_version,"2.3","<"))
{
	exit ($exit_msg);
}



require_once('thankyou_lib.php');


function thanks_optionsPage() {
  
  global $thanksCountersTable, $thanksPostReadersTable;

  $thanks_caption = get_option('thanks_caption');
  $thanks_display_page = get_option('thanks_display_page');
  $thanks_display_home = get_option('thanks_display_home');
  $thanks_position = get_option('thanks_position');
  $thanks_style = get_option('thanks_style');
  $thanks_size = get_option('thanks_size');
  $thanks_color = get_option('thanks_color');
  $thanks_check_ip_address = get_option('thanks_check_ip_address');

?>
<div class="wrap">
  <div class="icon32" id="icon-options-general"><br/></div>
  <h2><?php _e('Settings for Thank You Counter Button Plugin', 'thanks'); ?></h2>
  <p><?php _e('This plugin installs the Thank You Counter Button for each of your blog post.
                It can have custom style in your blog posts.','thanks'); ?>
  </p>
  <form method="post" action="options.php">
<?php
      if (function_exists('settings_fields')) {
        settings_fields('thankyoubutton-options');
      } else {
        wp_nonce_field('thankyoubutton-options');
?>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="thanks_caption,thanks_display_page,thanks_display_home,thanks_position,thanks_style,thanks_size,thanks_color,thanks_check_ip_address" />
<?php
        }
?>
        <table class="form-table">
          <tr>
            <th scope="row">
	             <label for="thanks_caption"><?php _e('Button Caption','thanks'); ?></label>
            </th>
            <td>
               <input type="text" value="<?php echo $thanks_caption; ?>" name="thanks_caption" id="thanks_caption" />
            </td>
          </tr>
          <tr>
            <th scope="row">
	             <?php _e('Display','thanks'); ?>
            </th>
            <td>
                <input type="checkbox" value="1" <?php echo ($thanks_display_page=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_display_page" id="thanks_display_page" />
                <label for="thanks_display_page"><?php _e('Display button at Pages','thanks'); ?></label><br/>
                <input type="checkbox" value="1" <?php echo ($thanks_display_home=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_display_home" id="thanks_display_home" />
                <label for="thanks_display_home"><?php _e('Display button at Home page','thanks'); ?></label>
            </td>
          </tr>
          <tr>
          <th scope="row">
            <?php _e('Position', 'thanks'); ?>
          </th>
          <td>
              <select name="thanks_position">
                <option <?php echo ($thanks_position=='before') ? 'selected="selected"' : ''; ?> value="before">
                    <?php _e('Before', 'thanks'); ?></option>
                <option <?php echo ($thanks_position=='after') ? 'selected="selected"' : ''; ?> value="after">
                    <?php _e('After', 'thanks'); ?></option>
                <option <?php echo ($thanks_position=='beforeandafter') ? 'selected="selected"' : ''; ?> value="beforeandafter">
                    <?php _e('Before and After','thanks'); ?></option>
                <option <?php echo ($thanks_position=='shortcode') ? 'selected="selected"' : ''; ?> value="shortcode">
                  <?php _e('Shortcode [thankyou]','thanks'); ?></option>
                <option <?php ($thanks_position=='manual') ? 'selected="selected"' : ''; ?> value="manual">
                  <?php _e('Manual','thanks'); ?></option>
              </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="thanks_style"><?php _e('Styling','thanks'); ?></label></th>
          <td>
            <input type="text" value="<?php echo htmlspecialchars($thanks_style); ?>" name="thanks_style" id="thanks_style" size="30"/>
            <span class="setting-description"><?php _e('Add style to the Thank You button\'s div, e.g.,','thanks');?> <code>float: left; margin-right: 10px;</code></span>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <?php _e('Size','thanks'); ?>
          </th>
          <td>
              <input type="radio" value="large" <?php echo ($thanks_size=='large') ? 'checked="checked"' : ''; ?>
                     name="thanks_size" id="thanks_size_large" />
              <label for="thanks_size_large"><?php _e('Normal size','thanks'); ?></label><br>
              <input type="radio" value="compact" <?php echo ($thanks_size=='compact') ? 'checked="checked"' : ''; ?>
                     name="thanks_size" id="thanks_size_compact" />
              <label for="thanks_size_compact"><?php _e('Compact','thanks'); ?></label>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <?php _e('Color', 'thanks'); ?>
          </th>
          <td>
            <select name="thanks_color">
              <option <?php echo ($thanks_color=='blue') ? 'selected="selected"' : ''; ?> value="blue" style="background: blue; color: white;">
                <?php _e('Blue', 'thanks'); ?></option>
              <option <?php echo ($thanks_color=='red') ? 'selected="selected"' : ''; ?> value="red" style="background: red;">
                <?php _e('Red', 'thanks'); ?></option>
              <option <?php echo ($thanks_color=='green') ? 'selected="selected"' : ''; ?> value="green" style="background: green;">
                <?php _e('Green','thanks'); ?></option>
              <option <?php echo ($thanks_color=='grey') ? 'selected="selected"' : ''; ?> value="grey" style="background: grey; color: #white;">
                <?php _e('Grey','thanks'); ?></option>
              <option <?php ($thanks_color=='black') ? 'selected="selected"' : ''; ?> value="black" style="background: black; color: white;">
                <?php _e('Black','thanks'); ?></option>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <?php _e('Check IP-address','thanks'); ?>
          </th>
          <td>
            <input type="checkbox" value="1" <?php echo ($thanks_check_ip_address=='1') ? 'checked="checked"' : ''; ?>
                   name="thanks_check_ip_address" id="thanks_check_ip_address" />
            <label for="thanks_check_ip_address"><?php _e('Only one Thanks for post for one IP-address limit','thanks'); ?></label><br/>
          </td>
        </tr>
        </table>
        <p class="submit">
          <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
    </div>
<?php

}
// end of thanks_optionPage()


function thanks_settings_menu() {
	if ( function_exists('add_options_page') ) {
		add_options_page(__('Thank You','thanks'), __('Thank You','thanks'), 9, basename(__FILE__), 'thanks_optionsPage');
	}
}
// end of thanks_settings_menu()


function thanks_buildButtonCode() {

  global $post;
    
  $thanks_size = get_option('thanks_size');
  $thanks_color = get_option('thanks_color');
  $imageName = 'thanks_'.$thanks_size.'_'.$thanks_color.'.png';
  $buttonSizeClass = 'thanks_'.$thanks_size;
  $buttonColorClass = 'thanks_'.$thanks_color;

  $button = '<div class="thanks_button_div" style="'.get_option('thanks_style').'">
                <input type="button" onclick="thankYouButtonClick('.$post->ID.')" value="'.getThanksCaption($post->ID).'"
                  class="thanks_button '.$buttonSizeClass.' '.$buttonColorClass.'"
                  style="background-image:url('.THANKS_PLUGIN_URL.'/images/'.$imageName.');"
                  id="thanksButton_'.$post->ID.'"/>
                <div id="ajax_loader_'.$post->ID.'" style="display:inline;visibility: hidden;"><img alt="ajax loader" src="'.THANKS_PLUGIN_URL.'/images/ajax-loader.gif" /></div>
             </div>';

  return $button;

}
// end of thanks_buildButtonCode()


function thanks_button_insert($content) {

  global $post;

  $thanks_position = get_option('thanks_position');
  // add the manual option, code added by kovshenin
  if ( ($thanks_position=='manual') ||
      (get_option('thanks_display_page')==null && is_page()) ||
      (get_option('thanks_display_home') == null && is_home()) ) {
    $html = $content;
  } else {
    $button = thanks_buildButtonCode();
    $html = '';
    
    if ($thanks_position=='shortcode') {
      $html .= str_replace('[thanksyou]', $button, $content);
    } else if ($thanks_position=='beforeandafter') {
      $html .= $button.$content.$button;
    } else if ($thanks_position=='before') {
      $html .= $button . $content;
    } else if ($thanks_position=='after') {
      $html .= $content.$button;
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

  $query = "SHOW TABLES LIKE '$thanksCountersTable'";
  $table = $wpdb->get_var($query);
	if ($table!=$thanksCountersTable) {
    $query = "CREATE TABLE `$thanksCountersTable` (
                      `id` bigint(20) NOT NULL auto_increment,
                      `post_id` bigint(20) NOT NULL,
                      `quant` bigint(20) default NULL,
                      PRIMARY KEY  (`id`),
                      UNIQUE KEY `post_id` (`post_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
		$wpdb->query($query);
	}
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
	add_option('thanks_db_version', '1.0');
  add_option('thanks_display_page', 1);
  add_option('thanks_display_home', 1);
  add_option('thanks_position', 'after');
  add_option('thanks_style', 'float: left; margin-right: 10px;');
  add_option('thanks_size', 'large');
  add_option('thanks_color', 'blue');
	add_option('thanks_check_ip_address', 1);
	add_option('thanks_show_last_date', 1);
	add_option('thanks_caption', __('Thank You','thanks'));
  
}
// end of thanks_install()


function thanks_init(){
  if(function_exists('register_setting')) {
    register_setting('thankyoubutton-options', 'thanks_display_page');
    register_setting('thankyoubutton-options', 'thanks_display_home');
    register_setting('thankyoubutton-options', 'thanks_position');
    register_setting('thankyoubutton-options', 'thanks_style');
    register_setting('thankyoubutton-options', 'thanks_size');
    register_setting('thankyoubutton-options', 'thanks_color');
    register_setting('thankyoubutton-options', 'thanks_check_ip_address');
    register_setting('thankyoubutton-options', 'thanks_caption');

  }
}
// end of thanks_init()


function thanks_cssAction() {

  if (is_admin() ||
      (get_option('thanks_display_page')==null && is_page()) ||
      (get_option('thanks_display_home') == null && is_home())) {
    return;
  }

  echo '<link rel="stylesheet" href="'.THANKS_PLUGIN_URL.'/thankyou.css" type="text/css" media="screen" />'."\n";

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


if (is_admin()) {

  // activation action
  register_activation_hook(__FILE__, "thanks_install");

  // add 'Thank You' item into WP Admin Settings menu to get access to the Thank You Button options page
  add_action('admin_menu', 'thanks_settings_menu');

  add_action('admin_init', 'thanks_init');

}

add_action('wp_head', 'thanks_cssAction');
add_action('wp_print_scripts', 'thanks_scriptsAction');
add_filter('the_content', 'thanks_button_insert');


?>

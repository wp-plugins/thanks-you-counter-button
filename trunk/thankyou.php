<?php
/*
Plugin Name: Thank You Counter Button
Plugin URI: http://www.shinephp.com/2009/10/05/thank-you-counter-button-wordpress-plugin/
Description: Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post.
Version: 1.0.02
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

  $thanks_caption = get_option('thanks_caption');
  $thanks_display_page = get_option('thanks_display_page');
  $thanks_display_home = get_option('thanks_display_home');
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

?>
<div class="wrap">
  <div class="icon32" id="icon-options-general"><br/></div>
  <h2><?php _e('Settings for Thank You Counter Button Plugin', 'thankyou'); ?></h2>
  <p><?php _e('This plugin installs the Thank You Counter Button for each of your blog post.
                It can have custom style in your blog posts.','thankyou'); ?>
  </p>
  <form method="post" action="options.php">
<?php
    settings_fields('thankyoubutton-options');
?>
        <table class="form-table" cellpadding="0" cellspacing="0">
          <tr>
            <th scope="row">
	             <label for="thanks_caption"><?php _e('Button Caption','thankyou'); ?></label>
            </th>
            <td>
               <input type="text" value="<?php echo $thanks_caption; ?>" name="thanks_caption" id="thanks_caption" />
            </td>
          </tr>
          <tr>
            <th scope="row">
	             <?php _e('Display','thankyou'); ?>
            </th>
            <td>
                <input type="checkbox" value="1" <?php echo ($thanks_display_page=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_display_page" id="thanks_display_page" />
                <label for="thanks_display_page"><?php _e('Display button at Pages','thankyou'); ?></label>&nbsp;
                <input type="checkbox" value="1" <?php echo ($thanks_display_home=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_display_home" id="thanks_display_home" />
                <label for="thanks_display_home"><?php _e('Display button at Home page','thankyou'); ?></label>
            </td>
          </tr>
          <tr>
          <th scope="row">
            <?php _e('Position in the Post text', 'thankyou'); ?>
          </th>
          <td>
              <select name="thanks_position">
                <option <?php echo ($thanks_position=='before') ? 'selected="selected"' : ''; ?> value="before">
                    <?php _e('Before', 'thankyou'); ?></option>
                <option <?php echo ($thanks_position=='after') ? 'selected="selected"' : ''; ?> value="after">
                    <?php _e('After', 'thankyou'); ?></option>
                <option <?php echo ($thanks_position=='beforeandafter') ? 'selected="selected"' : ''; ?> value="beforeandafter">
                    <?php _e('Before and After','thankyou'); ?></option>
                <option <?php echo ($thanks_position=='shortcode') ? 'selected="selected"' : ''; ?> value="shortcode">
                  <?php _e('Shortcode [thankyou]','thankyou'); ?></option>
                <option <?php ($thanks_position=='manual') ? 'selected="selected"' : ''; ?> value="manual">
                  <?php _e('Manual','thankyou'); ?></option>
              </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="thanks_style"><?php _e('Button Styling','thankyou'); ?></label></th>
          <td>            
            <span class="setting-description"><?php _e('Add style to the div:','thankyou');?></span>
            <input type="text" value="<?php echo htmlspecialchars($thanks_style); ?>" name="thanks_style" id="thanks_style" size="40"/>
            <span class="setting-description"><?php _e(', e.g.,','thankyou');?> <code>float: left; margin-right: 10px;</code></span>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <span class="setting-description"><?php _e('to the Caption font:','thankyou');?></span>
            <input type="text" value="<?php echo htmlspecialchars($thanks_caption_style); ?>" name="thanks_caption_style" id="thanks_caption_style" size="40"/>
            <span class="setting-description"><?php _e(', e.g.,','thankyou');?><code>font-family: Sans-Serif; font-size: 14px; font-weight: normal;</code></span>
            <input name="thanks_caption_color" id="thanks_caption_color" class="iColorPicker" value="<?php echo $thanks_caption_color; ?>" type="text" size="10">
          </td>
        </tr>
        <tr>
          <th scope="row">
            <?php _e('Size','thankyou'); ?>
          </th>
          <td>
              <input type="radio" name="thanks_size" id="thanks_size_large"<?php echo ($thanks_size=='large') ? 'checked="checked"' : ''; ?>
                     value="large"/>
              <label for="thanks_size_large"><?php _e('Normal','thankyou'); ?></label>&nbsp;
              <input type="radio" name="thanks_size" id="thanks_size_compact" <?php echo ($thanks_size=='compact') ? 'checked="checked"' : ''; ?>
                     value="compact" />
              <label for="thanks_size_compact"><?php _e('Compact','thankyou'); ?></label>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <?php _e('Form and Color', 'thankyou'); ?>
          </th>
          <td>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='brown') ? 'checked="checked"' : ''; ?> value="brown" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_brown.png" alt="brown" title="brown"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='brown1') ? 'checked="checked"' : ''; ?> value="brown1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_brown1.png" alt="brown1" title="brown1"/>
            </div>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='blue') ? 'checked="checked"' : ''; ?> value="blue" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_blue.png" alt="blue" title="blue"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='blue1') ? 'checked="checked"' : ''; ?> value="blue1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_blue1.png" alt="blue1" title="blue1"/>
            </div>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='red') ? 'checked="checked"' : ''; ?> value="red" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_red.png" alt="red" title="red"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='red1') ? 'checked="checked"' : ''; ?> value="red1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_red1.png" alt="red1" title="red1"/><br/>
            </div>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='green') ? 'checked="checked"' : ''; ?> value="green" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_green.png" alt="green" title="green"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='green1') ? 'checked="checked"' : ''; ?> value="green1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_green1.png" alt="green1" title="green1"/><br/>
            </div>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='grey') ? 'checked="checked"' : ''; ?> value="grey" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_grey.png" alt="grey" title="grey"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='grey1') ? 'checked="checked"' : ''; ?> value="grey1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_grey1.png" alt="grey1" title="grey1"/><br/>
            </div>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='black') ? 'checked="checked"' : ''; ?> value="black" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_black.png" alt="black" title="black"/>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color=='black1') ? 'checked="checked"' : ''; ?> value="black1" />
              <img src="<?php echo THANKS_PLUGIN_URL; ?>/images/thanks_compact_black1.png" alt="black1" title="black1"/><br/>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="thanks_custom" value="1" <?php echo ($thanks_custom=='1') ? 'checked="checked"' : ''; ?>/> <?php _e('Custom button image URL', 'thankyou'); ?>
          </td>
          <td>
            <input type="text" name="thanks_custom_url" value="<?php echo $thanks_custom_URL; ?>"  size="50" />
            <?php _e(', e.g.,','thankyou'); ?> <code>http://yourblog.com/wp-content/uploads/2009/10/your-button.png</code><br/>
            <?php _e('Width, px', 'thankyou'); ?> <input type="text" name="thanks_custom_width" value="<?php echo $thanks_custom_width; ?>" size="10" />
            <?php _e('Height, px', 'thankyou'); ?> <input type="text" name="thanks_custom_height" value="<?php echo $thanks_custom_height; ?>" size="10"/>
          </td>
        </tr>       
        <tr>
          <th scope="row">
              <?php _e('Check IP-address','thankyou'); ?>
          </th>
          <td>
            <input type="checkbox" value="1" <?php echo ($thanks_check_ip_address=='1') ? 'checked="checked"' : ''; ?>
                   name="thanks_check_ip_address" id="thanks_check_ip_address" />
            <label for="thanks_check_ip_address"><?php _e('Only one Thanks for post for one IP-address limit','thankyou'); ?></label><br/>
          </td>
        </tr>
        </table>
        <p class="submit">
          <input type="submit" name="Submit" value="<?php _e('Save Changes', 'thankyou') ?>" />
        </p>
    </form>
    </div>
<?php

}
// end of thanks_optionPage()


function thanks_settings_menu() {
	if ( function_exists('add_options_page') ) {
		add_options_page(__('Thank You','thankyou'), __('Thank You','thankyou'), 9, basename(__FILE__), 'thanks_optionsPage');
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

  $button = '<div class="thanks_button_div" style="'.get_option('thanks_style').'">
                <input type="button" onclick="thankYouButtonClick('.$post->ID.')" value="'.getThanksCaption($post->ID).'"
                  class="thanks_button '.$buttonSizeClass.' '.$buttonColorClass.'"
                  style="background-image:url('.$imageURL.');'.$thanks_custom_width.' '.$thanks_custom_height.' '.$thanks_caption_style.' '.$thanks_caption_color.'"
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
      $html .= str_replace('[thankyou]', $button, $content);
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
  add_option('thanks_caption_style', 'font-family: Verdana, Arial, Sans-Serif; font-size: 14px; font-weight: normal;');
  add_option('thanks_caption_color', '#ffffff');
  add_option('thanks_size', 'large');
  add_option('thanks_color', 'blue');
  add_option('thanks_custom', 0);
  add_option('thanks_custom_url', '');
  add_option('thanks_custom_width', 100);
  add_option('thanks_custom_height', 26);
  add_option('thanks_check_ip_address', 1);
	add_option('thanks_show_last_date', 1);
	add_option('thanks_caption', __('Thank You','thankyou'));
  
}
// end of thanks_install()


function thanks_init(){
  if(function_exists('register_setting')) {
    register_setting('thankyoubutton-options', 'thanks_caption');
    register_setting('thankyoubutton-options', 'thanks_display_page');
    register_setting('thankyoubutton-options', 'thanks_display_home');
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

  function thanks_settings_scriptsAction() {

    wp_enqueue_script('thanks_script', THANKS_PLUGIN_URL.'/iColorPicker.js.php?plugin_url='.THANKS_PLUGIN_URL, array('jquery'));

  }
  // end of thanks_settings_scriptsAction()

  // activation action
  register_activation_hook(__FILE__, "thanks_install");

  add_action('admin_print_scripts', 'thanks_settings_scriptsAction');
  // add 'Thank You' item into WP Admin Settings menu to get access to the Thank You Button options page
  add_action('admin_menu', 'thanks_settings_menu');
  add_action('admin_init', 'thanks_init');

}

add_action('wp_head', 'thanks_cssAction');
add_action('wp_print_scripts', 'thanks_scriptsAction');
add_filter('the_content', 'thanks_button_insert');


?>

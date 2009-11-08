<?php
/* 
 * Settings form of Thank You Counter Button WordPress Plugin
 * 
 */
?>
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
                <label for="thanks_display_home"><?php _e('Display button at Home page, Categories/Tags archive pages','thankyou'); ?></label><br/>
                <input type="checkbox" value="1" <?php echo ($thanks_not_display_for_categories=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_not_display_for_categories" id="thanks_not_display_for_categories" onclick="thanks_hideShowDiv(this)"/>
                <label for="thanks_not_display_for_categories">
<?php _e('Do not show button for selected categories','thankyou');
  $categories = get_terms('category', array('hierarchical' => true));

?>
                </label>
<script language="javascript" type="text/javascript">
  function thanks_hideShowDiv(checkbox) {
    var el = document.getElementById('categorydiv')
    if (checkbox.checked) {
      el.style.display = 'block';
    } else {
      el.style.display = 'none';
    }
  }

  function thanks_SettingsCancel() {
    document.location = <?php WP_SITE_URL; ?>'/wp-admin/options-general.php?page=thankyou.php';
  }
</script>
                <div id="categorydiv" class="postbox" style="width:350px;margin-bottom: 0px;display:<?php echo ($thanks_not_display_for_categories) ? 'block':'none';?>">
                  <div id="categories-all" class="tabs-panel">
                  <ul>
<?php
  
  foreach ($categories as $i=>$category) {
    if ($category->parent) {
      continue;
    }
    $checked = '';
    if (is_array($thanks_not_display_for_cat_list) and count($thanks_not_display_for_cat_list)) {
      foreach($thanks_not_display_for_cat_list as $catId) {
        if ($catId==$category->term_id) {
          $checked = 'checked="checked"';
          break;
        }
      }
    }
?>
   <li><input type="checkbox" name="thanks_not_display_for_cat_list[]" value="<?php echo $category->term_id;?>" <?php echo $checked; ?> />
<?php echo $category->name; ?>
   </li>
<?php
    $children = get_terms('category', array('hierarchical' => false, 'child_of' => $category->term_id));
    foreach ($children as $subcategory) {
      $checked = '';
      if (is_array($thanks_not_display_for_cat_list) and count($thanks_not_display_for_cat_list)) {
        foreach($thanks_not_display_for_cat_list as $catId) {
          if ($catId==$subcategory->term_id) {
            $checked = 'checked="checked"';
            break;
          }
        }
      }
?>
      <li>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="thanks_not_display_for_cat_list[]" value="<?php echo $subcategory->term_id;?>" <?php echo $checked; ?> />
        <?php echo $subcategory->name; ?>
      </li>
<?php
    }
  }

?>
                  </ul>
                  </div>
                </div>                
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
            <?php _e('Time limit:', 'thankyou'); ?> <input type="radio" value="1" name="thanks_time_limit[]" id="thanks_time_limit1" <?php echo ($thanks_time_limit[0]=='1') ? 'checked="checked"' : ''; ?> />
            <label for="thanks_time_limit1"><?php _e('Forever','thankyou'); ?></label>
            <input type="radio" value="2" name="thanks_time_limit[]" id="thanks_time_limit2" <?php echo ($thanks_time_limit[0]=='2') ? 'checked="checked"' : ''; ?> />
            <label for="thanks_time_limit2"><?php _e('Only for this period','thankyou'); ?></label>            
            <input type="text" name="thanks_time_limit_seconds" id="thanks_time_limit_seconds" value="<?php echo $thanks_time_limit_seconds; ?>" size="10" />
            <?php _e('seconds', 'thankyou'); ?>
          </td>
        </tr>
        </table>
        <p class="submit">
          <input type="submit" name="Submit" value="<?php _e('Save Changes', 'thankyou') ?>" />
          <input type="button" name="Cancel" value="<?php _e('Cancel', 'thankyou') ?>" title="Cancel not saved changes" onclick="thanks_SettingsCancel();"/>
        </p>
    </form>



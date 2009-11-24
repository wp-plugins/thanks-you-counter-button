<?php
/* 
 * Settings form of Thank You Counter Button WordPress Plugin
 * 
 */

// Just to include in the translation files - for the future use.
__('Donate','thankyou');

$buttonColors = array('brown', 'blue', 'red', 'green', 'grey', 'black');

function thanks_displayBoxStart($title) {
?>
			<div class="postbox" style="float: left;">
				<h3 style="cursor:default;"><span><?php echo $title ?></span></h3>
				<div class="inside">
<?php
}
// 	end of thanks_displayBoxStart()

function thanks_displayBoxEnd() {
?>
				</div>
			</div>
<?php
}
// end of thanks_displayBoxEnd()

$shinephpFavIcon = THANKS_PLUGIN_URL.'/images/vladimir.png';
?>

  <form method="post" action="options.php">
<?php
    settings_fields('thankyoubutton-options');
?>
				<div id="poststuff" class="metabox-holder has-right-sidebar">
					<div class="inner-sidebar" style="margin-top:20px;">
						<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
									<?php thanks_displayBoxStart(__('About this Plugin:', 'thankyou')); ?>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo $shinephpFavIcon; ?>);" target="_blank" href="http://www.shinephp.com/"><?php _e("Author's website", 'thankyou'); ?></a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/tycb.png'; ?>" target="_blank" href="http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/"><?php _e('Plugin webpage', 'thankyou'); ?></a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/tycb_help.png'; ?>" target="_blank" href="http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/2/#filterhooks"><?php _e('Additional documentation', 'thankyou'); ?></a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/tycb_changelog.png'; ?>);" target="_blank" href="http://www.shinephp.my/thank-you-counter-button-wordpress-plugin/2/#changelog"><?php _e('Changelog', 'thankyou'); ?></a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/tycb_faq.png'; ?>)" target="_blank" href="http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/2/#faq"><?php _e('FAQ', 'thankyou'); ?></a>
									<?php thanks_displayBoxEnd(); ?>									
									<?php thanks_displayBoxStart(__('Greetings:','thankyou')); ?>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo $shinephpFavIcon; ?>);" target="_blank" title="<?php _e("It's me, the author", 'thankyou'); ?>" href="http://www.shinephp.com/">Vladimir</a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/omi.png'; ?>);" target="_blank" title="<?php _e('for the help with Spanish translation, ideas and new versions testing', 'thankyou'); ?>" href="http://equipajedemano.info/">Omi</a>
											<a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/simon.png'; ?>);" target="_blank" title="<?php _e('for the excelent JQuery color picker', 'thankyou'); ?>" href="http://www.supersite.me/website-building/jquery-free-color-picker/">Simon</a>
                      <a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/whiler.png'; ?>);" target="_blank" title="<?php _e('for the help with French translation, ideas, source code contributions and new versions testing', 'thankyou'); ?>" href="http://blogs.wittwer.fr/whiler/">Whiler</a>
                      <a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/arne.png'; ?>);" target="_blank" title="<?php _e('for setting page layout idea and html markup examples', 'thankyou'); ?>" href="http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/">Arne</a>
                      <a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/dhtmlgoodies.png'; ?>);" target="_blank" title="<?php _e('for the form input slider code', 'thankyou'); ?>" href="http://www.dhtmlgoodies.com/">DHTMLGoodies</a>
                      <a class="thanks_rsb_link" style="background-image:url(<?php echo THANKS_PLUGIN_URL.'/images/eric.png'; ?>);" target="_blank" title="<?php _e('for the cute online button image generator', 'thankyou'); ?>" href="http://www.glassybuttons.com/glassy.php">Eric</a>
									<?php thanks_displayBoxEnd(); ?>
						</div>
					</div>
					<div class="has-sidebar" >
						<div id="post-body-content" class="has-sidebar-content">

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

  function switchDivDisplay(divName) {
    var divEl = document.getElementById(divName);
    if (divEl.style.display=='block') {
      divEl.style.display = 'none';
    } else {
      divEl.style.display = 'block';
    }
  }

  function refreshButtonsCaption(newCaption) {
    for (i=0; i<12; i++) {
      var el = document.getElementById('thanksButton_'+ i);
      el.value = newCaption +': '+ Math.ceil(Math.random()*100);
    }

    el = document.getElementById('thanksButton_custom');
    el.value = newCaption +': '+ Math.ceil(Math.random()*100);

    el = document.getElementById('thanksButton_stylePreview');
    el.value = newCaption +': '+ Math.ceil(Math.random()*100);
  }
  // end of refreshButtonsCaption();


  function refreshButtonsImage(size) {
    var colors = new Array();
<?php
    $i = 0;
    foreach ($buttonColors as $color) {
      echo 'colors['.$i++.'] = "'.$color.'";';
      echo 'colors['.$i++.'] = "'.$color.'1";';
    }
?>
    for (i=0; i<12; i++) {
      var el = document.getElementById('thanksButton_'+ i);      
      if (size=='large') {
        oldClassName = 'thanks_'+ 'compact';
      } else {
        oldClassName = 'thanks_'+ 'large';
      }
      el.className = el.className.replace(oldClassName,'thanks_'+ size);
      el.style.backgroundImage = 'url(<?php echo THANKS_PLUGIN_URL;?>/images/thanks_'+ size +'_'+ colors[i] +'.png)';
    }
    
  }
  // end of refreshButtonsImage();

  function refreshButtonCaptionColor(newColor) {
    for (i=0; i<12; i++) {
      var el = document.getElementById('thanksButton_'+ i);
      el.style.color = newColor;
    }
    el = document.getElementById('thanksButton_custom');
    el.style.color = newColor;

    el = document.getElementById('thanksButton_stylePreview');
    el.style.color = newColor;
  }
  // end of refreshButtonCaptionColor()


  function refreshButtonCaptionStyle(newStyle) {
    //font-family: Verdana, Arial, Sans-Serif; font-size: 14px; font-weight: normal;
    var newStyles = newStyle.split(';');
    var fontFamily =  ''; var fontWeight = ''; var fontSize = '';
    for (i=0; i<newStyles.length; i++) {
      var beg = newStyles[i].indexOf('font-family:');
      if (beg>=0) {
        fontFamily = newStyles[i].substr(beg + 12);
      }
      var beg = newStyles[i].indexOf('font-size:');
      if (beg>=0) {
        fontSize = newStyles[i].substr(beg + 10);
      }
      var beg = newStyles[i].indexOf('font-weight:');
      if (beg>=0) {
        fontWeight = newStyles[i].substr(beg + 12);
      }
    }
    for (i=0; i<12; i++) {
      var el = document.getElementById('thanksButton_'+ i);
      el.style.fontFamily = fontFamily;
      el.style.fontSize = fontSize;
      el.style.fontWeight = fontWeight;
    }
    el = document.getElementById('thanksButton_custom');
    el.style.fontFamily = fontFamily;
    el.style.fontSize = fontSize;
    el.style.fontWeight = fontWeight;

    el = document.getElementById('thanksButton_stylePreview');
    el.style.fontFamily = fontFamily;
    el.style.fontSize = fontSize;
    el.style.fontWeight = fontWeight;
  }
  // end of refreshButtonCaptionStyle()

  function thanksCustomChange(checkbox) {
    var el = document.getElementById('thanksCustomButtonDiv');
    if (checkbox.checked) {
      el.style.display = 'block';
    } else {
      el.style.display = 'none';
    }
  }
  // end of thanksCustomChange()

  function thanksCustomWidthChange(newValue) {
    var el = document.getElementById('thanksButton_custom');
    if (newValue.indexOf('px')<0) {
      newValue = newValue +'px';
    }
    el.style.width = newValue;
  }
  // end of thanksCustomWidthChange()

  function thanksCustomHeightChange(newValue) {
    var el = document.getElementById('thanksButton_custom');
    if (newValue.indexOf('px')<0) {
      newValue = newValue +'px';
    }
    el.style.height = newValue;
  }
  // end of thanksCustomWidthChange()

  function buttonDivStyleChange(newStyle) {
    var el = document.getElementById('thanks_button_preview');
    el.setAttribute("style", newStyle);
    el.style.cssText = newStyle;

  }
  // end of buttonDivStyleChange()

</script>

<?php
						thanks_displayBoxStart(__('Display', 'thankyou')); ?>
        <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">          
          <tr>
            <th scope="row">
	             <?php _e('Display','thankyou'); ?>
            </th>
            <td>
                <input type="checkbox" value="1" <?php echo ($thanks_display_page=='1') ? 'checked="checked"' : ''; ?>
                       name="thanks_display_page" id="thanks_display_page" />
                <label for="thanks_display_page"><?php _e('Display button at Pages','thankyou'); ?></label><br/>
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
            <span style="float: left; width: 80px;"><input type="checkbox" name="thanks_position_before" value="1" <?php echo thanks_optionChecked($thanks_position_before, 1); ?> /> <?php _e('Before', 'thankyou'); ?></span>
            <input type="checkbox" name="thanks_position_firstpageonly" value="1" <?php echo thanks_optionChecked($thanks_position_firstpageonly, 1); ?> /> <?php _e('At first page of multipaged posts only', 'thankyou'); ?><br/>
            <span style="float: left; width: 80px;"><input type="checkbox" name="thanks_position_after" value="1" <?php echo thanks_optionChecked($thanks_position_after, 1); ?> /> <?php _e('After', 'thankyou'); ?></span>
            <input type="checkbox" name="thanks_position_lastpageonly" value="1" <?php echo thanks_optionChecked($thanks_position_lastpageonly, 1); ?> /> <?php _e('At last page  of multipaged posts only', 'thankyou'); ?><br/>
            <input type="checkbox" name="thanks_position_shortcode" value="1" <?php echo thanks_optionChecked($thanks_position_shortcode, 1); ?> /> <?php _e('Shortcode [thankyou]','thankyou'); ?>
            <input type="checkbox" name="thanks_position_manual" value="1" <?php echo thanks_optionChecked($thanks_position_manual, 1); ?> /> <?php _e('Manual','thankyou'); ?>
          </td>
        </tr>
        <tr>
          <th scope="row">
	           <label for="thanks_caption"><?php _e('Button Caption','thankyou'); ?></label>
          </th>
          <td>
             <input type="text" value="<?php echo $thanks_caption; ?>" name="thanks_caption" id="thanks_caption" onkeyup="refreshButtonsCaption(this.value);" onchange="refreshButtonsCaption(this.value);"/>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="thanks_style"><?php _e('Button Styling','thankyou'); ?></label></th>
          <td>
            <span class="setting-description" style="float: left; width: 120px;"><?php _e('Add style to the div:','thankyou');?></span>
            <input type="text" value="<?php echo htmlspecialchars($thanks_style); ?>" name="thanks_style" id="thanks_style" size="40" onchange="buttonDivStyleChange(this.value);"/>
            <a href="javascript:void(0);" onclick="switchDivDisplay('buttonDivStyleHelp');"><img src="<?php echo THANKS_PLUGIN_URL.'/images/question_grey.png';?>" alt="question sign" title="float: left; margin-right: 10px;"/></a>
            <div id="buttonDivStyleHelp" style="display: none;"><span class="setting-description"><?php _e('e.g.,','thankyou');?> <code>float: left; margin-right: 10px;</code></span></div>
            <span class="setting-description" style="float: left; width: 120px;"><?php _e('to the Caption font:','thankyou');?></span>
            <input type="text" value="<?php echo htmlspecialchars($thanks_caption_style); ?>" name="thanks_caption_style" id="thanks_caption_style" size="40" onchange="refreshButtonCaptionStyle(this.value);"/>
            <a href="javascript:void(0);" onclick="switchDivDisplay('buttonFontStyleHelp');"><img src="<?php echo THANKS_PLUGIN_URL.'/images/question_grey.png';?>" alt="question sign" title="font-family: Sans-Serif; font-size: 14px; font-weight: normal;"/></a>
            <div id="buttonFontStyleHelp" style="display: none;"><span class="setting-description"><?php _e('e.g.,','thankyou');?><code>font-family: Sans-Serif; font-size: 14px; font-weight: normal;</code></span></div>
            <div><?php _e('font color: ','thankyou');?><input name="thanks_caption_color" id="thanks_caption_color" class="iColorPicker" value="<?php echo $thanks_caption_color; ?>" type="text" size="10" onchange="refreshButtonCaptionColor(this.value);"></div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <?php _e('Size','thankyou'); ?>
          </th>
          <td>
              <input type="radio" name="thanks_size" id="thanks_size_large"<?php echo ($thanks_size=='large') ? 'checked="checked"' : ''; ?>
                     value="large" onclick="refreshButtonsImage(this.value);"/>
              <label for="thanks_size_large"><?php _e('Normal','thankyou'); ?></label>&nbsp;
              <input type="radio" name="thanks_size" id="thanks_size_compact" <?php echo ($thanks_size=='compact') ? 'checked="checked"' : ''; ?>
                     value="compact" onclick="refreshButtonsImage(this.value);"/>
              <label for="thanks_size_compact"><?php _e('Compact','thankyou'); ?></label>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <?php _e('Form and Color', 'thankyou'); ?>
          </th>
          <td>
<?php
  $i = 0;
  foreach ($buttonColors as $color) {
?>
            <div class="form_color_row">
              <input type="radio" name="thanks_color" <?php echo ($thanks_color==$color) ? 'checked="checked"' : ''; ?> value="<?php echo $color; ?>" />
              <?php echo thanks_getButtonInputHTML('javascript:void(0);', $thanks_caption.': '.rand(0, 100), $buttonSizeClass, 'thanks_'.$color,
                                   THANKS_PLUGIN_URL.'/images/thanks_'.$thanks_size.'_'.$color.'.png', '', '', $thanks_caption_style,
                                   $thanks_caption_color, $i++, ''); ?>&nbsp;
              <input type="radio" name="thanks_color" <?php echo ($thanks_color==$color.'1') ? 'checked="checked"' : ''; ?> value="<?php echo $color.'1'; ?>" />
              <?php echo thanks_getButtonInputHTML('javascript:void(0);', $thanks_caption.': '.rand(0, 100), $buttonSizeClass, 'thanks_'.$color.'1',
                                   THANKS_PLUGIN_URL.'/images/thanks_'.$thanks_size.'_'.$color.'1.png', '', '', $thanks_caption_style,
                                   $thanks_caption_color, $i++, ''); ?>
            </div>
<?php
  }
?>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="thanks_custom" value="1" <?php echo ($thanks_custom=='1') ? 'checked="checked"' : ''; ?> onclick="thanksCustomChange(this);"/>
            <?php _e('Custom button image URL', 'thankyou'); ?>
          </td>
          <td>
            <input type="text" name="thanks_custom_url" value="<?php echo $thanks_custom_URL; ?>"  size="50" />
            <a href="javascript:void(0);" onclick="switchDivDisplay('customButtonDivStyleHelp');"><img src="<?php echo THANKS_PLUGIN_URL.'/images/question_grey.png';?>" alt="question sign" title="http://yourblog.com/wp-content/uploads/2009/10/your-button.png"/></a>
            <div id="customButtonDivStyleHelp" style="display:none;"><?php _e('e.g.,','thankyou'); ?> <code>http://yourblog.com/wp-content/uploads/2009/10/your-button.png</code></div>
            <div>
            <?php _e('Width, px', 'thankyou'); ?> <input type="text" name="thanks_custom_width" value="<?php echo $thanks_custom_width; ?>" size="10" onchange="thanksCustomWidthChange(this.value);"/>
            <?php _e('Height, px', 'thankyou'); ?> <input type="text" name="thanks_custom_height" value="<?php echo $thanks_custom_height; ?>" size="10" onchange="thanksCustomHeightChange(this.value);"/>
            </div>
            <div class="form_color_row" id="thanksCustomButtonDiv" <?php echo (!$thanks_custom) ? 'style="display:none;"':''; ?> >
              <?php echo thanks_getButtonInputHTML('javascript:void(0);', $thanks_caption.': '.rand(0, 100), 'thanks_custom_button', '',
                                   $thanks_custom_URL, $thanks_custom_width, $thanks_custom_height, $thanks_caption_style,
                                   $thanks_caption_color, 'custom', ''); ?>&nbsp;
            </div>
          </td>
        </tr>
      </table>
					<?php thanks_displayBoxEnd(); // I plan other options here
						thanks_displayBoxStart(__('Misc', 'thankyou')); ?>
      <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
        <tr>
          <th scope="row">
              <?php _e('Check IP-address','thankyou'); ?>
          </th>
          <td>
            <input type="checkbox" value="1" <?php echo ($thanks_check_ip_address=='1') ? 'checked="checked"' : ''; ?>
                   name="thanks_check_ip_address" id="thanks_check_ip_address" />
            <label for="thanks_check_ip_address"><?php _e('Only one Thanks for post for one IP-address limit','thankyou'); ?></label><br/>
            <?php _e('Time limit:', 'thankyou'); ?>
            <div style="display:inline-table;"><label for="thanks_time_limit1"><input type="radio" value="1" name="thanks_time_limit[]" id="thanks_time_limit1" <?php echo ($thanks_time_limit[0]=='1') ? 'checked="checked"' : ''; ?> />
            <?php _e('Forever','thankyou'); ?></label><br/>
            <label for="thanks_time_limit2"><input type="radio" value="2" name="thanks_time_limit[]" id="thanks_time_limit2" <?php echo ($thanks_time_limit[0]=='2') ? 'checked="checked"' : ''; ?> />
            <?php _e('Only for this period','thankyou'); ?></label>            
          <input type="text" name="thanks_time_limit_seconds" id="thanks_time_limit_seconds" value="<?php echo $thanks_time_limit_seconds; ?>" size="10" />
            <?php _e('seconds', 'thankyou'); ?></div>
          </td>
        </tr>
        </table>
					<?php thanks_displayBoxEnd(); ?>
        <p class="submit column-parent">
          <input type="submit" name="Submit" value="<?php _e('Save Changes', 'thankyou') ?>" />
          <input type="button" name="Cancel" value="<?php _e('Cancel', 'thankyou') ?>" title="Cancel not saved changes" onclick="thanks_SettingsCancel();"/>
        </p>
				<?php thanks_displayBoxStart(__('Button DIV Style Preview', 'thankyou')); $thanks_display_anchor = 1; ?>
								<div class="column-parent" >
<?php
  echo '<div class="thanks_button_div" id="thanks_button_preview" style="'.$thanks_style.'">'.
    thanks_getButtonInputHTML('javascript:void(0);', $thanks_caption.': '.rand(0, 100), $buttonSizeClass, 'thanks_'.$thanks_color,
                                   THANKS_PLUGIN_URL.'/images/thanks_'.$thanks_size.'_'.$thanks_color.'.png', '', '', $thanks_caption_style,
                                   $thanks_caption_color, 'stylePreview', '').'</div>';
?>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ipsum nibh, cursus eu imperdiet nec, vestibulum ac arcu. Nulla quis nulla in arcu congue varius vestibulum sit amet purus. Aliquam dui elit, adipiscing laoreet viverra ac, ultricies vitae turpis. Etiam hendrerit, ipsum nec mollis porttitor, nunc orci tempor tortor, nec iaculis nunc sapien quis ipsum. Aenean tincidunt, diam eu fermentum laoreet, nisi enim ornare tellus, vitae malesuada lacus quam ut dolor. Suspendisse tempus malesuada malesuada. Aenean quam mauris, feugiat ut ornare non, pharetra et diam. Sed auctor turpis in urna sagittis cursus. Sed accumsan eros eu magna fringilla elementum. Sed id neque nec sem pulvinar congue et vel turpis. Vivamus vel neque a mauris condimentum gravida ac eu lorem. Integer elementum odio diam. Nam hendrerit condimentum arcu, ut tincidunt felis semper non. Etiam tincidunt urna in tellus varius sit amet sollicitudin erat pharetra. Sed tempor varius fermentum. Nam at enim metus. Curabitur porttitor eleifend ligula, vitae vestibulum purus condimentum a. Sed vel massa purus, at consequat quam. Nulla facilisi. </p>
								</div>
<?php
                thanks_displayBoxEnd();
?>
						</div>
					</div>
				</div>
    </form>

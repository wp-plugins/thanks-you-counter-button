<?php
/* 
 * Statistics form of Thank You Counter Button WordPress Plugin
 * 
 */

global $wpdb, $wp_locale, $thanksCountersTable;


if (!isset($_GET['rowsperstatpage'])) {
  $rowsPerStatPage = get_option('thanks_rows_per_stat_page');
  if (!$rowsPerStatPage) {
    $rowsPerStatPage = 15;
    update_option('thanks_rows_per_stat_page', $rowsPerStatPage);
  }
} else {
  $rowsPerStatPage = $_GET['rowsperstatpage'];
  $temp = get_option('thanks_rows_per_stat_page');
  if (!is_numeric($rowsPerStatPage)) {
    $rowsPerStatPage = $temp;
  } else {
    if ($rowPerStatPage!=$temp) {
      update_option('thanks_rows_per_stat_page', $rowsPerStatPage);
    }
  }
}

if (!isset($_GET['paged']) || !$_GET['paged'] || !is_numeric($_GET['paged'])) {
  if (isset($_SESSION['thanks_paged']) && $_SESSION['thanks_paged'] && is_numeric($_SESSION['thanks_paged'])) {
    $_GET['paged'] = $_SESSION['thanks_paged'];
  } else {
    $_GET['paged'] = 1;
    $_SESSION['thanks_paged'] = 1;
  }
} else {
  $_SESSION['thanks_paged'] = $_GET['paged'];
}

if (!isset($_GET['sortfield'])) {
  if (isset($_SESSION['thanks_sortfield'])) {
    $sortField = $_SESSION['thanks_sortfield'];
  } else {
    $sortField = 'quant';
    $_SESSION['thanks_sortfield'] = $sortField;
  }
} else {
  $sortField = $_GET['sortfield'];
  $_SESSION['sortfield'] = $sortField;
}

if (!isset($_GET['sortdir'])) {
  $sortDir = 'desc';
} else {
  $sortDir = $_GET['sortdir'];
  if ($sortDir!='asc' && $sortDir!='desc') {
    $sortDir = 'desc';
  }
}


$where1 = '';
if (isset($_GET['month'])) {
  $month = (int)$_GET['month'];
  $_SESSION['thanks_month'] = $month;
} else if (isset($_SESSION['thanks_month'])) {
  $month = $_SESSION['thanks_month'];
}  else {
  $month = 0;
  $_SESSION['thanks_month'] = 0;
}
if ($month) {
  $where1 = " and DATE_FORMAT(post_date, '%Y%m')=$month";
}

$where2 = '';
if (isset($_GET['cat'])) {
  $cat_id = (int)$_GET['cat'];
  $_SESSION['thanks_cat'] = $cat_id;
} else if (isset($_SESSION['thanks_cat'])) {
  $cat_id = $_SESSION['thanks_cat'];
}  else {
  $cat_id = 0;
  $_SESSION['thanks_cat_id'] = 0;
}

if (!isset($_GET['zeroshow'])) {
  $where1 .= ' and counters.quant>0';
}

if ($cat_id) {
  $query = "select distinct posts.ID
              from $wpdb->posts posts
                left join $wpdb->term_relationships term_relationships on (posts.ID=term_relationships.object_id)
                left join $wpdb->term_taxonomy term_taxonomy on (term_relationships.term_taxonomy_id=term_taxonomy.term_taxonomy_id)
              where posts.post_type='post' and
                   (term_taxonomy.term_id=$cat_id or term_taxonomy.parent=$cat_id) and term_taxonomy.taxonomy='category'";
  $records = $wpdb->get_results($query);
  if ($wpdb->last_error) {
    echo 'error: '.$wpdb->last_error;
    return;
  }
  $posts = array();
  foreach ($records as $record) {
    $posts[] = $record->ID;
  }
  $where2 = implode($posts, ',');
  if ($where2) {
    $where2 = ' and posts.ID in ('.$where2.') ';
  }
}

$query = "select count(posts.ID)
            from $wpdb->posts posts
              left join $thanksCountersTable counters on counters.post_id=posts.ID
            where 1=1 $where1 $where2 and posts.post_type='post'";
$thankedPosts = $wpdb->get_var($query);
if ($wpdb->last_error) {
   echo 'error: '.$wpdb->last_error;
   return;
}

$maxNumPages = (int) ($thankedPosts / $rowsPerStatPage);
$rest = $thankedPosts / $rowsPerStatPage - $maxNumPages;
if ($rest>0) {
  $maxNumPages += 1;
}
if ($_GET['paged']>$maxNumPages) {
  $_GET['paged'] = $maxNumPages;
}
$fromRecord = max(0,($_GET['paged'] - 1))*$rowsPerStatPage;

$query = "select posts.ID, posts.post_title, counters.quant, counters.updated
            from $wpdb->posts posts
              left join $thanksCountersTable counters on counters.post_id=posts.ID
            where 1=1 $where1 $where2 and posts.post_type='post'
            order by $sortField $sortDir
            limit $fromRecord, $rowsPerStatPage";
$records = $wpdb->get_results($query);
if ($wpdb->last_error) {
   echo 'error: '.$wpdb->last_error;
   return;
}
$foundPosts = count($records);

?>

<div class="tablenav">
<?php
$base = remove_query_arg('updated');
$page_links = paginate_links(array(
	'base' => add_query_arg('paged', '%#%', $base),
	'format' => '',
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'total' => $maxNumPages,
	'current' => $_GET['paged']
));

?>
<div class="alignleft actions">
<form id="posts-filter" action="" method="get">
  <input type="hidden" name="page" value="thankyou.php" />
  <input type="hidden" name="paged" value="<?php echo $_GET['paged']; ?>" />

<?php // view filters
if (!is_singular()) {
$arc_query = "SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth
                FROM $wpdb->posts
                WHERE post_type = 'post'
                ORDER BY post_date DESC";

$arc_result = $wpdb->get_results( $arc_query );
$month_count = count($arc_result);
if ($month_count && !(1 == $month_count && 0 == $arc_result[0]->mmonth)) {
?>
<select name='month'>
<option<?php selected( $month, 0 ); ?> value='0'><?php _e('Show all post dates','thankyou'); ?></option>
<?php
foreach ($arc_result as $arc_row) {
	if ( $arc_row->yyear == 0 )
		continue;
	$arc_row->mmonth = zeroise( $arc_row->mmonth, 2 );

	if ( $arc_row->yyear . $arc_row->mmonth == $month )
		$default = ' selected="selected"';
	else
		$default = '';

	echo "<option$default value='" . esc_attr("$arc_row->yyear$arc_row->mmonth") . "'>";
	echo $wp_locale->get_month($arc_row->mmonth) . " $arc_row->yyear";
	echo "</option>\n";
}
?>
</select>
<?php } ?>

<?php
$dropdown_options = array('show_option_all' => __('View all categories','thankyou'), 'hide_empty' => 1, 'hierarchical' => 1,
	'show_count' => 1, 'orderby' => 'name', 'selected' => $cat_id);
wp_dropdown_categories($dropdown_options);

if (isset($_GET['zeroshow'])) {
  $checked = 'checked="checked"';
} else {
  $checked = '';
}
?>
&nbsp;<input type="checkbox" id="zeroshow" name="zeroshow" value="1" <?php echo $checked; ?>/>&nbsp;<span style="font-size:0.85em;"><?php _e('Show Posts without Thanks', 'thankyou');?></span>&nbsp;&nbsp;&nbsp;
<span style="font-size:0.85em;"><?php echo _e('Rows per page: ', 'thankyou'); ?></span>
<select name="rowsperstatpage" id="rowsperstatpage">
  <option value="5" <?php echo thanks_optionSelected($rowsPerStatPage, 5); ?> >5</option>
  <option value="10" <?php echo thanks_optionSelected($rowsPerStatPage, 10); ?> >10</option>
  <option value="15" <?php echo thanks_optionSelected($rowsPerStatPage, 15); ?> >15</option>
  <option value="20" <?php echo thanks_optionSelected($rowsPerStatPage, 20); ?> >20</option>
  <option value="25" <?php echo thanks_optionSelected($rowsPerStatPage, 25); ?> >25</option>
  <option value="30" <?php echo thanks_optionSelected($rowsPerStatPage, 30); ?> >30</option>
  <option value="50" <?php echo thanks_optionSelected($rowsPerStatPage, 50); ?> >50</option>
</select>
&nbsp;&nbsp;&nbsp;
<input type="submit" id="post-query-submit" value="<?php _e('Refresh','thankyou'); ?>" class="button-secondary" />
</form>
</div>
<?php
  if ( $page_links ) { ?>
<div class="tablenav-pages">
<?php
  $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s','thankyou' ) . '</span>%s',
	number_format_i18n(max($_GET['paged'] - 1, 0)*$rowsPerStatPage + 1),
	number_format_i18n(min( $_GET['paged']*$rowsPerStatPage, $thankedPosts)),
	number_format_i18n($thankedPosts),	$page_links );
  echo $page_links_text;
?>
</div>
<?php
  }
}
?>
</div>

<?php
if ($foundPosts) {
?>

<?php
  $link = remove_query_arg(array('updated', 'sortdir','sortfield'));  // remove 'updated=true' from URL params in case user go to Statistics tab after saving Settings
  $link = remove_query_arg('updated', $link);
  if (strpos($link, 'paged')===false) {
    $link = add_query_arg('paged', $_GET['paged'], $link);
  }
  $linkQuant = $link;
  $linkUpdated = $link;
  if ($sortField=='quant') {
    if ($sortDir=='asc') {
      $newSortDir = 'desc';
      $newSortDirTitle = __('descending', 'thankyou');
      $currentSortDirTitle = __('Ascending order', 'thankyou');
      $currentSortDirImg = '<img src="'.THANKS_PLUGIN_URL.'/images/asc-sort-arrow.png" alt="'.$currentSortDirTitle.'" title="'.$currentSortDirTitle.'" />';
    } else {
      $newSortDir = 'asc';
      $newSortDirTitle = __('ascending', 'thankyou');
      $currentSortDirTitle = __('Descending order', 'thankyou');
      $currentSortDirImg = '<img src="'.THANKS_PLUGIN_URL.'/images/desc-sort-arrow.png" alt="'.$currentSortDirTitle.'" title="'.$currentSortDirTitle.'" />';
    }
    $quantSortDirImg = $currentSortDirImg;
    $updatedSortDirImg = '';
    $linkQuant = add_query_arg('sortdir', $newSortDir, $link);
  } else {  
    if ($sortDir=='asc') {
      $newSortDir = 'desc';
      $newSortDirTitle = __('descending', 'thankyou');
      $currentSortDirTitle = __('Ascending order', 'thankyou');
      $currentSortDirImg = '<img src="'.THANKS_PLUGIN_URL.'/images/asc-sort-arrow.png" alt="'.$currentSortDirTitle.'" title="'.$currentSortDirTitle.'" />';
    } else {
      $newSortDir = 'asc';
      $newSortDirTitle = __('ascending', 'thankyou');
      $currentSortDirTitle = __('Descending order', 'thankyou');
      $currentSortDirImg = '<img src="'.THANKS_PLUGIN_URL.'/images/desc-sort-arrow.png" alt="'.$currentSortDirTitle.'" title="'.$currentSortDirTitle.'" />';
    }
    $linkUpdated = add_query_arg('sortdir', $newSortDir, $link);
    $quantSortDirImg = '';
    $updatedSortDirImg = $currentSortDirImg;
  }
  $newSortDirTitle = sprintf(__('Click to sort in %s order','thankyou'), $newSortDirTitle);
  
  $linkQuant = add_query_arg('sortfield', 'quant', $linkQuant);
  $linkUpdated = add_query_arg('sortfield', 'updated', $linkUpdated);
 
  

function thShow($linkQuant, $linkUpdated, $newSortDirTitle, $newSortDirTitle, $quantSortDirImg, $updatedSortDirImg) {
?>
  <tr>
    <th style="width: 70px;text-align:center;"><?php echo _e('Post Id', 'thankyou'); ?></th>
    <th style="text-align:center;"><?php _e('Post Title', 'thankyou'); ?></th>
    <th style="width: 130px;text-align:center;"><a href="<?php echo $linkQuant; ?>" title="<?php echo $newSortDirTitle; ?>"><?php echo __('Thanks Quant', 'thankyou').' '.$quantSortDirImg; ?></a></th>
    <th style="width: 160px;text-align:center;"><a href="<?php echo $linkUpdated; ?>" title="<?php echo $newSortDirTitle; ?>"><?php echo __('Last Thank Date', 'thankyou').' '.$updatedSortDirImg; ?></a></th>
  </tr>
<?php
}
// end of thShow()

?>
<script language="javascript" type="text/javascript">
  function resetCounter(post_id, message, page) {
    if (!confirm(message)) {
      return false;
    }

    el = document.getElementById('ajax_loader_stat');
    if (el!=undefined) {
      el.style.visibility = 'visible';
    }

    jQuery.ajax({
      type: "POST",
      url: ThanksSettings.plugin_url + '/thankyou-ajax.php',
      data: { post_id: post_id,
              page: page,
              action: 'reset',
              _ajax_nonce: ThanksSettings.ajax_nonce
    },
    success: function(msg){
      if (msg.indexOf('error')<0) {
        el = document.getElementById('thanksQuant_'+ post_id);
        if (el!=undefined) {
          el.innerHTML = '0';
        }
        el = document.getElementById('ajax_loader_stat');
        if (el!=undefined) {
          el.style.visibility = 'hidden';
        }
      } else {
        alert(msg);
      }
    },
    error: function(msg) {
      alert(msg);
    }
    });

  }
  // resetCounter()

</script>
<div id="ajax_loader_stat" style="display:inline;visibility: hidden;"><img alt="ajax loader" src="<?php echo THANKS_PLUGIN_URL.'/images/ajax-loader.gif';?>" /></div>
<table class="widefat fixed" cellspacing="0">
   <thead>
<?php thShow($linkQuant, $linkUpdated, $newSortDirTitle, $newSortDirTitle, $quantSortDirImg, $updatedSortDirImg); ?>
   </thead>
<?php
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$i = 0;
foreach ($records as $record) {
  if ($i & 1) {
    $rowClass = 'alternate';
  } else {
    $rowClass = '';
  }
  $i++;
  $updated = mysql2date($date_format.' '.$time_format, $record->updated, true);
?>
  <tr class="<?php echo $rowClass; ?>">
    <td class="txt_right" width="5%"><?php echo $record->ID; ?></td>
    <td class="txt_left" style="padding-left:10px;"><a href="<?php echo get_permalink($record->ID);?>"><?php echo $record->post_title; ?></a>
<?php
					$thankyou_actions = array();
					if ( current_user_can('edit_post', $record->ID) ) {
						$thankyou_actions['reset'] = '<span class="delete"><a class="submitdelete" title="'.attribute_escape(__('Reset this post counter', 'thankyou')).'"
                                            href="javascript:void(0);" onclick="resetCounter('.$record->ID.',\''.js_escape(sprintf( __("You are about to reset this post '%s' thanks counter.\n Click 'Cancel' to do nothing, 'OK' to reset it.", 'thankyou'), $record->post_title )).'\','.$_GET['paged'].');">'.__('Reset Counter', 'thankyou').'</a>';
					}
					$thankyou_actions['view'] = '<span class="view"><a href="' . get_permalink($record->ID) . '" title="' . attribute_escape(sprintf(__('View "%s"', 'thankyou'), $record->post_title)) . '" rel="permalink">' . __('View Post', 'thankyou') . '</a>';
					echo '<div class="row-actions">';
					echo implode(' | </span>', $thankyou_actions);
					echo '</div>';
?>
    </td>
    <td class="txt_right" width="5%" id="<?php echo 'thanksQuant_'.$record->ID; ?>"><?php echo ($record->quant) ? $record->quant : 0; ?></td>
    <td class="txt_center" width="5%"><?php echo $updated; ?></td>
  </tr>
<?php
}

?>
  <tfoot>
<?php thShow($linkQuant, $linkUpdated, $newSortDirTitle, $newSortDirTitle, $quantSortDirImg, $updatedSortDirImg); ?>
  </tfoot>
</table>

<?php
if ( $page_links ) { ?>
<div class="tablenav">
<div class="tablenav-pages"><?php $page_links_text = sprintf( '<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s','thankyou') . '</span>%s',
	number_format_i18n( ( $_GET['paged'] - 1 ) * $rowsPerStatPage + 1 ),
	number_format_i18n( min( $_GET['paged'] * $rowsPerStatPage, $thankedPosts ) ),
	number_format_i18n( $thankedPosts ),
	$page_links
); echo $page_links_text;
?>
</div>
</div>
<?php
}
?>

<?php
} else { // have_posts()
?>
<div class="clear"></div>
<p>  <?php _e('No posts found','thankyou') ?></p>

<?php
}
?>
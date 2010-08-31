/* 
 *
 * Javascript support for Thank You Counter Button WordPress plugin
 *
 */

function thankYouButtonRemoveSettingsShortcuts() {

	// Update the option
	jQuery.ajax({
			type: "POST",
			url: ThanksSettings.plugin_url + '/thankyou-ajax.php',
			data: { post_id: -1,
			action: 'hideSettingsShortcuts',
			_ajax_nonce: ThanksSettings.ajax_nonce
		},
		success: function(msg){
			if (msg.indexOf('error')<0) {
				var all = (document.all)?document.all:document.getElementsByTagName('*');
				for (var i = 0; i < all.length; i++) {
					// Hide all shortcut settings currently visible
					if (all[i].className == 'thanks_settings_shortcuts') {
						all[i].style.display = 'none';
					}
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



function thankYouButtonClick(post_id, done_title) {
  var i = 0;
  while (true) { // process all thanks buttons included in this post
    i++;
    el = document.getElementById('ajax_loader_'+ post_id +'_'+ i);
    if (el!=undefined) {
      el.style.visibility = 'visible';
    } else {
      break;
    }
    el = document.getElementById('thanksButton_'+ post_id +'_'+ i);
    if (el!=undefined) {
      el.onclick = "return false;";
      el.title = done_title;
      el.disabled = 'true';
    } else {
      break;
    }
  }
  
  jQuery.ajax({
   type: "POST",
   url: ThanksSettings.plugin_url + '/thankyou-ajax.php',
   data: { post_id: post_id,
           action: 'thankyou',
           _ajax_nonce: ThanksSettings.ajax_nonce
   },
   success: function(msg){
     if (msg.indexOf('error')<0) {
       beginTag = msg.indexOf('<thankyou>');
       endTag = msg.indexOf('</thankyou>');
       if (beginTag>=0 && endTag>0) {
         msg = msg.substring(beginTag + 10);
         endTag = msg.indexOf('</thankyou>');
         msg = msg.substring(0, endTag);
       } else {
         alert('Wrong answer format: '+ msg);
         return;
       }
       var regExp = new RegExp('\\d+$');
       var i = 0;
       while (true) { // process all thanks buttons included in this post
         i++;
         el = document.getElementById('thanksButton_'+ post_id +'_'+ i);
         if (el!=undefined) {
          el.value = el.value.replace(regExp, msg);
         } else {
           break;
         }
         el = document.getElementById('ajax_loader_'+ post_id +'_'+ i);
         if (el!=undefined) {
           el.style.visibility = 'hidden';
         } else {
           break;
         }
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

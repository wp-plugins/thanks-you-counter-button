/* 
 *
 * Javascript support for Thank You Counter Button WordPress plugin
 *
 */

function thankYouButtonClick(post_id) {
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
      el.title = '';
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


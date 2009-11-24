/* 
 *
 * Javascript support for Thank You Counter Button WordPress plugin
 *
 */

function thankYouButtonClick(post_id) {
  el = document.getElementById('ajax_loader_'+ post_id);
  if (el!=undefined) {
    el.style.visibility = 'visible';    
  }
  el = document.getElementById('thanksButton_'+ post_id);
  if (el!=undefined) {
    el.onclick = "return false;";
    el.title = '';
    el.disabled = 'true';
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
       el = document.getElementById('thanksButton_'+ post_id);
       if (el!=undefined) {
         beginTag = msg.indexOf('<thankyou>');
         endTag = msg.indexOf('</thankyou>');
         if (beginTag>=0 && endTag>0) {
           msg = msg.substring(beginTag + 10);
           endTag = msg.indexOf('</thankyou>');
           msg = msg.substring(0, endTag);
           el.value = msg;                      
         } else {
           alert('Wrong answer format: '+ msg);
         }
       }
       el = document.getElementById('ajax_loader_'+ post_id);
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


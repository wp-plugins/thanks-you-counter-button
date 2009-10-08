/* 
 *
 * Javascript support for Thank You Counter Button WordPress plugin
 *
 */

function thankYouButtonClick(post_id) {
  el = document.getElementById('ajax_loader_'+ post_id);
  if (el!=undefined) {
    el.style.visibility = 'visible';
    //el.style.display = 'inline';
  }
  jQuery.ajax({
   type: "POST",
   url: ThanksSettings.plugin_url + '/thankyou-ajax.php',
   data: { post_id: post_id,
           _ajax_nonce: ThanksSettings.ajax_nonce
   },
   success: function(msg){
     if (msg.indexOf('error')<0) {
       //alert('success: '+ msg);
       el = document.getElementById('thanksButton_'+ post_id);
       if (el!=undefined) {
         el.value = msg;
       }
       el = document.getElementById('ajax_loader_'+ post_id);
       if (el!=undefined) {
         el.style.visibility = 'hidden';
         //el.style.display = 'none';
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


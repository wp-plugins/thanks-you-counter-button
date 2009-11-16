=== Thank You Counter Button ===
Contributors: ShinePHP, Whiler
Donate link: shinephp.com
Tags: thanks, counter, button, tracker, dashboard, widget, plugin, shortcode, statistics
Requires at least: 2.7.1
Tested up to: 2.8.6
Stable tag: 1.3

Plugin adds "Thank You" button to every post/page, counts and shows a total number of the unique visitors "thank you" clicks for this post/page.
Plugin has wide choice of settings to customize its presentation and behaviour. "Statistics" table (Post title, Thanks Quant, Last Thanks Date) will help you to analyze which posts and how much are liked by your blog visitors.
Admin dashboard and sidebar widgets shows you the from 5 to 15 post titles for which blog visitors left their latest thanks or the largerst quant of thanks.

== Description ==

This is the simple visitor's 'Thank you' or 'I like it' clicks counter button. Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post.
The plugin stores its counters in the MySQL table. Only one "thank" for this IP-address can be permitted. Plugin can to skip all further "Thank you" clicks from this IP-addres once it is automatically registered. IP-address click limit can be set to the time interval in seconds.
Plugin has Statistics data table which shows posts list with total thanks quant for every post and time of the latest thank. Rows in the table can be filtered by posting month, category, can be sorted by thanks quant or time of latest thank in the descending or ascending order.
Admin dashboard and sidebar widgets with list of from 5 to 15 latest thanked or the most thanked posts is available. Use widgets control panels to change settings according to your preferences. Admin dashboard widget has Configure link on its title bar, just move mouse over it.
Side bar Thanks Stat widget has filter hook 'thanks_stat_sidebar' for its content.
Admin dashboard Thanks widget has filter hook 'thanks_stat_dashboard' for its content.
Thank You button has filter hook 'thanks_thankyou_button' for its html code now.
You can use those hooks in your plugins or just in function.php of your WP theme. Look on this code sample for your reference:

function thankStatModify($output) {
  // $output is the code of widget or button to modify. I add text to it here, from the begin and to the end.

  return 'before '.$output.' after';

}
add_filter('thanks_stat_sidebar', thankStatModify);
// and / or
add_filter('thanks_stat_dashboard', thankStatModify);
// and / or
add_filter('thanks_thankyou_button', thankStatModify);

== Installation ==

Installing procedure:

1. Deactivate plugin if you have the previous version installed. (It is important requirement for switching on 1.3 version from the previouse one.)
2. Extract "thanks-you-counter-button.1.3.zip" archive content to the "/wp-content/plugins/thanks-you-counter-button" directory.
3. Activate "Thank You Counter Button" plugin via 'Plugins' menu in WordPress admin menu. (If you updated from one of previouse versions, please check that Button Position setting is valid).
4. Go to the "Settings"-"Thanks CB" menu item and setup your preferences for this plugin.

== Frequently Asked Questions ==
There are no questions from the plugin users yet :).

== Screenshots ==
1. screenshot-1.png The example of "Thank You" button in blue color
2. screenshot-2.png The "Thank You" Counter Button Settings Page
3. screenshot-3.png The "Thank You" Counter Button Statistics page.
4. screenshot-4.png Admin dashboard "Latest Thanks/Most Thanked" configurable widget.
5. screenshot-5.png Sidebar "Latest Thanks/Most Thanked" configurable widgets.

== Translations ==
* Russian: [ShinePHP](http://shinephp.com/)
* Spanish: [Omi](http://equipajedemano.info/)
* French: [Whiler](http://blogs.wittwer.fr/whiler/)

Dear plugin User,
if you wish to help me with this plugin translation I very appreciate it. Please send your languge .po and .mo files to
vladimir@shinephp.com email. Do not forget include you site link in order I can show it with thanks for the translation help at shinephp.com
and in this readme.txt file.

== Special Thanks ==
* Thanks to [Omi](http://equipajedemano.info) for the help with Spanish translation, ideas and new versions testing.
* Thanks to [Simon](http://www.supersite.me/website-building/jquery-free-color-picker/) for the excelent JQuery color picker.
* Thanks to [Whiler](http://blogs.wittwer.fr/whiler/) for the help with French translation, ideas, source code contributions and new versions testing.

== Changelog ==

= 1.3 =
* 16.11.2009
- Thanks Stat sidebar widget: the latest or the most thanked post titles with total thanks quant on your blog sidebar. Select yourself what to show via widget settings.  Widget has its content filter hook 'thanks_stat_sidebar'.
- Dashboard statistics widget (the latest or the most thanked post titles with total thanks quant): minor CSS fix, link to the Full Statistics page is added, use widget control panel to configer its presentation. Widget has its content filter hook 'thanks_stat_dashboard' now.
- Thank You Counter Button has filter hook 'thanks_thankyou_button' for its button html code now.
- Settings link is added to the TYCB plugin actions list at the Plugins page;
- Button exclusion shortcode [nothankyou] is added. When this shortcode is included to the post text 'Thank You' button is not shown for this post.
- Button position control at the plugin Settings page is changed to the list of checkboxes. So you can use those positions together not on the alternate base only as earlier.
You can find the examples for using plugin content filters at http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/

= 1.2.01 =
* 10.11.2009
- bug when thanks send date and time was not updated is fixed;
- minor fixes for the translation files.

= 1.2. =
* 08.11.2009
- plugin menu item under Wordpress 'Settings' menu was renamed to 'Thanks CB' (abbreviation from 'Thank You Counter Button').
- admin dashboard widget to show posts with latest thanks is added.
- If IP-address checking is activated 'Thank You' button has no link for visitors who clicked it for this post already. So there are no more non-necessary requests to server.
- There are two tabs at the plugin page: Setting and Statistics.
  1) Options to not show 'Thank You' button for selected categories is added to the Settings page. Just check the categories in the list for which you don't want to show the 'Thank You' button.
  2) You can select from two options for IP-address checking: limit this IP forever or just on the time period in seconds you input.
  3) You can see how many 'Thanks' you have for every post and when last thanks for which post is left at the Statistics tab of the Settings page.

= 1.1.01 =
* 01.11.2009 French translation for the Settings page was added.

= 1.1 =
* 14.10.2009: 
- Settings page interface updated. Additions: button caption text style field including text color picker, 7 new rounded corner buttons, custom button image URL field. 
- Russian and Spanish translations were added.

= 1.0.02 =
* 09.10.2009 Ajax request answer and its processing enhancement. Some hosting providers automatically adds data to every http request answer, e.g. traffic tracking javascript code, etc. In such case part of that additional code was visible on the "Thank You" button just after the "Thanks" quant. Button caption and "thanks" quant is now properly tagged inside <thankyou></thankyou> tags and will be shown properly.

= 1.0.01 =
* 08.10.2009 Position shortcode [thankyou] bug fix. I documented [thankyou] shortcode but in the code [thanksyou] string was checked. Now it is fixed. Working shortcode to place "Thank You" button in the post by the 'shortcode' position is [thankyou].

= 1.0 =
* 06.10.2009 First stable release

== Documentation and Support ==

You can find more information about "Thank You Counter Button" plugin at this page
http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/
Plugin author (I am) answers on questions about plugin usage. Use comments to contact me please.

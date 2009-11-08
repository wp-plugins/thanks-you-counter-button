=== Thank You Counter Button ===
Contributors: [Whiler](http://blogs.wittwer.fr/whiler/)
Donate link: shinephp.com
Tags: thanks, counter, button, tracker, dashboard, widget, plugin, shortcode, statistics
Requires at least: 2.7.1
Tested up to: 2.8.5
Stable tag: 1.2

Plugin adds "Thank You" button to every post/page, counts and shows a total number of the unique visitors "thank you" clicks for this post/page.
Plugin has wide choice of settings to customize its presentation and behaviour. "Statistics" table (Post title, Thanks Quant, Last Thanks Date) will help you to analyze which posts and how much are liked by your blog visitors.
Admin dashboard widget shows you the 5 posts for which blog visitors left their latest "Thank You".

== Description ==

This is the simple visitor's 'Thank you' or 'I like it' clicks counter button. Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post.
The plugin stores its counters in the MySQL table. Only one "thank" for this IP-address can be permitted. Plugin can to skip all further "Thank you" clicks from this IP-addres once it is automatically registered. IP-address click limit can be set to the time interval in seconds.
Plugin has Statistics data table which shows posts list with total thanks quant for every post and time of the latest thank. Rows in the table can be filtered by posting month, category, can be sorted by thanks quant or time of latest thank in the descending or ascending order.
Admin dashboard widget with list of 5 latest thanked post is available.

== Installation ==

Installing procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "thanks-you-counter-button.1.2.zip" archive content to the "/wp-content/plugins/thanks-you-counter-button" directory.
3. Activate "Thank You Counter Button" plugin via 'Plugins' menu in WordPress admin menu.
4. Go to the "Settings"-"Thanks CB" menu item and setup your preferences for this plugin.

== Frequently Asked Questions ==
There are no questions from the plugin users yet :).

== Screenshots ==
1. screenshot-1.png The example of "Thank You" button in blue color
2. screenshot-2.png The "Thank You" Counter Button Settings Page
3. screenshot-3.png The "Thank You" Counter Button Settings Page Spanish translation
4. screenshot-4.png The "Thank You" Counter Button Settings Page French translation
5. screenshot-5.png The "Thank You" Counter Button Statistics page.

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

== Support ==

You can find more information about "Thank You Counter Button" plugin at this page
http://www.shinephp.com/2009/10/05/thank-you-counter-button-wordpress-plugin/
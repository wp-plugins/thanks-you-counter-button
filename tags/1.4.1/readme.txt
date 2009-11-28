=== Thank You Counter Button ===
Contributors: ShinePHP, Whiler
Donate link: http://www.shinephp.com/donate/
Tags: thanks, thank you, counter, button, tracker, dashboard, sidebar, widget, shortcode, statistics
Requires at least: 2.7.1
Tested up to: 2.9 & MU 2.8.6
Stable tag: 1.4.1

Plugin adds 'Thank You' button to every post/page, counts and shows a total number of the unique visitors 'thank you' clicks for this post/page.

== Description ==

This is the visitor's 'Thank you' or 'I like it' clicks counter button. Every time a new visitor clicks the "Thank you" button, one point is added to the total "thanks" counter for this post which can be seen at the same button.

The plugin stores its counters in the MySQL tables. Only one "thank" for this IP-address can be permitted. Plugin can skip all further "Thank you" clicks from this IP-address once it is automatically registered. IP-address click limit can be set to a time interval in seconds.

Plugin has Statistics data table which shows posts list with total thanks quant for every post and time of the latest thank. Rows in the table can be filtered by posting month, category, can be sorted by thanks quant or time of latest thank in the descending or ascending order. Selected post can be viewed or edit directly from this table.

Admin dashboard and sidebar widgets with list of latest thanked or the largests thanked posts (between 3 and 15) are available. Total quant of thanks can be shown. Use widgets control panels to change settings according to your preferences.

The set of shortcodes and content filters is available for this plugin. Visit http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/ for more details.

== Installation ==

Installing procedure:

1. Deactivate plugin if you have the previous version installed. (It is important requirement for switching to this version from a previous one.)
2. Extract "thanks-you-counter-button.x.x.x.zip" archive content to the "/wp-content/plugins/thanks-you-counter-button" directory.
3. Activate "Thank You Counter Button" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Settings"-"Thanks CB" menu item and check/change your preferences to customize how this plugin will work for you.

== Frequently Asked Questions ==

- Does this plugin work with Wordpress MU?

  Yes, it does. Plugin is tested with WordPress MU 2.8.6. Thanks to WP MU developers. Separate tables for thanks counters are created for each blog instance where plugin is activated. Every blog has its own plugin settings to manage its presentation and behaviour.

== Screenshots ==
1. screenshot-1.png The example of "Thank You" button in blue color
2. screenshot-2.png The "Thank You" Counter Button Settings Page part 1.
3. screenshot-3.png The "Thank You" Counter Button Settings Page part 2.
4. screenshot-4.png The "Thank You" Counter Button Statistics page.
5. screenshot-5.png Admin dashboard "Latest Thanks/Most Thanked" configurable widget.
6. screenshot-6.png Sidebar "Latest Thanks/Most Thanked" configurable widgets.
7. screenshot-7.png Admin dashboard "Latest Thanks/Most Thanked" widget control panel.
8. screenshot-8.png Sidebar "Latest Thanks/Most Thanked" widget control panel.

== Translations ==
* Russian: [ShinePHP](http://shinephp.com/)
* Spanish: [Omi](http://equipajedemano.info/)
* French: [Whiler](http://blogs.wittwer.fr/whiler/)

Dear plugin User,
if you wish to help me with this plugin translation I very appreciate it. Please send your language .po and .mo files to vladimir@shinephp.com email. Do not forget include you site link in order I can show it with greetings for the translation help at shinephp.com and in this readme.txt file.

== Special Thanks to ==
* [Omi](http://equipajedemano.info) for the help with Spanish translation, ideas and new versions testing.
* [Whiler](http://blogs.wittwer.fr/whiler/) for the help with French translation, ideas, source code contributions and new versions testing.
* [Simon](http://www.supersite.me/website-building/jquery-free-color-picker/) for the excelent JQuery color picker.
* [Arne](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/) for setting page layout idea, html markup examples.
* [DHTMLGoodies](http://www.dhtmlgoodies.com/) for the form input slider code.
* [Eric](http://www.glassybuttons.com/glassy.php) for the cute online button image generator.

== Changelog ==
= 1.4.1 =
* 28.11.2009
- Manual button position shortcode [thankyou] functionality is extended. You can include custom button caption to this shortcode optionally, e.g. [thankyou]YourCustomCaptionHere[/thankyou].
- Bug fix: It concerned those only who showed more than one thanks button for post. In that case the only first button from that buttons set was updated without page refresh after visitor's click.

= 1.4 =
* 27.11.2009
- Settings screen update 1: Live preview of the button and its caption style changes at the same Settings tab is realized. Every change if text, CSS styles, button size is immediately displayed in your browser.
- Settings screen update 2: Two checkboxes added for more advanced management of button position for the multi-paged posts. You can now select where to show buttons: before - before 1st page only or before every page, after - after last page only or after every page of the multi-paged post.
- Settings screen update 2: Two new buttons added into the Misc section: "Return to Defaults" - reset all settings to its default values, "Reset Counters" - reset on thanks counters for all post to the 0.
- Statistics tab - Link to reset selected post thanks counter is added. Action is realised with AJAX use. Link to edit selected post is added.
- You can show total quant of thanks now at the admin dashboard and sidebars widgets. Just check the correspondent checkbox in the widget parameters.  
- Shortcode [thanks_total_quant] is added. You can use it in your post to show the total quant of thanks visitor sent to your blog.
- Slider control was added to the admin dashboard TYCB widget in order to help you change rows quant to show.
- Minor fix to show 'Thanks CB' menu in the front-end 'Settings' menu with WordPress Admin Bar plugin, if it is installed and activated on your blog.

= 1.3.01 =
* 18.11.2009
- Testing 'Thank You Counter Button' plugin with Wordpress MU 2.8.5.2 is finished. We are proud to declare that plugin works with WP MU too.
- Button was not displayed on the Home page inside the post's excerpts for the multi-paged posts if button position was set to the 'After' only. This bug is fixed now.
- Due to conflict with some other plugins are installed PHP warning message about problem with PHP session start was shown on the plugin Setting page. That warning (if exists) is hidden now.
- Some typos are corrected in this readme.txt file. Possibly new mistakes were added :), so do not hesitate to correct me, if typos still exist in this text or in the plugin text labels.

= 1.3 =
* 16.11.2009
- Thanks Stat sidebar widget: the latest or the most thanked post titles with total thanks quant on your blog sidebar. Select yourself what to show via widget settings.  Widget has its content filter hook 'thanks_stat_sidebar'.
- Dashboard statistics widget (the latest or the most thanked post titles with total thanks quant): minor CSS fix, link to the Full Statistics page is added, use widget control panel to configer its presentation. Widget has its content filter hook 'thanks_stat_dashboard' now.
- Thank You Counter Button has filter hook 'thanks_thankyou_button' for its button html code now.
- Settings link is added to the TYCB plugin actions list at the Plugins page;
- Button exclusion shortcode [nothankyou] is added. When this shortcode is included to the post text 'Thank You' button is not shown for this post.
- Button position control at the plugin Settings page is changed to the list of checkboxes. So you can use those positions together not on the alternate base only as earlier.

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
* 09.10.2009 
- Ajax request answer and its processing enhancement. Some hosting providers automatically adds data to every http request answer, e.g. traffic tracking javascript code, etc. In such case part of that additional code was visible on the "Thank You" button just after the "Thanks" quant. Button caption and "thanks" quant is now properly tagged inside <thankyou></thankyou> tags and will be shown properly.

= 1.0.01 =
* 08.10.2009 
- Position shortcode [thankyou] bug fix. I documented [thankyou] shortcode but in the code [thanksyou] string was checked. Now it is fixed. Working shortcode to place "Thank You" button in the post by the 'shortcode' position is [thankyou].

= 1.0 =
* 06.10.2009 
- First stable release

== Additional Documentation ==
Additional documentation such as content filter hook list, available shortcodes description can be found at this link http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/2/#filterhooks


You can find more information about "Thank You Counter Button" plugin at this page
http://www.shinephp.com/thank-you-counter-button-wordpress-plugin/
I am ready to answers on your questions about plugin usage. Use plugin page comments or site contact form for it please.

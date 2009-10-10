=== Thank You Counter Button ===
Contributors: shinephp
Donate link:
Tags: thanks counter button tracker
Requires at least: 2.7.1
Tested up to: 2.8.4
Stable tag: 1.0.02

Adds "Thank You" button to every post, counts and shows a total number of the unique visitors "thank you" clicks for this post.

== Description ==

This is the simple visitor's 'Thank you' or 'I like it' click counter. Every time a new visitor clicks
the "Thank you" button one point is added to the total "thanks" counter for this post.
The plugin stores its counters in MySQL table. Only one "thank" for this IP-address is permitted. Plugin skips all further
"Thank you" clicks from this IP-addres once it is automatically registered.

== Installation ==

Installing procedure:

1. Extract "thankyou.zip" archive content to the "/wp-content/plugins/thankyou" directory.
2. Activate "Thank You Counter Button" plugin via 'Plugins' menu in WordPress admin menu.
3. Go to the "Settings"-"Thank You" and setup your preferences for this plugin.

== Frequently Asked Questions ==
Coming soon...

== Screenshots ==
1. screenshot-1.png The example of "Thank You" button in blue color
2. screenshot-2.png The "Thank You" Counter Button Settings Page

== Translations ==
* Russian: I made myself :)
* Spanish: Thanks to Omi  http://equipajedemano.inf

Dear plugin User,
if you wish to help me with this plugin translation I very appreciate it. Please send your languge .po and .mo files to
vladimir@shinephp.com email. Do not forget include you site link in order I can show it with thanks for the translation help at shinephp.com
and in this readme.txt file.

== Changelog ==

= 1.0.02 =
* 09.10.2009 Ajax request answer and its processing enhancement. Some hosting providers automatically adds data to every http request answer, e.g. traffic tracking javascript code, etc. In such case part of that additional code was visible on the "Thank You" button just after the "Thanks" quant. Button caption and "thanks" quant is now properly tagged inside <thankyou></thankyou> tags and will be shown properly.

= 1.0.01 =
* 08.10.2009 Position shortcode [thankyou] bug fix. I documented [thankyou] shortcode but in the code [thanksyou] string was checked. Now it is fixed. Working shortcode to place "Thank You" button in the post by the 'shortcode' position is [thankyou].

= 1.0 =
* 06.10.2009 First stable release

== Support ==

You can find more information about "Thank You Counter Button" plugin at this page
http://www.shinephp.com/2009/10/05/thank-you-counter-button-wordpress-plugin/
=== Facebook Comments (OTF) ===
Contributors: Sawyer Hollenshead
Tags: social, facebook, comments, discussion, only the functions
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TAPWP9QGK6NDG
Requires at least: 3.1
Tested up to: 3.2.1
Stable tag: trunk

Provides functions to be used to display a Facebook comment form and retrieve the comment count

== Description ==

Facebook Comments (OTF) is part of the ["Only The Functions" movement](http://onlythefunctions.com) &mdash; A collection of WordPress plugins that give code-savvy users access to functions which return the information / functionality they are looking for, and allows them to place it where they want, without any hacking to change default behavior.

This plugin includes functions for displaying a Facebook comment form and functions for retrieving the comment count. View the installation instructions for more info regarding these functions.

For updates, follow [@sawyerh](http://twitter.com/sawyerh).

== Installation ==

1) Install the plugin
2) Place the comment form function in your theme code (probably want to put it in single.php)

= For moderation capabilities = 

3) [Create a Facebook App](https://developers.facebook.com/apps)
4) Copy the App ID and paste it into the plugin Settings (Settings &raquo; Facebook Comments)

= Available Functions =

When you place a plugin function into your theme, you will likely want to wrap it with an `if( function_exists('FUNCTION_NAME_HERE') )` condition. This way, if the plugin gets disabled, your theme won't explode.

**fbc_comment_form( $args )**:

$args is an optional associative array that you can implement to override the following defaults:

- (int) num_comments (Default = 10)
- (int) width (Default = $content_width | 500)
- (string) app_id (Default = option set in settings | null)
- (string) color (light|dark, Default = light)
- (int) id (Default = $post->ID)
- (string) notify_email (Default = post author's e-mail)

== Other Notes ==


== Changelog ==

= 1.0 =

* Initial release
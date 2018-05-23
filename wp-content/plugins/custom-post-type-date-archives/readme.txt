=== Custom Post Type Date Archives ===
Contributors: keesiemeijer
Tags: post type,date,archives
Requires at least: 4.0
Tested up to: 4.7
Stable tag: 2.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add date archives to WordPress custom post types

== Description ==
Add Date archives to custom post types right in the dashboard itself. This plugin provides a calendar and archives widget to display your date archives as a super simple events calendar.

Features

* Adds a date archives submenu for each custom post type
* Allow scheduled posts with future dates to be published like normal posts
* Calendar and archive widget.
* Use theme templates specific for custom post type date archives

[Plugin Documentation](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki)

Example url for a custom post type `events` date archive.
`
https:&#47;&#47;example.com&#47;events&#47;2015&#47;06&#47;12
`

WordPress doesn't support [pretty permalinks](https://codex.wordpress.org/Using_Permalinks#Permalink_Types) date archives for custom post types. This plugin creates the rewrite rules needed for custom post types to also have pretty permalinks date archives.

The cpt date archives use the same theme template files as normal date archives. Extra [template files](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki/Theme-Template-Files) and [template functions](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki/Functions) are available for use in the custom post type date archives.

For more information visit the [Plugin Documentation](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki)

== Installation ==
Follow these instructions to install the plugin.

1. In your WordPress admin panel, go to Plugins > New Plugin, search for "custom post type date archives" and click "Install now".
2. Alternatively, download the plugin and upload the contents of custom-post-type-date-archives.zip to your plugins directory, which usually is /wp-content/plugins/.
3. Activate the plugin
4. Add date archives in the "Date Archives" sub menu of a custom post type.

== Frequently Asked Questions ==
For more information about this plugin visit the [Plugin Documentation](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki)

= Where do I add the date archives? =
You add the date archives in the "Date Archives" sub menu of a custom post type.

= I don't see the sub menu to add date archives? =
If you don't see the "Date Archives" sub menu in the menu of a custom post type, the post type is probably [registered](https://codex.wordpress.org/Function_Reference/register_post_type) to not be public or not have archives. See [Custom Post Types](https://github.com/keesiemeijer/custom-post-type-date-archives/wiki/Custom-Post-Types)


== Screenshots ==

1. Date archives settings page for the custom post type Products.
2. The Calendar widget
3. The Archives widget

== Changelog ==
= 2.3.1 =
* Enhancement
	* Add selective refresh for widgets in the customizer

= 2.3.0 =
* Enhancement
	* Let WordPress create the rewrite rules for the date archives.
	* Add more control over creating feeds for the date archives (filter)
	* Flush rewrite rules after settings are updated (wp-admin)
	* More PHPUnit tests (github)

= 2.2.1 =
* Enhancement
	* Flush rewrite rules when date archives are removed in admin page
	* Update help section with WordPress repo links
	* Add screenshots

= 2.2.0 =
Initial Commit

== Upgrade Notice ==
= 2.3.1 =
This update adds selective refresh for widgets in the customizer. Tested with WordPress 4.6

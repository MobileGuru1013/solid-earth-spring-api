=== Plugin Name ===
Contributors: solidearth.com
Donate link: http://solidearth.com/
Tags: real estate, homes, listings, IDX, MLS, Property Search
Requires at least: 3.0.1
Tested up to: 4.2.3
Stable tag: 1.3.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for the Solid Earth Spring API. Please visit developer.solidearth.com for more information into acquiring an API key for live use.

== Description ==

Plugin for using the listings contained in the Solid Earth Spring API. Please visit [Solid Earth](http://solidearth.com/products/spring/) for more information on how to get a key for production use.

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. The plugin requires two pages to be present called Property and Search
3. Cut and paste the shortcode [spring-slider] onto any page to display the photo slider
4. Cut and paste the shortcode [full-result] on the Property page, it will display the property search results.
5. Cut and paste the shortcode [quick-search] on the Search page, it will display the search tool.
6. Cut and paste the shortcode [agent-listing name="The Agent Name"] on any page to display the active listings of the named agent.


== Frequently Asked Questions ==

= How do I configure the plugin? =

In the side menu of the admin panel, find the menu labeled 'Spring IDX' and under that four choices:
Spring IDX
Site Select: This is where you choose the scope of the data to be returned by the plugin. Each choice represents a specific MLS organization with which the user of the plugin must have a license agreement. Contact api@solidearth.com for more information.
API Key: copy and paste the key provided by Solid Earth. To obtain a key go to http://developer.solidearth.com and register (link is in the upper right corner). If you are registering for the first time, choose a SANDBOX key. Solid Earth will switch it to production access when you are ready to go live.
Template: You probably don’t need to edit any of this unless you are a developer and want to modify the style or display of the results.
Search
Site Select: This is where you choose the scope of the data to be returned by the plugin. Each choice represents a specific MLS organization with which the user of the plugin must have a license agreement. Contact api@solidearth.com for more information.
API Key: copy and paste the key provided by Solid Earth. To obtain a key go to http://developer.solidearth.com and register (link is in the upper right corner). If you are registering for the first time, choose a SANDBOX key. Solid Earth will switch it to production access when you are ready to go live.
Template: You probably don’t need to edit any of this unless you are a developer and want to modify the style or display of the results.
Listing Details
Site Select: This is where you choose the scope of the data to be returned by the plugin. Each choice represents a specific MLS organization with which the user of the plugin must have a license agreement. Contact api@solidearth.com for more information.
API Key: copy and paste the key provided by Solid Earth. To obtain a key go to http://developer.solidearth.com and register (link is in the upper right corner). If you are registering for the first time, choose a SANDBOX key. Solid Earth will switch it to production access when you are ready to go live.
Template: You probably don’t need to edit any of this unless you are a developer and want to modify the style or display of the results.
Agent Listings
Site Select: This is where you choose the scope of the data to be returned by the plugin. Each choice represents a specific MLS organization with which the user of the plugin must have a license agreement. Contact api@solidearth.com for more information.
API Key: copy and paste the key provided by Solid Earth. To obtain a key go to http://developer.solidearth.com and register (link is in the upper right corner). If you are registering for the first time, choose a SANDBOX key. Solid Earth will switch it to production access when you are ready to go live.
Template: You probably don’t need to edit any of this unless you are a developer and want to modify the style or display of the results.

= The email features on the email a friend and request information are not working. =

Be sure that the SMTP server is configured for your WordPress site. If you do not have the settings configured, install a plugin such as WP Mail SMTP to get started with configuring your mail server.

= Where do I find more information on the API? =

Please visit [Solid Earth](http://solidearth.com/products/spring/) for more information on how to get a key for production use.

== Changelog ==

= 1.0 =
* Initial release version

= 1.1 =
* Copy changes
* Adjustment of pagination to take up less space on the screen
* Addition of ability to display latest listings within 7 days [quick-search name=“Your Agency”]

= 1.2 =
* Addition of Google Maps functionality, request information/showing buttons, and email a friend button
* Major changes to styling and formatting

= 1.3 =
* Major upgrades to styling and formatting
* Minor bug fixes to searches and maps

= 1.3.1 =
* Minor styling adjustments to the maps and modals

= 1.3.2 =
* Fix sandbox API override bug

= 1.3.5 =
* Property types dropdown options now called from API

= 1.3.6 =
* Sites dropdown options now called from API

= 1.3.7 =
* Bug fixes on agent listing

= 1.3.8 =
* Fixing agent listing

= 1.3.9 =
* Fix the Single Family Residence value on search parameter
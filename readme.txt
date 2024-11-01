=== StickyVideo ===
Contributors: octavewp
Donate link: http://stickyvideo.octave.systems/
Tags: sticky video, pinned video, video player, floating, viewability rate, video publishing
Requires at least: 3.0.1
Tested up to: 4.8
Stable tag: 2.0.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

StickyVideo plugin allows you to create a sticky/pinned floating video on page Scroll.

== Description ==

StickyVideo plugin allows you to create a sticky/pinned floating video on page Scroll.

* Easy setup and minimal configuration
* Auto-detects videos in pages and posts
* Options panel for easy customizations
* Works with many video hosting platforms like YouTube, Vimeo, WordPress Media Library, Facebook, Wistia and many more.

Boost viewability rates like CNN, Daily Mail and the Washington Post! StickyVideo pins your videos to a fixed position while scrolling. Supports iframe and HTML5 videos. Super easy to set up and no need for shortcodes. It can auto-detects videos in pages!

StickyVideo [plugin demo](http://stickyvideo.octave.systems/demo "StickyVideo Demo")

<strong>What type of videos does it work with?</strong>

This plugin supports videos that are hosted in;

* Archive.org
* Break
* Brightcove
* Dailymotion
* Facebook
* JW platform
* Liveleak
* Metacafe
* Schooltube
* Tudou
* Twitch
* Vimeo
* Wistia
* WordPress (Self hosted in Media Library)
* YouTube
* Youku

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/sticky-video` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the Settings->Sticky Video screen to configure the plugin options.

== Frequently Asked Questions ==

= Can I customise it? =

Of course you can! Once you activate the plugin, you can access the customization options under Settings > Sticky Video

== Screenshots ==

1. Before and after scroll.

== Upgrade Notice ==

= 2.0.2 =
Better placeholder behaviour and forced positioning.


== Changelog ==

= 2.1.0 =
- Refactored part of the code to separate logic for different JS players.
  This will make it easier to include more players support in the future.
- Added "forced-sticky-video" class and "forced-selector" parameter.
- Fixed bug for Twitch iframe support.
- Added support to Wistia JS player.

= 2.0.2 =
- Better placeholder behaviour if video is position:absolute (e.g. forced 16:9 aspect ratio)
- Forced positioning with "!important" when sticky (reduced contrast with aggressive style from external theme/plugins)

= 2.0.1 =
- Fixed issue when using minifying plugins that change the order of scripts.

= 2.0.0 =
- Removed jQuery dependency
- Fixed minor-bug on window resizing
- Added "data-sticky-video-state" attributes
- Added fade/motion/scale transition types
- Added placeholder-background choice
- Added styling options for mobile breakpoint
- Improved compatibility with WP's media player
- Improved transition performance

= 1.3.1 =
* Fixed bug when positioning to bottom-left/right

= 1.3.0 =
* Improved JS performance: less use of jQuery and use of requestAnimationFrame for scrolling checks
* Fixed minor bugs for WP's video player

= 1.2.0 =
* Added support to embedded videos from: youtube, vimeo, facebook, brightcove, jwplatform, dailymotion, youku, tudou, wistia, schooltube, break, metacafe, liveleak, archive.org
* Added support for jwplayer JS player

= 1.1.0 =
* Added HTML class selecting method ("sticky-video" and "contains-sticky-video")
* Added close button functionality

= 1.0.3 =
* Fixed wrong initial positioning at the edge of the page for rare cases of iframes

= 1.0.2 =
* Fixed bug in selecting vimeo tags
* Added support for dailymotion.com
* Higher zIndex for videos in fixed position

= 1.0.1 =
* Fixed issue if sticky-video.js <script> has "defer" attribute
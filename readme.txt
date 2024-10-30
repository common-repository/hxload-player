=== HxLoadPlayer ===
Contributors: HxLoad
Donate link: https://hxload.to/
Tags: player plugin, hxload player, hxload api, google drive, google photos, mp4upload, fembed, clipwatching, vidoza, gounlimited
Requires at least: 4.4
Tested up to: 5.2
Stable tag: 1.4.4
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

== Description ==

HxLoadplayer is a plugin to get direct link to hxload player from google drive, google photos, mp4upload, fembed, clipwatching, vidoza, gounlimited

== Features ==

* Support multi resolution like 360p, 480p, 720p, 1080p for google drive
* Bypass limit for google drive

== Hxload API or Shortcode tag ==

Example shortcode tag:
* [gdu link=""]
* [gdu link="" subtitle=""]
* [gdu link="" poster="" subtitle=""]

Shortcode tag result an iframe_code

Example API for Hxload Player or iframe code with method GET:
https://hxload.to/api/getlink/?secretkey=demo&link=https://drive.google.com/open?id=1wUXqu0_4gY-e0n0ymvTBYokJEc10gayf&poster=poster&subtitle=subtitle

Parameters:
* secretkey. Get secret key from https://hxload.to/?p=account
* link. Your remote URL
* poster. Your poster URL
* subtitle. Subtitle URL. If you want to use multi subtitle, example http://myweb/sub1.srt=english|http://myweb/sub2.srt=dutch (Last parameter http://myweb/sub2.srt=dutch is default subtitle)

JSON Response:
{
  "status": "success",
  "result": {
    "player": "hxload_player_url",
    "iframe": "iframe_code"
  }
}

== Installation ==

= From WordPress backend =

1. Navigate to Plugins -> Add new.
2. Click the button "Upload Plugin" next to "Add plugins" title.
3. Upload the downloaded zip file and activate it.

= Direct upload =

1. Upload the downloaded zip file into your `wp-content/plugins/` folder.
2. Unzip the uploaded zip file.
3. Navigate to Plugins menu on your WordPress admin area.
4. Activate this plugin.

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.4.4 =
* Remove mirror option

= 1.4.3 =
* Added mirror option
* Remove remote onlystream

= 1.4.2 =
* Change our domain to hxload.to
* Added vidoza

= 1.4.1 =
* Removed uptostream/uptobox
* Add remote clipwatching
* Removed remote youtube, facebook, openload, okru, streamango, userscloud, vidoza, verystream, streamcherry

= 1.4.0 =
* Updated cache system

= 1.3.9 =
* Fixed minor bugs

= 1.3.8 =
* Updated cache system

= 1.3.7 =
* Updated plugin description 

= 1.3.6 =
* Added API description

= 1.3.5 =
* Improved api system
* Removed xvideos
* Added remote youtube, facebook, openload, okru, streamango, userscloud, fembed, vidoza, verystream, streamcherry, onlystream

= 1.3.4 =
* Fixed subtitle cache

= 1.3.3 =
* Fixed video player
* Fixed cache system
* Added remote google photos

= 1.3.2 =
* Fixed API URL

= 1.3.1 =
* Fixed domain name

= 1.3.0 =
* Added direct link remote upload via plugin

= 1.2.9 =
* Fxed response status

= 1.2.8 =
* Fxed convert option

= 1.2.7 =
* Fxed filter system

= 1.2.6 =
* Fxed API URL

= 1.2.5 =
* Fixed cache system

= 1.2.4 =
* Added & Fixed cache option

= 1.2.3 =
* Change domain name

= 1.2.2 =
* Fixed cache system

= 1.2.1 =
* Added remote rapidvideo

= 1.2.0 =
* Remove custom filter tag [play][/play]
* Remove TAG 2 as multi tag
* Added cache option

= 1.1.9 =
* Added filter response data

= 1.1.8 =
* Fixed cache system

= 1.1.7 =
* Added reload mode

= 1.1.6 =
* Fixed multi subtitle tag

= 1.1.5 =
* Added multi subtitle

= 1.1.4 =
* Improved get link method

= 1.1.3 =
* Improved cache system
* Added xvideos shortcode/filter tag
* Removed remote google photos

= 1.1.2 =
* Added TAG 2 as multi tag
* Added remote mp4upload

= 1.1.1 =
* Added remote google photos

= 1.1.0 =
* Fixed parameter for response data

= 1.0.9 =
* Added process image when load response data

= 1.0.8 =
* Removed cache form in setting, now cache system automatically load from our server

= 1.0.7 =
* Improved cache system

= 1.0.6 =
* Improved api system
* Removed post ID marker

= 1.0.5 =
* Improved cache system

= 1.0.4 =
* Fixed bug api system

= 1.0.3 =
* Fixed bug subtitle or cover generate method

= 1.0.2 =
* Fixed bug content not display for normal page

= 1.0.1 =
* Added custom filter tag [play][/play]
* Fixed name system for shortcode

= 1.0.0 =
* Official plugin release.
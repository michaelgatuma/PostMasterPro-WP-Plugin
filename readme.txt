=== PostMasterPro ===
Contributors: your_username
Tags: post, automation, fetch, publish, scheduler, cron
Requires at least: 5.2
Tested up to: 5.9
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically fetch, publish, and schedule posts from an external API with PostMasterPro.

== Description ==

PostMasterPro is a WordPress plugin designed to automate the process of fetching, publishing, and scheduling posts from an external API. With this plugin, you can:

- Configure the API endpoint to fetch posts from
- Set a schedule for fetching and publishing posts using cron
- Map API fields to your WordPress post fields, such as title, content, and categories
- Store and manage fetched posts in your WordPress database
- Acknowledge published posts with a callback request to the external API

== Installation ==

1. Upload the entire `/postmasterpro` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the PostMasterPro settings page and configure the API endpoint, authentication token, and other settings.
4. Set up a schedule for fetching and publishing posts using the WordPress cron system.

== Frequently Asked Questions ==

= How do I configure the API endpoint? =

You can configure the API endpoint and other settings in the PostMasterPro settings page in your WordPress dashboard.

= Can I map custom fields from the API to my WordPress posts? =

Yes, you can map custom fields from the API to your WordPress post fields using the settings in the PostMasterPro dashboard.

== Screenshots ==

1. PostMasterPro settings page
2. PostMasterPro dashboard with fetched and published posts

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.

=== Multisite Shared Media ===
Contributors: aikadesign
Tags: gallery, image, media, media library, multilingual, Multisite, network, replicate media, shared images, shared media, woocommerce, wordpress
Requires at least: WordPress 4.6
Tested up to: 5.2.3
Requires PHP: 5.6
License: GPL v2

Synchronise uploaded media to other network sites instantly without duplicating the file itself. Save disk space and publish faster.

== Description ==
WordPress Multisite Shared Media does just what it says: makes the uploaded media available across network. It suits perfectly for multi-language setups, and yes, it works with Featured Images and WooCommerce Product Galleries.

## Main features ##

* Enable / disable media sharing between network sites
* Enable / disable media deletion across network sites
* Replicate all existing media from main site across network
* Technical stuff: Translation ready
* Technical stuff: Only references to the media files are replicated, files are hosted centrally, resulting in savings in disk space -> hosting costs.

For more information: [https://codecanyon.net/item/wordpress-multisite-shared-media/19306250](https://codecanyon.net/item/wordpress-multisite-shared-media/19306250)

**NEW! We invite to collaborate on possible future features on our [Trello-board for WordPress Multisite Shared Media](https://trello.com/b/UiIlGba4/multisite-shared-media). Welcome join the party!**

== Installation ==
For installation instructions, please refer to our updated documentation:
https://codecanyon.net/item/wordpress-multisite-shared-media/19306250#item-description__quick-start-guide

== Frequently Asked Questions ==
For Frequently Asked Questions, please refer to the updated list:
https://codecanyon.net/item/wordpress-multisite-shared-media/19306250/support

== Changelog ==

1.3.1
Fix: Fix rewrite path where legacy UPLOADS has been defined

1.3.0
Improvement: Store flag for ignored items
Fix: Do not count ignored items in "unsynced" during replication of existing items
New: Added new filter 'msm_media_item_is_ignored' where manipulation of MSMMediaItem object no longer breaks compatibility.
New: Troubleshooting tab in Settings, where it's possible to clear "Ignored" flags from media items.

1.2.5
Fix: Fix compatibility issue with WooMultistore.

1.2.4
Compatibility: Compatible with WP 5.2.3 and PHP 7.3. Deduplication of UI logic.

1.2.3
Compatibility: Compatible with latest WP version

1.2.2
Performance: Use custom query in bulk replication to get total item count

1.2.1
Improvement: Use sitewide admin notices and transients

1.2.0
New: Implement automatic processing of plugin updates
Improvement: Inform admin when plugin has been up-/downgraded

1.1.0
New: Sharing can now be enabled/disabled per-site.
New: Bulk replication is now per source-target.
Improvement: Admin area is split to tabs.

1.0.1
Hotfix: Fix public image paths

1.0.0
New: Replicate to newly created sites
Fix: PHP notices
Tweak: Prevent removal of root uploads folder upon site deletion
Technical: Refactor plugin completely, split to smaller classes with clear responsibilities

0.6.7
Fix: PHP 5.6 compatibility

0.6.5 ... 0.6.6
Fix: Woocommerce Multistore compatibility

0.6.1 ... 0.6.4
Technical: Correct plugin header
Doc: Correct and improve documentation
Technical: Fix version control

0.6
New: Added compatibility with WooCommerce Multistore

0.5.4
Fix: issue with settings page on certain install paths

0.5.3
Fix: PHP error in plugin deactivation

0.5.2
Fix: bug in media deletion

0.5
Fix: Issue with AJAX uploads (to avoid HTTP errors)
Fix: Issue with admin scripts enqueuing (to avoid notices when debugging is on)

0.1
New: First public release
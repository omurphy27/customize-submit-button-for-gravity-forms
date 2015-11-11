=== Customize Submit Button for Gravity Forms ===
Contributors: omurphy
Tags: gravityforms, form, button
Requires at least: 4.0
Tested up to: 4.3.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lets you customize the submit button in Gravity Forms by switching it to a button element and changing its CSS classes

== Description ==

Gravity Forms already lets you customize the Submit Button under its Form Settings for each form; you can change the button's text and you can select whether the button should be an `<input>` or an `<img>` element. However, you can't add html as part of the button text and you're restricted to using either an input or image element for the button. With this plugin you can choose to use a `<button>` tag element instead, which also lets you embed HTML inside it. Moreover, this plugin also lets you conveniently change the CSS classes of the submit button.

There are plenty of use cases for adding HTML into the submit button text. For instance, if your button text is multiple words long and you'd like to bold or italicize some of them by wrapping certain words in strong or em tags. 

Likewise, there are many reasons to change the button's default CSS class. For example, GravityForms automatically adds the 'button' class, but, if you're using the Twitter Bootstrap framework, 'btn' would actually be more helpful. 

**Gravity Forms requires at least: 1.9.12.16**

**Gravity Forms tested up to: 1.9.14.19**

== Installation ==

= Automatic Installation =

Installing this plugin automatically is the easiest option. You can install the plugin automatically by going to the plugins section in WordPress and clicking Add New. Type "WooCommerce Change Product Author" in the search bar and install the plugin by clicking the Install Now button.

= Manual Installation =

To manually install the plugin you'll need to download the plugin to your computer and upload it to your server via FTP or another method. The plugin needs to be extracted in the `wp-content/plugins` folder. Once done you should be able to activate it as usual.

If you are having trouble, take a look at the [Managing Plugins](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation) section in the WordPress Codex, it has more information on this topic.

== Other Notes ==

After activating the plugin, please navigate to the form settings of the form that you wish to customize. Scroll down to the 'form button' section where, in addition to 'text' and 'image', you'll also be given 'button' as an input type option. Selecting the 'button' option will change the submit button's markup to a `<button>` element. You will also be able to embed html in the 'HTML Button Text' field. 

In the same 'form button' section under form settings, there's an input called 'Submit Button CSS Classes'. This is where you can change the CSS classes being currently used by the submit button. 

Currently you are only able to customize the submit buttons on a per form basis within the form settings and not globally.

= Please note that Gravity Forms must be installed and activated for the plugin to work. =

== Screenshots ==

1. Where to edit the form settings
2. Where to select the button input type, enter HTML in the button text and make changes to the button's CSS classes

== Changelog ==

= 1.0.0 =
* Initial Release

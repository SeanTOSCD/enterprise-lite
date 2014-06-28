=== Enterprise Lite ===

Created by Sean Davis: http://seandavis.co/ - http://buildwpyourself.com/

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



== Description ==

A fun, flexible, and professional WordPress theme designed to highlight content without sacrificing aesthetics.



== Installation ==

1. Upload `enterprise-lite` to the `/wp-content/themes/` directory
2. Activate the theme through the 'Themes' menu in WordPress
3. Use the Theme Customizer settings under "Appearance -> Customize" to adjust Enterprise Lite's settings



== Frequently Asked Questions ==

= Does this theme support child themes? =

Certainly! Here's exactly what you need to do.

1. Through FTP, navigate to `your_website/wp-content/themes/` and in that directory, create a new folder as the name of your child theme. Something like `enterprise-lite-child` is perfectly fine.

2. Inside of your new folder, create a file called `style.css` (the name is NOT optional).

3. Inside of your new `style.css` file, add the following CSS:

. . . . . . . . . . copy what's below . . . . . . . . . . . . 


	/*
		Theme Name: your_child_theme_name
		Author: your_name
		Author URI: 
		Description: Child theme for Enterprise Lite
		Template: enterprise-lite
	*/

	@import url("../enterprise-lite/style.css");

	/*--------------------------------------------------------------
	Theme customization starts here
	--------------------------------------------------------------*/


. . . . . . . . . . copy what's above . . . . . . . . . . . . 

4. You may edit all of what you pasted EXCEPT for the `Template` line as well as the `@import` line. Leave those two lines alone or the child theme will not work properly.

5. With your new child theme folder in place and the above CSS pasted inside of your `style.css` file, go back to your WordPress dashboard and navigate to "Appearance -> Themes" and locate your new theme (you'll see the name you chose). Activate your theme.

6. With your child theme activated, you can edit its stylesheet all you like. You may also create a `functions.php` file in the root of your child theme to add custom PHP.

7. Enjoy!

= Can I override template files? =

Yup. Any of the template files in the root of Enterprise can be copied to the root of your child theme (see above) and WordPress will use the child theme's file's instead. This also applies to template files inside of the `templates` folder.



== Credits ==

Enterprise Lite WordPress Theme, Copyright (C) 2014 Sean Davis - SDavis Media LLC
Enterprise Lite is distributed under the terms of the GNU GPL
Enterprise Lite is based on Underscores http://underscores.me/, (C) 2012-2014 Automattic, Inc.

Font Awesome http://fortawesome.github.io/Font-Awesome/license/
Font Awesome Licenses:
	SIL Open Font License http://scripts.sil.org/OFL 
	MIT License http://opensource.org/licenses/mit-license.html 
	CC BY 3.0 License – http://creativecommons.org/licenses/by/3.0/
Copyright: Dave Gandy, http://fontawesome.io



== Changelog ==

= 1.0.2 =
* updated theme URI

= 1.0.1 =
* moved $content_width into theme setup function
* changed theme admin page capabilities
* added missing translation function

= 1.0.0 =
* first stable version
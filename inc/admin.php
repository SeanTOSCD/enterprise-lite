<?php
/**
 * admin page
 */
define( 'ENTERPRISE_FULL_NAME', 'Enterprise' );

/***********************************************
* menu item
***********************************************/

function enterprise_license_menu() {
	add_theme_page( ENTERPRISE_NAME, ENTERPRISE_NAME, 'edit_theme_options', 'enterprise-lite', 'enterprise_admin' );
}
add_action('admin_menu', 'enterprise_license_menu');


/***********************************************
* admin styles
***********************************************/

function enterprise_admin_styles() {	
	wp_enqueue_style( 'enterprise-lite-admin-style', get_template_directory_uri() . '/assets/css/admin.css' );
}
add_action( 'admin_print_scripts-appearance_page_enterprise-lite', 'enterprise_admin_styles' );


/***********************************************
* admin page output
***********************************************/

function enterprise_admin() { ?>
	<div class="wrap upgrade-wrap">
		<h2 class="headline"><?php echo sprintf( __( 'Upgrade to the Full-Featured Version of %1$s!', 'enterprise-lite' ), ENTERPRISE_FULL_NAME ); ?></h2>
		<p>
			<?php echo sprintf(__( 'You are currently using the <strong>FREE</strong> version of %1$s. Upgrade to the full-featured version of %1$s for more customization options, additional features such as a built-in Feature Box and Post Footer, a Landing Page template and more!', 'enterprise-lite' ), ENTERPRISE_FULL_NAME	); 
			?>
		</p>
		<p><a class="cta-button" href="http://buildwpyourself.com/downloads/enterprise/" target="_blank"><?php echo sprintf( __( 'View the Full Version of %1$s', 'enterprise-lite' ), ENTERPRISE_FULL_NAME ); ?></a></p>
		<p><?php echo ENTERPRISE_NAME . __( ' users get 20% off by using Coupon Code: <strong>LITE20</strong> at checkout.', 'enterprise-lite' ); ?></p>
		<div class="screenshot">
			<img class="enterprise-screenshot" src="<?php echo ENTERPRISE_IMG . 'enterprise-full.png'; ?>" alt="Enterprise">
		</div>
	</div>
	<?php
	/*
	 * only show child theme instructions if Enterprise Lite is the active theme
	 */
	$enterprise = wp_get_theme();
	if ( $enterprise->get( 'Name' ) === 'Enterprise Lite' ) : ?>
	
		<div class="wrap child-theme-wrap">
			<h2 class="headline"><?php echo sprintf( __( 'How to Create a Child Theme for %1$s', 'enterprise-lite' ), ENTERPRISE_NAME ); ?></h2>
			<ol>
				<li><?php _e( 'Through FTP, navigate to <code>your_website/wp-content/themes/</code> and in that directory, create a new folder as the name of your child theme. Something like <code>enterprise-lite-child</code> is perfectly fine.', 'enterprise-lite' ); ?></li>
				<li><?php _e( 'Inside of your new folder, create a file called <code>style.css</code> (the name is NOT optional).', 'enterprise-lite' ); ?></li>
				<li><?php _e( 'Inside of your new <code>style.css</code> file, add the following CSS:', 'enterprise-lite' ); ?>
				
<pre class="enterprise-pre">
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
</pre>
				</li>
				<li><?php _e( 'You may edit all of what you pasted EXCEPT for the <code>Template</code> line as well as the <code>@import</code> line. Leave those two lines alone or the child theme will not work properly.', 'enterprise-lite' ); ?></li>
				<li><?php _e( 'With your new child theme folder in place and the above CSS pasted inside of your <code>style.css</code> file, go back to your WordPress dashboard and navigate to "Appearance -> Themes" and locate your new theme (you\'ll see the name you chose). Activate your theme.', 'enterprise-lite' ); ?></li>
				<li><?php _e( 'With your child theme activated, you can edit its stylesheet all you like. You may also create a <code>functions.php</code> file in the root of your child theme to add custom PHP.', 'enterprise-lite' ); ?></li>
				<li><?php _e( 'Enjoy!', 'enterprise-lite' ); ?></li>
			</ol>
		</div>
		
	<?php endif;
}
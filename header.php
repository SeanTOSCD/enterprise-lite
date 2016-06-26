<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Enterprise
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'enterprise-lite' ); ?></a>
		
		<div class="header-wrap inner">
			<header id="masthead" class="site-header site-element" role="banner">
				<div class="site-branding">
					<span class="site-title">
						<?php if ( get_theme_mod( 'enterprise_logo' ) ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img src="<?php echo get_theme_mod( 'enterprise_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							</a>
						<?php else : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						<?php endif; ?>
					</span>
					<?php if ( 1 != get_theme_mod( 'enterprise_hide_tagline' ) ) : ?>
						<h1 class="site-description"><?php bloginfo( 'description' ); ?></h1>
					<?php endif; ?>
				</div>
				
				<?php if ( ! is_page_template( 'templates/landing-page.php' ) ) : ?>
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<span class="menu-toggle"><i class="fa fa-bars"></i> <?php _e( 'Menu', 'enterprise-lite' ); ?></span>
						<?php
							wp_nav_menu( array(
								'theme_location' => 'header',
								'fallback_cb' => '__return_false'
							) );
						?>
					</nav><!-- #site-navigation -->
				<?php endif; ?>
			</header><!-- #masthead -->
		</div>
	
		<div id="content" class="site-content inner site-element">

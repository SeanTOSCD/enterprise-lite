<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Enterprise
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="archives" class="widget">
				<span class="widget-title"><?php _e( 'Archives', 'enterprise' ); ?></span>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="meta" class="widget">
				<span class="widget-title"><?php _e( 'Meta', 'enterprise' ); ?></span>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->

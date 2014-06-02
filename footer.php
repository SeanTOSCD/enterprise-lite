<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Enterprise
 */
?>

			</div><!-- #content -->
			
			<div class="footer-wrap inner">
				<footer id="colophon" class="site-footer site-element" role="contentinfo">
					<div class="site-info">
						<?php
							$site_info = get_bloginfo( 'description' ) . ' - ' . get_bloginfo( 'name' ) . ' &copy; ' . date( 'Y' );
							if ( '' != get_theme_mod( 'enterprise_credits_copyright' ) ) :
								echo get_theme_mod( 'enterprise_credits_copyright' );
							else : 
								echo $site_info;
							endif;
						?>
					</div><!-- .site-info -->
				</footer><!-- #colophon -->
			</div>
			
		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>
</html>

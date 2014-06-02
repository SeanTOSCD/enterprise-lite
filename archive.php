<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Enterprise
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author Archive: %s', 'enterprise' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'enterprise' ), '<span class="archive-element">' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'enterprise' ), '<span class="archive-element">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'enterprise' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'enterprise' ), '<span class="archive-element">' . get_the_date( _x( 'Y', 'yearly archives date format', 'enterprise' ) ) . '</span>' );

						else :
							_e( 'Archives', 'enterprise' );

						endif;
					?>
				</h1>
				<?php
					$term_description = term_description();
					$tag_description = tag_description();
					if ( is_author() ) : // show author avatar and user bio if it exists ?>
						<div class="archive-author-info">
							<span class="archive-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?></span>
							<?php if ( '' != get_the_author_meta( 'description' ) ) : ?>
								<p class="user-description"><?php echo get_the_author_meta( 'description' ); ?></p>
							<?php endif; ?>
						</div>
						<?php					
					elseif ( is_category() || is_tag() && ! empty( $tag_description ) ) : ?>
							<div class="taxonomy-description"><?php echo $term_description; ?></div>
							<?php
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'templates/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php enterprise_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'templates/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

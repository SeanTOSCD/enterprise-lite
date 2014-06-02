<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Enterprise
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/content', 'single' ); ?>

			<?php 'post' == get_post_type() ? enterprise_post_nav() : ''; ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php is_single() && 'post' != get_post_type() ? get_sidebar() : ''; // only remove sidebar on *standard* posts ?>
<?php get_footer(); ?>
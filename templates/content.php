<?php
/**
 * @package Enterprise
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta-feed">
			<?php enterprise_posted_on(); ?>
		</div>
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_archive() || 1 == get_theme_mod( 'enterprise_post_content' ) ) : ?>
	<div class="entry-summary">
		<?php
			// display featured image
			if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'enterprise_featured_image', array( 'class' => 'featured-img' ) ); ?>
				</a>
				<?php
			endif;
			// output the excerpt
			the_excerpt();
		?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">			
		<?php
			// display featured image
			if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'enterprise_featured_image', array( 'class' => 'featured-img' ) ); ?>
				</a>
				<?php
			endif;
			// output the content
			the_content( get_theme_mod( 'enterprise_read_more', __( 'Continue reading', 'enterprise-lite' ) ) . '<i class="fa fa-caret-right"></i>' );
			// break into pages
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'enterprise-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'enterprise-lite' ) );
				if ( $categories_list && enterprise_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php echo '<i class="fa fa-archive"></i>' . $categories_list; ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'enterprise-lite' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php echo '<br><i class="fa fa-tags"></i>' . $tags_list; ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

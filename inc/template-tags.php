<?php
/**
 * Enterprise template tags
 *
 * @package Enterprise
 */


if ( ! function_exists( 'enterprise_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function enterprise_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'enterprise' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( '<i class="fa fa-caret-left"></i> ' . __( 'Older posts', 'enterprise' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'enterprise' ) . ' <i class="fa fa-caret-right"></i>' ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'enterprise_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function enterprise_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'enterprise' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous"><span class="post-nav-title">Previous Post:</span> %link</div>', _x( '%title', 'Previous post link', 'enterprise' ) );
				next_post_link( '<div class="nav-next"><span class="post-nav-title">Next Post:</span> %link</div>', _x( '%title', 'Next post link',     'enterprise' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'enterprise_posted_by' ) ) :
/**
 * Prints HTML with author information for the current post
 */
function enterprise_posted_by() {	
	printf(
		'<span class="byline">%1$s',
		get_avatar( get_the_author_meta( 'ID' ), 48 )
	);
	printf( ' by %1$s</span>',
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;


if ( ! function_exists( 'enterprise_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function enterprise_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( '<span class="posted-on"><i class="fa fa-calendar"></i> ' . __( '%1$s', 'enterprise' ) . '</span>',
		sprintf( '%2$s',
			esc_url( get_permalink() ),
			$time_string
		)
	);
	
	echo ! is_single() && strlen( get_the_title() ) == 0 ? '<a href="' . esc_url( get_permalink() ) . '"><i class="fa fa-link"></i></a>' : '';
}
endif;


if ( !function_exists( 'enterprise_comment_template' ) ) :
/**
 * Used as a custom callback by wp_list_comments() for displaying
 * the comments and pings.
 */
function enterprise_comment_template( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$avatar_size = apply_filters( 'avatar_size', 48 );

	switch ( $comment->comment_type ) {

		// Pings format
		case 'pingback' :
		case 'trackback' : ?>
			<div class="pingback">
				<span>
					<?php
						echo __( 'Pingback: ', 'enterprise'),
						comment_author_link(),
						edit_comment_link( __(' (Edit) ', 'enterprise') ); 
					?>
				</span>
			<?php 
			break;

		// Comments format	
		default : ?>
			<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment-full">
					<footer class="comment-footer">
						<div class="comment-author vcard">
							<div class="comment-avatar">
								<?php echo get_avatar( $comment, $avatar_size ); ?>
							</div>
						</div>
						<?php
							if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'enterprise' ); ?></em><br /> 
								<?php
							endif;
						?>
						<div class="comment-meta commentmetadata">
							<cite class="fn"><?php echo __( 'by ', 'enterprise' ) . get_comment_author_link(); ?></cite>
							<span class="comment-date">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>"><?php echo get_comment_date(); // translators: 1: date, 2: time ?></time>
								</a>
								<?php edit_comment_link( __( ' (Edit) ', 'enterprise' ) ); ?>
							</span>
						</div>
					</footer>
					<div class="comment-content"> 
						<?php comment_text(); ?>
					</div>
					<div class="reply">
						<?php 
							comment_reply_link(
								array_merge( $args, array(
									'reply_text'	=> '<i class="fa fa-reply"></i> ' . __( 'Reply', 'enterprise' ),
									'depth'			=> $depth, 
									'max_depth'		=> $args['max_depth'],
								) )
							);
						?>
					</div>
				</article>
			<?php
			break;
	}
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function enterprise_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'enterprise_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'enterprise_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so enterprise_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so enterprise_categorized_blog should return false.
		return false;
	}
}


/**
 * Flush out the transients used in enterprise_categorized_blog.
 */
function enterprise_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'enterprise_categories' );
}
add_action( 'edit_category', 'enterprise_category_transient_flusher' );
add_action( 'save_post',     'enterprise_category_transient_flusher' );

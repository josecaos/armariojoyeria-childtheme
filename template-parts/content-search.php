<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tyche-blog-post' ); ?>>
	<header class="entry-header">
		<div class="tyche-blog-meta">
			<?php Tyche_Helper::post_meta(); ?>
		</div>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<img src="<?php echo wp_get_attachment_image_src( $attachment_ids[0], 'small')?>" alt="">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

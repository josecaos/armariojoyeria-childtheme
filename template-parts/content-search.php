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
		<?php
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'small' );
		?>
		<div class="col-md-3 col-lg-2">
			<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $loop->post->ID; ?>">
		</div>
			<hr>
			<div class="col-md-9 col-lg-10">
			<?php the_excerpt(); ?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

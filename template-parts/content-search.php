<?php
/**
* Template part for displaying results in search pages.
*
* @link    https://codex.wordpress.org/Template_Hierarchy
*
* @package Tyche
*/

global $product
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tyche-blog-post' ); ?>>
	<header class="entry-header">
		<div class="tyche-blog-meta">
			<?php //Tyche_Helper::post_meta(); ?>
			<?php echo get_the_post_title(); ?>
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
			<div id="product-description-container" style="border:2px dashed green;">
  <ul>
  <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
    <li><h4><?php echo $product->get_title(); ?></h4></li></a>
    <li><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt )?></li>
    <li><h6><?php echo $product->get_price_html(); ?>  **MISSING CODE TO ADD TO CART BUTTON HERE**</h6></li>
 </ul>
</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

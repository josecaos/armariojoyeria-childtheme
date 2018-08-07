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

			<!--  -->
			<div id="product-description-container" style="border:2px dashed green;">
				<ul>
					<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
						<li><h4><?php echo $product->get_title(); ?></h4></li></a>
						<li><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt )?></li>
						<li><h6><?php echo $product->get_price_html();

						echo apply_filters( 'woocommerce_loop_add_to_cart_link',
						sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( $product->id ),
						esc_attr( $product->get_sku() ),
						$product->is_purchasable() ? 'add_to_cart_button' : '',
						esc_attr( $product->product_type ),
						esc_html( $product->add_to_cart_text() )
					),
					$product );

					?>
				</h6></li>
			</ul>
		</div>
		<!--  -->
	</div>
</div><!-- .entry-content -->
</article><!-- #post-## -->

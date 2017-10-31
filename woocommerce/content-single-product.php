<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div class="container">
<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
</div>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-7">
				<div class="single-product-image">
					<?php
						/**
						 * woocommerce_before_single_product_summary hook
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action( 'woocommerce_before_single_product_summary' );
					?>
				</div>

			</div>
			<div class="col-xs-12 col-md-5">
				<div class="summary entry-summary single-product-info">
					<div class="product-nav">
						<div class="next-prev">
							<div class="prev"><?php previous_post_link('%link'); ?></div>
							<div class="next"><?php next_post_link('%link'); ?></div>
						</div>
					</div>

					<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
					?>
					<div class="single-product-sharing">
						<?php
						if(function_exists('chamo_product_sharing')) {
							chamo_product_sharing();
						} ?>
					</div>

				</div><!-- .summary -->
			</div>
		</div>
	</div>

	<div class="container">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
		
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</div><!-- #product-<?php the_ID(); ?> -->
<?php do_action('woocommerce_show_related_products');

//dynamic_sidebar( 'sidebar-product' ); ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>

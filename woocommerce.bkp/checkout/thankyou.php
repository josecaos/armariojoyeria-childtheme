<?php
/**
* Thankyou page
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     2.2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( $order ) : ?>
<div class="checkout-done">
	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'chamo' ); ?></p>

		<p><?php
		if ( is_user_logged_in() )
		_e( 'Please attempt your purchase again or go to your account page.', 'chamo' );
		else
		_e( 'Please attempt your purchase again.', 'chamo' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'chamo' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php esc_html_e( 'My Account', 'chamo' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'chamo' ), $order ); ?></p>

		<ul class="order_details order_summary">
			<li class="order">
				<?php esc_html_e( 'Order:', 'chamo' ); ?>
				<strong><?php echo ''.$order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php esc_html_e( 'Date:', 'chamo' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php esc_html_e( 'Total:', 'chamo' ); ?>
				<strong><?php echo ''.$order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
				<li class="method">
					<?php esc_html_e( 'Payment method:', 'chamo' ); ?>
					<strong><?php echo ''.$order->payment_method_title; ?></strong>
				</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'chamo' ), null ); ?></p>

	<!-- VI agregado  -->
	<!-- <img src="//cdsusa.veinteractive.com/DataReceiverService.asmx/Pixel?journeycode=369D5BF8-AB57-4A3D-BAB3-5AA69878B604" width="1" height="1"/> -->
	<!--  -->

</div>
<?php endif; ?>

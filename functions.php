<?php
// php armariojoyeria custom
 function armariojoyeria_scripts() {
	// estilos
	wp_enqueue_style( 'armariojoyeria-child', get_stylesheet_directory_uri() . '/css/armariojoyeria_custom.css', array('chamocss-responsive'), '1.0.0' );
// js custom
  wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/js/armariojoyeria_custom.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'armariojoyeria_scripts' );

//
// Opcion de empaque para regalo en el checkout
// dos empaques chico y grande
add_action( 'woocommerce_checkout_before_order_review', 'add_box_option_to_checkout' );
function add_box_option_to_checkout( $checkout ) {
    echo '<h4 class="titulo-empaque">Empaque regalo: </h4><div class="checkbox-envoltura">';

    woocommerce_form_field( 'checkbox_caja_chica', array(
        'type'          => 'checkbox',
        'class'         => array('checkbox_caja_chica'),
        'label'         => __('Chico + $25.00'),
      ));
      echo '</div>';

      echo '<div class="checkbox-envoltura">';
    woocommerce_form_field( 'checkbox_caja_grande', array(
        'type'          => 'checkbox',
        'class'         => array('checkbox_caja_grande'),
        'label'         => __('Grande + $50.00'),
      ));

        echo '</div>';
}
// detecta el evento
add_action( 'wp_footer', 'woocommerce_add_gift_box' );
function woocommerce_add_gift_box() {
    if (is_checkout()) {
    ?>
    <script type="text/javascript">
    jQuery( document ).ready(function( $ ) {
        jQuery('#checkbox_caja_chica, #checkbox_caja_grande').click(function(){
            jQuery('body').trigger('update_checkout');
        });

    });
    </script>
    <?php
    }
}
//aplica el valor
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
        if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // non-ajax
    }

    if (isset($post_data['checkbox_caja_chica'])) {
        $extracost = 25; //
        WC()->cart->add_fee( 'Empaque chico:', $extracost );
    } else if (isset($post_data['checkbox_caja_grande'])) {
      $extracost = 50;
      WC()->cart->add_fee( 'Empaque grande:', $extracost );
    }

}

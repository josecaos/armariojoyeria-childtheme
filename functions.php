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
//
add_action( 'woocommerce_checkout_before_order_review', 'checkbox_regalo' );
// add_action( 'woocommerce_before_checkout_form', 'checkbox_regalo' );
function checkbox_regalo( $checkout ) {
  echo '<div class="modulo-caja">
  <h3 class="titulo-empaque">
    <i class="fa fa-dropbox"></i>&nbsp;¿Lo quieres para Regalo?
  </h3>
  <div class="checkbox-envoltura">
    <div class="thumb-regalo">
      <img src="' . get_stylesheet_directory_uri() .'/img/caja-regalo-grande.jpg" / >
    </div>';
  woocommerce_form_field( 'checkbox_caja_grande', array(
    'type'          => 'checkbox',
    'class'         => array('checkbox_caja_grande'),
    'label'         => __('Para collares, dijes ,cadenas y pulseras (10cm x 10cm)'),
  ));
  woocommerce_form_field( 'cantidad_caja_grande', array(
    'type'          => 'number',
    'class'         => array('cantidad_caja_grande'),
    'label'         => __('$30.00 c/u cantidad:'),
  ));

  echo '</div>
  <div class="checkbox-envoltura">
  <div class="thumb-regalo">
  <img src="' . get_stylesheet_directory_uri() .'/img/caja-regalo-chico.jpg" / >
  </div>';

  woocommerce_form_field( 'checkbox_caja_chica', array(
    'type'          => 'checkbox',
    'class'         => array('checkbox_caja_chica'),
    'label'         => __('Para anillos, piedras, charms, aretes (5cm x 5cm)'),
  ));
  woocommerce_form_field( 'cantidad_caja_chica', array(
    'type'          => 'number',
    'class'         => array('cantidad_caja_chica'),
    'label'         => __('$20.00 c/u cantidad:'),
  ));
  echo '</div>
  </div>';
}
// detecta el evento
add_action( 'wp_footer', 'agrega_evento' );
function agrega_evento() {
  if (is_checkout()) {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      // caja chica
      jQuery('#cantidad_caja_chica').attr('min',1).attr('max',15).attr('value',1);
      jQuery('#checkbox_caja_chica').click(function(){
        // jQuery('#checkbox_caja_grande').attr('checked', false);
        jQuery('body').trigger('update_checkout');
      });
      jQuery('#cantidad_caja_chica').on('change',function(){
        jQuery('body').trigger('update_checkout');
      });
      // caja grande
      jQuery('#cantidad_caja_grande').attr('min',1).attr('max',15).attr('value',1);
      jQuery('#checkbox_caja_grande').click(function(){
        // $('#checkbox_caja_chica').attr('checked', false);
        jQuery('body').trigger('update_checkout');
      });
      jQuery('#cantidad_caja_grande').on('change',function(){
        jQuery('body').trigger('update_checkout');
      });
      //
      //
    });
    </script>
    <?php
  }
}
//aplica el valor
add_action( 'woocommerce_cart_calculate_fees', 'agrega_datos' );
function agrega_datos( $cart ){
  if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
    return;
  }

  if ( isset( $_POST['post_data'] ) ) {
    parse_str( $_POST['post_data'], $post_data );
  } else {
    $post_data = $_POST; // non-ajax
  }

  if (isset($post_data['checkbox_caja_chica'])) {

    $small_quant = $post_data['cantidad_caja_chica'];
    $smallcost = 20 * $small_quant; //
    WC()->cart->add_fee($small_quant . ' Caja(s) de regalo chico', $smallcost );
  }

  if (isset($post_data['checkbox_caja_grande'])) {
    $large_quant = $post_data['cantidad_caja_grande'];
    $largecost = 30 * $large_quant;
    WC()->cart->add_fee($large_quant . ' Caja(s) de regalo grande', $largecost );
  }

}
echo vardump($_POST);
// Oferta 3x2
// WooCommerce Dynamic Pricing & Discounts
// Aplicar oferta 3x2 a un producto determinado
add_filter( 'woocommerce_cart_item_subtotal', 'aplicar_oferta_3x2', 10, 3 );
function aplicar_oferta_3x2( $subtotal, $cart_item, $cart_item_key ){

    $ofertaFinal = $subtotal;
    $cantidad = $cart_item[ 'quantity' ];
    echo var_dump($ofertaFinal);
    echo var_dump($cantidad);

    if ( ( $cart_item[ 'product_id' ] === 4696 ) && ( $cantidad >= 3 ) ) {

        $precioProducto = $cart_item[ 'data' ]->get_price();
        $precioProductoImpuestoIncl = $cart_item[ 'data' ]->get_price_including_tax();
        $descuento = floor( $cantidad / 3 ) * $precioProducto;
        $descuentoImpuestoIncl = floor( $cantidad / 3 ) * $precioProductoImpuestoIncl;

        // Calcula oferta para configuración de impuestos activa
        if ( WC()->cart->tax_display_cart == 'excl' ) {

            $oferta = $cart_item[ 'data' ]->get_price_excluding_tax( $cantidad ) - $descuento;
            $ofertaFinal = wc_price( $oferta );

            if ( WC()->cart->prices_include_tax && WC()->cart->tax_total > 0 ) {
                $ofertaFinal .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
            }
        } else {

            $oferta = $cart_item[ 'data' ]->get_price_including_tax( $cantidad ) - $descuentoImpuestoIncl;
            $ofertaFinal = wc_price( $oferta );

            if ( ! WC()->cart->prices_include_tax && WC()->cart->tax_total > 0 ) {
                $ofertaFinal .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
            }
        }

        // Actualiza subtotal del carrito
        if ( WC()->cart->tax_display_cart == 'excl' ) {

            WC()->cart->subtotal_ex_tax = WC()->cart->subtotal_ex_tax - $descuento;
        }else{

            WC()->cart->subtotal = WC()->cart->subtotal - $descuentoImpuestoIncl;
        }
        // Actualiza total del carrito
        WC()->cart->total = WC()->cart->total - $descuentoImpuestoIncl;
    }

    return $ofertaFinal;
}

// Actualiza los impuestos después de aplicar la oferta
add_filter( 'woocommerce_cart_tax_totals', 'actualiza_impuestos_aplicados', 10, 2 );
function actualiza_impuestos_aplicados( $tax_totals, $cartObject ){

    $impuestosDesc = 0;
    foreach ( $cartObject->get_cart() as $cart_item_key => $cart_item ){

        if ( ( $cart_item[ 'product_id' ] === 4696 ) && ( $cart_item[ 'quantity' ] >= 3 ) ) {

            $impuestosDesc = ( $cart_item[ 'data' ]->get_price_including_tax() - $cart_item[ 'data' ]->get_price_excluding_tax() ) * floor( $cart_item[ 'quantity' ] / 3 );
        }
    }
    // Aplica descuento al desglose de impuestos mostrado debajo del total del carrito
    $newTaxTotal = current( $tax_totals );
    $clave = key( $tax_totals );
    $newTaxTotal->amount -= $impuestosDesc;
    $newTaxTotal->formatted_amount = wc_price( $newTaxTotal->amount );

    $tax_totals[ $clave ] = $newTaxTotal;

    return $tax_totals;
}

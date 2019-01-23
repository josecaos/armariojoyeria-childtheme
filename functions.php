<?php
// php armariojoyeria custom
function armariojoyeria_scripts() {
  // estilos
  wp_enqueue_style( 'armariojoyeria-child', get_stylesheet_directory_uri() . '/assets/css/armariojoyeria_custom.css', array(''), '1.0.0' );
  // js custom
  wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/assets/js/armariojoyeria_custom.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'armariojoyeria_scripts' );

// Limite de numero de tags en widget
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'custom_woocommerce_tag_cloud_widget' );
function custom_woocommerce_tag_cloud_widget() {
  $args = array(
    'number' => 13,
    'taxonomy' => 'product_tag',
    'orderby' => 'rand',
  );
  return $args;
}

//remueve woocomerce breadcrumbs
add_action( 'init', 'remove_wc_breadcrumbs' );
function remove_wc_breadcrumbs() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
// texto agrega a carrito
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text() {
  global $product;

  $product_type = $product->product_type;

  switch ( $product_type ) {
    case 'external':
    return __( 'Comprar', 'woocommerce' );
    break;
    case 'grouped':
    return __( 'Ver todos', 'woocommerce' );
    break;
    case 'simple':
    return __( 'Agrega a carrito', 'woocommerce' );
    break;
    case 'variable':
    return __( 'Ver opciones', 'woocommerce' );
    break;
    default:
    return __( 'Conoce más', 'woocommerce' );
  }
}

// sticker fuera de stock
//Add an out of stock overlay to product images when all variations are unavailable
add_action( 'woocommerce_before_shop_loop_item_title', function() {
global $product;
if ( !$product->is_in_stock() ) {
echo '<span class="sold-out">Sin Existencias</span>';
}
});
//

// Empaque para regalo en el carrito
// dos empaques chico y grande
//
add_action( 'woocommerce_checkout_before_order_review', 'checkbox_regalo' );
function checkbox_regalo( $checkout ) {
  echo '<div class="modulo-caja container">
  <h3 class="titulo-empaque">
  <i class="fa fa-dropbox"></i>&nbsp;¿Lo quieres para Regalo?
  </h3>
  <div class="checkbox-envoltura col-sm-12 col-md-6">
  <div class="thumb-regalo">
  <img src="' . get_stylesheet_directory_uri() .'/assets/img/caja-regalo-grande.jpg" / >
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
  <div class="checkbox-envoltura col-sm-12 col-md-6">
  <div class="thumb-regalo">
  <img src="' . get_stylesheet_directory_uri() .'/assets/img/caja-regalo-chico.jpg" / >
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
      jQuery('#checkbox_caja_chica').on('click',function() {
        // jQuery('#checkbox_caja_grande').attr('checked', false);
        jQuery('body').trigger('update_checkout');
      });
      jQuery('#cantidad_caja_chica').on('change',function() {
        jQuery('body').trigger('update_checkout');
      });
      // caja grande
      jQuery('#cantidad_caja_grande').attr('min',1).attr('max',15).attr('value',1);
      jQuery('#checkbox_caja_grande').on('click',function() {
        // $('#checkbox_caja_chica').attr('checked', false);
        jQuery('body').trigger('update_checkout');
      });
      jQuery('#cantidad_caja_grande').on('change',function() {
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
function agrega_datos(){
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

// 3X2
// Hook before calculate fees - "Buy X get cheapest free" coupon
add_action('woocommerce_cart_calculate_fees' , 'cupon3x2');

/**
* Add discount for "Buy 3 get cheapest free" coupon
* @param WC_Cart $cart
*/

function cupon3x2( WC_Cart $cart ){

  // los cupones en array
  $promo_cupons = array('3x2NAVIDAD','3x2navidad');

  // cantidad de objetos a comprar
  if( $cart->cart_contents_count < 3 ) {
    return;
  } $applied_coupons = $cart->get_applied_coupons();
  $matches = array_intersect($promo_cupons, $applied_coupons);

  // pasa, si no existe el cupon
  if (empty($matches)) return;

  // itera el carrito y encuentra el mas barato
  foreach ( $cart->get_cart() as $cart_item_key => $values ) {
    $_product = $values['data'];
    $product_price[] = $_product->get_price_including_tax();
  }

  $cheapest = min($product_price);

  $cart->add_fee( 'Cupón: El tercer más barato es gratis', -$cheapest);
}

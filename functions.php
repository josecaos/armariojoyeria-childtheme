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
        'number' => 15,
        'taxonomy' => 'product_tag',
        'orderby' => 'rand',
    );
    return $args;
}

// Opcion de empaque para regalo en el checkout
// dos empaques chico y grande
//
add_action( 'woocommerce_checkout_before_order_review', 'checkbox_regalo' );
// add_action( 'woocommerce_before_checkout_form', 'checkbox_regalo' );
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

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
  <h3 class="titulo-empaque"><i class="fa fa-dropbox"></i>&nbsp;¿Lo quieres para Regalo?</h3>
  <div class="checkbox-envoltura">
  <div class="thumb-regalo">
  <img src="' . get_stylesheet_directory_uri() .'/img/caja-regalo-grande.jpg" / >
  </div>';
  woocommerce_form_field( 'checkbox_caja_grande', array(
    'type'          => 'checkbox',
    'class'         => array('checkbox_caja_grande'),
    'label'         => __('Para collares, dijes ,cadenas y pulseras (10cmX10cm) + $30.00 c/u'),
  ));

  echo '</div>
  <div class="checkbox-envoltura">
    <div class="thumb-regalo">
      <img src="' . get_stylesheet_directory_uri() .'/img/caja-regalo-chico.jpg" / >
    </div>';

  woocommerce_form_field( 'checkbox_caja_chica', array(
    'type'          => 'checkbox',
    'class'         => array('checkbox_caja_chica'),
    'label'         => __('Para anillos, piedras, charms, aretes (5cm X 5cm)'),
  ));
  woocommerce_form_field( 'cantidad_caja_chica', array(
    'type'          => 'number',
    'class'         => array('cantidad_caja_chica'),
    'label'         => __('Cantidad: $15.00 c/u'),
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
        jQuery('#checkbox_caja_grande').attr('checked', false);
        jQuery('body').trigger('update_checkout');
      });
      jQuery('#cantidad_caja_chica').on('change',function(){
        jQuery('body').trigger('update_checkout');
      });
      // caja grande
      jQuery('#checkbox_caja_grande').click(function(){
        $('#checkbox_caja_chica').attr('checked', false);
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

    $cantidad = $post_data['cantidad_caja_chica'];
    $extracost = 15 * $cantidad ; //
    // $extracost = 15;
    WC()->cart->add_fee($cantidad . ' Caja(s) de regalo chico', $extracost );
    // var_dump($_POST);
  } else if (isset($post_data['checkbox_caja_grande'])) {

    $extracost = 30;
    WC()->cart->add_fee( 'Caja regalo grande', $extracost );
  }

}

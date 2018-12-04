<?php
/*
Template Name: Ofertas ArmarioJoyeria
*/
get_header();
?>
<div class="container-fluid">

  <ul class="col products">

    <?php
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => 20,
      'meta_query'     => array(
      'relation' => 'OR',
      'post__in' => wc_get_product_ids_on_sale(),
        array( // Simple products type
          'key'           => '_sale_price',
          'value'         => 0,
          'compare'       => '>',
          'type'          => 'numeric'
        ),
        array( // Variable products type
          'key'           => '_min_variation_sale_price',
          'value'         => 0,
          'compare'       => '>',
          'type'          => 'numeric'
        )
      )
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
      while ( $loop->have_posts() ) : $loop->the_post();
      ?>

      <div class="sale-item col-12 col-sm-6 col-lg-3">


        <?php
        woocommerce_get_template_part( 'content', 'product' );
        ?>

      </div>


      <?php

    endwhile;
  } else {
    echo __( 'No products found' );
  }
  wp_reset_postdata();
  ?>
</ul>
</div>

<?php get_footer(); ?>
<!-- WooCommerce On-Sale Products -->

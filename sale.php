<?php
/*
Template Name: Ofertas ArmarioJoyeria
*/
get_header();
?>
<div class="container-fluid">

  <h1 class="col text-center">Nuestras ofertas</h1>

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

      <div class="sale-item col-12 col-sm-6 col-lg-4">


        <?php
        woocommerce_get_template_part( 'content', 'product' );
        ?>

      </div>


      <?php

    endwhile;
    // the_posts_pagination(
    //   array(
    //     'prev_text' => '<span class="pagination-arrow-container"><span class="fa fa-long-arrow-left"></span> ' . esc_html__( 'PREV', 'tyche' ) . '</span>',
    //     'next_text' => '<span class="pagination-arrow-container">' . esc_html__( 'NEXT', 'tyche' ) . ' <span class="fa fa-long-arrow-right"></span></span>',
    //   )
    // );

  } else {
    echo __( 'No products found' );
  }
  wp_reset_postdata();


  ?>
</ul>

<nav>
  <ul>
    <li><?php previous_posts_link( '&laquo; PREV', $loop->max_num_pages) ?></li>
    <li><?php next_posts_link( 'NEXT &raquo;', $loop->max_num_pages) ?></li>
  </ul>
</nav>

</div>

<?php get_footer(); ?>
<!-- WooCommerce On-Sale Products -->

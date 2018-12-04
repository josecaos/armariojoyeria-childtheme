<?php
/*
Template Name: Ofertas ArmarioJoyeria
*/
get_header();
?>
<!-- WooCommerce On-Sale Products -->
<ul class="products">
    <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'meta_query'     => array(
                    'relation' => 'OR',
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
                woocommerce_get_template_part( 'content', 'product' );
            endwhile;
        } else {
            echo __( 'No products found' );
        }
        wp_reset_postdata();
    ?>
</ul>

<?php get_footer(); ?>
<!-- WooCommerce On-Sale Products -->

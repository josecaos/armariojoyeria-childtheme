<?php
//Template Name: Inicio Armario Joyeria

get_header();

$breadcrumbs_enabled = get_theme_mod( 'tyche_enable_post_breadcrumbs', true );

if ( $breadcrumbs_enabled ) { ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php Tyche_Helper::add_breadcrumbs(); ?>
			</div>
		</div>
	</div>
<?php } ?>

<?php
// $shop_page    = Tyche_Helper::has_sidebar();
// $account_page = false;
// if ( class_exists( 'WooCommerce' ) ) {
// 	$account_page = is_account_page();
}
?>
	<div class="contenedor_armario container">
		<div class="row">
			<div id="primary" class="primary_armario content-area col-12">
				<main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) :
						the_post();


						get_template_part( 'template-parts/content', 'page' );

						echo "DEBUG PAGINA INICIO JOYERIA";

						// If comments are open or we have at least one comment, load up the comment template.
						// if ( comments_open() || get_comments_number() ) :
						// 	comments_template();
						// endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
			// if ( $shop_page ) {
			// 	if ( ! $account_page ) {
			// 		//get_sidebar( 'shop' );
			// 	}
			// } else {
			// 	// get_sidebar();
			// }
			?>
		</div>
	</div>
<?php
get_footer();

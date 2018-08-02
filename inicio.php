<?php
//Template Name: Inicio Armario Joyeria
$filepath = str_replace(get_option('template'), get_option('stylesheet'), __FILE__);
if (file_exists($filepath)) {include($filepath); return;}

get_header();

?>
	<div class="contenedor_armario container">
		<div class="row">
			<div id="primary" class="primary_armario content-area col-12">
				<main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) :
						the_post();


						get_template_part( 'template-parts/content', 'page' );

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div>
	</div>
<?php
get_footer();

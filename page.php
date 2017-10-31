<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */
$chamo_opt = get_option( 'chamo_opt' );

get_header();
?>
<div class="main-container default-page">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<?php Chamo::chamo_breadcrumb(); ?>
			</div>


		</div>
	</div>
	<div class="clearfix"></div>
	<div class="container">
		
		<div class="row">
			<?php if( $chamo_opt['sidebarse_pos']=='left'  || !isset($chamo_opt['sidebarse_pos']) ) :?>
				<?php get_sidebar('page'); ?>
			<?php endif; ?>
			<div class="col-xs-12 <?php if ( is_active_sidebar( 'sidebar-page' ) ) : ?>col-md-9<?php endif; ?>">
				<div class="page-content default-page">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'page' ); ?>
						<?php comments_template( '', true ); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<?php if( $chamo_opt['sidebarse_pos']=='right' ) :?>
				<?php get_sidebar('page'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
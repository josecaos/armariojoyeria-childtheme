<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */
$chamo_opt = get_option( 'chamo_opt' );

get_header('error');

?>
	<div class="main-container error404">
			<div class="search-form-wrapper">
				<h1><?php esc_html_e( '404', 'chamo' ); ?></h1>
				<h4><?php esc_html_e('This is not the web page you are looking for', 'chamo'); ?></h4>
				<div class="link-wrapper">
					<p class="home-link"><?php esc_html_e( 'Please try one of the following pages ', 'chamo' ); ?></p>
					<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_html_e( 'Back to home', 'chamo' ); ?>"><?php esc_html_e( 'Home page', 'chamo' ); ?></a>
				</div>
				<?php get_search_form(); ?>
				<p class="copyright">
					<?php 
					if( isset($chamo_opt['copyright']) && $chamo_opt['copyright']!='' ) {
						echo wp_kses($chamo_opt['copyright'], array(
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						));
					} else {
						echo 'Copyright <a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a> '.date('Y').'. All Rights Reserved';
					}
					?>
				</p>
			</div>
	</div>
</div>
<?php get_footer('error'); ?>
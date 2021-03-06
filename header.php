<?php
/**
* The header for our theme.
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
*
* @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Tyche
*/
F
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K4WJQMN');</script>
<!-- End Google Tag Manager -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1407055999305968');
	fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1407055999305968&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- rebajas floating button -->
	<div id="sale_floating" class="text-center hidden">
		<a href="https://armariojoyeria.com/rebajas">
			<i class="fa fa-gift"></i> Rebajas
		</a>
	</div>
	<!--  -->

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K4WJQMN"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<div id="page" class="site">
			<?php
			/**
			* Enable / Disable the top bar
			*/
			if ( get_theme_mod( 'tyche_enable_top_bar', true ) ) :
				get_template_part( 'template-parts/top-header' );
			endif;
			?>
			<header id="masthead" class="site-header" role="banner">
				<div class="site-branding container">
					<div class="row">
						<div class="col-sm-4 header-logo">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
								else :
									?>
									<div class="site-title-description">
										<?php
										$header_textcolor = get_theme_mod( 'header_textcolor' );
										if ( 'blank' !== $header_textcolor ) :
											?>
											<a class="site-title" href="<?php echo esc_url( get_home_url() ); ?>">
												<?php Tyche_Helper::customize_partial_blogname(); ?>
											</a>
											<?php
											$description = get_bloginfo( 'description', 'display' );
											if ( $description || is_customize_preview() ) :
												?>
												<p class="site-description"> <?php Tyche_Helper::customize_partial_blogdescription(); ?> </p>
											<?php endif; ?>

										<?php endif; ?>
									</div>
									<?php
								endif;
								?>
							</div>

							<?php if ( get_theme_mod( 'tyche_show_banner', false ) ) : ?>
								<div class="col-sm-8 header-banner">
									<?php
									$banner = get_theme_mod( 'tyche_banner_type', 'image' );
									get_template_part( 'template-parts/banner/banner', $banner );
									?>
								</div>
							<?php endif; ?>
						</div>
					</div><!-- .site-branding -->

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<?php
									wp_nav_menu(
										array(
											'menu'           => 'primary',
											'theme_location' => 'primary',
											'depth'          => 10,
											'container'      => '',
											'menu_id'        => 'desktop-menu',
											'menu_class'     => 'sf-menu',
											'fallback_cb'    => 'Tyche_Navwalker::fallback',
											'walker'         => new Tyche_Navwalker(),
										)
									);
									?>
									<!-- /// Mobile Menu Trigger //////// -->
									<a href="#" id="mobile-menu-trigger"> <i class="fa fa-bars"></i> </a>
									<!-- end #mobile-menu-trigger -->
								</div>

							</div>
						</div>
					</nav><!-- #site-navigation -->

				</header><!-- #masthead -->

				<?php
				/**
				* Enable / Disable the main slider
				*/
				$show_on_front = get_option( 'show_on_front' );
				if ( get_theme_mod( 'tyche_enable_main_slider', true ) && is_front_page() && 'posts' !== $show_on_front ) :
					get_template_part( 'template-parts/main-slider' );
				endif;
				?>

				<div class="site-content container">

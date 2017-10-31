<?php
$_SESSION["preset"] = 3;
/**
 * Template Name: Demo Third
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php $chamo_opt = get_option( 'chamo_opt' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
if(isset($chamo_opt['opt-favicon']) && $chamo_opt['opt-favicon']!="") { 
	if(is_ssl()){
		$chamo_opt['opt-favicon'] = str_replace('http', 'https', $chamo_opt['opt-favicon']);
	}
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($chamo_opt['opt-favicon']['url']);?>">
<?php } ?>
<?php wp_head(); ?>
<style type="text/css">
	/*change icon for preset*/
	.header-container.layout3 .widget_shopping_cart:hover .cart-toggler:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -622px -304px no-repeat;
	}
	.wrapper .slick-slider button.slick-prev:hover:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -310px -310px no-repeat;
	}
	.wrapper .slick-slider button.slick-next:hover:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -382px -310px no-repeat;
	}
	.wrapper .carouseltype2 .slick-slider button.slick-prev:hover:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -175px -303px no-repeat;
	}
	.wrapper .carouseltype2 .slick-slider button.slick-next:hover:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -237px -303px no-repeat;
	}
	.home-product-list.layout3 .slick-slider button.slick-prev:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -310px -310px no-repeat;
	}
	.home-product-list.layout3 .slick-slider button.slick-next:before {
		background: url(../wp-content/themes/chamo/images/chamo-icon.png) -382px -310px no-repeat;
	}
</style>

</head>

<body <?php body_class('home'); ?>>
	<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
	<div class="wrapper">
		<div class="page-wrapper">
			<div class="header-container layout3">
				<div class="header">
					<div class="header-inner">
						<div class="top-bar">
							<div class="container">
								<div class="top-navigation">
									<div class="vmenu-toggler">
										<div class="vmenu-toggler-button">
											<a href="#"><?php esc_html_e('My account', 'chamo'); ?><i class="fa fa-angle-down"></i></a>
										</div>
										<div class="vmenu-content">
											<?php wp_nav_menu( array( 'theme_location' => 'topmenu', 'container_class' => 'top-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
										</div>
									</div>
									<!-- end vmenu-toggler -->

									<div class="header-language">
										<?php do_action('icl_language_selector'); ?>
									</div>
									<!-- end header-language -->

									<div class="header-currency">
										<?php do_action('currency_switcher'); ?>
									</div>
									<!-- end header-currency -->
								</div>

								<div class="header-icon">
									<?php if(class_exists('WC_Widget_Product_Search') ) { ?>
										<div class="header-search">
											<div class="search-icon">
												<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
											</div>
										</div>
									<?php } ?>
									<!-- end header search -->

									<?php if ( class_exists( 'WC_Widget_Cart' ) ) {
										the_widget('Custom_WC_Widget_Cart'); 
									} ?>
									<!-- end header cart -->
								</div>
							</div>
						</div>
						<!-- end top-bar -->

						<div class="header-main <?php if(isset($chamo_opt['sticky_header']) && $chamo_opt['sticky_header']) {echo 'header-sticky';} ?> <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
							<div class="container">
								<div class="logo-wrap">
									<?php if( isset($chamo_opt['logo_main']['url']) ){ ?>
										<div class="logo">
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
												<img src="<?php echo esc_url($chamo_opt['logo_main']['url']); ?>" alt="" />
											</a>
										</div>
									<?php
									} else { ?>
										<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
										<?php
									} ?>
									<!-- end header logo -->
								</div>

								<div class="menu-wrap">	
									<div class="horizontal-menu">
										<div class="visible-large">
											<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
										</div>
									</div>
									<!-- end menu -->
								</div>

								<div class="visible-small mobile-menu">
									<div class="nav-container">
										<div class="mbmenu-toggler"><?php echo esc_html($chamo_opt['mobile_menu_label']);?><span class="mbmenu-icon"><i class="fa fa-bars"></i></span></div>
										<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
									</div>
								</div>
							</div>
						</div>
						<!-- end header-main -->
					</div>
				</div><!-- .header -->
				<div class="clearfix"></div>
			</div>
			<div class="main-container">
				<div class="page-content front-page">
					<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content">
								<?php the_content(); ?>
							</div>
						</article>
					<?php endwhile; ?>
					
				</div>
			</div>
			<?php get_footer(); ?>
		</div><!-- .page -->
	</div><!-- .wrapper -->
	<!--<div class="chamo_loading"></div>-->
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php wp_footer(); ?>
</body>
</html>
<?php unset($_SESSION["preset"]); ?>
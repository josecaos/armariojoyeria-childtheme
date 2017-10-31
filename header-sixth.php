<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */
$chamo_opt = get_option( 'chamo_opt' ); 
if(is_ssl()){
	$chamo_opt['logo_main']['url'] = str_replace('http:', 'https:', $chamo_opt['logo_main']['url']);
}
?>
	<div class="header-container layout6 <?php if(class_exists('RevSliderFront')) { echo 'rs-active';}?>">
		<div class="header">
			<div class="header-inner">
				<div class="top-bar">
					<div class="container">
						<div class="top-navigation">
							<?php if ( has_nav_menu( 'topmenu' ) ) { ?>
							<div class="vmenu-toggler">
								<div class="vmenu-toggler-button">
									<a href="#"><?php esc_html_e('My account', 'chamo'); ?><i class="fa fa-angle-down"></i></a>
								</div>
								<div class="vmenu-content">
									<?php wp_nav_menu( array( 'theme_location' => 'topmenu', 'container_class' => 'top-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
								</div>
							</div>
							<?php } ?>
							<!-- end vmenu-toggler -->
							<?php if (class_exists('SitePress')) { ?>
							<div class="header-language">
								<?php do_action('icl_language_selector'); ?>
							</div>
							<!-- end header-language -->

							<div class="header-currency">
								<?php do_action('currency_switcher'); ?>
							</div>
							<?php } ?>
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

						<?php if(isset($chamo_opt['header_block']) && $chamo_opt['header_block']!=''){ ?>
							<div class="container">
								<div class="header-static-block">
									<?php echo wp_kses($chamo_opt['header_block'], array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'img' => array(
										'src' => array(),
										'alt' => array()
									),
									'ul' => array(),
									'li' => array(),
									'i' => array(
										'class' => array()
									),
									'div' => array(
										'class' => array(),
									),
									'h4' => array(),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'span' => array(),
									'p' => array(),
									)); ?>
								</div>
							</div>
						<!-- end header-static-block -->
				        <?php } ?>

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
<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */
$chamo_opt = get_option( 'chamo_opt' ); ?>

	<div class="footer">
		<?php if(class_exists('ReduxFrameworkPlugin')) { ?>
		<div class="footer-main">
			<div class="container">
				<div class="row">
					<?php if(isset($chamo_opt['about_us']) && $chamo_opt['about_us']!=''){ ?>
					<div class="col-sm-6 col-lg-3 footer-col">
						<div class="about-us-wrap">
							<?php if( isset($chamo_opt['logo_footer']['url']) ){ ?>
							<div class="footer-logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
									<img src="<?php echo str_replace("http:","https:",esc_url($chamo_opt['logo_footer']['url'])); ?>" alt="" />
								</a>
							</div>
							<?php } ?>
							<!-- end footer logo -->

							<?php if(isset($chamo_opt['about_us']) && $chamo_opt['about_us']!='' ) { ?>
							<div class="widget widget_about_us">
								<?php echo wp_kses($chamo_opt['about_us'], array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'div' => array(
										'class' => array(),
									),
									'img' => array(
										'src' => array(),
										'alt' => array()
									),
									'h3' => array(
										'class' => array(),
									),
									'ul' => array(),
									'li' => array(),
									'i' => array(
										'class' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'p' => array(),
								)); ?>
							</div>
							<?php } ?>
							<!-- end widget about us -->

							<?php if(isset($chamo_opt['social_icons'])) { ?>
							<div class="widget widget-social">
								<?php  echo '<ul class="social-icons">';
										foreach($chamo_opt['social_icons'] as $key=>$value ) {
											if($value!=''){
												if($key=='vimeo'){
													echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(str_replace('-square', '', esc_attr($key))).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
												} else {
													echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(str_replace('-square', '', esc_attr($key))).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
												}
											}
										}
										echo '</ul>';
								?>
							</div>
							<?php } ?>
							<!-- end social-icon -->

						</div>
						<!-- end about-us-wrap -->
					</div>
					<?php } ?>

					<div class="col-sm-6 col-lg-3 footer-col">
						<h3 class="widgettitle">Suscríbete</h3>
<p>Recibirás las últimas noticias y promociones de Armario Joyería</p>
						<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//armariojoyeria.us14.list-manage.com/subscribe/post?u=e4b5f4573662ff09bf1fb7c48&amp;id=7fc5e72601" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
<div class="indicates-required"><span class="asterisk">*</span> campos requeridos</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
	<label for="mce-FNAME">Nombre </label>
	<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
</div>
<div class="mc-field-group">
	<label for="mce-LNAME">Apellido </label>
	<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_e4b5f4573662ff09bf1fb7c48_7fc5e72601" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribirme" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text'; /*
 * Translated default messages for the $ validation plugin.
 * Locale: ES
 */
$.extend($.validator.messages, {
  required: "Este campo es obligatorio.",
  remote: "Por favor, rellena este campo.",
  email: "Por favor, escribe una dirección de correo válida",
  url: "Por favor, escribe una URL válida.",
  date: "Por favor, escribe una fecha válida.",
  dateISO: "Por favor, escribe una fecha (ISO) válida.",
  number: "Por favor, escribe un número entero válido.",
  digits: "Por favor, escribe sólo dígitos.",
  creditcard: "Por favor, escribe un número de tarjeta válido.",
  equalTo: "Por favor, escribe el mismo valor de nuevo.",
  accept: "Por favor, escribe un valor con una extensión aceptada.",
  maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
  minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
  rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
  range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
  max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
  min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
});}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
					</div>

					<?php if(isset($chamo_opt['footer_product_tag_title']) && $chamo_opt['footer_product_tag_title']!='' ) { ?>
					<div class="col-sm-6 col-lg-3 footer-col">
						<div class="footer-col related-newsleter-wrap">
							<?php if(class_exists('WC_Widget_Product_Tag_Cloud')) { ?>
							<div class="footer-product-tag">
						         <h3 class="widget-title"><?php echo esc_html($chamo_opt['footer_product_tag_title']);?></h3>
						        <?php the_widget('WC_Widget_Product_Tag_Cloud');?>
					        </div>
							<?php } ?>
							<?php if ( isset($chamo_opt['newsletter_form']) ) { ?>
								<div class="newsletter">
									<?php if(class_exists( 'WYSIJA_NL_Widget' )){
										the_widget('WYSIJA_NL_Widget', array(
											'title' => esc_html($chamo_opt['newsletter_title']),
											'form' => (int)$chamo_opt['newsletter_form'],
											'id_form' => 'newsletter1',
											'success' => '',
										));
									} ?>
								</div>
							<?php } ?>
							<!-- end newsletter -->
						</div>
					</div>
					<?php } ?>
					<!-- end related tag newsletter -->

					<?php if(isset($chamo_opt['contact_title']) && $chamo_opt['contact_title']!='' ) { ?>
					<div class="col-sm-6 col-lg-3 footer-col">
						<div class="contact-info">
							<h3 class="widget-title"><?php echo esc_html($chamo_opt['contact_title']);?></h3>
							<?php echo wp_kses($chamo_opt['contact_info'], array(
								'a' => array(
									'href' => array(),
									'title' => array()
								),
								'div' => array(
									'class' => array(),
								),
								'img' => array(
									'src' => array(),
									'alt' => array()
								),
								'h3' => array(
									'class' => array(),
								),
								'ul' => array(),
								'li' => array(
									'class' => array(),
								),
								'i' => array(
									'class' => array()
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'p' => array(
									'class' => array(),
								),
							)); ?>
						</div>
					</div>
					<?php } ?>
					<!-- end contact-info -->
				</div>

			</div>
		</div>
		<?php } ?>
		<!-- end footer-main -->
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-inner">
					<div class="widget-copyright">
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
					</div>
					<!-- end copyright -->
					<?php if( isset($chamo_opt['footer_bottom']) && $chamo_opt['footer_bottom']!='' ) {
					$menufooterbottom_args = array(
						'menu_class'      => 'nav_menu',
						'menu'         => $chamo_opt['footer_bottom'],
					); ?>
					<div class="widget widget_menu footer-bottom-nav">
						<?php wp_nav_menu( $menufooterbottom_args ); ?>
					</div>
					<?php } ?>
					<!-- end footer menu bottom -->
				</div>
			</div>
		</div>
		<!-- end footer-bottom -->


	</div>

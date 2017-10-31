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
			<?php
			if ( !isset($chamo_opt['footer_layout']) || $chamo_opt['footer_layout']=='default' ) {
				get_footer('first');
			} else {
				get_footer($chamo_opt['footer_layout']);
			}
			?>
		</div><!-- .page -->
	</div><!-- .wrapper -->



	<!--<div class="chamo_loading"></div>-->
	<?php if ( isset($chamo_opt['back_to_top']) && $chamo_opt['back_to_top'] ) { ?>
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php } ?>
	<?php wp_footer(); ?>
	<!-- VI agregado
	<script type="text/javascript">
	//!function(){ var a = document.createElement("script"); a.type = "text/javascript",a.async = !0,a.src = "//configusa.veinteractive.com/tags/369D5BF8/AB57/4A3D/BAB3/5AA69878B604/tag.js"; var b = document.getElementsByTagName("head")[0]; if (b) b.appendChild(a, b); else { var b = document.getElementsByTagName("script")[0]; b.parentNode.insertBefore(a, b)}}();
	</script>
 -->
</body>
</html>

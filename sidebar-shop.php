<?php
/**
 * The sidebar for shop page
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
<div id="secondary" class="col-xs-12 col-md-3 sidebar-shop">
	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
</div>
<?php endif; ?>
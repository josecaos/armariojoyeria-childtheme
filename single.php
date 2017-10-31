<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */

$chamo_opt = get_option( 'chamo_opt' );

get_header();

$bloglayout = 'nosidebar';
if(isset($chamo_opt['blog_layout']) && $chamo_opt['blog_layout']!=''){
	$bloglayout = $chamo_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$bloglayout = $_GET['layout'];
}
$blogsidebar = 'right';
if(isset($chamo_opt['sidebarblog_pos']) && $chamo_opt['sidebarblog_pos']!=''){
	$blogsidebar = $chamo_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$blogsidebar = $_GET['sidebar'];
}
switch($bloglayout) {
	case 'sidebar':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	default:
		$blogclass = 'blog-nosidebar'; //for both fullwidth and no sidebar
		$blogcolclass = 12;
		$blogsidebar = 'none';
}
?>
<div class="main-container page-wrapper">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner">
				<header class="entry-header">
					<h1 class="entry-title"><?php if(isset($chamo_opt)) { echo esc_html($chamo_opt['blog_header_text']); } else { esc_html_e('Blog', 'chamo');}  ?></h1>
				</header>
				<?php Chamo::chamo_breadcrumb(); ?>
			</div>
		</div>
		
	</div>
	<div class="container">
		<div class="row">

			<?php if($blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-xs-12 <?php echo 'col-md-'.$blogcolclass; ?>">
				<div class="page-content blog-page single <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

						<?php comments_template( '', true ); ?>
						
						<!--<nav class="nav-single">
							<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'chamo' ); ?></h3>
							<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'chamo' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'chamo' ) . '</span>' ); ?></span>
						</nav><!-- .nav-single -->
						
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<?php if( $blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
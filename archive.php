<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Chamo already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
		Chamo::chamo_post_thumbnail_size('chamo-category-thumb');
		break;
	case 'largeimage':
		$blogclass = 'blog-large';
		$blogcolclass = 9;
		Chamo::chamo_post_thumbnail_size('chamo-category-thumb');
		break;
	default:
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		$blogsidebar = 'none';
		Chamo::chamo_post_thumbnail_size('chamo-post-thumb');
}
?>
<div class="main-container">
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
				<div class="page-content blog-page <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<header class="archive-header">
							<h1 class="archive-title"><?php
								if ( is_day() ) :
									printf( esc_html__( 'Daily Archives: %s', 'chamo' ), '<span>' . get_the_date() . '</span>' );
								elseif ( is_month() ) :
									printf( esc_html__( 'Monthly Archives: %s', 'chamo' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'chamo' ) ) . '</span>' );
								elseif ( is_year() ) :
									printf( esc_html__( 'Yearly Archives: %s', 'chamo' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'chamo' ) ) . '</span>' );
								else :
									_e( 'Archives', 'chamo' );
								endif;
							?></h1>
						</header><!-- .archive-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/* Include the post format-specific template for the content. If you want to
							 * this in a child theme then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
						?>
						
						<div class="pagination">
							<?php Chamo::chamo_pagination(); ?>
						</div>
						
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if( $blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
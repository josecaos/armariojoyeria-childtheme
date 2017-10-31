<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage chamo_Themes
 * @since Chamo 1.0
 */

$chamo_opt = get_option( 'chamo_opt' );

$chamo_postthumb = Chamo::chamo_post_thumbnail_size('');

if(Chamo::chamo_post_odd_event() == 1){
	$chamo_postclass='even';
} else {
	$chamo_postclass='odd';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($chamo_postclass); ?>>
	
	<?php if ( ! post_password_required() && ! is_attachment() ) : ?>
	<?php 
		if ( is_single() ) { ?>
			<div class="post-thumbnail-wrapper">
				<div class="post-thumbnail"><?php the_post_thumbnail(); ?>
					<span class="post-date">
						<?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span>' ;?>
					</span>
				</div>
				<div class="player"><?php echo do_shortcode(get_post_meta( $post->ID, '_chamo_meta_value_key', true )); ?></div>
			</div>
		<?php }
	?>
	<?php if ( !is_single() ) { ?>
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail($chamo_postthumb); ?>
				<span class="post-date">
					<?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span>' ;?>
				</span>
			</a>
			<a href="<?php the_permalink(); ?>" class="view-icon"><i class="fa fa-search"></i></a>
		</div>
		<?php } ?>
	<?php } ?>
	<?php endif; ?>
	
	<div class="postinfo-wrapper <?php if ( !has_post_thumbnail() ) { echo 'no-thumbnail';} ?>">
		
		<div class="post-info">
			<header class="entry-header">
				<?php if ( is_single() ) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<span class="post-category"> 
						<?php echo get_the_category_list( ', ' ); ?>
					</span>
					<span class="post-separator">|</span>
					<span class="post-author">
						<span class="post-by"><?php esc_html_e('Posted by', 'chamo');?> : </span>
						<?php printf( get_the_author() ); ?>
					</span>

				<?php else : ?>
					<span class="post-date">
							<?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span>' ;?>
					</span>

					<span class="post-separator">|</span>

					<span class="post-author">
						<span><?php esc_html_e('by ', 'chamo');?> </span>
						<?php printf( get_the_author() ); ?>
					</span>

					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>

				<?php endif; ?>
			</header>
			
			<?php if ( is_single() ) : ?>
				<div class="entry-content">
					<?php the_content( wp_kses(__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chamo' ), array('span'=>array('class'=>array())) )); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chamo' ), 'after' => '</div>', 'pagelink' => '<span>%</span>' ) ); ?>
				</div>
			<?php else : ?>
				<div class="entry-summary">
					<div class="player"><?php echo do_shortcode(get_post_meta( $post->ID, '_chamo_meta_value_key', true )); ?></div>

					<?php the_excerpt(); ?>

					<?php
					$num_comments = (int)get_comments_number($post->ID);
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments = esc_html__('0 comments', 'chamo');
						} elseif ( $num_comments > 1 ) {
							$comments = $num_comments . esc_html__(' comments', 'chamo');
						} else {
							$comments = esc_html__('1 comment', 'chamo');
						}
						echo '<a class="comment" href="' . get_comments_link() .'">'. $comments.'</a>';
					}
					?>

					<a class="readmore" href="<?php the_permalink(); ?>"><?php if(isset($chamo_opt['readmore_text']) && $chamo_opt['readmore_text']!=''){ echo esc_html($chamo_opt['readmore_text']); } else { esc_html_e('Read more', 'chamo');}  ?></a>
				</div>
			<?php endif; ?>
			
			<?php if ( is_single() ) : ?>
				<div class="entry-meta">
					<?php Chamo::chamo_entry_meta(); ?>
				</div>
			
				<?php if( function_exists('chamo_blog_sharing') ) { ?>
					<div class="social-sharing"><?php chamo_blog_sharing(); ?></div>
				<?php } ?>
			
				<div class="author-info">
					<div class="author-avatar">
						<?php
						$author_bio_avatar_size = apply_filters( 'roadthemes_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div>
					<div class="author-description">
						<h2><?php esc_html_e( 'About the Author:', 'chamo'); printf( '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" rel="author">%s</a>' , get_the_author()); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>
				</div>
				<div class="relatedposts">
					<h3><strong><?php esc_html_e('Related posts', 'chamo');?></strong></h3>
					<div class="row">
						<?php
						    $orig_post = $post;
						    global $post;
						    $tags = wp_get_post_tags($post->ID);
						     
						    if ($tags) {
						    $tag_ids = array();
						    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
						    $args=array(
						    'tag__in' => $tag_ids,
						    'post__not_in' => array($post->ID),
						    'posts_per_page'=>3, // Number of related posts to display.
						    'caller_get_posts'=>1
						    );
						     
						    $my_query = new wp_query( $args );
						 
						    while( $my_query->have_posts() ) {
						    $my_query->the_post();
						    ?>
					    	<div class="relatedthumb col-md-4">
					    		<div class="image">
					    			<?php the_post_thumbnail('chamo-post-thumb'); ?>
						    		<span class="post-date">
										<?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span>' ;?>
									</span>
					    		</div>
					    		<span class="post-category"> 
									<?php echo get_the_category_list(', '); ?>
								</span>
						        <h4><a rel="external" href="<?php the_permalink()?>"><?php the_title(); ?></a></h4>
						        <div class="short-description">
						        	<?php echo Chamo::chamo_limitStringByWord(get_the_excerpt(), 140, '...'); ?>
						    	</div>
						        <a class="readmore button" href="<?php get_the_permalink($post->ID); ?>"><?php if(isset($chamo_opt['readmore_text']) && $chamo_opt['readmore_text']!=''){ echo esc_html($chamo_opt['readmore_text']); } else { esc_html_e('Read more', 'chamo');}  ?></a>
						    </div>
						     
						    <?php }
						    }
						    $post = $orig_post;
						    wp_reset_postdata();
						?>
					</div> 
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>
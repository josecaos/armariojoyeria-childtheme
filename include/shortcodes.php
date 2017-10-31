<?php
function chamo_logo_shortcode( $atts ) {
	$chamo_opt = get_option( 'chamo_opt' );

	$atts = shortcode_atts( array(
							'logoimage_home' => '',
							'logoimage_inner' => '',
							), $atts, 'roadlogo' );
	$html = '';

	if( isset($atts['logoimage_home']) && $atts['logoimage_home']!=''){
		
		$html .= '<div class="logo">';

			$html .= '<div class="logo-home">';
					$html .= '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';

					$html .= '<img src="'.wp_get_attachment_url( $atts['logoimage_home']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" />';

					$html .= '</a>';

			$html .= '</div>';

			$html .= '<div class="logo-inner">';
					$html .= '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';

					$html .= '<img src="'.wp_get_attachment_url( $atts['logoimage_inner']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" />';

					$html .= '</a>';

			$html .= '</div>';

		$html .= '</div>';
	} else {
		$html .= '<h1 class="logo">';

		$html .= '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';

		$html .= bloginfo( 'name' );

		$html .= '</a>';

		$html .= '</h1>';
	}
	
	return $html;
}

function chamo_mainmenu_shortcode( $atts ) {
	$chamo_opt = get_option( 'chamo_opt' );

	$atts = shortcode_atts( array(
							'sticky_logoimage_home' => '',
							'sticky_logoimage_inner' => '',
							), $atts, 'roadmainmenu' );
	$html = '';
	
	ob_start(); ?>
	<div class="main-menu-wrapper">
		<div class="visible-small mobile-menu"> 
			<div class="mbmenu-toggler"><?php echo esc_html($chamo_opt['mobile_menu_label']);?><span class="mbmenu-icon"><i class="fa fa-bars"></i></span></div>
			<div class="clearfix"></div>
			<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
		</div>
		<div class="<?php if(isset($chamo_opt['sticky_header']) && $chamo_opt['sticky_header']) {echo 'header-sticky';} ?> <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
			<div class="nav-container">
				<?php if( isset($atts['sticky_logoimage_home']) && $atts['sticky_logoimage_home']!=''){ ?>
					<div class="logo-sticky">
						<div class="logo-sticky-home">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo  wp_get_attachment_url( $atts['sticky_logoimage_home']);?>" alt="" /></a>
						</div>
						<div class="logo-sticky-inner">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo  wp_get_attachment_url( $atts['sticky_logoimage_inner']);?>" alt="" /></a>
						</div>
					</div>
				<?php } ?>
				<div class="horizontal-menu visible-large">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
				</div> 
			</div> 
		</div>
	</div>	
	<?php
	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadcategoriesmenu_shortcode ( $atts ) {

	$chamo_opt = get_option( 'chamo_opt' );

	$html = '';

	ob_start();

	$cat_menu_class = '';

	if(isset($chamo_opt['categories_menu_home']) && $chamo_opt['categories_menu_home']) {
		$cat_menu_class .=' show_home';
	}
	if(isset($chamo_opt['categories_menu_sub']) && $chamo_opt['categories_menu_sub']) {
		$cat_menu_class .=' show_inner';
	}
	?>
	<div class="categories-menu visible-large <?php echo esc_attr($cat_menu_class); ?>">
		<div class="catemenu-toggler"><i class="fa fa-bars"></i><span><?php if(isset($chamo_opt)) { echo esc_html($chamo_opt['categories_menu_label']); } else { _e('Category', 'chamo'); } ?></span><i class="fa  fa-chevron-down"></i></div>
		<?php wp_nav_menu( array( 'theme_location' => 'categories', 'container_class' => 'categories-menu-container', 'menu_class' => 'categories-menu' ) ); ?>
		<div class="morelesscate">
			<span class="morecate"><i class="fa fa-plus"></i><?php if ( isset($chamo_opt['categories_more_label']) && $chamo_opt['categories_more_label']!='' ) { echo esc_html($chamo_opt['categories_more_label']); } else { _e('More Categories', 'chamo'); } ?></span>
			<span class="lesscate"><i class="fa fa-minus"></i><?php if ( isset($chamo_opt['categories_less_label']) && $chamo_opt['categories_less_label']!='' ) { echo esc_html($chamo_opt['categories_less_label']); } else { _e('Close Menu', 'chamo'); } ?></span>
		</div>
	</div>
	<?php

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadlangswitch_shortcode( $atts ) {
	$chamo_opt = get_option( 'chamo_opt' );

	$html = '';

	ob_start();

	if (class_exists('SitePress')) { ?>
		<div class="switcher">
			<div class="language"><?php do_action('icl_language_selector'); ?></div>
			<div class="currency"><?php do_action('currency_switcher'); ?></div>
		</div> 
	<?php }

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadsocialicons_shortcode( $atts ) {
	$chamo_opt = get_option( 'chamo_opt' );

	$html = '';

	ob_start();

	if(isset($chamo_opt['social_icons'])) {
		echo '<ul class="social-icons">';
		foreach($chamo_opt['social_icons'] as $key=>$value ) {
			if($value!=''){
				if($key=='vimeo'){
					echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
				} else {
					echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
				}
			}
		}
		echo '</ul>';
	}

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadminicart_shortcode( $atts ) {

	$html = '';

	ob_start();

	if ( class_exists( 'WC_Widget_Cart' ) ) {
		the_widget('Custom_WC_Widget_Cart');
	}

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadproductssearch_shortcode( $atts ) {

	$html = '';

	ob_start();

	if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
		<div class="search-dropdown">
			<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
		</div>
	<?php }

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_roadcopyright_shortcode( $atts ) {
	$chamo_opt = get_option( 'chamo_opt' );

	$html = '';

	ob_start(); ?>
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
		} ?>
	</div>

	<?php

	$html .= ob_get_contents();

	ob_end_clean();
	
	return $html;
}

function chamo_brands_shortcode( $atts ) {
	global $chamo_opt;
	$brand_index = 0;
	
	if(isset($chamo_opt['brand_logos'])) {
		$brandfound = count($chamo_opt['brand_logos']);
	}
	$atts = shortcode_atts( array(
							'rowsnumber' => '1',
							'colsnumber' => '6',
							), $atts, 'ourbrands' );
	$html = '';
	
	if(isset($chamo_opt['brand_logos']) && $chamo_opt['brand_logos']) {
		$html .= '<div class="brands-carousel" data-col="'.$atts['colsnumber'].'">';
			foreach($chamo_opt['brand_logos'] as $brand) {
				if(is_ssl()){
					$brand['image'] = str_replace('http:', 'https:', $brand['image']);
				}
				$brand_index ++;
				if ( (0 == ( $brand_index - 1 ) % $atts['rowsnumber'] ) || $brand_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div>';
				$html .= '<a href="'.$brand['url'].'" title="'.$brand['title'].'">';
					$html .= '<img src="'.$brand['image'].'" alt="'.$brand['title'].'" />';
				$html .= '</a>';
				$html .= '</div>';
				if ( ( ( 0 == $brand_index % $atts['rowsnumber'] || $brandfound == $brand_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	
	return $html;
}

function chamo_counter_shortcode( $atts ) {
	
	$atts = shortcode_atts( array(
							'image' => '',
							'number' => '100',
							'text' => 'Demo text',
							), $atts, 'chamo_counter' );
	$html = '';
	$html.='<div class="chamo-counter">';
		$html.='<div class="counter-image">';
			$html.='<img src="'.wp_get_attachment_url($atts['image']).'" alt="" />';
		$html.='</div>';
		$html.='<div class="counter-info">';
			$html.='<div class="counter-number">';
				$html.='<span>'.$atts['number'].'</span>';
			$html.='</div>';
			$html.='<div class="counter-text">';
				$html.='<span>'.$atts['text'].'</span>';
			$html.='</div>';
		$html.='</div>';
	$html.='</div>';
	
	return $html;
}

function chamo_popular_categories_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'category' => '',
		'image' => ''
	), $atts, 'popular_categories' );
	
	$html = '';
	
	$html .= '<div class="category-wrapper">';
		$pcategory = get_term_by( 'slug', $atts['category'], 'product_cat', 'ARRAY_A' );
		if($pcategory){
			$html .= '<div class="category-list">';
				$html .= '<h3><a href="'. get_term_link($pcategory['slug'], 'product_cat') .'">'. $pcategory['name'] .'</a></h3>';
				
				$html .= '<ul>';
					$args2 = array(
						'taxonomy'     => 'product_cat',
						'child_of'     => 0,
						'parent'       => $pcategory['term_id'],
						'orderby'      => 'name',
						'show_count'   => 0,
						'pad_counts'   => 0,
						'hierarchical' => 0,
						'title_li'     => '',
						'hide_empty'   => 0
					);
					$sub_cats = get_categories( $args2 );

					if($sub_cats) {
						foreach($sub_cats as $sub_category) {
							$html .= '<li><a href="'.get_term_link($sub_category->slug, 'product_cat').'">'.$sub_category->name.'</a></li>';
						}
					}
				$html .= '</ul>';
			$html .= '</div>';

			if ($atts['image']!='') {
			$html .= '<div class="cat-img">';
				$html .= '<a href="'.get_term_link($pcategory['slug'], 'product_cat').'"><img class="category-image" src="'.esc_attr($atts['image']).'" alt="" /></a>';
			$html .= '</div>';
			}
		}
	$html .= '</div>';
	
	return $html;
}

function chamo_categoriescarousel_shortcode( $atts ) {
	global $chamo_opt;
	$categories_index = 0;
	if(isset($chamo_opt['cate_images'])){
		$categoriesfound = count($chamo_opt['cate_images']);
	}
	
	$atts = shortcode_atts( array(
							'rowsnumber' => '1',
							'colsnumber' => '6',
							), $atts, 'categoriescarousel' );
	$html = '';
	
	if(isset($chamo_opt['cate_images'])){
		$html .= '<div class="categories-carousel" data-col="'.$atts['colsnumber'].'">';
			foreach($chamo_opt['cate_images'] as $categories) {
				if(is_ssl()){
					$categories['image'] = str_replace('http:', 'https:', $categories['image']);
				}
				$categories_index ++;
				if ( (0 == ( $categories_index - 1 ) % $atts['rowsnumber'] ) || $categories_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div>';
				$html .= '<a href="'.$categories['url'].'" class="image" title="'.$categories['title'].'">';
					$html .= '<img src="'.$categories['image'].'" alt="'.$categories['title'].'" />';
				$html .= '</a>';
					$html .= '<div class="description">'.$categories['description'].'</div>';
				$html .= '</div>';
				if ( ( ( 0 == $categories_index % $atts['rowsnumber'] || $categoriesfound == $categories_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	
	return $html;
}

function chamo_latestposts_shortcode( $atts ) {
	global $chamo_opt;
	$post_index = 0;
	$atts = shortcode_atts( array(
		'posts_per_page' => 5,
		'order' => 'DESC',
		'orderby' => 'post_date',
		'image' => 'wide', //square
		'length' => 20,
		'rowsnumber' => '1',
		'colsnumber' => '4',
		'image1' => 'square',
	), $atts, 'latestposts' );
	
	if($atts['image']=='wide'){
		$imagesize = 'chamo-post-thumbwide';
	} else {
		$imagesize = 'chamo-post-thumb';
	}
	$html = '';

	$postargs = array(
		'posts_per_page'   => $atts['posts_per_page'],
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => $atts['orderby'],
		'order'            => $atts['order'],
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true );
	
	$postslist = get_posts( $postargs );

	$html.='<div class="posts-carousel" data-col="'.$atts['colsnumber'].'">';

			foreach ( $postslist as $post ) {
				$post_index ++;
				if ( (0 == ( $post_index - 1 ) % $atts['rowsnumber'] ) || $post_index == 1) {
					$html .= '<div class="group">';
				}
				$html.='<div class="item-col">';
					$html.='<div class="post-wrapper">';

						$html.='<div class="post-thumb">';
							$html.='<a href="'.get_the_permalink($post->ID).'" class="link">'.get_the_post_thumbnail($post->ID, $imagesize);
								$html.='<span class="post-date">
											<span class="day">'.get_the_date('d ', $post->ID).'</span>
											<span class="month">'.get_the_date('M ', $post->ID).'</span>
										</span>';
							$html.='</a>';	
								$html.='<a href="'.get_the_permalink($post->ID).'" class="view-icon"><i class="fa fa-search"></i></a>';
						$html.='</div>';
						
						$html.='<div class="post-info">';
							$categories_list = get_the_category_list( ', ','', $post->ID );

							$html.='<div class="post-meta">';

								$num_comments = (int)get_comments_number($post->ID);
								$write_comments = '';
								if ( comments_open($post->ID) ) {
									if ( $num_comments == 0 ) {
										$comments = __('<span>0</span> comments', 'chamo');
									} elseif ( $num_comments > 1 ) {
										$comments = '<span>'.$num_comments .'</span>'. __(' comments', 'chamo');
									} else {
										$comments = __('<span>1</span> comment', 'chamo');
									}
									$write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
								}


								
								$html.='<span class="post-date">
											<span class="day">'.get_the_date('d ', $post->ID).'</span>
											<span class="month">'.get_the_date('M ', $post->ID).'</span>
											<span class="year">'.get_the_date('Y ', $post->ID).'</span>
										</span>';
								$html.='<span class="author">Por '.get_the_author($post->ID).'</span>';
								 
							$html.='</div>';

								$html.='<h3 class="post-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';		
								$html.='<div class="post-excerpt">';
									$html.= Chamo::chamo_excerpt_by_id($post, $length = $atts['length']);
							$html.='</div>';

							$html.='<div class="comment">'.$write_comments.'</div>';
							if(!isset($chamo_opt['readmore_text'])){
								$chamo_opt['readmore_text'] = 'Read more';
							}
							$html.='<a class="readmore" href="'.get_the_permalink($post->ID).'">'.'<span>' .esc_html($chamo_opt['readmore_text']). '</span>'.'</a>';
						$html.='</div>';

					$html.='</div>';
				$html.='</div>';
				if ( ( ( 0 == $post_index % $atts['rowsnumber'] || $atts['posts_per_page'] == $post_index ))  ) {
					$html .= '</div>';
				}
			}
	$html.='</div>';

	wp_reset_postdata();
	
	return $html;
}

function chamo_contact_map( $atts ) {
	global $chamo_mapid;
	
	if(!isset($chamo_mapid)){
		$chamo_mapid = 1;
	} else {
		$chamo_mapid++;
	}
	$atts = shortcode_atts( array(
		'map_height' => 400,
		'map_zoom' => 17,
		'lat1' => '',
		'long1' => '',
		'address1' => '',
		'marker1' => '',
		'description1' => '',
		'lat2' => '',
		'long2' => '',
		'address2' => '',
		'marker2' => '',
		'description2' => '',
		'lat3' => '',
		'long3' => '',
		'address3' => '',
		'marker3' => '',
		'description3' => '',
		'lat4' => '',
		'long4' => '',
		'address4' => '',
		'marker4' => '',
		'description4' => '',
		'lat5' => '',
		'long5' => '',
		'address5' => '',
		'marker5' => '',
		'description5' => '',
		
	), $atts, 'chamo_map' );
	
	$map_zoom = 17;
	if(intval($atts['map_zoom'])){
		$map_zoom = intval($atts['map_zoom']);
	}
	$map_height = 400;
	if(intval($atts['map_height'])){
		$map_height = intval($atts['map_height']);
	}
	
	$markers = array(
		array(
			'lat1' => $atts['lat1'],
			'long1' => $atts['long1'],
			'address1' => $atts['address1'],
			'marker1' => $atts['marker1'],
			'description1' => $atts['description1'],
		),
		array(
			'lat2' => $atts['lat2'],
			'long2' => $atts['long2'],
			'address2' => $atts['address2'],
			'marker2' => $atts['marker2'],
			'description2' => $atts['description2'],
		),
		array(
			'lat3' => $atts['lat3'],
			'long3' => $atts['long3'],
			'address3' => $atts['address3'],
			'marker3' => $atts['marker3'],
			'description3' => $atts['description3'],
		),
		array(
			'lat4' => $atts['lat4'],
			'long4' => $atts['long4'],
			'address4' => $atts['address4'],
			'marker4' => $atts['marker4'],
			'description4' => $atts['description4'],
		),
		array(
			'lat5' => $atts['lat5'],
			'long5' => $atts['long5'],
			'address5' => $atts['address5'],
			'marker5' => $atts['marker5'],
			'description5' => $atts['description5'],
		),
	);
	
	$html = '';
	
	$html.='<div class="map-wrapper">';
		$html.='<div id="map'.$chamo_mapid.'" class="map" style="height: '.$map_height.'px"></div>';
	$html.='</div>';
	
	//Add google map API
	wp_enqueue_script( 'gmap-api-js', 'http://maps.google.com/maps/api/js?sensor=false' , array(), '3', false );
	// Add jquery.gmap.js file
	wp_enqueue_script( 'jquery.gmap-js', get_template_directory_uri() . '/js/jquery.gmap.js', array(), '2.1.5', false );

	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#map<?php echo esc_attr($chamo_mapid);?>').gMap({
				scrollwheel: false,
				zoom: <?php echo esc_js($map_zoom);?>,
				
				markers:[
					<?php 
					$markeridx = 0;
					foreach($markers as $marker){
						$markeridx++;
						
						$map_desc = str_replace(array("\r\n", "\r", "\n"), "", $marker['description'.$markeridx]);
						$map_desc = addslashes($map_desc);
						
						if( $marker['address'.$markeridx]!='' || ($marker['lat'.$markeridx]!='' && $marker['long'.$markeridx]!='') ){ ?>
							{
								<?php if($marker['address'.$markeridx]!=''){ ?>
								address: '<?php echo  esc_js($marker['address'.$markeridx]);?>',
								<?php } else { ?>
								latitude: <?php echo  esc_js($marker['lat'.$markeridx]);?>,
								longitude: <?php echo  esc_js($marker['long'.$markeridx]);?>,
								<?php } ?>
								html: '<?php echo wp_kses($map_desc, array(
												'a' => array(
													'href' => array(),
													'title' => array()
												),
												'i' => array(
													'class' => array()
												),
												'br' => array(),
												'em' => array(),
												'strong' => array(),
												'h1' => array(),
												'h2' => array(),
												'h3' => array(),
											)); ?>',
								icon: {
									<?php if( isset($marker['marker'.$markeridx]) && $marker['marker'.$markeridx]!='') : ?>
									image: '<?php echo  wp_get_attachment_url( $marker['marker'.$markeridx]); ?>',
									<?php else : ?>
									image: '<?php echo get_template_directory_uri() . '/images/marker.png'; ?>',
									<?php endif; ?>
									iconsize: [40, 46],
									iconanchor: [40, 40]
								},
								popup: true
							},
						
						<?php }
					
					} ?>
				]
			});
		});
	</script>
	<?php
	
	return $html;
}
?>
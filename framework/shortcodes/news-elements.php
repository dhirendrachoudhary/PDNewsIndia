<?php
//double arrows
	$da = '<i class="fa-icon-double-angle-right"></i>';
	if (is_rtl()) {
		$da = '<i class="fa-icon-double-angle-left"></i>';
	}
	$la = '<i class="fa-icon-long-arrow-right"></i>';
	if (is_rtl()) {
		$la = '<i class="fa-icon-long-arrow-left"></i>';
	}
	
/* ==========================================================================
       Feathure slider
   ========================================================================== */
function mom_elements_feature_slider($atts, $content = null) {

global $unique_posts;
global $do_unique_posts;


	extract(shortcode_atts(array(
	'style' => '', //default, new
	'display' => '',
	'category' => '',
	'exclude_categories' => '',
	'class' => '',
	'tag' => '',
	'count' => 5,
	'orderby' => 'date', // recent, popular
	'caption' => 'on',
	'caption_style' => '', //1, 2
	'caption_length' => 110,
	'nav' => 'bullets', //bullets, thumbs, numbers 
	'thumbs_event' => 'click',
	'animation' => 'crossfade', //"none", "scroll", "directscroll", "fade", "crossfade", "cover", "cover-fade", "uncover" or "uncover-fade"
	'easing' => 'easeInOutCubic',
	'speed' => 600,
	'autoplay' => '',
	'timeout' => 4000,
	'animation_new' => 'fade', 
	'animation_in' => '',
	'animation_out' => '',
	'arrows' => '',
	'post_type' => '', 
	'items' => '6', // thumbnails number of items 
	'no_spaces' => '',
	'full_width' => '',
	'caption_title_size' => '',
	'caption_text_size' => '',
	), $atts));
$output = get_transient('mom_feature_slider2_'.$display.$category.$tag.$caption_style.$nav.$animation.$count);
if ($output == false) {
	ob_start();
global $da;
global $la;
if ($caption_title_size != '') {
	$caption_title_size = 'style="font-size:'.$caption_title_size.';"';
}
if ($caption_text_size != '') {
	$caption_text_size = 'style="font-size:'.$caption_text_size.';"';
}
$img_size = 'big-wide-img';
$wide_class = '';
	$thumb_size = 'small-wide';

if (mom_option('site_width') == 'wide') {
//	both-sidebars
$classes = get_body_class();
if (in_array('both-sidebars',$classes)) {
    // nothing
} else {
	$img_size = 'bigger-wide-img';
	$wide_class = 'fs-wide';

	$thumb_size = 'small-wide-hd';

}
}

	if ($exclude_categories != '') {
		$exclude_categories = explode(',', $exclude_categories);
	}

	$detect = new Mobile_Detect;
	if( $detect->isMobile()) {
		wp_enqueue_script('TSwipe');
	}
	//orderby 
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} else {
		$orderby = $orderby;	
	}
	$rndn = rand(1,1000);
	
	$style_class = 'old-style';
	if ($style != '') {
		$style_class = $style.'-style';
	}
			if ($style == 'new') {
				$animation = '';
			}
			if ($animation_new == 'fade') {
				$animation_out = 'fadeOut';
				$animation_in = '';
			} elseif ($animation_new == 'slide') {
				$animation_out = '';
				$animation_in = '';
				
			} elseif ($animation_new == 'flip') {
				$animation_out = 'slideOutDown';
				$animation_in = 'flipInX';
			}
			if ($autoplay == 'no') {
				$autoplay = 'false';
			} else {
				$autoplay = 'true';		
			}
			if ($items < 6) {
				$thumb_size = 'news_box_big';
			} 
						
			$nospaces = '';
			if ($no_spaces == 'yes') {
				$nospaces = 'no_spaces';
				$thumb_size = 'small-wide-hd';
			}

			if ($full_width == 'yes') {
				$img_size = 'full-width-slider';
				$thumb_size = 'news_box_big';
			}

			if( $detect->isMobile()) {
				$image_size = 'scrolling-box';
				$thumb_size = 'small-wide';
			}

	?>
	<div class="feature-slider base-box <?php echo 'nav-'.$nav.' '. $wide_class.' '.$style_class.' '.$nospaces.' '.$class; ?>" data-speed="<?php echo $speed; ?>" data-timeout="<?php echo $timeout; ?>" data-sanimation="<?php echo $animation; ?>" data-easing="<?php echo $easing; ?>" data-rndn="<?php echo $rndn; ?>" data-animation_new="<?php echo $animation_new; ?>" data-animation_in="<?php echo $animation_in; ?>" data-animation_out="<?php echo $animation_out; ?>" data-autoplay="<?php echo $autoplay; ?>" data-items="<?php echo $items; ?>" data-thumbs_event="<?php echo $thumbs_event; ?>">
		<?php if ($arrows == 'on') {?>
		<div class="fs-drection-nav fs-dnav-<?php echo $rndn; ?>">
			<span class="fsd-prev"><i class="fa-icon-angle-left"></i></span>
			<span class="fsd-next"><i class="fa-icon-angle-right"></i></span>
		</div>
		<?php } else { ?>
		<div class="mom_visibility_mobile fs-drection-nav fs-dnav-<?php echo $rndn; ?>">
			<span class="fsd-prev"><i class="fa-icon-angle-left"></i></span>
			<span class="fsd-next"><i class="fa-icon-angle-right"></i></span>
		</div>
		<?php }?>
	<div class="fslides fs-<?php echo $rndn; ?>">

		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
		); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
		); 
		if (!is_numeric($tag)) {$args['tag'] = $tag;}

		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'orderby' => $orderby,
			); 
		}

		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php $i = 0; if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php if (mom_post_image() != false) {
			if ($nav != 'thumbs') {
			if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
			}
			
		?>
                        <div <?php post_class('fslide'); ?> data-i="<?php echo $i; ?>">
                            <a href="<?php the_permalink(); ?>"><?php mom_post_image_full($img_size); ?></a>
			    <?php if ($caption != 'off') {
				if ($caption_style == 2) {
					$caption_style = 'fs-caption-alt';
				}
					$nav_class = ' nav-is-'.$nav;
				?>
                            <div class="slide-caption <?php echo $caption_style.$nav_class; ?>">
                                <h2 <?php echo $caption_title_size; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php if ($caption_length != 0) { ?>
                                <P <?php echo $caption_text_size; ?>>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), $caption_length, '...');
					?>
				</P>
				<?php } ?>
                            </div>
			    <?php } ?>
                        </div>
			<?php $i++;} ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                    </div>
		    <?php if ($nav == 'thumbs') { ?>
                    <div class="fs-image-nav fc-nav-<?php echo $rndn; ?>">
			<span class="fs-prev"><i class="enotype-icon-arrow-left5"></i></span>
			<span class="fs-next"><i class="enotype-icon-arrow-right5"></i></span>
	<div class="fs-thumbs">
		<?php
		if ($display == 'category') {
			$args = array(
'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
		); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
		); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'orderby' => $orderby,
			); 
		}

		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php $i = 0; if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php if (mom_post_image() != false) { if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                       <div class="fs-thumb" <?php post_class(); ?> data-i="<?php echo $i; ?>">
                            <?php mom_post_image_full($thumb_size); ?>
                        </div>
		<?php $i++;} ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                    </div>
		    </div>
		    <?php } else { ?>
                    <div class="fs-nav fs-nav-<?php echo $rndn; ?> <?php echo $nav; ?>"></div>
		    <?php } ?>
		
                </div> <!--fearure slider-->
<?php

	$output = ob_get_contents();
	ob_end_clean();

	set_transient('mom_feature_slider_'.$display.$category.$tag.$caption_style.$nav.$animation.$count, $output, 60*60*24);
} // end if output false
	return $output;

	}

add_shortcode('feature_slider', 'mom_elements_feature_slider');

/* ==========================================================================
       Scrolling Box
   ========================================================================== */
function mom_elements_scrolling_box($atts, $content = null) {
global $unique_posts;
global $do_unique_posts;

	extract(shortcode_atts(array(
	'title' => '',
	'display' => '',
	'category' => '',
	'exclude_categories' => '',
	'class' => '',
	'tag' => '',
	'format' => '',
	'orderby' => 'date', // recent, popular, random
	'sort' => 'DESC', //DESC & ASC
	'count' => 6,
	'excerpt_length' => 0,
	'items' => 3,
	'autoplay' => '',
	'timeout' => '5000',
	'post_type' => '',
	'header_background' => '',
	'header_text_color' => '',
	'hide_dots' => '',
	'rows'	=> 1
	
	), $atts));
$output = get_transient('msb2_'.$display.$category.$tag.$orderby.$excerpt_length.$count);
if ($output == false) {
	ob_start();
global $da;
global $la;

	if ($autoplay == 'yes') {
		$autoplay = 'true';		
	} else {
		$autoplay = 'false';
	}

	//orderby 
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} elseif ($orderby == 'random') {
		$orderby = 'rand';
	} else {
		$orderby = $orderby;	
	}
	//post format
	if ($format != '') {
		$format = explode(',',$format);
		$formats = array ();
		foreach ($format as $f) {
			$formats[] = 'post-format-'.$f;
		}
		$format = array(
				array(
				    'taxonomy' => 'post_format',
				    'field' => 'slug',
				    'terms' => $formats,
				    'operator' => 'IN'
				)
			);
	}
	if ($exclude_categories != '') {
		$exclude_categories = explode(',', $exclude_categories);
	}
		// title & display
      if ($header_background != '') {
        $header_background = 'style="background:'.$header_background.';"';
      }
      if ($hide_dots == 'yes') {
        $hide_dots = 'background:none;';
      }
      if ($header_text_color != '') {
        $header_text_color = 'style="color:'.$header_text_color.';'.$hide_dots.'"';
      } else {
        $header_text_color = 'style="'.$hide_dots.';"';
      }
      
	$title_holder = '<span '.$header_background.'>'.$title.'</span>';
	$url = '';
	$rndn = rand(1,1000);
	if ($display == 'category') {
		if (is_numeric($category)) { $cat_data = get_category($category); } else { $cat_data = get_category_by_slug($category); }
		if ($title == '') {
			$title = $cat_data->name;
		}
		$url = get_category_link( $cat_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';
	}
	if ($display == 'tag') {
		if (is_numeric($tag)) { $tag_data = get_tag($tag); } else { $tag_data = get_term_by('slug',$tag,'post_tag'); }
		if ($title == '') {
			$title = $tag_data->name;
		}
		$url = get_tag_link( $tag_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';
	}
	if ($display == '' && $title == '') {
		$title_holder = '<span '.$header_background.'>'.__('Recent Posts','theme').'</span>';
	}
	
	?>
	<script>
		jQuery(document).ready(function($){
				var rtl = false;
				<?php if (is_rtl()) { ?>
					rtl = true;
				<?php } ?>
				var rows = <?php echo $rows; ?>;
				if (rows !== '' && rows > 1) {
				 	var divs = $(".sb-content-<?php echo $rndn; ?> .sb-item");
					for(var i = 0; i < divs.length; i+=rows) {
					  divs.slice(i, i+rows).wrapAll("<div class='rows-<?php echo $rows; ?>'></div>");
					}
				}

			 $(".sb-content-<?php echo $rndn; ?>").owlCarousel({
				items: <?php echo $items; ?>,
				baseClass: 'mom-carousel',
				rtl: rtl,
				autoplay:<?php echo $autoplay; ?>,
				autoplayTimeout:<?php echo $timeout; ?>,
				autoplayHoverPause : true,
				responsive:{	
				1000:{
				  items:<?php echo $items; ?>
				},

				671:{
				  items:3
				},
				
				480:{
				  items:2
				},
			    
				320:{
				  items:1
				},
				1:{
				  items:1
				}
					     }
			});
		});
	</script>
                <div class="news-box <?php echo $class; ?> base-box scrolling-box-wrap">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                        <div class="scrolling-box">
                            <div class="sb-content mom-carousel sb-content-<?php echo $rndn; ?>">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'tax_query' => $format
		); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'tax_query' => $format
		); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}

		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'tax_query' => $format
			); 
		}

		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                                <div <?php post_class('sb-item'); ?>>
				<?php if (mom_post_image() != false) { ?>
                                   <div class="sb-item-img">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('big-wide-img', 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                   </div>
				<?php } ?>
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                    <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
					<?php mom_show_review_score(); ?>				   
                                   </div>
				<?php if ($excerpt_length != 0) { ?>
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), $excerpt_length, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
				<?php } ?>
				   

                                </div> <!--sb item-->
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                            </div> <!--sb-content-->
                        </div> <!--scrolling box-->
                    </div>
                    <footer class="nb-footer">
                        
                    </footer>
                </div> <!--news box-->
<?php
	$output = ob_get_contents();
	ob_end_clean();
	set_transient('msb_'.$display.$category.$tag.$orderby.$excerpt_length.$count, $output, 60*60*24);
}
	return $output;

	}

add_shortcode('scrolling_box', 'mom_elements_scrolling_box');

/* ==========================================================================
       News List
   ========================================================================== */
function mom_elements_news_list($atts, $content = null) {
global $unique_posts;
global $do_unique_posts;

	extract(shortcode_atts(array(
	'title' => '',
	'display' => '', //cat, tag
	'category' => '',
	'exclude_categories' => '',
	'class' => '',
	'tag' => '',
	'format' => '',
	'orderby' => 'date', // recent, popular, random
	'sort' => 'DESC', //DESC & ASC
	'image_size' => 'medium', //medium & big
	'count' => 4,
	'excerpt_length' => 150,
	'show_more' => '',
	'show_more_type' => 'ajax',
	'post_type' => '',
	'header_background' => '',
	'header_text_color' => '',
	'hide_dots' => '',

	), $atts));
$output = get_transient('mnl_'.$display.$category.$tag.$excerpt_length.$count);
if ($output == false) {	
	ob_start();
global $da;
global $la;
	$nl_class = '';
	$sm_format = $format;
	// image size
	if ($image_size == 'big') {
		$image_size = 'scrolling-box';
		$nl_class = 'nl-big';
	} else {
		$image_size = 'related-posts';
	}
	//orderby 
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} elseif ($orderby == 'random') {
		$orderby = 'rand';
	} else {
		$orderby = $orderby;	
	}
	//post format
	if ($format != '') {
		$format = explode(',',$format);
		$formats = array ();
		foreach ($format as $f) {
			$formats[] = 'post-format-'.$f;
		}
		$format = array(
				array(
				    'taxonomy' => 'post_format',
				    'field' => 'slug',
				    'terms' => $formats,
				    'operator' => 'IN'
				)
			);
	}
	if ($exclude_categories != '') {
		$exclude_categories_text = $exclude_categories;
		$exclude_categories = explode(',', $exclude_categories);
	}
		// title & display
      if ($header_background != '') {
        $header_background = 'style="background:'.$header_background.';"';
      }
      if ($hide_dots == 'yes') {
        $hide_dots = 'background:none;';
      }
      if ($header_text_color != '') {
        $header_text_color = 'style="color:'.$header_text_color.';'.$hide_dots.'"';
      } else {
        $header_text_color = 'style="'.$hide_dots.';"';
      }
      
	$title_holder = '<span '.$header_background.'>'.$title.'</span>';
	$url = '';
	$rndn = rand(1,1000);
	if ($display == 'category') {
		if (is_numeric($category)) { $cat_data = get_category($category); } else { $cat_data = get_category_by_slug($category); }
		if ($title == '') {
			$title = $cat_data->name;
		}
		$url = get_category_link( $cat_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';
	}
	if ($display == 'tag') {
		if (is_numeric($tag)) { $tag_data = get_tag($tag); } else { $tag_data = get_term_by('slug',$tag,'post_tag'); }
		if ($title == '') {
			$title = $tag_data->name;
		}
		$url = get_tag_link( $tag_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';
	}
	if ($display == '' && $title == '') {
		$title_holder = '<span '.$header_background.'>'.__('Recent Posts','theme').'</span>';
	}
	
	?>

                <div class="news-box <?php echo $class; ?> base-box">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                        <div class="news-list <?php echo $nl_class; ?>">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'tax_query' => $format,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'tax_query' => $format,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'tax_query' => $format,
			); 
		}

		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class('nl-item'); ?>>
				<?php
				$is_img = '';
				if (mom_post_image() != false) {
					$is_img = 'has-feature-image';
				?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full($image_size, 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary <?php echo $is_img; ?>">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                    <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
					<?php mom_show_review_score(); ?>				   
                                   </div> <!--meta-->
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), $excerpt_length, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                        </div> <!--news list-->
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="news_list" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>" data-format="<?php echo $sm_format; ?>" data-excerpt_length="<?php echo $excerpt_length; ?>" data-image_size="<?php echo $image_size; ?>"><?php _e('Show More','theme'); ?><?php echo $la; ?></a>
                    </footer>
		    <?php } ?>
                    
                </div> <!--news box-->
<?php
	$output = ob_get_contents();
	ob_end_clean();
	set_transient('mnl_'.$display.$category.$tag.$excerpt_length.$count, $output, 60*60*24);
}
	return $output;

}

add_shortcode('news_list', 'mom_elements_news_list');

/* ==========================================================================
 *                News Boxes
   ========================================================================== */
function mom_elements_news_boxes($atts, $content) {
global $unique_posts;
global $do_unique_posts;

	extract(shortcode_atts(array(
	'style' => '1',
	'title' => '',
	'link' => '',
	'link_target' => '',
	'display' => '', //category, tag, latest
	'category' => '',
	'exclude_categories' => '',
	'class' => '',
	'tag' => '',
	'orderby' => 'date', // recent, popular, random
	'sort' => 'DESC', //DESC & ASC
	'count' => '',
	'last' => '', //just for newsbox 2 columns
	'show_more' => '',
	'show_more_type' => 'ajax',
	'post_type' => '',
	'header_background' => '',
	'header_text_color' => '',
	'hide_dots' => '',
	
	), $atts));
$output = get_transient('mnb_'.$style.$display.$category.$tag.$show_more);
$output = false;
if ($output == false) {
	ob_start();
global $da;
global $la;
	if ($count == '') {
		switch ($style) {
			case '1':
				$count = 6;
			break;
			case '2':
				$count = 4;
			break;
			case '3':
				$count = 4;
			break;
			case 'two_cols':
				$count = 3;
			break;
			case '4':
				$count = 5;
			break;
		}
	}
	//orderby 
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} elseif ($orderby == 'random') {
		$orderby = 'rand';
	} else {
		$orderby = $orderby;
	}
	if ($exclude_categories != '') {
		$exclude_categories_text = $exclude_categories;
		$exclude_categories = explode(',', $exclude_categories);
	}

	// title & display
      if ($header_background != '') {
        $header_background = 'style="background:'.$header_background.';"';
      }
      if ($hide_dots == 'yes') {
        $hide_dots = 'background:none;';
      }
      if ($header_text_color != '') {
        $header_text_color = 'style="color:'.$header_text_color.';'.$hide_dots.'"';
      } else {
        $header_text_color = 'style="'.$hide_dots.';"';
      }
      
	$url = $link;
	if ($link_target == '_blank') {
		$link_target = 'target="_blank"';
	}
	$rndn = rand(1,1000);
	$default_title = $title;
	if ($title == '') {
		$default_title = __('Recent Posts', 'theme');
	}

		$title_holder = '<span '.$header_background.'>'.$default_title.'</span>';
	if ($url != '') {
		$title_holder = '<a href="'.$url.'" '.$link_target.$header_background.'>'.$default_title.'</a>';
	}
	if ($display == 'category') {
		if (is_numeric($category)) { $cat_data = get_category($category); } else { $cat_data = get_category_by_slug($category); }
		if ($title == '') {
			$title = $cat_data->name;
		}
		if ($url == '') {
			$url = get_category_link( $cat_data->term_id );
		}	
		$title_holder = '<a href="'.$url.'"'.$link_target.$header_background.'>'.$title.'</a>';
	}
	if ($display == 'tag') {
		if (is_numeric($tag)) { $tag_data = get_tag($tag); } else { $tag_data = get_term_by('slug',$tag,'post_tag'); }
		if ($title == '') {
			$title = $tag_data->name;
		}
		if ($url == '') {
			$url = get_tag_link( $tag_data->term_id );
		}
		$title_holder = '<a href="'.$url.'"'.$link_target.$header_background.'>'.$title.'</a>';
	}

	
	
	?>
<?php if($style == 2) { ?>
		<!--News box two-->	
               <div class="news-box <?php echo $class; ?> base-box nb-style2">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                      <div class="recent-news">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class(); ?>>
                                <div class="rn-title">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <span class="category"><?php _e('In', 'theme'); ?>: <?php the_category(', '); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
				    <?php mom_show_review_score(); ?>
                                   </div> <!--meta-->
                                </div> <!--rn title-->
				<?php if (mom_post_image() != false) { ?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('news_box_big', 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary">
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), 240, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                  </div> <!--recent news-->

                            <div class="older-articles">
                                <ul class="two-cols">

		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                                    <li <?php post_class(); ?>>
				<?php
				$is_img = '';
				if (mom_post_image() != false) {
					$is_img = 'has-feature-image';
				?>
                 <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('small-wide', 'small-wide-hd'); ?></a>
		 <?php } ?>
                                        <div class="details <?php echo $is_img; ?>">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
                                   </div> <!--meta-->
					<?php mom_show_review_score(); ?>				   
                                   </div>
                                    </li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

                                </ul>
                            </div>
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count+1; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo $style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>"><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
		    <?php } ?>
                    
                </div> <!--news box-->
		<!--News box two-->	
<?php } elseif ($style == 3) { ?>
		<!--News box three-->	
               <div class="news-box <?php echo $class; ?> base-box nb-style3">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                            <div class="recent-news">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class(); ?>>
				<?php if (mom_post_image() != false) { ?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('news_box3', 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
				    <?php mom_show_review_score(); ?>
                                   </div> <!--meta-->
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), 100, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

                            </div> <!--recent news-->
                            <div class="older-articles">
                                <ul>
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                                    <li>
				<?php
				$is_img = '';
				if (mom_post_image() != false) {
					$is_img = 'has-feature-image';
				?>
                 <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('small-wide', 'small-wide-hd'); ?></a>
				<?php } ?>
                                        <div class="details <?php echo $is_img; ?>">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
                                   </div> <!--meta-->
					<?php mom_show_review_score(); ?>				   
                                   </div>
                                    </li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                                </ul>

                            </div>
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count+1; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo $style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>"><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
		    <?php } ?>
                    
                </div> <!--news box-->                
		<!--News box three-->	
<?php } elseif ($style == 4) { ?>
		<!--News box three-->	
               <div class="news-box <?php echo $class; ?> base-box nb-style3 nb-style4">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                            <div class="recent-news">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'posts_per_page' => 1,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class(); ?>>
				<?php if (mom_post_image() != false) { ?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('news_box3', 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
				    <?php mom_show_review_score(); ?>
                                   </div> <!--meta-->
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), 100, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

                            </div> <!--recent news-->
                            <div class="older-articles">
                                <ul>
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                                    <li <?php post_class(); ?>>
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
					<?php mom_show_review_score(); ?>				   
                                   </div> <!--meta-->
                                    </li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                                </ul>

                            </div>
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count+1; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo $style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>"><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
		    <?php } ?>
                    
                </div> <!--news box-->                
		<!--News box three-->	
<?php } elseif ($style == 'two_cols') {
	if ($last != '') {
		$last = 'last';
	}
	$img_size = 'news_box_big';
	$wide_class = '';
if (mom_option('site_width') == 'wide') {
	$classes = get_body_class();
if (in_array('both-sidebars',$classes)) {
    // nothing
} else {
	$img_size = 'big-wide-img';
	$wide_class = ' nb2c-wide';
}
}	
	?>
		<!--News box 2 columns-->	
                <div class="news-box <?php echo $class; ?> base-box nb-style2 nb-2col <?php echo $last.$wide_class; ?>">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                            <div class="recent-news">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class(); ?>>
				<?php if (mom_post_image() != false) { ?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full($img_size, 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
				    <?php mom_show_review_score(); ?>
                                   </div> <!--meta-->
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), 100, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
			    
                            </div> <!--recent news-->
                            <div class="older-articles">
                                <ul>
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                                      <li <?php post_class(); ?>>
				<?php
				$is_img = '';
				if (mom_post_image() != false) {
					$is_img = 'has-feature-image';
				?>
                 <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('small-wide', 'small-wide-hd'); ?></a>
		 <?php } ?>
                                        <div class="details <?php echo $is_img; ?>">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
                                   </div> <!--meta-->
					<?php mom_show_review_score(); ?>				   
					</div>
                                    </li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                                </ul>

                            </div>
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count+1; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo $style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>"><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
			<?php } ?>
                    
                </div> <!--news box-->
		<?php if ($last != '') { ?>
			<div class="clear"></div>
		<?php } ?>
		<!--News box 2 columns-->	
<?php } else {  // default news box?>
		<!--News box one-->	
                <div class="news-box <?php echo $class; ?> base-box nb-style1">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
                      <div class="recent-news">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                            <article <?php post_class(); ?>>
                                <div class="rn-title">
                                   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <div class="mom-post-meta nb-item-meta">
                                <span datetime="<?php the_time('c'); ?>" class="entry-date"><?php mom_date_format(); ?></span>
                                    <span class="category"><?php _e('In', 'theme'); ?>: <?php the_category(', '); ?></span>
                                    <a href="<?php comments_link(); ?>" class="comment_number"><?php comments_number(__('No comments', 'theme'), __('1 Comment', 'theme'), __('% Comments')); ?></a>
				    <?php mom_show_review_score(); ?>
                                   </div> <!--meta-->
                                </div> <!--rn title-->
				<?php if (mom_post_image() != false) { ?>
                                <div class="news-image">
                                        <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('small-wide-hd', 'big-wide-img'); ?></a><span class="post-format-icon"></span>
                                </div>
				<?php } ?>
                                <div class="news-summary">
                                <P>
					<?php
						$excerpt = get_the_excerpt();
						if ($excerpt == false) {
						$excerpt = get_the_content();
						}
						
						echo wp_html_excerpt(strip_shortcodes($excerpt), 270, '...');
					?>
				   <a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more', 'theme'); ?> <?php echo $da; ?></a>
				</P>
                                </div>
                            </article>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                  </div> <!--recent news-->

                            <div class="nb1-older-articles">
                                <ul class="two-cols">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
				'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
        <li <?php post_class(); ?>><?php echo $da; ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

                                </ul>
                            </div>
                    </div>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $count+1; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo $style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>" ><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
		    <?php } ?>
                    
                </div> <!--news box-->
		<!--News box one-->
	<?php } ?>

<?php
	$output = ob_get_contents();
	ob_end_clean();
	set_transient('mnb_'.$style.$display.$category.$tag.$show_more, $output, 60*60*24);
}
	return $output;

	}

add_shortcode('news_box', 'mom_elements_news_boxes');

/* ==========================================================================
	media box
   ========================================================================== */
function mom_elements_media_box($atts, $content) {
global $unique_posts;
global $do_unique_posts;

	extract(shortcode_atts(array(
	'title' => __('Latest Media','theme'),
	'url' => '',
	'format' => 'audio,video,gallery',
	'orderby' => 'date', // recent, popular, random
	'sort' => 'DESC', //DESC & ASC
	), $atts));
	ob_start();
global $da;
global $la;
	//orderby 
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} elseif ($orderby == 'random') {
		$orderby = 'rand';
	}
	//post format
	if ($format != '') {
		$format = explode(',',$format);
		$formats = array ();
		foreach ($format as $f) {
			$formats[] = 'post-format-'.$f;
		}
		$format = array(
				array(
				    'taxonomy' => 'post_format',
				    'field' => 'slug',
				    'terms' => $formats,
				    'operator' => 'IN'
				)
			);
	}
	//title & display
	$title_holder = '<span>'.$title.'</span>';
	if ($url != '') {
		$title_holder = '<a href="'.$url.'">'.$title.'</a>';
	}

	
	?>
                <div class="news-box <?php echo $class; ?> base-box media-box">
                    <header class="nb-header">
                        <h2 class="nb-title"><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
		<?php
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1,
				'orderby' => $orderby,
				'order' => $sort,
				'tax_query' => $format
			); 
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
                        <div class="recent-media">
                            <img src="<?php echo MOM_IMG; ?>/demo/img.png" alt="">
                        </div>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                        <div class="older-media">
                            <ul>
		<?php
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 4,
				'orderby' => $orderby,
				'order' => $sort,
				'tax_query' => $format
			); 
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>                              
		<li><a href="#"><img src="<?php echo MOM_IMG; ?>/demo/simg.png" alt=""></a></li>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    </div> <!--nb content-->
                    <footer class="nb-footer">
                        <a href="#" class="show-more"><?php _e('Show More', 'theme'); ?> <?php echo $la; ?> </a>
                    </footer>
                    
                </div> <!--news box --> 


<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;

	}

add_shortcode('media_box', 'mom_elements_media_box');

/* ==========================================================================
       News In pics
   ========================================================================== */
function mom_elements_news_in_pics($atts, $content = null) {
global $unique_posts;
global $do_unique_posts;

	extract(shortcode_atts(array(
	'title' => '',
	'style' => '',
	'display' => '',
	'category' => '',
	'exclude_categories' => '',
	'class' => '',
	'tag' => '',
	'orderby' => 'date', // recent, popular, random
	'sort' => 'DESC', //DESC & ASC
	'count' => 18,
	'show_more' => '',
	'show_more_type' => 'ajax',
	'post_type' => '',
	'header_background' => '',
	'header_text_color' => '',
	'hide_dots' => '',
	

	), $atts));

$output = get_transient('mom_nip_'.$display.$category.$tag);
if ($output == false) {	
	ob_start();
global $da;
global $la;
	if ($orderby == 'popular') {
		$orderby = 'comment_count';	
	} elseif ($orderby == 'random') {
		$orderby = 'rand';
	}
	if ($exclude_categories != '') {
		$exclude_categories = explode(',', $exclude_categories);
	}	
	// title & display
      if ($header_background != '') {
        $header_background = 'style="background:'.$header_background.';"';
      }
      if ($hide_dots == 'yes') {
        $hide_dots = 'background:none;';
      }
      if ($header_text_color != '') {
        $header_text_color = 'style="color:'.$header_text_color.';'.$hide_dots.'"';
      } else {
        $header_text_color = 'style="'.$hide_dots.';"';
      }
      
	$title_holder = '<span '.$header_background.'>'.$title.'</span>';
	$url = '';
	$rndn = rand(1,1000);
	if ($display == 'category') {
		if (is_numeric($category)) { $cat_data = get_category($category); } else { $cat_data = get_category_by_slug($category); }
		if ($title == '') {
			$title = $cat_data->name;
		}
		$url = get_category_link( $cat_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';	

		}

		if ($display == 'tag') {
		if (is_numeric($tag)) { $tag_data = get_tag($tag); } else { $tag_data = get_term_by('slug',$tag,'post_tag'); }
		if ($title == '') {
			$title = $tag_data->name;
		}
		$url = get_tag_link( $tag_data->term_id );
		$title_holder = '<a href="'.$url.'"'.$header_background.'>'.$title.'</a>';
	}
	if ($display == '' && $title == '') {
		$title_holder = '<span '.$header_background.'>'.__('News In Pictures','theme').'</span>';
	}
		
$np_class = '';
if ($style == '2') {
	$np_class = 'nip-big';
	$count = 9;
}

	$img_size = 'news_in_pics_big';
	$wide_class = '';
if (mom_option('site_width') == 'wide') {
	$classes = get_body_class();
if (in_array('both-sidebars',$classes)) {
    // nothing
} else {
	$img_size = 'big-wide-img';
	$wide_class = ' nip-wide';
}
	
}	

?>
		
	          <div class="news-box <?php echo $class; ?> base-box new-in-pics <?php echo $np_class.$wide_class; ?>">
                    <header class="nb-header" <?php echo $header_background; ?>>
                        <h2 class="nb-title" <?php echo $header_text_color; ?>><?php echo $title_holder; ?></h2>
                    </header> <!--nb header-->
                    <div class="nb-content">
		<?php if ($style == '2') { ?>
                            <div <?php post_class('nip-recent'); ?>>
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 1,
			'cat' => $category,
			'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,		
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'post_type' => $post_type,'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'posts_per_page' => 1,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1,
				'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query );
		 ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
				<?php global $post; if (mom_post_image() != false) { ?>
                                <a href="<?php the_permalink(); ?>" data-tooltip="<?php echo $post->post_title; ?>" class="simptip-position-top simptip-movable"><?php mom_post_image_full($img_size, 'big-wide-img'); ?></a>
				<?php } ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>		
                            </div>
                            <div class="nip-grid">
                                <ul class="clearfix">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			'offset' => '1',
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			'offset' => '1',
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
						<?php if (mom_post_image() != false) { ?>
				<li <?php post_class(); ?>>
                                <a href="<?php the_permalink(); ?>" data-tooltip="<?php the_title(); ?>" class="simptip-position-top simptip-movable"><?php mom_post_image_full('small-wide', 'small-wide-hd'); ?></a>
				</li>
				<?php } ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		</ul>
                            </div>
                            <div class="clear"></div>
		<?php } else { ?>
                            <div class="nip-grid">
                                <ul class="clearfix">
		<?php
		if ($display == 'category') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $sort,
			); 
		if (!is_numeric($category)) {$args['category_name'] = $category;}
		} elseif ($display == 'tag') {
			$args = array(
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
			'tag_id' => $tag,
			'orderby' => $orderby,
			'order' => $sort,
			); 
			if (!is_numeric($tag)) {$args['tag'] = $tag;}
		} else {
			$args = array(
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $count, 'post_type' => $post_type, 'category__not_in' => $exclude_categories, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts,
				'orderby' => $orderby,
				'order' => $sort,
			); 
		}
		$query = new WP_Query( $args );
		update_post_thumbnail_cache( $query ); ?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); if ($unique_posts) {$do_unique_posts[] = get_the_ID();} ?>
				<?php if (mom_post_image() != false) { ?>
		<li <?php post_class(); ?>>
                                <a href="<?php the_permalink(); ?>" data-tooltip="<?php the_title(); ?>" class="simptip-position-top simptip-movable"><?php mom_post_image_full('news_in_pics', 'small-wide-hd'); ?></a>
				</li>
				<?php } ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
                                </ul>
                            </div>
		<?php } ?>
                    </div> <!--nb content-->
		<?php
		$offset = $count;
		if ($style == 2) {
			$offset = $count+1;
		}
		?>
		    <?php if ($show_more == 'on') { ?>
                    <footer class="nb-footer">
                        <a href="<?php echo $url; ?>" data-post_type="<?php echo $post_type; ?>" class="show-more-<?php echo $show_more_type; ?>" data-offset="<?php echo $offset; ?>" data-number_of_posts="<?php echo $count; ?>" data-display="<?php echo $display; ?>" data-category="<?php echo $category; ?>" data-tag="<?php echo $tag; ?>" data-nbs="<?php echo 'npic'.$style; ?>" data-sort="<?php echo $sort; ?>" data-orderby="<?php echo $orderby; ?>" data-exclude_cats="<?php echo esc_attr($exclude_categories_text); ?>"><?php _e('Show More','theme'); ?> <?php echo $la; ?> </a>
                    </footer>
		<?php } ?>
                    
                </div> <!--news box -->
<?php
	$output = ob_get_contents();
	ob_end_clean();
	set_transient('mom_nip_'.$display.$category.$tag, $output, 60*60*24);
}
	return $output;

	}

add_shortcode('news_in_pics', 'mom_elements_news_in_pics');
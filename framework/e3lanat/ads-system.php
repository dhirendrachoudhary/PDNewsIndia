<?php
/*------------------------------------------*/
/*	ads Columns
/*------------------------------------------*/

add_filter( 'manage_edit-ads_columns', 'e3lanat_extra_cols' );
function e3lanat_extra_cols($columns) {
	unset($columns['views']);
	$columns['ad-views'] = __('Views', 'framework');
    $columns['ad-clicks'] = __('Clicks', 'framework');
    return $columns;
}

add_action( 'manage_posts_custom_column', 'e3lanat_exra_cols_m' );
function e3lanat_exra_cols_m($column) {
    global $post;
	$views = get_post_meta($post->ID, 'ad_views_count', true);
	if ($views == '') {
		$views = 0;
	}
	$clicks = get_post_meta($post->ID, 'ad_clicks_count', true);
	if ($clicks == '') {
		$clicks = 0;
	}

    switch($column) {
        case 'ad-views' :
                echo $views;
        break;
        case 'ad-clicks' :
                echo $clicks;
        break;
    }
}

add_action( 'init', 'mom_e3lanat_ajax_init' );
function mom_e3lanat_ajax_init() {
        //show more
        add_action( 'wp_ajax_mom_mom_adclicks', 'mom_e3lanat_clicks' );  
        add_action( 'wp_ajax_nopriv_mom_mom_adclicks', 'mom_e3lanat_clicks');
}

function mom_e3lanat_clicks() {
	// stay away from bad guys 
$nonce = $_POST['nonce'];
if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
die ( 'Nope!' );
$id = $_POST['id'];
	$count_key = 'ad_clicks_count';
	    $count = get_post_meta($id, $count_key, true);
	    if($count==''){
		$count = 0;
		delete_post_meta($id, $count_key);
		add_post_meta($id, $count_key, '1');
	    }else{
		$count++;
		update_post_meta($id, $count_key, $count);
	    }
exit();
}
function mom_e3lanat_system($atts, $content = null) {
	extract(shortcode_atts(array(
	'id' => '',
	'class' => ''
	), $atts));
	if (! is_preview() ) {
				$count_key = 'ad_views_count';
			    $count = get_post_meta($id, $count_key, true);
			    if($count==''){
				$count = 0;
				delete_post_meta($id, $count_key);
				add_post_meta($id, $count_key, '0');
			    }else{
				$count++;
				update_post_meta($id, $count_key, $count);
			    }
	}
ob_start();

 ?>
	<?php
		global $e3lanat_mb;
		global $e3lanat_content_mb;

		$ad_setting = get_post_meta($id, $e3lanat_mb->get_the_id(), TRUE);
		$size = isset($ad_setting['ad_size']) ? explode('x',$ad_setting['ad_size']) : '';
        $c_class = '';
		if(isset($ad_setting['ad_size'])) {
			if ($ad_setting['ad_size'] == 'custom-size') {
				$w = isset($ad_setting['ad_custom_size_width']) ? $ad_setting['ad_custom_size_width'] : '' ;
				$h = isset($ad_setting['ad_custom_size_height']) ? $ad_setting['ad_custom_size_height'] : '' ;;
				$size = array($w, $h);
			}

		if(isset($ad_setting['ad_size'])) {
			if ($ad_setting['ad_size'] == 'responsive') {
				$w = isset($ad_setting['ad_rsponsive_width']) ? $ad_setting['ad_rsponsive_width'] : '' ;
				$size = array($w, 'auto');
			}
		}
			if ($ad_setting['ad_size'] == 'responsive') {
				$c_class = $ad_setting['ad_size'];
			} else {
				$c_class = '';
			}
		}
		$layout = isset($ad_setting['ad_layout']) ? $ad_setting['ad_layout'] : '';
		$rndn = rand(1,1000);

		$space = isset($ad_setting['ad_space']) ? $ad_setting['ad_space'] : '';
		$w_space = '';
		if ($space != '') {
			if ($layout == 'grid') {
			$w_space = 'margin-right:-'.$space.'px; margin-bottom:-'.$space.'px;';
			}
			$w_space = 'margin-bottom:-'.$space.'px;';
			$space = 'margin-bottom:'.$space.'px;';
		}

		$rotator_dem = '';
		$rotator_rndn = '';
		$arrows_output ='';
		$rotator = false;
		if ($layout == 'rotator') {
		
			$rotator_dem = 'width:'.$size[0].'px; height:'.$size[1].'px;';
			$rotator_rndn = ' e3lanat-rotator-id-'.$rndn;
			$arrows_output = '<div class="adr-arrows"><span class="adr-prev"><i class="enotype-icon-arrow-left4"></i></span><span class="adr-next"><i class="enotype-icon-arrow-right4"></i></span></div>';
			$rotator = true;
		}
		if ($layout != '') {
			$layout = 'e3lanat-layout-'.$layout;
		}
		$empty_link = mom_option('e3lanat_request_page');
		if ($empty_link == '') {
			$empty_link = '#';
		}
		
		// rotator options
		$autoscroll = isset($ad_setting['ad_rotate_autoscroll']) ? $ad_setting['ad_rotate_autoscroll'] : 'true';
		$timeout = isset($ad_setting['ad_rotate_timeout']) ? $ad_setting['ad_rotate_timeout'] : '5000';
		$speed = isset($ad_setting['ad_rotate_speed']) ? $ad_setting['ad_rotate_speed'] : '800';
		$effect = isset($ad_setting['ad_rotate_effect']) ? $ad_setting['ad_rotate_effect'] : '800';
		$arrows = isset($ad_setting['ad_rotate_arrows']) ? $ad_setting['ad_rotate_arrows'] : 'no';
		
		// ads 
		$ads = get_post_meta($id, $e3lanat_content_mb->get_the_id(), TRUE);
		if ($rotator == true) {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.e3lanat-rotator-id-<?php echo $rndn; ?> .mom-e3lanat-inner').imagesLoaded( function() {
			jQuery('.e3lanat-rotator-id-<?php echo $rndn; ?> .mom-e3lanat-inner').boxSlider({
				autoScroll: <?php echo $autoscroll; ?>,
				timeout: <?php echo $timeout; ?>,
				speed: <?php echo $speed; ?>,
				effect: '<?php echo $effect; ?>',
				pauseOnHover: true,
				next:'.e3lanat-rotator-id-<?php echo $rndn; ?> .adr-next',
				prev: '.e3lanat-rotator-id-<?php echo $rndn; ?> .adr-prev'
				
			});

			});

		});
	</script>
	<?php } // end if $rotator true ?>
	<div class="mom-e3lanat-wrap <?php echo $c_class; ?> <?php echo $class; ?>">
	<div class="mom-e3lanat <?php echo $layout.$rotator_rndn; ?>" style="<?php echo $w_space.$rotator_dem; ?>">
	<?php if ($arrows == 'yes') {
		echo $arrows_output;
	} ?>
	<div class="mom-e3lanat-inner">
		
	<?php
	if (!isset($ads['ads'])) {
		//echo '<p>'.__('There are no ads, please add some', 'framework').'</p>';
	} else {
	//shuffle($ads['ads']);
	foreach ($ads['ads'] as $ad) {
		$type = isset($ad['ad_type']) ? $ad['ad_type'] : '';
		$img = isset($ad['ad_image']) ? $ad['ad_image'] : '';
		$img = wp_get_attachment_image_src($img,'full');
		$img = $img[0];
		$url = isset($ad['ad_url']) ? $ad['ad_url'] : '#';
		$url_target = isset($ad['ad_url_target']) ? $ad['ad_url_target'] : '';
		$code = isset($ad['ad_code']) ? $ad['ad_code'] : '';
		$expire_date = isset($ad['ad_expire_date']) ? $ad['ad_expire_date'] : '';
		$today_date = date('m/d/Y');
		$dateArr = '';
		$exp_day = '';
		$today = strtotime($today_date);
		$expiration_date = strtotime($expire_date);
		$output = true;
		$name = isset($ad['ad_title']) ? $ad['ad_title'] : 'ad';
	?>
	<?php
	if ($expire_date != '') {
		 if( $today >= $expiration_date ) {
			$output = false;
		}
	} ?>
	<?php if ($output) { ?>
	<div class="mom-e3lan" data-id="<?php echo $id; ?>" style="<?php if ($c_class != '') { ?>width:<?php echo $size[0]; ?>px; height:<?php echo $size[1]; ?>px; <?php } ?> <?php echo $space; ?>">
		<?php if ($type == 'code') { 
			echo '<div class="e3lan-code">'.do_shortcode($code).'</div>';
		} else { ?>
			<a href="<?php echo $url; ?>" target="<?php echo $url_target; ?>"><img src="<?php echo $img ?>" alt="<?php echo $name; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
		 <?php } ?>
	</div><!--mom ad-->
	<?php } else { ?>
	<?php if ($ad_setting['ad_size'] == 'responsive') { ?>
		<div class="mom-e3lan mom_e3lan-empty border-box" style="width:<?php echo $size[0]; ?>px; <?php echo $space; ?>">
	<?php } else { ?>
		<div class="mom-e3lan mom_e3lan-empty border-box" style="width:<?php echo $size[0]; ?>px; height:<?php echo $size[1]; ?>px; line-height:<?php echo $size[1]; ?>px; <?php echo $space; ?>">
	<?php } ?>
			<a href="<?php echo $empty_link; ?>"><?php _e('Ad Here: ', 'framework'); echo $size[0].'x'.$size[1]; ?></a>
			<a href="<?php echo $empty_link; ?>" class="overlay"></a>
		</div>
	<?php } ?>
	<?php }
	} //end ads here 
	?>
	</div>
	</div>	<!--Mom ads-->
	</div>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;


}
add_shortcode("ad", "mom_e3lanat_system");
?>
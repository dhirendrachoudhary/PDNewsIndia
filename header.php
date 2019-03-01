<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KPSHCCH');</script>
<!-- End Google Tag Manager -->



        
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127388187-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-127388187-1');
</script>


	<meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
if (mom_option('mom_og_tags') == 1) {
if (is_front_page() || is_home()) {
	?>
	<meta property="og:image" content="<?php echo mom_option('logo_img', 'url'); ?>"/>
    <meta property="og:image:width" content="<?php echo get_option( 'medium_size_w' ); ?>" />
    <meta property="og:image:height" content="<?php echo get_option( 'medium_size_h' ); ?>" />

<meta property="og:title" content="<?php echo get_bloginfo() ?>"/>
<meta property="og:type" content="article"/>
<meta property="og:description" content="<?php echo get_bloginfo( 'description' ) ?>"/>
<meta property="og:url" content="<?php the_permalink(); ?>"/>
<meta property="og:site_name" content="<?php echo get_bloginfo() ?>"/>
<?php 

} else {

if (is_singular()) { 
	?>
<meta property="og:image" content="<?php echo mom_post_image('large'); ?>"/>
    <meta property="og:image:width" content="<?php echo get_option( 'large_size_w' ); ?>" />
    <meta property="og:image:height" content="<?php echo get_option( 'large_size_h' ); ?>" />

<?php
    $mom_og_title = get_the_title();
if (function_exists('is_buddypress') && is_buddypress()) {
    if ( bp_is_user() && !bp_is_register_page() ) {
			$mom_og_title = bp_get_displayed_user_fullname();
    } else {
	$mom_og_title = wp_title('', false);
    }
}
?>
<meta property="og:title" content="<?php echo $mom_og_title; ?>"/>
<meta property="og:type" content="article"/>
<meta property="og:description" content="<?php global $post; $og_excerpt = get_the_excerpt(); if ($og_excerpt == false) { $og_excerpt = $post->post_content; } echo wp_html_excerpt(strip_shortcodes($og_excerpt), 200); ?>"/>
<meta property="og:url" content="<?php the_permalink(); ?>"/>
<meta property="og:site_name" content="<?php echo get_bloginfo() ?>"/>
<?php }

} //end else
} //end facebook og ?>

<?php
$responsive = isset($_GET['responsive']) ? esc_attr($_GET['responsive']) : mom_option('enable_responsive');
if($responsive == 'false' || $responsive == false) { ?>
<meta name="viewport" content="user-scalable=yes, minimum-scale=0.25, maximum-scale=3.0" />
<?php } else {  ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php } ?>
<?php if ( mom_option('custom_favicon', 'url') != 'false') { ?>
<link rel="shortcut icon" href="<?php echo mom_option('custom_favicon', 'url'); ?>" />
<?php } ?>
<?php if ( mom_option('apple_touch_icon', 'url') != '') { ?>
<link rel="apple-touch-icon" href="<?php echo mom_option('apple_touch_icon', 'url'); ?>" />
<?php } else { ?>
<link rel="apple-touch-icon" href="<?php echo MOM_URI; ?>/apple-touch-icon-precomposed.png" />
<?php } ?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <!--[if lt IE 9]>
	<script src="<?php echo MOM_HELPERS; ?>/js/html5.js"></script>
	<script src="<?php echo MOM_HELPERS; ?>/js/IE9.js"></script>
	<![endif]-->
	<?php
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
		}

	?>
<?php wp_head(); ?>
    </head>
    <body
    <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <?php do_action('mom_first_on_body');
        if (isset($_GET['login']) && $_GET['login'] == 'failed') {
            echo '<div class="alert-bar hide"><p>'.__('Sorry your username or password is incorrect.', 'theme').'</p></div>';
        }
    ?>

        <!--[if lt IE 7]>
            <p class="browsehappy"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'theme'); ?></p>
        <![endif]-->
        <div class="boxed-wrap clearfix">
	    <div id="header-wrapper">
            <?php if (mom_option('top_banner_position') != 'under_menu')get_template_part('elements/topbanner'); ?>
            <?php
	            get_template_part('elements/topbar');
	            $logo_position = mom_option('logo_position') != '' ? 'logo-'.mom_option('logo_position') :'';
            ?>
            <header class="header <?php echo esc_attr($logo_position); ?>"
            itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
                
                          <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127388187-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-127388187-1');
</script>
                
                
                <div class="inner">
					<?php mom_logo(); ?>
                    <?php
			if (is_singular()) {
			    //custom banner
			    $header_banner = get_post_meta(get_queried_object_id(), 'mom_Header_banner', true);
			    if ($header_banner == '')  {
				$header_banner = mom_option('header_banner_id');
			    }
			} elseif (is_category()) {
			    //custom banner
			    $header_banner = isset($cat_data['custom_banner']) ? $cat_data['custom_banner'] :'';
			    if ($header_banner == '')  {
				$header_banner = mom_option('header_banner_id');
			    }
			} else {
			    $header_banner = mom_option('header_banner_id');
			}

                    if (mom_option('header_banner') != false) { ?>
                    <div class="header-right">
                                  <?php
                                        echo do_shortcode('[ad id="'.$header_banner.'"]');
                                  ?>
                    </div> <!--header right-->
                    <?php } else {
			    if (mom_option('header_custom_content') != '') {
				$mt = mom_option('header_custom_content_mt');
				echo '<div class="header-right header-right_custom-content" style="margin-top:'.$mt.'px">'.do_shortcode(mom_option('header_custom_content')).'</div>';
			    }
		    } ?>

                <div class="clear"></div>
                </div>
            </header>
	    <?php do_action('mom_after_header'); ?>
	    </div> <!--header wrap-->
            <?php get_template_part('elements/navigation'); ?>
             <div style="margin-top:-17px; margin-bottom:20px;"><?php if (mom_option('top_banner_position') == 'under_menu')get_template_part('elements/topbanner'); ?></div>
            <?php do_action('mom_before_content'); ?>
            <div class="inner">
                <?php
		    $nt = mom_option('news_ticker');
		      global $post;
		      if (is_singular()) {
			$pnt = get_post_meta($post->ID, 'mom_disbale_newsticker', true);
			if ($pnt == 1) {
			  $nt = 0;
			}
		      }
		    if ($nt == 1) {
			$nt_title = mom_option('news_ticker_title');
			$nt_display = mom_option('news_ticker_display');
			$nt_category = mom_option('news_ticker_category');
			$nt_tag = mom_option('news_ticker_tag');
			$nt_custom = balancetags(mom_option('news_ticker_custom'));
			$nt_count = mom_option('news_ticker_count');
			$nt_time = mom_option('news_ticker_time');
			$exclude_cats = mom_option('news_ticker_exclude_cats');
			$animation = mom_option('news_ticker_animation');
			if ($nt_time == 0) {
			    $nt_time = 'off';
			}
			$nt_time_format = mom_option('news_ticker_time_format');
			$nt_clock_only = mom_option('news_ticker_time_clock_only');

			$nt_icon = mom_option('news_ticker_icon');
			$nt_icon_url = isset($nt_icon['url']) ? $nt_icon['url'] : '';

			echo do_shortcode('[news_ticker title="'.$nt_title.'" animation="'.$animation.'" display="'.$nt_display.'" category="'.$nt_category.'" tag="'.$nt_tag.'" count="'.$nt_count.'" time="'.$nt_time.'" icon="'.$nt_icon_url.'" clock_only="'.$nt_clock_only.'" time_format="'.$nt_time_format.'" exclude_cats="'.$exclude_cats.'"]'.$nt_custom.'[/news_ticker]');
		    }
		?>
            </div>

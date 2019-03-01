<?php function mom_news_ticker($atts, $content = null) {
	extract(shortcode_atts(array(
	'title' => __('BREAKING NEWS', 'theme'),
	'display' => '',
	'category' => '',
    'animation' => '',
    'exclude_cats' => '',
	'tag' => '',
        'custom' => '',
        'count' => '5',
        'time' => '',
        'icon' => '',
	'time_format' => '',
	'clock_only' => '',
	), $atts));
	if ($title == '') {
	    $title =  __('BREAKING NEWS', 'theme');
	}
    $exclude_cats = explode(',', $exclude_cats);
$output = get_transient('mom_news_ticker');
$output = false;

if ($output == false) { 

	ob_start();
	$site_time = mom_option('main_time') != '' ? mom_option('main_time') : '+2';

            if ($icon == '') {
		if (is_rtl()) {
                $icon = '<i class="fa-icon-double-angle-left"></i>';
		} else {
                $icon = '<i class="fa-icon-double-angle-right"></i>';
		}
            } else {
                $icon = '<img src="'.$icon.'" alt="">';
            }
            $tm = '';
            if ($time == 'off') {
                $tm = 'style="margin:0;"'; 
            }

            if ($animation != '') {
                $animation = 'animation-'.$animation.' custom-animation';
            }

	?>
        
        <div class="breaking-news">
    <div class="the_ticker" <?php echo $tm; ?>>
    <div class="bn-title"><span><?php echo $title; ?></span></div>
    <div class="news-ticker <?php echo $animation; ?>" data-timeout="<?php echo mom_option('news_ticker_timeout'); ?>">
        <ul>
<?php
    if ($display != 'custom') { 
		if ($display == 'category') {
			$args = array(
			'posts_per_page' => $count,
			'cat' => $category,
            'category__not_in' => $exclude_cats
		); 
		} elseif ($display == 'tag') {
			$args = array(
			'posts_per_page' => $count,
			'tag_id' => $tag,
            'category__not_in' => $exclude_cats
		); 
        if (!is_numeric($tag)) {unset($args['tag_id']); $args['tag'] = $tag;}

		} elseif ($display == 'popular') {
            $args = array(
                'posts_per_page' => $count,
                'category__not_in' => $exclude_cats,
                'orderby' => 'comment_count'
            ); 

        } else {
			$args = array(
				'posts_per_page' => $count,
                'category__not_in' => $exclude_cats
        	); 
		}

                $query = new WP_Query( $args );
                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();                
?>
            <li><?php echo $icon; ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; else: ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php } else {
    if ($content != '') {
        $custom = explode(PHP_EOL, $content);
        foreach($custom as $ct) {
            echo '<li>'.$icon.$ct.'</li>';
        } 
    }
} ?>
        </ul>
    </div> <!--news ticker-->
    </div>
    <?php if($time != 'off') { ?>
    <span class="current_time"><?php if (mom_option('news_ticker_time_type') == 0) { ?>
    <?php if ($clock_only != 1) { _e('GMT', 'theme'); echo $site_time; } ?> <?php $h ='h'; $a = 'A'; if ($time_format == 1) { $h = 'H'; $a = ''; } echo date("$h:i", strtotime($site_time.' hours', time()));
    $tp = date("$a", strtotime($site_time.' hours', time()));
    echo ' ';
    if (mom_option('news_ticker_time_suffix') != '') {
    if ($tp == 'PM') {
	echo __('PM', 'theme');
    } elseif ($tp == 'AM') {
	echo __('AM', 'theme');
    }
    }
    ?>
    <?php } else { echo '<span></span>';} ?> <?php echo mom_option('news_ticker_time_suffix'); ?></span>
    <?php } ?>
    </div> <!--breaking news-->
<?php

	$output = ob_get_contents();
	ob_end_clean();
    set_transient('mom_news_ticker', $output, 60*60*24);
}
	return $output;

	
	}
add_shortcode('news_ticker', 'mom_news_ticker');
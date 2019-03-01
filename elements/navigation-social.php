        <?php if(mom_option('twitter_url') != '') { ?>
            <span class="nav-button nav-social-button twitter"><a target="_blank" class="vector_icon" href="<?php echo mom_option('twitter_url'); ?>"><i class="fa-icon-twitter"></i></a></span>
        <?php } ?>

        <?php if(mom_option('facebook_url') != '') { ?>
        <span class="nav-button nav-social-button facebook"><a target="_blank" class="vector_icon" href="<?php echo mom_option('facebook_url'); ?>"><i class="fa-icon-facebook "></i></a></span>        
        <?php } ?>

        <?php if(mom_option('gplus_url') != '') { ?>
           <span class="nav-button nav-social-button gplus"><a target="_blank" class="vector_icon" href="<?php echo mom_option('gplus_url'); ?>" ><i class="fa-icon-google-plus"></i></a></span>     
        <?php } ?>

        <?php if(mom_option('linkedin_url') != '') { ?>
                <span class="nav-button nav-social-button linkedin"><a target="_blank" class="vector_icon" href="<?php echo mom_option('linkedin_url'); ?>"><i class="fa-icon-linkedin"></i></a></span>
        <?php } ?>

        <?php if(mom_option('youtube_url') != '') { ?>
                <span class="nav-button nav-social-button youtube"><a target="_blank" class="vector_icon" href="<?php echo mom_option('youtube_url'); ?>"><i class="fa-icon-youtube"></i></a></span>
        <?php } ?>
        <?php if(mom_option('skype_url') != '') { ?>
	       <span class="nav-button nav-social-button skype"><a target="_blank" class="vector_icon" href="skype:<?php echo mom_option('skype_url'); ?>?call"><i class="fa-icon-skype"></i></a></span>
        <?php } ?>


        <?php if(mom_option('flickr_url') != '') { ?>
                <span class="nav-button nav-social-button flickr"><a target="_blank" class="vector_icon" href="<?php echo mom_option('flickr_url'); ?>"><i class="fa-icon-flickr"></i></a></span>
        <?php } ?>


        <?php if(mom_option('picasa_url') != '') { ?>
        <span class="nav-button nav-social-button picasa"><a target="_blank" class="vector_icon" href="<?php echo mom_option('picasa_url'); ?>"><i class="momizat-icon-picassa"></i></a></span>
        <?php } ?>

        <?php if(mom_option('vimeo_url') != '') { ?>
        <span class="nav-button nav-social-button vimeo"><a target="_blank" class="vector_icon" href="<?php echo mom_option('vimeo_url'); ?>"><i class="momizat-icon-vimeo"></i></a></span>
        <?php } ?>

        <?php if(mom_option('tumblr_url') != '') { ?>
        <span class="nav-button nav-social-button tumblr"><a target="_blank" class="vector_icon" href="<?php echo mom_option('tumblr_url'); ?>"><i class="fa-icon-tumblr"></i></a></span>
        <?php } ?>
        <?php if(mom_option('rss_on_off') != false) { ?>
             <span class="nav-button nav-social-button rss"><a target="_blank" class="vector_icon" href="<?php bloginfo( 'rss2_url' ); ?>"><i class="fa-icon-rss"></i></a></span>
        <?php } ?>	
	<?php
	    //print_r(mom_option('social_icons'));
	    $icons = mom_option('custom_social_icons');
	    if (isset($icons) && $icons != false && is_array($icons) ) {
	    foreach ($icons as $icon) {
			if ( ( isset($icon['icon']) &&  $icon['icon'] != '')) {
			echo '<span class="nav-button nav-social-button">';
			    
			    if ( $icon['icon'] != '') {
				if (0 === strpos($icon['icon'], 'http')) {
					echo '<a target="_blank" class="vector_icon" href="'.$icon['url'].'"><img src="'.$icon['icon'].'" alt=""></i></a>';
				} else {
				$bgcolorh = isset($icon['bgcolorh']) ? $icon['bgcolorh'] : '';
				if ($bgcolorh != '') {
				    $bgcolorh = 'data-bghover="'.$bgcolorh.'"';
				}
				echo '<a target="_blank" class="vector_icon" rel="'.$icon['icon'].'" href="'.$icon['url'].'"'.$bgcolorh.'><i class="'.$icon['icon'].'"></i></a>';
				}
			    } 
			    
	
			echo '</span>';
			}
	    }
	    }
	?>
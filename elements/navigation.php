            <?php
            $lang = '';
            if(defined('ICL_LANGUAGE_CODE')) {
                $lang = ICL_LANGUAGE_CODE;
            }

            if (function_exists('qtrans_getLanguage')) {
                $lang = qtrans_getLanguage();
            }

            if ( is_user_logged_in() ) {
                $user = 'u';
            } else {
                $user = 'v';
            }

            $dd_effect = 'dd-effect-'.mom_option('nav_dd_animation');
            if ($dd_effect == '' || mom_option('nav_dd_animation') == false) {
                $dd_effect = 'dd-effect-slide';
            }
            $nav_sh = '';
            if (mom_option('nav_shadow') == 2) {
                $nav_sh = ' nav_shadow_on';
            } elseif (mom_option('nav_shadow') == 3) {
                $nav_sh = ' nov_white_off';
            }
            ?>
            <nav id="navigation" itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation" class="<?php echo $dd_effect.$nav_sh; ?> ">
                <div class="navigation-inner">
                <div class="inner">
                    <?php if (mom_option('sticky_navigation_logo', 'url') != '') {
                            echo '<a class="sticky_logo" href="'. esc_url(home_url()) .'"><img src="'.mom_option('sticky_navigation_logo', 'url').'" alt="'. get_bloginfo('name') .'"></a>';
                    } ?>
                    <?php if ( has_nav_menu( 'main' ) ) { ?>
                        <?php 
$main_menu_query = get_transient( 'main_menu_query'.get_queried_object_id().$lang.$user );
if (function_exists('is_buddypress')) {$main_menu_query = false;}
if( $main_menu_query === false ) {
    $main_menu_query = wp_nav_menu ( array( 'menu_class' => 'main-menu mom_visibility_desktop','container'=> 'ul', 'theme_location' => 'main', 'walker' => new mom_custom_Walker(), 'echo' => false  )); 
        set_transient( 'main_menu_query'.get_queried_object_id().$lang.$user, $main_menu_query, 60*60*24 );
}
echo $main_menu_query;
    ?>
                    <?php } ?>
                    <?php if ( has_nav_menu( 'main' ) || has_nav_menu( 'mobile_main' ) ) { 
                            $menu_location = 'main';
                            if (has_nav_menu( 'mobile_main' )) {
                                $menu_location = 'mobile_main';
                            }
                    ?>
                        <div class="device-menu-wrap mom_visibility_device">
                        <div id="menu-holder" class="device-menu-holder">
                            <i class="fa-icon-align-justify mh-icon"></i> <span class="the_menu_holder_area"><i class="dmh-icon"></i><?php _e('Menu', 'theme'); ?></span><i class="mh-caret"></i>
                        </div>
                        <?php 
$main_mobile_menu_query = get_transient( 'main_mobile_menu_query'.get_queried_object_id().$lang.$user );
if (function_exists('is_buddypress')) {$main_mobile_menu_query = false;}
if( $main_mobile_menu_query === false ) {
    $main_mobile_menu_query = wp_nav_menu ( array( 'menu_class' => 'device-menu mom_visibility_device','container'=> 'ul', 'theme_location' => $menu_location, 'walker' => new mom_mobile_custom_walker(), 'echo' => false  )); 
        set_transient( 'main_mobile_menu_query'.get_queried_object_id().$lang.$user, $main_mobile_menu_query, 60*60*24 );
}
echo $main_mobile_menu_query;
                        ?>
                        </div>
                        <?php
                        if (file_exists(get_template_directory() . '/demo/demo.php')) {
                            global $mom_iconic_menu;
                                wp_nav_menu ( array( 'menu_class' => 'main-menu mom_visibility_desktop display_none iconic_menu','container'=> 'ul', 'menu' => $mom_iconic_menu, 'walker' => new mom_custom_Walker()  ));
                        }
                        ?>
                    <?php } ?>
		    <div class="nav-buttons">
                    <?php   
                        if (class_exists('woocommerce')) {
                            if (mom_option('nav_cart') == 1) {
			if (class_exists('woocommerce')) {
			    	    global $woocommerce;
				    $cart_url = $woocommerce->cart->get_cart_url();
				    $num = $woocommerce->cart->cart_contents_count;
			}
			$in_woo = mom_option('nav_cart_in_woo');
			$output = '<a href="'.$cart_url.'" class="nav-button nav-cart"><i class="fa-icon-shopping-cart"></i><span class="numofitems" data-num="'.$num.'">'.$num.'</span></a>';

			if ($in_woo) {
			    if(function_exists('is_woocommerce') && mom_is_woocommerce_page()) {
				echo $output;
			    }
			} else {
			    echo $output;
			}
		    } } ?>
                    <?php if (mom_option('nav_login') == 1) { ?>
			<span class="nav-button nav-login">
			    <i class="momizat-icon-users"></i>
			</span>
			<div class="nb-inner-wrap">
			    <div class="nb-inner lw-inner">
			    <?php mom_login_widget(mom_option('nav_login_register_link'), mom_option('nav_login_reset_link')); ?>
			    </div>
			</div>
		    <?php } ?>		    
		    <?php if (mom_option('nav_search') == 1) { ?> 
                    <span class="nav-button nav-search">
                        <i class="fa-icon-search"></i>
                    </span>
                    <div class="nb-inner-wrap search-wrap border-box">
                        <div class="nb-inner sw-inner">
                        <div class="search-form mom-search-form">
                            <form method="get" action="<?php echo home_url(); ?>">
                                <input class="sf" type="text" placeholder="<?php _e('Search ...', 'theme'); ?>" autocomplete="off" name="s">
                                <button class="button" type="submit"><i class="fa-icon-search"></i></button>
                            </form>
                            <span class="sf-loading"><img src="<?php echo MOM_IMG; ?>/ajax-search-nav.gif" alt="loading..." width="16" height="16"></span>
                        </div>
                    <div class="ajax_search_results">
                    </div> <!--ajax search results-->
                    </div> <!--sw inner-->
                    </div> <!--search wrap-->
                    <?php } ?>
		
        <?php if (mom_option('navigation_social_icons')) { get_template_part('elements/navigation-social'); } ?>
		    </div> <!--nav-buttons-->
                    
                </div>
                </div> <!--nav inner-->
            </nav> <!--Navigation-->
            <?php do_action('mom_under_navigation'); ?>
	    <div class="boxed-content-wrapper clearfix">
            <?php if (mom_option('nav_shadow') == 1) { ?> 
            <div class="nav-shaddow"></div>
            <?php } else { ?>
            <div style="height:20px;"></div>
            <?php } ?>


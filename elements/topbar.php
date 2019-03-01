<?php 
$lang = '';
if(defined('ICL_LANGUAGE_CODE')) {
    $lang = ICL_LANGUAGE_CODE;
}
if (mom_option('topbar') == 1) { ?>
 <div class="topbar">
  <div class="inner">
    <?php
if(mom_option('today_date')) {
$date_format = mom_option('today_date_format');
?>
<div class="today_date">
<?php  echo date_i18n( $date_format , strtotime("11/15-1976") ); ?>
</div>
<?php } ?>
        <div class="top-left-content">
            <?php if(mom_option('tn_left_content') == 'custom') {
                echo do_shortcode(mom_option('tn_custom_text'));
             } elseif (mom_option('tn_left_content') == 'social') { ?>
		<?php get_template_part('elements/social', 'icons'); ?>
		<?php } elseif (mom_option('tn_left_content') == 'search') { ?>
                        <div class="search-form">
                            <form method="get" action="<?php echo home_url(); ?>">
                                <input type="text" name="s" placeholder="<?php _e('Search ...', 'theme'); ?>">
                                <button class="button"><i class="fa-icon-search"></i></button>
                            </form>
                        </div>
		<?php } else { ?>
     <?php if ( has_nav_menu( 'topnav' ) ) { ?>
			     <?php  
          
$top_menu_left = get_transient( 'top_menu_left'.get_queried_object_id().$lang );
if (function_exists('is_buddypress')) { $top_menu_left = false;}

if( $top_menu_left === false ) {
    $top_menu_left = wp_nav_menu ( array( 'menu_class' => 'top-nav mom_visibility_desktop','container'=> 'ul', 'theme_location' => 'topnav', 'echo' => false )); 
        set_transient( 'top_menu_left'.get_queried_object_id().$lang, $top_menu_left, 60*60*24 );
}
echo $top_menu_left;
    } //end top menu
           ?>

     <?php if ( has_nav_menu( 'topnav' ) || has_nav_menu( 'mobile_top' ) ) { 
                            $menu_location = 'topnav';
                            if (has_nav_menu( 'mobile_top' )) {
                                $menu_location = 'mobile_top';
                            }
    ?>
			     <div class="mom_visibility_device device-top-menu-wrap">
			      <div class="top-menu-holder"><i class="fa-icon-reorder mh-icon"></i></div>
			      <?php  
           
$top_mobile_menu_left = get_transient( 'top_mobile_menu_left'.get_queried_object_id().$lang );
if (function_exists('is_buddypress')) { $top_mobile_menu_left = false;}

if( $top_mobile_menu_left === false ) {
    $top_mobile_menu_left = wp_nav_menu ( array( 'menu_class' => 'device-top-nav','container'=> 'ul', 'theme_location' => $menu_location, 'walker' => new mom_topmenu_custom_walker(), 'echo' => false )); 
        set_transient( 'top_mobile_menu_left'.get_queried_object_id().$lang, $top_mobile_menu_left, 60*60*24 );
}
echo $top_mobile_menu_left;
            ?>
			     </div>

    <?php } ?>
             <?php }?>
       </div> <!--tb left-->
        <div class="top-right-content">
            <?php if(mom_option('tn_right_content') == 'search') { ?>
                        <div class="search-form">
                            <form method="get" action="<?php echo home_url(); ?>">
                                <input type="text" name="s" placeholder="<?php _e('Search ...', 'theme'); ?>">
                                <button class="button"><i class="fa-icon-search"></i></button>
                            </form>
                        </div>
<?php } elseif(mom_option('tn_right_content') == 'custom') {
                echo do_shortcode(mom_option('tn_right_custom_text'));
    } elseif (mom_option('tn_right_content') == 'menu') { ?> 
     <?php if ( has_nav_menu( 'topnav' ) ) { ?>
           <?php
$top_menu_right = get_transient( 'top_menu_right'.get_queried_object_id().$lang );
if (function_exists('is_buddypress')) { $top_menu_right = false;}

if( $top_menu_right === false ) {
    $top_menu_right = wp_nav_menu ( array( 'menu_class' => 'top-nav mom_visibility_desktop','container'=> 'ul', 'theme_location' => 'topnav', 'echo' => false )); 
        set_transient( 'top_menu_right'.get_queried_object_id().$lang, $top_menu_right, 60*60*24 );
}
echo $top_menu_right;
    } //end top menu
           ?>

     <?php if ( has_nav_menu( 'topnav' ) || has_nav_menu( 'mobile_top' ) ) { 
                            $menu_location = 'topnav';
                            if (has_nav_menu( 'mobile_top' )) {
                                $menu_location = 'mobile_top';
                            }
    ?>
           <div class="mom_visibility_device device-top-menu-wrap">
            <div class="top-menu-holder"><i class="fa-icon-reorder mh-icon"></i></div>
            <?php  
           
$top_mobile_menu_right = get_transient( 'top_mobile_menu_right'.get_queried_object_id().$lang );
if (function_exists('is_buddypress')) { $top_mobile_menu_right = false;}

if( $top_mobile_menu_right === false ) {
    $top_mobile_menu_right = wp_nav_menu ( array( 'menu_class' => 'device-top-nav','container'=> 'ul', 'theme_location' => $menu_location, 'walker' => new mom_topmenu_custom_walker(), 'echo' => false )); 
        set_transient( 'top_mobile_menu_right'.get_queried_object_id().$lang, $top_mobile_menu_right, 60*60*24 );
}
echo $top_mobile_menu_right;
            ?>
           </div>

    <?php } ?>
                
	<?php } else { ?>
		<?php get_template_part('elements/social', 'icons'); ?>

            <?php } ?>
        </div> <!--tb right-->
</div>
 </div> <!--topbar-->
 <?php } ?>
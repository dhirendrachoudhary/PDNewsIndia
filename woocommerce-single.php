<?php 
    //Page settings
    $d_breacrumb = get_post_meta(get_the_ID(), 'mom_disbale_breadcrumb', true);
    $hpt = get_post_meta(get_the_ID(), 'mom_hide_pagetitle', true);
    $PS = get_post_meta(get_the_ID(), 'mom_page_share', true);
    $PC = get_post_meta(get_the_ID(), 'mom_page_comments', true);
    //Page Layout
    $custom_page = get_post_meta(get_the_ID(), 'mom_custom_page', true);
    $layout = get_post_meta(get_the_ID(), 'mom_page_layout', true);
    $right_sidebar = get_post_meta(get_the_ID(), 'mom_right_sidebar', true);
    $left_sidebars = get_post_meta(get_the_ID(), 'mom_left_sidebar', true);

    if ($layout == '') {
        $layout = mom_option('wc_product_layout');
    }
    if ($right_sidebar == '') {
        $right_sidebar = mom_option('wc_product_right_sidebar');
    }
    if ($left_sidebars == '') {
        $left_sidebars = mom_option('wc_product_left_sidebar');
    }

get_header(); ?>
    <div class="inner">
        <?php if ($layout == 'fullwidth') { ?>
                <?php if ($d_breacrumb != true) { ?>
                <div class="category-title">
                        <div class="mom_breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
                </div>
                <?php } ?>
                <?php if ($custom_page) { ?>
            <?php woocommerce_content(); ?>
                <?php } else { ?>
                        <div class="base-box page-wrap">
                        <?php if ($hpt != true) { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>
            <?php woocommerce_content(); ?>
            </div> <!-- base box -->
                <?php } // end cutom page  ?>
        <?php } else { //if not full width ?>
            <div class="main_container">
           <div class="main-col">
                <?php if ($d_breacrumb != true) { ?>
                <div class="category-title">
                        <div class="mom_breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
                </div>
                <?php } ?>
<?php if ($custom_page) { ?>
            <?php woocommerce_content(); ?>
<?php } else { ?>
        <div class="base-box page-wrap">
           <?php if ($hpt != true) { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>
            <?php woocommerce_content(); ?>
        </div> <!-- base box -->
        <?php if ($PC == true) comments_template(); ?>        
<?php } ?>
            </div> <!--main column-->
            <?php get_sidebar('secondary'); ?>
            <div class="clear"></div>
</div> <!--main container-->            
<?php get_sidebar(); ?>
<?php }// end full width ?>            
</div> <!--main inner-->
            
<?php get_footer(); ?>
<?php
/*
 Template Name: fullwidth Page
 */
?>

<?php get_header(); ?>
    <div class="inner">
        <div class="page-wrap" style="margin-bottom:40px;">
                                <?php while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'theme' ), 'after' => '</div>' ) ); ?>
                    <?php endwhile; // end of the loop. ?>

        </div> <!-- base box -->
</div> <!--main inner-->
            
<?php get_footer(); ?>
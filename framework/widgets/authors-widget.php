<?php

add_action('widgets_init','mom_widget_authors');

function mom_widget_authors() {
	register_widget('mom_widget_authors');

	}

class mom_widget_authors extends WP_Widget {
	function __construct() {

		$widget_ops = array('classname' => 'momizat-authors','description' => __('Widget display authors','theme'));
		parent::__construct('momizat-authors_widget',__('Momizat - Authors widget','theme'),$widget_ops);

		}

	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$role = $instance['role'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		                            $users = get_users(array(
		                            	'orderby'	=> $orderby,
		                            	'number'	=> $count,
		                            	'role'		=> $role,

		                            	));
?>
                                <div class="mom-authors-widget">
<?php

                            foreach ( $users as $user ) {
$author_link = esc_url( get_author_posts_url( $user->ID ) );
if (class_exists('userpro_api')) {
	global $userpro;
$author_link = $userpro->permalink(get_the_author_meta( $user->ID ));
}

global $wpdb;
$where = 'WHERE comment_approved = 1 AND user_id = ' . $user->ID ;
$comment_count = $wpdb->get_var(
    "SELECT COUNT( * ) AS total
		FROM {$wpdb->comments}
		{$where}
	");
$post_count = count_user_posts($user->ID);
?>
                                <div class="mom-author clearfix">
                                 <div class="author_avatar">
                                    <a href="<?php echo $author_link; ?>"><?php echo get_avatar($user->ID, 60); ?></a>
                                 </div> <!--End Author Avatar-->
                                 <div class="author_desc">
                                    <h3 class="vcard author">
                                       <span class="fn"><a href="<?php echo $author_link; ?>"><?php the_author_meta( 'display_name', $user->ID ); ?></a></span>
                                    </h3>
                                       <span class="author_info">
                                          <span class="button small comments-count"><?php echo $comment_count; echo ' '; _e('Comments', 'theme'); ?></span>
                                          <span class="button small articles-count"><?php echo $post_count; echo ' '; _e('Posts', 'theme'); ?></span>
                                       </span>
                                 </div> <!--End Author Description-->
                              </div> <!--End About Author-->

<?php
	}
?>
                              </div>
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['role'] = $new_instance['role'];

		return $instance;
	}

function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Our Authors','theme'),
			'count' => 5
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$orderby = isset($instance['orderby']) ? $instance['orderby'] : '';
		$role = isset($instance['role']) ? $instance['role'] : '';

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','theme'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of authors:','theme'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('orderby', 'theme') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo $instance['orderby']; ?>" class="widefat" />
		<small><?php _e("by 'ID', 'login', 'nicename', 'email', 'url', 'registered', 'display_name', 'post_count'",'theme'); ?></small>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'role' ); ?>"><?php _e('Users Role', 'theme') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'role' ); ?>" name="<?php echo $this->get_field_name( 'role' ); ?>" value="<?php echo $instance['role']; ?>" class="widefat" />
		<small><?php _e("Limit the returned users to the role specified",'theme'); ?></small>
		</p>
   <?php
}

 } //end class

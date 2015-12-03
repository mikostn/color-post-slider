<?php
/*
Plugin Name: Color Post Slider
Plugin URI: 
Description: 
Author: miko@stn based on Kailey Lampert work
Version: 1.0
Author URI: http://web.stn.pl/
*/
/*
    Copyright (C) 2015 Miko

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 * Adds Foo_Widget widget.
 */
class colorPostSliderWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'colorPostSliderWidget', // Base ID
			__( 'Color Post Slider Widget', 'text_domain' ), // Name
			array( 'description' => __( 'Color Post Slider Widget', 'text_domain' ), ) // Args
		);

		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes') );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts') );
		add_action( 'admin_footer-post.php', array( &$this, 'admin_footer') );
		add_action( 'admin_footer-post-new.php', array( &$this, 'admin_footer') );
		add_action( 'save_post', array( &$this, 'update_post') );

		add_action( 'wp_print_styles', array( &$this, 'plugin_styles') );
		add_action( 'wp_enqueue_scripts', array( &$this, 'plugin_scripts') );
	}


	/**
	 * Include CSS file for MyPlugin.
	 */
	function plugin_styles() {
	    wp_register_style( 'color-post-slider-css',  plugins_url( '/assets/css/color-post-slider.css', __FILE__ ) );
	    wp_enqueue_style( 'color-post-slider-css' );
	}
	function plugin_scripts() {
		wp_register_script( 'color-post-slider-js', plugins_url( '/assets/js/color-post-slider.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'color-post-slider-js' );
	}

	function add_meta_boxes() {
		add_meta_box('bar-color', 'Bar Color', array( &$this, 'box'), 'color_post', 'side');
	}
	
	function box( $post ) { 
		wp_nonce_field( 'a_save', 'b_color' );
		?>
			<input type="text" class="colorpick" name="color_post_color" value="<?php echo get_post_meta( $post->ID,'color_post_color', true ); ?>" />
		<?php
	}

	function admin_enqueue_scripts( $hook ) {
		// only load these scripts on the proper admin pages
		$ok = array( 'post.php', 'post-new.php' );
		if ( ! in_array( $hook, $ok ) ) return;

		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style('wp-color-picker');
	}	

	function admin_footer() {
		?><script>
	jQuery('.colorpick').wpColorPicker({
		change: function( event, ui ) {
			jQuery(this).val( ui.color.toString() );
		}
	});
		</script><?php
	}

	function update_post( $post_id ) {
		if ( ! isset( $_POST['color_post_color'] ) )
			return;

		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return;

		if ( ! isset( $_POST['post_type'] ) )
			return;

		if( ! wp_verify_nonce( $_POST['b_color'], 'a_save' ) )
			return;

		// Check permissions
		if ( 'post' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		}

		$color = $_POST['color_post_color'];

		update_post_meta( $post_id, 'color_post_color', $color );

	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] :'';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$pq = new WP_Query(array( 'post_type' => 'color_post'));
		
		if( $pq->have_posts() ) :
			include_once('color-post-loop.php');
		endif;
		
		wp_reset_query();

		echo $args['after_widget'];
	}
}

function register_colorPostSliderWidget() {
    register_widget( 'colorPostSliderWidget' );
}
add_action( 'widgets_init', 'register_colorPostSliderWidget' );

function create_color_post_type() {
	register_post_type( 'color_post',
	array(
		'labels' => array(
			'name' => __( 'Color Post Slider' ),
			'singular_name' => __( 'Color Post' )
		),
		'public' => true,
		'has_archive' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'post-formats')
	)
	);
}
add_action( 'init', 'create_color_post_type' );

function rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    create_color_post_type();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'rewrite_flush' );

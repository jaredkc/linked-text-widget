<?php
/**
 * Plugin Name: Linked Text Widget
 * Plugin URI: https://github.com/jaredkc/linked-text-widget
 * Description: A text widget that provides an option to add a link the widget title.
 * Version: 0.1
 * Author: Jared Cornwall
 * Author URI: http://jaredcornwall.com
 */

function register_linked_text_widget() {
	register_widget( 'Linked_Text_Widget' );
}
add_action( 'widgets_init', 'register_linked_text_widget' );

class Linked_Text_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		load_plugin_textdomain( 'linked-text-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );

		parent::__construct(
			'linked-text-widget',
			'Linked Text Widget',
			array( 'description' => __( 'A bold callout with title, description and link.', 'linked-text-widget' ), )
		);
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
		$title = apply_filters( 'widget_title', $instance['title'] );
		$description = wpautop( $instance['description'] );
		$link = $instance['link'];

		echo $args['before_widget'];
		if ( (! empty( $title )) && (! empty ( $link )) ) {
			echo $args['before_title'] . '<a href="' . $link . '"' . '>' . $title . '</a>' . $args['after_title'];
		} else {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if ( ! empty( $description ) ) {
			echo $description;
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// Set defaults
		if( !isset($instance['title']) ) { $instance['title'] = ''; }
		if( !isset($instance['description']) ) { $instance['description'] = ''; }
		if( !isset($instance['link']) ) { $instance['link'] = ''; }

		$title = $instance[ 'title' ];
		$description = $instance[ 'description' ];
		$link = $instance[ 'link' ];
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link: (http://example.com)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
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
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		return $instance;
	}

}
<?php

class Anila_WP_Widget_Event_Details extends WP_Widget {

	/**
	 * Sets up a new Service List widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_event_details',
			'description'                 => __( 'Displays the information in the event details page', 'anila' ),
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
		parent::__construct( 'event-details', 'Anila '.__( 'Event Details', 'anila' ), $widget_ops );
		$this->alt_option_name = 'widget_event_details';
	}

	/**
	 * Outputs the content for the current Service List widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Service List widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if (!is_singular('event')) {
			echo '<pre>'; echo __('Only show in event detail page', 'anila'); echo '</pre>';
			return;
		}

		$default_title = __( 'Event Details', 'anila' );
		$title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$show_time_start = isset( $instance['show_time_start'] ) ? $instance['show_time_start'] : false;
		$show_time_end = isset( $instance['show_time_end'] ) ? $instance['show_time_end'] : false;
		$show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
		$show_price = isset( $instance['show_price'] ) ? $instance['show_price'] : false;

		if (!($show_time_start || $show_time_end || $show_category || $show_price)) return;

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$event_id = get_the_ID();

		$datetime_format = apply_filters('anila_datetime_format_event_details', get_option('date_format', 'F j, Y') . ' @ ' . get_option('time_format', 'g:i a'));
		?>

		<ul class="anila-event-details">
			<?php 
			if ($show_time_start) {
				$event_time_start = get_post_meta($event_id, 'event_time_start', true);
				if(!empty($event_time_start)) {
					?>
					<li>
						<strong><?php _e('Start:', 'anila') ?></strong>
						<span><?php echo esc_html(date( $datetime_format, $event_time_start )) ?></span>
					</li>
					<?php
				}
			}
			if ($show_time_end) {
				$event_time_end = get_post_meta($event_id, 'event_time_end', true);
				if(!empty($event_time_end)) {
					?>
					<li>
						<strong><?php _e('End:', 'anila') ?></strong>
						<span><?php echo esc_html(date( $datetime_format, $event_time_end )) ?></span>
					</li>
					<?php
				}
			}
			if ($show_category) {
				$terms = get_the_terms( $event_id, 'event-category' );
				if($event_time_end && !is_wp_error($terms)) {
					$terms = join(', ', wp_list_pluck( $terms , 'name') );
					?>
					<li>
						<strong><?php _e('Category:', 'anila') ?></strong>
						<span><?php echo esc_html($terms) ?></span>
					</li>
					<?php
				}
			}
			if ($show_price) {
				$event_fee = get_post_meta($event_id, 'event_fee', true);
				if(!empty($event_fee)) {
					?>
					<li>
						<strong><?php _e('Price:', 'anila') ?></strong>
						<span><?php echo esc_html($event_fee) ?></span>
					</li>
					<?php
				}
			}
			do_action('anila_more_details_for_event', $args);
			?>
		</ul>

		<?php

		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Service List widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['show_time_start'] = isset( $new_instance['show_time_start'] ) ? (bool) $new_instance['show_time_start'] : false;
		$instance['show_time_end'] = isset( $new_instance['show_time_end'] ) ? (bool) $new_instance['show_time_end'] : false;
		$instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
		$instance['show_price'] = isset( $new_instance['show_price'] ) ? (bool) $new_instance['show_price'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Service List widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$show_time_start = isset( $instance['show_time_start'] ) ? (bool) $instance['show_time_start'] : false;
		$show_time_end = isset( $instance['show_time_end'] ) ? (bool) $instance['show_time_end'] : false;
		$show_category = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
		$show_price = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : false;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'anila' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_time_start ); ?> id="<?php echo $this->get_field_id( 'show_time_start' ); ?>" name="<?php echo $this->get_field_name( 'show_time_start' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_time_start' ); ?>"><?php _e( 'Display event time start?', 'anila' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_time_end ); ?> id="<?php echo $this->get_field_id( 'show_time_end' ); ?>" name="<?php echo $this->get_field_name( 'show_time_end' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_time_end' ); ?>"><?php _e( 'Display event time end?', 'anila' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display event category?', 'anila' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_price ); ?> id="<?php echo $this->get_field_id( 'show_price' ); ?>" name="<?php echo $this->get_field_name( 'show_price' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_price' ); ?>"><?php _e( 'Display event price?', 'anila' ); ?></label>
		</p>
		<?php
	}
}

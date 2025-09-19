<?php

/**
 * Sets up the anila_service_loop global from the passed args or from the main query.
 *
 * @since 3.3.0
 * @param array $args Args to pass into the global.
 */
function anila_setup_service_loop( $args = array() ) {
	$default_args = array(
		'loop'         => 0,
		'columns'      => 4,
		'name'         => '',
		'is_shortcode' => false,
		'is_paginated' => true,
		'is_search'    => false,
		'is_filtered'  => false,
		'total'        => 0,
		'total_pages'  => 0,
		'per_page'     => 0,
		'current_page' => 1,
	);

	$default_args = array_merge(
		$default_args,
		array(
			'is_search'    => $GLOBALS['wp_query']->is_search(),
			'total'        => $GLOBALS['wp_query']->found_posts,
			'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
			'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
			'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
		)
	);

	// Merge any existing values.
	if ( isset( $GLOBALS['anila_service_loop'] ) ) {
		$default_args = array_merge( $default_args, $GLOBALS['anila_service_loop'] );
	}

	$GLOBALS['anila_service_loop'] = wp_parse_args( $args, $default_args );

    // echo '<pre>'; print_r($GLOBALS['anila_service_loop']); echo '</pre>';
}

/**
 * Resets the anila_service_loop global.
 *
 * @since 3.3.0
 */
function anila_reset_service_loop() {
	unset( $GLOBALS['anila_service_loop'] );
}

/**
 * Gets a property from the anila_service_loop global.
 *
 * @since 3.3.0
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */
function anila_get_service_loop_prop( $prop, $default = '' ) {
	anila_setup_service_loop(); // Ensure shop loop is setup.

	return isset( $GLOBALS['anila_service_loop'], $GLOBALS['anila_service_loop'][ $prop ] ) ? $GLOBALS['anila_service_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the anila_service_loop global.
 *
 * @since 3.3.0
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */
function anila_set_service_loop_prop( $prop, $value = '' ) {
	if ( ! isset( $GLOBALS['anila_service_loop'] ) ) {
		anila_setup_service_loop();
	}
	$GLOBALS['anila_service_loop'][ $prop ] = $value;
}


if ( ! function_exists( 'anila_service_loop_start' ) ) {

	/**
	 * Output the start of a service loop. By default this is a UL.
	 *
	 * @param bool $echo Should echo?.
	 * @return string
	 */
	function anila_service_loop_start( $echo = true ) {
		ob_start();

		anila_set_service_loop_prop( 'loop', 0 );

		// wc_get_template( 'loop/loop-start.php' );
        get_template_part( 'template-parts/service/loop/loop', 'start' );

		$loop_start = apply_filters( 'anila_service_loop_start', ob_get_clean() );

		if ( $echo ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			printf('%s', $loop_start);
		} else {
			return $loop_start;
		}
	}
}

if ( ! function_exists( 'anila_service_loop_end' ) ) {

	/**
	 * Output the end of a service loop. By default this is a UL.
	 *
	 * @param bool $echo Should echo?.
	 * @return string
	 */
	function anila_service_loop_end( $echo = true ) {
		ob_start();

		// wc_get_template( 'loop/loop-end.php' );
        get_template_part( 'template-parts/service/loop/loop', 'end' );

		$loop_end = apply_filters( 'anila_service_loop_end', ob_get_clean() );

		if ( $echo ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			printf('%s', $loop_end);
		} else {
			return $loop_end;
		}
	}
}

/**
 * Resets the anila_service_loop global.
 *
 * @since 3.3.0
 */
function anila_service_reset_loop() {
	unset( $GLOBALS['anila_service_loop'] );
}

if ( ! function_exists( 'anila_get_service_icon' ) ) {
	/**
	 * Output the end of a service loop. By default this is a UL.
	 *
	 * @param bool $echo Should echo?.
	 * @return string
	 */
	function anila_get_service_icon() {
		$service_id = get_the_ID();
		$icon_id = intval(get_post_meta($service_id, '_service_icon_id', true));
		
		if (!$icon_id || $icon_id <= 0) {
			return false;
		}
		
		$icon_path = wp_get_original_image_path($icon_id);
		if(!$icon_path) return false;
		
		if(mime_content_type($icon_path) && in_array(mime_content_type($icon_path), ['image/svg+xml', 'image/svg'])) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
			$filesystem = new WP_Filesystem_Direct( true );
			return $filesystem->get_contents($icon_path);
		}
		
		$icon_url = wp_get_attachment_image_src( $icon_id, 'large' );
		if (!$icon_url || !is_array($icon_url)) {
			return false;
		}
		return '<img class="service_icon_img" src="'.$icon_url[0].'" alt="">';
	}
}

if ( ! function_exists( 'anila_get_thumbnail_service_url' ) ) {
	/**
	 * Output the end of a service loop. By default this is a UL.
	 *
	 * @param bool $echo Should echo?.
	 * @return string
	 */
	function anila_get_thumbnail_service_url() {
		$id = get_the_ID();
		$size = 'large';
		if (has_post_thumbnail( $id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
			return $image[0];
		}

		// use first attached image
		$images = get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $id );
		if (!empty($images)) {
			$image = reset($images);
			$image_data = wp_get_attachment_image_src( $id, $size );
			return $image_data[0];
		}

		// use no preview fallback
		return Elementor\Utils::get_placeholder_image_src();
	}
}
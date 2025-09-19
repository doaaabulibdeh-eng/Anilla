<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Event shortcode class.
 */
class Anila_Content_Event {

	/**
	 * Attributes.
	 *
	 * @var   array
	 */
	protected $attributes = array();

	/**
	 * Query args.
	 *
	 * @var   array
	 */
	protected $query_args = array();

	/**
	 * Set custom visibility.
	 *
	 * @var   bool
	 */
	protected $custom_visibility = false;

	/**
	 * Initialize shortcode.
	 *
	 * @param array  $attributes Shortcode attributes.
	 * @param string $type       Shortcode type.
	 */
	public function __construct( $attributes = array() ) {
		$this->attributes = $this->parse_attributes( $attributes );
		$this->query_args = $this->parse_query_args();
	}

	/**
	 * Get shortcode attributes.
	 *
	 * @return array
	 */
	public function get_attributes() {
		return $this->attributes;
	}

	/**
	 * Get query args.
	 *
	 * @return array
	 */
	public function get_query_args() {
		return $this->query_args;
	}

	/**
	 * Get shortcode content.
	 *
	 * @return string
	 */
	public function get_content() {
		return $this->event_loop();
	}

	/**
	 * Parse attributes.
	 *
	 * @param  array $attributes Shortcode attributes.
	 * @return array
	 */
	protected function parse_attributes( $attributes ) {
        // $attributes = $this->parse_legacy_attributes( $attributes );
        
		$attributes = wp_parse_args(
            $attributes,
            array(
				'limit'          => '-1',      // Results limit.
				'columns'        => '',        // Number of columns.
				'rows'           => '',        // Number of rows. If defined, limit will be ignored.
				'orderby'        => '',        // menu_order, title, date, rand, price, popularity, rating, or id.
				'order'          => '',        // ASC or DESC.
				'attribute'      => '',        // Single attribute slug.
				'class'          => '',        // HTML class.
				'page'           => 1,         // Page for pagination.
				'paginate'       => false,     // Should results be paginated.
				'cache'          => true,      // Should shortcode output be cached.
			),
		);

		if ( ! absint( $attributes['columns'] ) ) {
			$attributes['columns'] = 4;
		}

		return $attributes;
	}

	/**
	 * Parse query args.
	 *
	 * @return array
	 */
	protected function parse_query_args() {
		$query_args = array(
			'post_type'           => 'event',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'orderby'             => $this->attributes['orderby'],
        );

		$orderby_value         = explode( '-', $query_args['orderby'] );
		$orderby               = esc_attr( $orderby_value[0] );
		$order                 = ! empty( $orderby_value[1] ) ? $orderby_value[1] : strtoupper( $this->attributes['order'] );
		$query_args['orderby'] = $orderby;
		$query_args['order']   = $order;

		if (isset($this->attributes['post__not_in']) && !empty($this->attributes['post__not_in'])) {
			$query_args['post__not_in'] = $this->attributes['post__not_in'];
		}

		if ( anila_string_to_bool( $this->attributes['paginate'] ) ) {
			$this->attributes['page'] = absint( empty( $_GET['event-page'] ) ? 1 : $_GET['event-page'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		if ( ! empty( $this->attributes['rows'] ) ) {
			$this->attributes['limit'] = $this->attributes['columns'] * $this->attributes['rows'];
		}

		$query_args['posts_per_page'] = intval( $this->attributes['limit'] );
		if ( 1 < $this->attributes['page'] ) {
			$query_args['paged'] = absint( $this->attributes['page'] );
		}
		$query_args['tax_query']  = array(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		$this->set_categories_query_args( $query_args );

		// Always query only IDs.
		$query_args['fields'] = 'ids';

		return apply_filters('anila_query_args_param_list_event', $query_args);
	}

	/**
	 * Set categories query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_categories_query_args( &$query_args ) {
		if ( ! empty( $this->attributes['category'] ) ) {
			$categories = array_map( 'sanitize_title', explode( ',', $this->attributes['category'] ) );
			$field      = 'slug';

			if ( is_numeric( $categories[0] ) ) {
				$field      = 'term_id';
				$categories = array_map( 'absint', $categories );
				// Check numeric slugs.
				foreach ( $categories as $cat ) {
					$the_cat = get_term_by( 'slug', $cat, 'event-cat' );
					if ( false !== $the_cat ) {
						$categories[] = $the_cat->term_id;
					}
				}
			}

			$query_args['tax_query'][] = array(
				'taxonomy'         => 'event-cat',
				'terms'            => $categories,
				'field'            => $field,
				'operator'         => $this->attributes['cat_operator'],

				/*
				 * When cat_operator is AND, the children categories should be excluded,
				 * as only products belonging to all the children categories would be selected.
				 */
				'include_children' => 'AND' === $this->attributes['cat_operator'] ? false : true,
			);
		}
	}

    /**
	 * Get wrapper classes.
	 *
	 * @param  int $columns Number of columns.
	 * @return array
	 */
	protected function get_wrapper_classes( $columns ) {
		$classes = array( 'anila-event' );

        $classes[] = 'columns-' . $columns;

		$classes[] = $this->attributes['class'];

		return $classes;
	}

    /**
	 * Run the query and return an array of data, including queried ids and pagination information.
	 *
	 * @return object Object with the following props; ids, per_page, found_posts, max_num_pages, current_page
	 */
	protected function get_query_results() {
		
			$query = new WP_Query( $this->query_args );

			$paginated = ! $query->get( 'no_found_rows' );

			$results = (object) array(
				'ids'          => wp_parse_id_list( $query->posts ),
				'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
				'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
				'per_page'     => (int) $query->get( 'posts_per_page' ),
				'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
			);

		/**
		 * Filter shortcode event query results.
		 *
		 * @param stdClass $results Query results.
		 */
		return apply_filters( 'anila_shortcode_event_query_results', $results, $this );
	}

	/**
	 * Loop over found event.
	 *
	 * @return string
	 */
	protected function event_loop() {
		$columns  = absint( $this->attributes['columns'] );
		$classes  = $this->get_wrapper_classes( $columns );
		$event = $this->get_query_results();

		ob_start();

		if ( $event && $event->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $event->ids );
			}

			// Setup the loop.
            $setup_args = [
                'columns'      => $columns,
                'is_shortcode' => true,
                'is_search'    => false,
                'is_paginated' => anila_string_to_bool( $this->attributes['paginate'] ),
                'total'        => $event->total,
                'total_pages'  => $event->total_pages,
                'per_page'     => $event->per_page,
                'current_page' => $event->current_page,
            ];

            if (isset($this->attributes['enable_carousel'])) {
                $setup_args['enable_carousel'] = anila_string_to_bool( $this->attributes['enable_carousel'] );
            }
            if (isset($this->attributes['style'])) {
                $setup_args['style'] = $this->attributes['style'];
            }
			if (isset($this->attributes['show_title'])) {
                $setup_args['show_title'] = $this->attributes['show_title'];
            }
			if (isset($this->attributes['show_exerpt'])) {
                $setup_args['show_exerpt'] = $this->attributes['show_exerpt'];
            }
			if (isset($this->attributes['show_button'])) {
                $setup_args['show_button'] = $this->attributes['show_button'];
            }
			if (isset($this->attributes['show_time'])) {
                $setup_args['show_time'] = $this->attributes['show_time'];
            }
			if (isset($this->attributes['show_address'])) {
                $setup_args['show_address'] = $this->attributes['show_address'];
            }

			anila_setup_event_loop($setup_args);

            // echo '<pre>'; print_r(); echo '</pre>';

			$original_post = $GLOBALS['post'];

			anila_event_loop_start();

			if ( anila_get_event_loop_prop( 'total' ) ) {
				foreach ( $event->ids as $event_id ) {
					$GLOBALS['post'] = get_post( $event_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Render event template.
					get_template_part( 'template-parts/event/content', 'event' );

				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			anila_event_loop_end();

			if ( anila_string_to_bool( $this->attributes['paginate'] ) ) {
				$args = array(
					'total'   => anila_get_event_loop_prop( 'total_pages' ),
					'current' => anila_get_event_loop_prop( 'current_page' ),
					'base'    => esc_url_raw( add_query_arg( 'event-page', '%#%', false ) ),
					'format'  => '?event-page=%#%',
				);
		
				get_template_part( 'template-parts/event/loop/pagination', '', $args);
			}

			if (isset($this->attributes['enable_carousel']) && $this->attributes['enable_carousel'] === 'yes') {
                anila_set_event_loop_prop('enable_carousel', false);
                if (isset($this->attributes['carousel_settings']) && $this->attributes['carousel_settings'] != '') {
                    echo wp_kses_post($this->attributes['carousel_settings']);
                }
            }

			wp_reset_postdata();
			anila_event_reset_loop();
		} else {
			echo esc_attr(apply_filters('anila_event_nodata_found', __('No data was founded', 'anila')));
		}

		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . ob_get_clean() . '</div>';
	}

}

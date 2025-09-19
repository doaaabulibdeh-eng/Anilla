<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract($args);

$total   = isset( $total ) ? $total : anila_get_service_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : anila_get_service_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) { 
	return;
}
?>
<nav class="service-pagination pagination">
	<?php
	echo paginate_links(
		apply_filters(
			'service_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
                'next_text' => '<span>' . esc_html__('Next', 'anila') . '<i class="anila-icon-double-right"></i></span>',
                'prev_text' => '<span><i class="anila-icon-double-left"></i>' . esc_html__('Prev', 'anila') . '</span>',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	?>
</nav>

<?php
/**
 * =================================================
 * Hook anila_page
 * =================================================
 */
add_action('anila_page', 'anila_page_header', 10);
add_action('anila_page', 'anila_page_content', 20);

/**
 * =================================================
 * Hook anila_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook anila_single_post
 * =================================================
 */
add_action('anila_single_post', 'anila_post_thumbnail', 15);
add_action('anila_single_post', 'anila_post_excerpt', 20);
add_action('anila_single_post', 'anila_post_header', 10);
add_action('anila_single_post', 'anila_post_content', 30);

/**
 * =================================================
 * Hook anila_single_post_bottom
 * =================================================
 */
add_action('anila_single_post_bottom', 'anila_post_taxonomy', 5);
add_action('anila_single_post_bottom', 'anila_post_nav', 10);
add_action('anila_single_post_bottom', 'anila_single_author', 15);
add_action('anila_single_post_bottom', 'anila_display_comments', 20);

/**
 * =================================================
 * Hook anila_loop_post
 * =================================================
 */
add_action('anila_loop_post', 'anila_post_header', 15);
add_action('anila_loop_post', 'anila_post_content', 30);

/**
 * =================================================
 * Hook anila_after_container
 * =================================================
 */
add_action('anila_after_container', 'anila_output_related_products', 20);

/**
 * =================================================
 * Hook anila_before_footer
 * =================================================
 */
add_action('anila_before_footer', 'anila_coach_bottom_template', 10);

/**
 * =================================================
 * Hook anila_footer
 * =================================================
 */
add_action('anila_footer', 'anila_footer_default', 20);

/**
 * =================================================
 * Hook anila_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'anila_template_account_dropdown', 1);
add_action('wp_footer', 'anila_mobile_nav', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'anila_pingback_header', 1);

/**
 * =================================================
 * Hook anila_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook anila_before_content
 * =================================================
 */
add_action('anila_before_content', 'anila_archive_blog_top', 10);

/**
 * =================================================
 * Hook anila_before_container
 * =================================================
 */

/**
 * =================================================
 * Hook anila_content_top
 * =================================================
 */

/**
 * =================================================
 * Hook anila_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook anila_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook anila_sidebar
 * =================================================
 */
add_action('anila_sidebar', 'anila_get_sidebar', 10);

/**
 * =================================================
 * Hook anila_loop_before
 * =================================================
 */

/**
 * =================================================
 * Hook anila_loop_after
 * =================================================
 */
add_action('anila_loop_after', 'anila_paging_nav', 10);

/**
 * =================================================
 * Hook anila_page_after
 * =================================================
 */
add_action('anila_page_after', 'anila_display_comments', 10);

/**
 * =================================================
 * Hook anila_single_event_top
 * =================================================
 */

/**
 * =================================================
 * Hook anila_single_event
 * =================================================
 */
add_action('anila_single_event', 'anila_event_header', 10);
add_action('anila_single_event', 'anila_event_thumbnail', 10);
add_action('anila_single_event', 'anila_post_content', 30);

/**
 * =================================================
 * Hook anila_single_event_bottom
 * =================================================
 */
add_action('anila_single_event_bottom', 'anila_event_tags', 10);

/**
 * =================================================
 * Hook anila_woocommerce_list_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_list_item_content
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_before_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_before_shop_loop_item_image
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_shop_loop_item_caption
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_after_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook anila_product_list_start
 * =================================================
 */

/**
 * =================================================
 * Hook anila_product_list_image
 * =================================================
 */

/**
 * =================================================
 * Hook anila_product_list_content
 * =================================================
 */

/**
 * =================================================
 * Hook anila_product_list_end
 * =================================================
 */

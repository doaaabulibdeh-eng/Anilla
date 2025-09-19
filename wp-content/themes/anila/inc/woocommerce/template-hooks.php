<?php
/**
 * =================================================
 * Hook anila_page
 * =================================================
 */

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

/**
 * =================================================
 * Hook anila_single_post_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook anila_loop_post
 * =================================================
 */

/**
 * =================================================
 * Hook anila_after_container
 * =================================================
 */

/**
 * =================================================
 * Hook anila_before_footer
 * =================================================
 */

/**
 * =================================================
 * Hook anila_footer
 * =================================================
 */

/**
 * =================================================
 * Hook anila_after_footer
 * =================================================
 */
add_action('anila_after_footer', 'anila_sticky_single_add_to_cart', 999);

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'anila_render_woocommerce_shop_canvas', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */

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
add_action('anila_content_top', 'anila_shop_messages', 10);

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

/**
 * =================================================
 * Hook anila_page_after
 * =================================================
 */

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

/**
 * =================================================
 * Hook anila_single_event_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook anila_woocommerce_list_item_title
 * =================================================
 */
add_action('anila_woocommerce_list_item_title', 'anila_product_label', 5);
add_action('anila_woocommerce_list_item_title', 'anila_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook anila_woocommerce_list_item_content
 * =================================================
 */
add_action('anila_woocommerce_list_item_content', 'woocommerce_template_loop_product_title', 10);
add_action('anila_woocommerce_list_item_content', 'anila_woocommerce_get_product_description', 15);
add_action('anila_woocommerce_list_item_content', 'woocommerce_template_loop_rating', 15);
add_action('anila_woocommerce_list_item_content', 'woocommerce_template_loop_price', 20);
add_action('anila_woocommerce_list_item_content', 'anila_stock_label', 25);

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
add_action('anila_woocommerce_before_shop_loop_item_image', 'anila_product_label', 10);
add_action('anila_woocommerce_before_shop_loop_item_image', 'woocommerce_template_loop_product_thumbnail', 15);
add_action('anila_woocommerce_before_shop_loop_item_image', 'anila_woocommerce_product_loop_action_start', 20);
add_action('anila_woocommerce_before_shop_loop_item_image', 'anila_quickview_button', 30);
add_action('anila_woocommerce_before_shop_loop_item_image', 'anila_woocommerce_product_loop_action_close', 40);
add_action('anila_woocommerce_before_shop_loop_item_image', 'anila_single__quantity_cart', 50);

/**
 * =================================================
 * Hook anila_woocommerce_shop_loop_item_caption
 * =================================================
 */
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_woocommerce_get_product_category', 5);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_single__rating_brands', 10);
add_action('anila_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_product_title', 15);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_woocommerce_get_product_description', 20);
add_action('anila_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_price', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_single_product_extra_label', 25);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_woocommerce_product_loop_action_start', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_wishlist_button', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_quickview_button', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_compare_button', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_woocommerce_product_loop_action_close', 30);
add_action('anila_woocommerce_shop_loop_item_caption', 'anila_single__quantity_cart', 35);

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
add_action('anila_product_list_image', 'anila_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook anila_product_list_content
 * =================================================
 */
add_action('anila_product_list_content', 'woocommerce_template_loop_product_title', 10);
add_action('anila_product_list_content', 'anila_single_product_extra_label', 15);
add_action('anila_product_list_content', 'woocommerce_template_loop_price', 20);

/**
 * =================================================
 * Hook anila_product_list_end
 * =================================================
 */

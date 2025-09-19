<?php

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('product-list', $product); ?>>
    <?php
    /**
     * Functions hooked in to anila_woocommerce_before_shop_loop_item action
     *
     */
    do_action('anila_woocommerce_before_shop_loop_item');

    ?>
    <div class="product-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php
            /**
             * Functions hooked in to anila_woocommerce_before_shop_loop_item_image action
             *
             * @see anila_product_label - 10 - woo
             * @see woocommerce_template_loop_product_thumbnail - 15 - woo
             * @see anila_woocommerce_product_loop_action_start - 20 - woo
             * @see anila_quickview_button - 30 - woo
             * @see anila_woocommerce_product_loop_action_close - 40 - woo
             * @see anila_single__quantity_cart - 50 - woo
             */
            do_action('anila_woocommerce_before_shop_loop_item_image');
            ?>
        </a>
    </div>
    <div class="product-caption">
        <?php
        /**
         * Functions hooked in to anila_woocommerce_shop_loop_item_caption action
         *
         * @see anila_woocommerce_get_product_category - 5 - woo
         * @see anila_single__rating_brands - 10 - woo
         * @see woocommerce_template_loop_product_title - 15 - woo
         * @see anila_woocommerce_get_product_description - 20 - woo
         * @see woocommerce_template_loop_price - 30 - woo
         * @see anila_single_product_extra_label - 25 - woo
         * @see anila_woocommerce_product_loop_action_start - 30 - woo
         * @see anila_wishlist_button - 30 - woo
         * @see anila_quickview_button - 30 - woo
         * @see anila_compare_button - 30 - woo
         * @see anila_woocommerce_product_loop_action_close - 30 - woo
         * @see anila_single__quantity_cart - 35 - woo
         */
        do_action('anila_woocommerce_shop_loop_item_caption');
        ?>
    </div>
    <?php
    /**
     * Functions hooked in to anila_woocommerce_after_shop_loop_item action
     *
     */
    do_action('anila_woocommerce_after_shop_loop_item');
    ?>
</li>

<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_sku = ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'anila');
$separator = '<span style="color:var(--e-global-color-secondary);"> , </span>';

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

    <?php echo wc_get_product_category_list( $product->get_id(), $separator , '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'anila' ) . '  ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), $separator , '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'anila' ) . '  ', '</span>' ); ?>

    <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
        <span class="sku_wrapper"><?php esc_html_e('SKU:', 'anila'); ?> <span class="sku"><?php echo esc_html($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'anila'); ?></span></span>
    <?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
    <div class="pbr-social-share">
        <?php esc_html_e('share:', 'anila'); ?>
        <a class="bo-social-facebook" href="<?php echo 'http://www.facebook.com/sharer.php?s=100&amp;p[url]=' . get_the_permalink() . '&amp;p[title]=' . urlencode('Dri Fit Academy Football Drill Top'); ?>" target="_blank" title="Share on facebook">
            <i class="opal-icon-facebook-f"></i>
        </a>

        <a class="bo-social-twitter" href="<?php echo 'http://twitter.com/home?status=' . get_the_permalink(); ?>" target="_blank" title="Share on Twitter">
            <i class="opal-icon-twitter"></i>
        </a>

        <a class="bo-social-youtube" href="<?php echo 'http://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&amp;description=' . urlencode('Dri Fit Academy Football Drill Top'); ?>" target="_blank" title="Share on Pinterest">
            <i class="opal-icon-youtube"></i>
        </a>

        <a class="bo-social-instagram" href="<?php echo 'http://linkedin.com/shareArticle?mini=true&amp;url=' . get_the_permalink() . '&amp;title=' . urlencode('Dri Fit Academy Football Drill Top'); ?>" target="_blank" title="Share on LinkedIn">
            <i class="opal-icon-instagram"></i>
        </a>

    </div>
</div>



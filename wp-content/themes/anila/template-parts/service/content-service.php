<?php
/**
 * The template for displaying product content within loops
 *
 */

defined('ABSPATH') || exit;

$class = 'service';
if (anila_get_service_loop_prop('enable_carousel', false) == true) {
    $class .= ' swiper-slide';
}
if ($style = anila_get_service_loop_prop('style', 1)) {
    $class .= ' service-style-'.$style;
}

?>
<li class="<?php echo esc_attr($class); ?>">
    <div class="service-block">
        <?php
        if ($style != 4) {
            ?>
            <div class="service-transition">
                <div class="service-img-wrap bottom-to-top">
                    <div class="inner">
                        <figure class="service-image">
                            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
                                <img src="<?php echo esc_attr(anila_get_thumbnail_service_url()) ?>" class="service_thumbnail" alt="<?php the_title() ?>">
                            </a>
                        </figure>
                    </div>
                </div>
            </div>
            <?php
        }
        else {
            ?><div class="service-index-item"><span><?php echo esc_html(str_pad($args['index'], 2, '0', STR_PAD_LEFT)); ?></span></div><?php
        }
        ?>
        <div class="service-caption">
            <?php 
            if (anila_get_service_loop_prop('show_icon') == 'yes' && $icon = anila_get_service_icon()) {
                ?>
                <div class="service-image-icon">
                    <div class="service_icon">
                        <?php printf('%s', $icon); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="service-content-loop">
                <h3 class="service-loop-title">
                    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                </h3>
                <div class="service-content-box">
                    <?php 
                    if (anila_get_service_loop_prop('show_exerpt') == 'yes') {
                        ?>
                        <div class="service-loop-excerpt"><?php the_excerpt() ?></div>
                        <?php
                    }
                    if (anila_get_service_loop_prop('show_notice') == 'yes' && $notice = get_post_meta(get_the_ID(), '_service_notice', true)) {
                        ?>
                        <div class="service-loop-notice"><?php printf('%s', $notice); ?></div>
                        <?php
                    }
                    ?>
                </div>
                <div class="service-button">
                    <a class="elementor-btn-type-link" href="<?php the_permalink() ?>" title="<?php the_title() ?>"><span class="elementor-button-icon left" ><i class="anila-icon anila-icon-double-right"></i></span><span class="elementor-button-text"><?php esc_html_e('Get Started', 'anila') ?></span><span class="elementor-button-icon right"><i class="anila-icon anila-icon-double-right"></i></span></a>
                </div>
            </div>
        </div>
    </div>
</li>

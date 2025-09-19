<?php
/**
 * The template for displaying product content within loops
 *
 */

defined('ABSPATH') || exit;

$class = 'coach';
if (anila_get_coach_loop_prop('enable_carousel', false) == true) {
    $class .= ' swiper-slide';
}
if ($style = anila_get_coach_loop_prop('style', 1)) {
    $class .= ' coach-style-'.$style;
}

$show_btn = anila_get_coach_loop_prop('show_button');

$coach_socials_group = get_post_meta(get_the_ID(), 'coach_socials_group', true);
?>
<li class="<?php echo esc_attr($class); ?>">
    <div class="coach-block">
        <div class="coach-transition">
            <figure class="coach-image">
                <a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
                    <img src="<?php echo esc_attr(anila_get_thumbnail_coach_url()) ?>" class="coach_thumbnail" alt="<?php the_title() ?>">
                </a>
                <?php if($coach_socials_group) { ?>
                    <ul class="coach_socials">
                        <?php if(!empty($coach_socials_group[0]['coach_fb'])) { ?>
                            <li>
                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_fb']) ?>" target="_blank"><i class="anila-icon-facebook-f"></i></a>
                            </li>
                        <?php } ?>
                        <?php if(!empty($coach_socials_group[0]['coach_x'])) { ?>
                            <li>
                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_x']) ?>" target="_blank"><i class="anila-icon-twitter"></i></a>
                            </li>
                        <?php } ?>
                        <?php if(!empty($coach_socials_group[0]['coach_ig'])) { ?>
                            <li>
                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_ig']) ?>" target="_blank"><i class="anila-icon-instagram"></i></a>
                            </li>
                        <?php } ?>
                        <?php if(!empty($coach_socials_group[0]['coach_in'])) { ?>
                            <li>
                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_in']) ?>" target="_blank"><i class="anila-icon-linkedin"></i></a>
                            </li>
                        <?php } ?>
                        <?php do_action('anila_coach_more_socials_loop'); ?>
                    </ul>
                <?php } ?>  
            </figure>
        </div>
        <div class="coach-caption">
            <div class="coach-caption-inner">
                <?php 
                if (anila_get_coach_loop_prop('show_title') == 'yes') {
                    ?>
                    <h3 class="coach-loop-title">
                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    </h3>
                    <?php
                }
                if (anila_get_coach_loop_prop('show_job') == 'yes') {
                    $coach_job = get_post_meta(get_the_ID(), 'coach_job', true);
                    if(!empty($coach_job)) { ?>
                        <div class="coach-subtitle"><?php echo esc_html($coach_job) ?></div>
                    <?php }
                }
                if (anila_get_coach_loop_prop('show_exerpt') == 'yes') {
                    ?>
                    <div class="coach-loop-excerpt"><?php the_excerpt() ?></div>
                    <?php
                }
                if ($show_btn == 'yes') {
                    ?>
                    <div class="coach-button"><a class="more-link" href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php _e('Detail Coach', 'anila') ?></a></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</li>

<?php
/**
 * The template for displaying product content within loops
 *
 */

defined('ABSPATH') || exit;

$class = 'event';
if (anila_get_event_loop_prop('enable_carousel', false) == true) {
    $class .= ' swiper-slide';
}
if ($style = anila_get_event_loop_prop('style', 1)) {
    $class .= ' event-style-'.$style;
}

$show_btn = anila_get_event_loop_prop('show_button');
$datetime_format = apply_filters('anila_datetime_format_event_details', get_option('time_format', 'g:i a'));
?>
<li class="<?php echo esc_attr($class); ?>">
    <div class="event-block">
        <div class="event-transition">
            <?php anila_event_thumbnail() ?>
        </div>
        <div class="event-caption">
            <div class="event-caption-inner">
                <?php 
                if (anila_get_event_loop_prop('show_title') == 'yes') {
                    ?>
                    <h3 class="event-loop-title">
                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    </h3>
                    <?php
                }
                if (anila_get_event_loop_prop('show_time') == 'yes') {
                    $event_id = get_the_ID();
                    $time = '';

                    $event_time_start = get_post_meta($event_id, 'event_time_start', true);
                    if(!empty($event_time_start)) {
                        $time .= date( $datetime_format, $event_time_start );
                    }
                    $event_time_end = get_post_meta($event_id, 'event_time_end', true);
                    if(!empty($event_time_end)) {
                        $time .= ' - ' . date( $datetime_format, $event_time_end );
                    }

                    if ($time != '') {
                        ?>
                        <div class="event-time"><?php echo esc_html(apply_filters('anila_show_time_loop_event', $time)) ?></div>
                        <?php
                    }
                }
                if (anila_get_event_loop_prop('show_address') == 'yes') {
                    $event_id = get_the_ID();
                    $event_contacts = get_post_meta($event_id, 'event_contact_group', true);
                    if (!empty($event_contacts) && !empty($event_contacts[0])) {
                        $contacts = $event_contacts[0];
                        if(!empty($contacts['event_address'])) { ?>
                            <div class="event-address"><?php echo esc_html($contacts['event_address']) ?></div>
                        <?php }
                    }
                }
                if (anila_get_event_loop_prop('show_exerpt') == 'yes') {
                    ?>
                    <div class="event-loop-excerpt"><?php the_excerpt() ?></div>
                    <?php
                }
                if ($show_btn == 'yes') {
                    ?>
                    <div class="event-button"><a class="more-link" href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php _e('Read more', 'anila') ?></a></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</li>

<?php
/**
 * Event Loop Start
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

$classe         = ['anila-event'];
$classe_wrapper = ['anila-con'];
if (anila_get_event_loop_prop('enable_carousel', false) == true) {
    $classe_wrapper[] = 'anila-swiper';
    $classe[]         = 'swiper-wrapper';
} else {
    $classe[] = 'elementor-grid';
}
$classe_wrapper = esc_attr(implode(' ', array_unique($classe_wrapper)));
$classe         = esc_attr(implode(' ', array_unique($classe)));
anila_set_event_loop_prop('event-class', $classe);
anila_set_event_loop_prop('event-class-wrapper', $classe_wrapper);
?>

<div class="<?php echo esc_attr(anila_get_event_loop_prop('event-class-wrapper', 'event-wrapper')); ?>">
    <ul class="<?php echo esc_attr(anila_get_event_loop_prop('event-class', 'event')); ?>">


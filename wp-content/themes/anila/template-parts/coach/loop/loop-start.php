<?php
/**
 * Coach Loop Start
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

$classe         = ['anila-coach'];
$classe_wrapper = ['anila-con'];
if (anila_get_coach_loop_prop('enable_carousel', false) == true) {
    $classe_wrapper[] = 'anila-swiper';
    $classe[]         = 'swiper-wrapper';
} else {
    $classe[] = 'elementor-grid';
}
$classe_wrapper = esc_attr(implode(' ', array_unique($classe_wrapper)));
$classe         = esc_attr(implode(' ', array_unique($classe)));
anila_set_coach_loop_prop('coach-class', $classe);
anila_set_coach_loop_prop('coach-class-wrapper', $classe_wrapper);
?>

<div class="<?php echo esc_attr(anila_get_coach_loop_prop('coach-class-wrapper', 'coach-wrapper')); ?>">
    <ul class="<?php echo esc_attr(anila_get_coach_loop_prop('coach-class', 'coach')); ?>">


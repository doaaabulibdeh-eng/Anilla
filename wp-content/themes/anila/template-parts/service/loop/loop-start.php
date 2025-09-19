<?php
/**
 * Service Loop Start
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

$classe         = ['anila-service'];
$classe_wrapper = ['anila-con'];
if (anila_get_service_loop_prop('enable_carousel', false) == true) {
    $classe_wrapper[] = 'anila-swiper';
    $classe[]         = 'swiper-wrapper';
} else {
    $classe[] = 'elementor-grid';
}
$classe_wrapper = esc_attr(implode(' ', array_unique($classe_wrapper)));
$classe         = esc_attr(implode(' ', array_unique($classe)));
anila_set_service_loop_prop('service-class', $classe);
anila_set_service_loop_prop('service-class-wrapper', $classe_wrapper);
?>

<div class="<?php echo esc_attr(anila_get_service_loop_prop('service-class-wrapper', 'service-wrapper')); ?>">
    <ul class="<?php echo esc_attr(anila_get_service_loop_prop('service-class', 'service')); ?>">


<?php
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_setting('lexus_options_mouse_cursor', array(
        'type'              => 'option',
        'default'           => 'yes',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('lexus_options_mouse_cursor', array(
        'section' => 'title_tagline',
        'label'   => esc_html__('Show Mouse Cursor', 'themelexus-debug'),
        'type'    => 'select',
        'choices' => [
            'no' => esc_html__('No', 'themelexus-debug'),
            'yes' => esc_html__('Yes', 'themelexus-debug'),
        ]
    ));
}, 20);

add_action('wp_enqueue_scripts', function () {
    $mouse_cursor = lexus_get_theme_option('mouse_cursor');
    if (!$mouse_cursor || $mouse_cursor === 'no') {
        wp_dequeue_script('gainlove2-mouse-cursor');
        wp_deregister_script('gainlove2-mouse-cursor');
    }
}, 20);

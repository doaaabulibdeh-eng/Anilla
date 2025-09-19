<?php
// Video
use Elementor\Controls_Manager;

add_action('elementor/element/video/section_video_style/before_section_end', function ($element, $args) {
    $element->add_responsive_control(
        'video_width',
        [
            'label'          => esc_html__('Wrapper Video Width', 'anila'),
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => 'px',
            ],
            'tablet_default' => [
                'unit' => 'px',
            ],
            'mobile_default' => [
                'unit' => 'px',
            ],
            'size_units'     => ['%', 'px', 'vh'],
            'range'          => [
                '%'  => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 500,
                ],
                'vh' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-wrapper' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $element->add_responsive_control(
        'video_height',
        [
            'label'          => esc_html__('Wrapper Video Height', 'anila'),
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => 'px',
            ],
            'tablet_default' => [
                'unit' => 'px',
            ],
            'mobile_default' => [
                'unit' => 'px',
            ],
            'size_units'     => ['%', 'px', 'vh'],
            'range'          => [
                '%'  => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 500,
                ],
                'vh' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-wrapper' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

}, 10, 2);





<?php
// Button
use Elementor\Controls_Manager;
use Elementor\Includes\Widgets\Traits\Button_Trait;

add_action('elementor/element/button/section_button/before_section_end', function ($element, $args) {
    $element->update_control(
        'size',
        [
            'label' => esc_html__( 'Size', 'anila' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'sm',
            'options' => (new class { use Button_Trait; })::get_button_sizes(),
            'style_transfer' => true,
            'condition' => false
        ]
    );

}, 10, 2);


add_action('elementor/element/button/section_button/after_section_end', function ($element, $args) {
    $element->update_control(
        'button_type',
        [
            'label'        => esc_html__('Type', 'anila'),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'default',
            'options'      => [
                'default'  => esc_html__('Default', 'anila'),
                'secondary'=> esc_html__('Secondary', 'anila'),
                'outline'  => esc_html__('OutLine', 'anila'),
                'info'     => esc_html__('Info', 'anila'),
                'success'  => esc_html__('Success', 'anila'),
                'warning'  => esc_html__('Warning', 'anila'),
                'danger'   => esc_html__('Danger', 'anila'),
                'link'     => esc_html__('Link', 'anila'),
            ],
            'prefix_class' => 'elementor-button-',
        ]
    );

}, 10, 2);

add_action( 'elementor/element/button/section_style/after_section_end', function ($element, $args ) {

    $element->update_control(
        'background_color',
        [
            'global' => [
                'default' => '',
            ],
			'selectors' => [
				'{{WRAPPER}} .elementor-button' => ' background-color: {{VALUE}};',
			],
        ]
    );
}, 10, 2 );

add_action('elementor/element/button/section_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'button_style_categories',
        [
            'label'        => esc_html__('Button Categories', 'anila'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'button-style-category-',
            'separator'    => 'before',
            'condition' => [
                'button_type[value]' => 'link',
            ],
        ]
    );

    $element->add_control(
        'icon_button_size',
        [
            'label' => esc_html__('Icon Size', 'anila'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button .elementor-button-icon'   => 'display: flex; align-items: center;',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );

    $element->add_control(
        'icon_button_rotate',
        [
            'label' => esc_html__('Icon Rotate', 'anila'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 360,
                ],
            ],
            'separator'    => 'before',
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'transform: rotate({{SIZE}}deg);',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );

    $element->add_control(
        'icon_button_rotate_hover',
        [
            'label' => esc_html__('Icon Rotate Hover', 'anila'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 360,
                ],
            ],
            'separator'    => 'after',
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'transform: rotate({{SIZE}}deg);',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );

    $element->add_control(
        'button_icon_color',
        [
            'label'     => esc_html__('Icon Color', 'anila'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-link .elementor-button:after' => 'background-color: {{VALUE}};',
            ],

        ]
    );

    $element->add_control(
        'button_icon_color_hover',
        [
            'label'     => esc_html__('Icon Color Hover', 'anila'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-link .elementor-button:hover:after' => 'background-color: {{VALUE}};',
            ],

        ]
    );


}, 10, 2);





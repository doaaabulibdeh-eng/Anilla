<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!post_type_exists('service')) {
    return;
}

use Anila\Elementor\Anila_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Anila\Elementor\Anila_Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Anila_Elementor_Widget_Service extends Anila_Base_Widgets {


    public function get_categories() {
        return array('anila-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'anila-services';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Services', 'anila');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-bag-medium';
    }


    public function get_script_depends() {
        return [
            'anila-elementor-service',
            'tooltipster'
        ];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Settings', 'anila'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'limit',
            [
                'label'   => esc_html__('Posts Per Page', 'anila'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'service_updown',
            [
                'label'        => __('Up Down', 'anila'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    ''       => __('Default', 'anila'),
                    'custom' => __('Custom', 'anila'),
                ],
                'prefix_class' => 'service-updown-',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'service_updown_custom',
            [
                'label'      => __('Service Up Down', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'range'      => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-slide:nth-last-child(2n)' => 'margin-top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-slide:nth-last-child(2n-1)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'service_updown' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label'   => esc_html__('Show Icon Service', 'anila'),
                'default' => 'yes',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control(
            'show_exerpt',
            [
                'label'   => esc_html__('Show Excerpt Service', 'anila'),
                'default' => 'yes',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control(
            'show_notice',
            [
                'label'   => esc_html__('Show Service Notice', 'anila'),
                'default' => 'yes',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
                'condition'          => [
                    'enable_carousel!' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'anila'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__('Date', 'anila'),
                    'id'         => esc_html__('Service ID', 'anila'),
                    'menu_order' => esc_html__('Menu Order', 'anila'),
                    'title'      => esc_html__('Service Title', 'anila'),
                    'rand'       => esc_html__('Random', 'anila'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'anila'),
                    'desc' => esc_html__('DESC', 'anila'),
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label'     => esc_html__('Block Style', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1'  => esc_html__('Style 1', 'anila'),
                    '2'  => esc_html__('Style 2', 'anila'),
                ],
            ]
        );


        $this->add_control(
            'style_image_hover',
            [
                'label'     => esc_html__('Image Hover', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'          => esc_html__('None', 'anila'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'anila'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'anila'),
                    'right-to-left' => esc_html__('Right to Left', 'anila'),
                    'left-to-right' => esc_html__('Left to Right', 'anila'),
                    'swap'          => esc_html__('Swap', 'anila'),
                    'fade'          => esc_html__('Fade', 'anila'),
                    'zoom-in'       => esc_html__('Zoom In', 'anila'),
                    'zoom-out'      => esc_html__('Zoom Out', 'anila'),
                ],
                'condition' => [
                    'service_layout' => 'grid'
                ]
            ]
        );

        $this->end_controls_section();


        //Section Query
        $this->start_controls_section(
            'section_service_style',
            [
                'label' => esc_html__('Services', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'service_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-block .service-caption-hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-block' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'service_overlay',
            [
                'label'     => esc_html__('Overlay', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-block .service-image a::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => '1'
                ]
            ]
        );

        $this->add_responsive_control(
            'service_height',
            [
                'label'      => esc_html__('Box Height', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_height_image',
            [
                'label'      => esc_html__('Image Height', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-image' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bottom_space',
            [
                'label' => esc_html__( 'Spacing Row', 'anila' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' , '%', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--service-spacing-row: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_service_style',
            [
                'label' => esc_html__('Content', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_content_head',
            [
                'label'     => esc_html__('Box Content', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'vertical_content_position',
            [
                'label'        => esc_html__('Vertical Position', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start'    => [
                        'title' => esc_html__('Top', 'anila'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'anila'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'anila'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-block' => 'align-items: {{value}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_content_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-caption'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'      => 'content_border',
                'selector'  => '{{WRAPPER}} .service-block .service-caption',
            ]
        );

        $this->add_control(
            'box_icon_head',
            [
                'label'     => esc_html__('Service Icon', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('color_tabs');

        $this->start_controls_tab('colors_normal',
            [
                'label' => esc_html__('Normal', 'anila'),
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'color_icon',
            [
                'label'   => esc_html__('Color Icon', 'anila'),
                'type'    => Controls_Manager::COLOR,
                'default' => '',                
                'selectors'  => [
                    '{{WRAPPER}} .service_icon svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .service_icon svg g' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .service_icon svg path' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab('colors_hover',
            [
                'label' => esc_html__('Hover', 'anila'),
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'color_icon_hover',
            [
                'label'   => esc_html__('Color Icon Hover', 'anila'),
                'type'    => Controls_Manager::COLOR,
                'default' => '',                
                'selectors'  => [
                    '{{WRAPPER}} .service-block:hover .service_icon svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .service-block:hover .service_icon svg g' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .service-block:hover .service_icon svg path' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_width',
            [
                'label'     => esc_html__('Icon Width', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service_icon svg' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .service_icon svg g' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .service_icon svg path' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'horizontal_icon_position',
            [
                'label'        => esc_html__('Horizontal Position', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Top', 'anila'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-image-icon' => 'text-align: {{value}}',
                ],
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'box_title_head',
            [
                'label'     => esc_html__('Service Title', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'title_align',
            [
                'label'        => esc_html__('Text Align', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'anila'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-loop-title' => 'text-align: {{value}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-caption .service-loop-title'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-loop-title a'   => 'color: {{VALUE}};',
                ],
            ]
        );

         $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-loop-title a:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .service-loop-title, {{WRAPPER}} .service-loop-title a',
            ]
        );

        $this->add_control(
            'box_excerpt_head',
            [
                'label'     => esc_html__('Service Excerpt', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'excerpt_align',
            [
                'label'        => esc_html__('Text Align', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'anila'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-loop-excerpt' => 'text-align: {{value}}',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-loop-excerpt'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-loop-excerpt'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .service-loop-excerpt',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'      => 'excerpt_border',
                'selector'  => '{{WRAPPER}} .service-block .service-loop-excerpt',
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-loop-excerpt'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-loop-excerpt'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_notice_head',
            [
                'label'     => esc_html__('Service Notice', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'notice_align',
            [
                'label'        => esc_html__('Text Align', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'anila'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-loop-notice' => 'text-align: {{value}}',
                ],
            ]
        );

        $this->add_control(
            'notice_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-loop-notice'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'notice_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .service-loop-notice',
            ]
        );

        $this->add_responsive_control(
            'notice_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-block .service-caption .service-loop-notice'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->get_controls_column();
        // Carousel Option
        $this->get_control_carousel();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->handle_setting($settings);
    }

    private function handle_setting($settings) {
        $class = '';
        $atts  = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['enable_carousel'] === 'yes' ? 1 : $settings['column'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'show_icon'      => $settings['show_icon'],
            'show_exerpt'    => $settings['show_exerpt'],
            'show_notice'    => $settings['show_notice']
        ];

        $class         .= ' elementor-service';
        $class         .= ' elementor-service-style' . $settings['style'];
        
        if (isset($settings['style']) && $settings['style'] !== '') {
            $atts['style'] = $settings['style'];
        }

        if (isset($settings['style_image_hover']) && $settings['style_image_hover'] !== '') {
            $atts['style_image_hover'] = $settings['style_image_hover'];
        }
        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['enable_carousel']   = 'yes';
            $atts['carousel_settings'] = $this->get_swiper_navigation_for_service();
            $class                     = ' anila-swiper-wrapper swiper';
        }
        if ($settings['show_pagination'] === 'yes' && $settings['enable_carousel'] !== 'yes') {
            $atts['paginate'] = true;
        }
        $atts['class'] = $class;

        echo (new Anila_Content_Service($atts))->get_content(); // WPCS: XSS ok
    }

    protected function get_swiper_navigation_for_service() {
        $settings = $this->get_settings_for_display();
        if ($settings['enable_carousel'] != 'yes') {
            return;
        }
        $settings_navigation = '';
        $show_dots           = (in_array($settings['navigation'], ['dots', 'both']));
        $show_arrows         = (in_array($settings['navigation'], ['arrows', 'both']));


        if ($show_dots) {
            $settings_navigation .= '<div class="swiper-pagination swiper-pagination-' . $this->get_id() . '"></div>';
        }
        if ($show_arrows && $settings['custom_navigation'] != 'yes') {
            $settings_navigation .= '<div class="elementor-swiper-button elementor-swiper-button-prev elementor-swiper-button-prev-' . $this->get_id() . '">';
            $settings_navigation .= $this->render_swiper_button('previous', true);
            $settings_navigation .= '<span class="elementor-screen-only">' . esc_html__('Previous', 'anila') . '</span>';
            $settings_navigation .= '</div>';
            $settings_navigation .= '<div class="elementor-swiper-button elementor-swiper-button-next elementor-swiper-button-next-' . $this->get_id() . '">';
            $settings_navigation .= $this->render_swiper_button('next', true);
            $settings_navigation .= '<span class="elementor-screen-only">' . esc_html__('Next', 'anila') . '</span>';
            $settings_navigation .= '</div>';
        }
        return $settings_navigation;
    }
}

$widgets_manager->register(new Anila_Elementor_Widget_Service());

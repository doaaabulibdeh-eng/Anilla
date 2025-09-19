<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!post_type_exists('event')) {
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
class Anila_Elementor_Widget_Event extends Anila_Base_Widgets {


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
        return 'anila-event';
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
        return esc_html__('Anila Event', 'anila');
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
            'anila-elementor-event',
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
            'show_title',
            [
                'label'   => esc_html__('Show Title', 'anila'),
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
                'label'   => esc_html__('Show Excerpt Event', 'anila'),
                'default' => 'no',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control(
            'show_time',
            [
                'label'   => esc_html__('Show Event Time', 'anila'),
                'default' => 'yes',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label'   => esc_html__('Show Event Address', 'anila'),
                'default' => 'yes',
                'type'    => Controls_Manager::SWITCHER,
                // 'render_type'        => 'template',
                'selectors' => [
                ],
            ]
        );

        $this->add_control('show_button',
            [
                'label' => esc_html__('Show Button', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
                'condition'          => [
                    'enable_carousel!' => 'yes'
                ],
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
                    'id'         => esc_html__('Event ID', 'anila'),
                    'menu_order' => esc_html__('Menu Order', 'anila'),
                    'title'      => esc_html__('Event Title', 'anila'),
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
                'type'      => Controls_Manager::HIDDEN,
                'default'   => '1',
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
                    'event_layout' => 'grid'
                ]
            ]
        );



        $this->end_controls_section();


        //Section Query
        $this->start_controls_section(
            'section_event_style',
            [
                'label' => esc_html__('Event', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'event_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-block'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'event_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-block'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'event_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'event_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-block' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => '2'
                ]
            ]
        );

        $this->add_control(
            'event_overlay',
            [
                'label'     => esc_html__('Overlay Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-block:hover .event-caption' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => '1'
                ]
            ]
        );

        $this->add_responsive_control(
            'event_height',
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
                    '{{WRAPPER}} .event-block' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_event_style',
            [
                'label' => esc_html__('Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => esc_html__('Image Height', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .event-image img' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'img_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_event_style',
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
                    '{{WRAPPER}} .event-caption' => 'align-items: {{value}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label'        => esc_html__('Content Align', 'anila'),
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
                    '{{WRAPPER}} .event-caption' => 'text-align: {{value}}',
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
                    '{{WRAPPER}} .event-caption'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_time_head',
            [
                'label'     => esc_html__('Event Time', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
            'time_align',
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
                    '{{WRAPPER}} .event-time' => 'text-align: {{value}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'time_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-time'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'time_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .event-time'   => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'time_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-block:hover .event-time'   => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'time_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .event-time',
            ]
        );

        $this->add_control(
            'box_address_head',
            [
                'label'     => esc_html__('Event Address', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
            'address_align',
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
                    '{{WRAPPER}} .event-address' => 'text-align: {{value}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'address_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .event-address'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'address_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .event-address'   => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'address_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-block:hover .event-address'   => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'address_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .event-address',
            ]
        );

        $this->add_control(
            'box_title_head',
            [
                'label'     => esc_html__('Event Title', 'anila'),
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
                    '{{WRAPPER}} .event-loop-title' => 'text-align: {{value}}',
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
                    '{{WRAPPER}} .event-loop-title'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .event-loop-title a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-loop-title a:hover'   => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .event-loop-title, {{WRAPPER}} .event-loop-title a',
            ]
        );

        $this->add_control(
            'box_excerpt_head',
            [
                'label'     => esc_html__('Event Excerpt', 'anila'),
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
                    '{{WRAPPER}} .event-loop-excerpt' => 'text-align: {{value}}',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .event-loop-excerpt'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color_hover',
            [
                'label'     => esc_html__('Text Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-loop-excerpt:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .event-loop-excerpt',
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
        // echo '<pre>'; print_r($settings); echo '</pre>';
        $class = '';
        $atts  = [
            'limit'           => $settings['limit'],
            'columns'         => $settings['enable_carousel'] === 'yes' ? 1 : $settings['column'],
            'orderby'         => $settings['orderby'],
            'order'           => $settings['order'],
            'show_title'      => $settings['show_title'],
            'show_button'     => $settings['show_button'],
            'show_exerpt'     => $settings['show_exerpt'],
            'show_time'        => $settings['show_time'],
            'show_address'        => $settings['show_address']
        ];

        $class         .= ' elementor-event';
        $class         .= ' elementor-event-style' . $settings['style'];

        if (isset($settings['style']) && $settings['style'] !== '') {
            $atts['style'] = $settings['style'];
        }

        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['enable_carousel']   = 'yes';
            $atts['carousel_settings'] = $this->get_swiper_navigation_for_event();
            $class                     = ' anila-swiper-wrapper swiper';
        }
        if ($settings['show_pagination'] === 'yes' && $settings['enable_carousel'] !== 'yes') {
            $atts['paginate'] = true;
        }
        $atts['class'] = $class;

        echo (new Anila_Content_Event($atts))->get_content(); // WPCS: XSS ok
    }

    protected function get_swiper_navigation_for_event() {
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

    protected function get_event_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'event-cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }
}

$widgets_manager->register(new Anila_Elementor_Widget_Event());

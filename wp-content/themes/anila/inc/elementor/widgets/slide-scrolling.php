<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Anila\Elementor\Anila_Base_Widgets;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Anila_Elementor_Slide_Scrolling extends Anila_Base_Widgets {

    public function get_categories() {
        return array('anila-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'anila-slide-scrolling';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Anila Slide Scrolling', 'anila');
    }
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-image';
    }

    /**
     * Enqueue scripts.
     *
     * Registers all the scripts defined as element dependencies and enqueues
     * them. Use `get_script_depends()` method to add custom script dependencies.
     *
     * @since 1.3.0
     * @access public
     */

    public function get_script_depends() {
        return ['anila-elementor-slide-scrolling','tweenmax'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_scrolling',
            [
                'label' => esc_html__('Items', 'anila'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'scrolling_title',
            [
                'label'       => esc_html__('Scrolling name', 'anila'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Scrolling Name', 'anila'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'scrolling_image',
            [
                'label'   => esc_html__('Choose Image', 'anila'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],

            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__('Link to', 'anila'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'anila'),
            ]
        );

        $this->add_control(
            'scrolling',
            [
                'label'       => esc_html__('Items', 'anila'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ scrolling_title }}}',
            ]
        );


        $this->add_control(
            'heading_settings',
            [
                'label'     => esc_html__('Settings', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'scrolling_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `scrolling_image_size` and `scrolling_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'scrolling_align',
            [
                'label'     => esc_html__('Alignment', 'anila'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-scrolling-wrapper .elementor-scrolling-item-inner' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label'      => esc_html__('Spacing', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-scrolling-wrapper .elementor-scrolling-inner' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .elementor-scrolling-wrapper .elementor-scrolling-item'  => 'margin-left: calc({{SIZE}}{{UNIT}}/2); margin-right: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .scrolling-title:before' => 'right: calc(-{{SIZE}}{{UNIT}}/2);',
                ],
            ]
        );

        $this->add_control(
            'border_style',
            [
                'label'        => esc_html__('Border', 'anila'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'anila-scrolling-border-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_scrolling_item',
            [
                'label' => esc_html__('Item', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'scrolling_item',
                'selector' => '{{WRAPPER}} .elementor-scrolling-item-inner',
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-scrolling-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_scrolling_image',
            [
                'label' => esc_html__('Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-scrolling-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-scrolling-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_scrolling_wrapper');

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => esc_html__('Normal', 'anila'),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => esc_html__('Opacity', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-scrolling-image img, {{WRAPPER}} .elementor-scrolling-image i, {{WRAPPER}} .elementor-scrolling-image svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'scrolling_imag',
                'selector' => '{{WRAPPER}} .elementor-scrolling-image',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_scrolling_image_hover',
            [
                'label' => esc_html__('Hover', 'anila'),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     => esc_html__('Opacity', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'default'   => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-scrolling-image a:hover img, {{WRAPPER}} .elementor-scrolling-image a:hover i, {{WRAPPER}} .elementor-scrolling-image a:hover svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'scrolling_image_hover',
                'selector' => '{{WRAPPER}} .elementor-scrolling-image:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'image_width',
            [
                'label'          => esc_html__('Width', 'anila'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-scrolling-item .elementor-scrolling-image img' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'          => esc_html__('Height', 'anila'),
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
                'size_units'     => ['px', 'vh'],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-scrolling-item .elementor-scrolling-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title.
        $this->start_controls_section(
            'section_style_scrolling_title',
            [
                'label' => esc_html__('Title', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .scrolling-title a',
            ]
        );

        $this->start_controls_tabs('tabs_text_wrapper');

        $this->start_controls_tab(
            'tab_wrapper_text_normal',
            [
                'label' => esc_html__('Normal', 'anila'),
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .scrolling-title'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .scrolling-title a'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .scrolling-title:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_scrolling_title_hover',
            [
                'label' => esc_html__('Hover', 'anila'),
            ]
        );

        $this->add_control(
            'title_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .scrolling-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .scrolling-title:hover a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .scrolling-title:hover:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['scrolling']) && is_array($settings['scrolling'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-scrolling-wrapper');

            $this->add_render_attribute('item', 'class', 'elementor-scrolling-item');

            ?>
            <div class="elementor-scrolling">
                <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                    <div class="elementor-scrolling-inner">
                        <?php foreach ($settings['scrolling'] as $item) : ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <div class="elementor-scrolling-item-inner">
                                <div class="elementor-scrolling-image">
                                    <?php
                                    if (!empty($item['link'])) {
                                        if (!empty($item['link']['is_external'])) {
                                            $this->add_render_attribute('scrolling-image', 'target', '_blank');
                                        }

                                        if (!empty($item['link']['nofollow'])) {
                                            $this->add_render_attribute('scrolling-image', 'rel', 'nofollow');
                                        }

                                        echo '<a href="' . esc_url($item['link']['url'] ? $item['link']['url'] : '#') . '" ' . $this->get_render_attribute_string('scrolling-image') . ' title="' . esc_attr($item['scrolling_title']) . '">';
                                    }
                                    $item['image_size']             = $settings['scrolling_image_size'];
                                    $item['image_custom_dimension'] = $settings['scrolling_image_custom_dimension'];

                                    if (!empty($item['scrolling_image']['url'])) { ?>
                                    <div class="elementor-animation-image">
                                        <?php
                                        $item['hover_animation'] = 'main';
                                        echo Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'image', 'scrolling_image');
                                        ?>
                                    </div>
                                    <?php }

                                    if (!empty($item['link'])) {
                                        echo '</a>';
                                    }
                                    ?>
                                </div>

                                <?php if ($item['scrolling_title']) { ?>
                                    <div class="scrolling-title">
                                    <?php
                                    if (!empty($item['link'])) {
                                        if (!empty($item['link']['is_external'])) {
                                            $this->add_render_attribute('scrolling-title', 'target', '_blank');
                                        }

                                        if (!empty($item['link']['nofollow'])) {
                                            $this->add_render_attribute('scrolling-title', 'rel', 'nofollow');
                                        }

                                        echo '<a href="' . esc_url($item['link']['url'] ? $item['link']['url'] : '#') . '" ' . $this->get_render_attribute_string('scrolling-title') . ' title="' . esc_attr($item['scrolling_title']) . '">';
                                    }?>
                                        <?php echo esc_html($item['scrolling_title']); ?>
                                    <?php if (!empty($item['link'])) {
                                    echo '</a>';
                                    } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
            <?php
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Slide_Scrolling());

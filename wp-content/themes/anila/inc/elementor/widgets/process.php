 <?php

//namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Background;
use Elementor\Controls_Manager;
 use Elementor\Group_Control_Border;
 use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
 use Elementor\Group_Control_Text_Stroke;
 use Elementor\Group_Control_Typography;
use Anila\Elementor\Anila_Base_Widgets;

class Anila_Elementor_Process extends Anila_Base_Widgets {

    public function get_name() {
        return 'anila-process';
    }

    public function get_title() {
        return __('Anila Process', 'anila');
    }

    public function get_categories() {
        return array('anila-addons');
    }

    public function get_icon() {
        return 'eicon-editor-list-ol';
    }

    public function get_script_depends() {
        return [
            'anila-elementor-process'
        ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => __('General', 'anila'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label'       => __('Title', 'anila'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Process Title', 'anila'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label'       => __('Sub Title', 'anila'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',

            [
                'label'      => __('Content', 'anila'),
                'type'       => Controls_Manager::WYSIWYG,
                'default'    => __('Process Content', 'anila'),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'image_link_source',
            [
                'label'      => esc_html__('Choose Image', 'anila'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => __('Link', 'anila'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'anila'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'process_list',
            [
                'label'       => __('Process Items', 'anila'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'   => __('Process #1', 'anila'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'anila'),
                        'link'    => '#'
                    ],
                    [
                        'title'   => __('Process #2', 'anila'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'anila'),
                        'link'    => '#'
                    ],
                    [
                        'title'   => __('Process #3', 'anila'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'anila'),
                        'link'    => '#'
                    ],
                ],
                'title_field' => '{{{ title }}}',

            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label'   => esc_html__('Show Button', 'anila'),
                'default' => 'no',
                'type'    => Controls_Manager::SWITCHER,
                'render_type'        => 'template',
            ]
        );

        $this->add_control(
            'process_style',
            [
                'label'        => __('Process Style', 'anila'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '1',
                'options'      => [
                    '1' => __('Layout 1', 'anila'),
                    '2' => __('Layout 2', 'anila'),
                ],
                'render_type' => 'template',
                'prefix_class' => 'elementor-process-layout-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __('Wrapper', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-anila-process-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'min-height',
            [
                'label'      => esc_html__('Height', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}} .anila-con-inner' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => esc_html__('Image Opacity', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .anila-con:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_style',
            [
                'label' => __('Item', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]

        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-process-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'color_tabs' );

        $this->start_controls_tab( 'colors_normal',
            [
                'label' => esc_html__( 'Normal', 'anila' ),
            ]
        );

        $this->add_control(
            'item-background',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-process-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'colors_hover',
            [
                'label' => esc_html__( 'Hover', 'anila' ),
            ]
        );

        $this->add_control(
            'item-background-hover',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-process-item:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => __('Content', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'process_alignment',
            [
                'label'       => esc_html__('Alignment Content', 'anila'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'label_block' => false,
                'selectors'   => [
                    '{{WRAPPER}} .process-content-wap'  => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-inner-content-wap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'content_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-inner-content-wap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'      => 'content_border',
                'selector'  => '{{WRAPPER}} .process-content-wap',
            ]
        );

        $this->add_control(
            'border_hover',
            [
                'label'     => __('Border Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-process-item:hover .process-content-wap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing_content_hover',
            [
                'label'      => esc_html__('Spacing Hover', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-process-item:hover .process-inner-content-wap'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
            ]
        );

        $this->start_controls_tabs( 'color_tabs_content' );

        $this->start_controls_tab( 'colors_content_normal',
            [
                'label' => esc_html__( 'Normal', 'anila' ),
            ]
        );

        $this->add_control(
            'background-content',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .process-content-wap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'colors_content_hover',
            [
                'label' => esc_html__( 'Hover', 'anila' ),
            ]
        );

        $this->add_control(
            'background-content-hover',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .process-content-wap:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title',
            [
                'label'     => __('Title', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Title Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-inner-content-wap .process-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .process-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing_item',
            [
                'label'      => __('Spacing', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_position',
            [
                'label'        => esc_html__('Title Position', 'anila'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'show-title-position-',
                'separator'    => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_padding_position',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-title'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label'     => __('Sub Title', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Sub Title Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .process-subtitle',
            ]
        );

        $this->add_responsive_control(
            'sub_title_spacing_item',
            [
                'label'      => __('Spacing', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'content_heading',
            [
                'label'     => __('Content', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .content',
            ]
        );

        $this->add_responsive_control(
            'content_spacing_item',
            [
                'label'      => __('Spacing', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button',
            [
                'label'     => __('Button', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Button Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .anila-process-button a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .anila-process-button a:after' => 'background-color: {{VALUE}};',

                ],
            ]
        );
        $this->add_control(
            'button_color_hover',
            [
                'label'     => __('Button Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-inner-content-wap .anila-process-button:hover a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .process-inner-content-wap .anila-process-button:hover a:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .anila-process-button',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => __('Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'process_style' => '1'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => __('Width', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .anila-process-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height_width',
            [
                'label'      => __('Height', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .anila-process-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->get_controls_column();
        // Carousel options
        $this->get_control_carousel();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $count_process = 0;
        if (is_array($settings['process_list'])) {
            $count_process = count($settings['process_list']);
        }

        $layout = (!empty($settings['process_style'])) ? $settings['process_style'] : '1';

        if ($count_process > 0) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-anila-process-wrapper');
            $this->add_render_attribute('item', 'class', 'elementor-process-item');
            $this->get_data_elementor_columns();

            $image_list = [];
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['process_list'] as $index => $item) : 
                            $link_key = 'link_' . $index;
                            if (!empty($item['link']['url'])) {
                                $this->add_render_attribute($link_key, 'href', $item['link']['url']);
                                if ($item['link']['is_external']) {
                                    $this->add_render_attribute($link_key, 'target', '_blank');
                                }
    
                                if ($item['link']['nofollow']) {
                                    $this->add_render_attribute($link_key, 'rel', 'nofollow');
                                }
                            }

                            $pad_index = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                            $str_index = sprintf(__('%s step', 'anila'), $pad_index);

                            $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image_link_source']['id'], 'image', $settings);
                            if (!$image_url && isset($attachment['url'])) {
                                $image_url = Elementor\Utils::get_placeholder_image_src();
                            }
                            $image_list[] = $image_url;

                            $item_key = 'process_'.$index;
                            
                            $this->add_render_attribute($item_key, 'class', 'anila-inner-process');
                            $this->add_render_attribute($item_key, 'data-index', $index);
                            if ($index == 0) {
                                $this->add_render_attribute($item_key, 'class', 'activate');
                            }

                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <div <?php $this->print_render_attribute_string($item_key); ?>>
                                        <?php
                                        if ($layout == '1') {
                                            ?>
                                            <div class="anila-top-process">
                                                <div class="anila-process-image">
                                                    <img class="image img-anila-process" src="<?php echo esc_url($image_url); ?>" alt="image">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    <div class="process-content-wap">
                                        <?php if (!empty($item['title'])) : ?>
                                            <h3 class="process-title">
                                                <a <?php $this->print_render_attribute_string($link_key); ?>>
                                                    <?php echo esc_html($item['title']); ?>
                                                </a>
                                            </h3>
                                        <?php endif; ?>
                                        <div class="process-inner-content-wap">
                                            <?php if (!empty($item['subtitle'])) : ?>
                                                <h5 class="process-subtitle">
                                                    <?php echo esc_html($item['subtitle']); ?>
                                                </h5>
                                            <?php endif; ?>
                                            <?php if (!empty($item['content'])) : ?>
                                                <div class="content">
                                                    <?php printf('%s', $this->parse_text_editor($item['content'])); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($settings['show_btn']) && $settings['show_btn'] == 'yes') : ?>
                                                <div class="anila-process-button">
                                                    <a <?php $this->print_render_attribute_string($link_key); ?>>
                                                        <?php _e('View all', 'anila'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    if ($layout == '2' && !empty($image_list)) {
                        ?>
                        <div class="anila-process-list-image" style="background-image: url(<?php echo esc_url($image_list[0]) ?>);">
                            <?php
                            foreach ($image_list as $i => $img) { ?>
                                <div class="anila-process-image <?php echo esc_attr('img-'.$i) ?>" style="background-image: url(<?php echo esc_url($img) ?>);"></div>
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php $this->get_swiper_navigation($count_process); ?>
                
            </div>
            <?php
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Process());
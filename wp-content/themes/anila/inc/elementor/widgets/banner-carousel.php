<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Anila\Elementor\Anila_Base_Widgets;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;

class Anila_Elementor_Banner_Carousel extends Anila_Base_Widgets {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'anila-banner-carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Anila Banner Carousel', 'anila');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-carousel-loop';
    }

    public function get_script_depends() {
        return ['anila-elementor-banner-carousel'];
    }

    public function get_categories() {
        return array('anila-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_carousel_image',
            [
                'label' => esc_html__('Image Carousel', 'anila'),
            ]
        );

            $repeater = new Repeater();

            $repeater->add_control(
                'image_title',
                [
                    'label'       => esc_html__('Title', 'anila'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'image_description',
                [
                    'label'       => esc_html__('Description', 'anila'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Description',
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'image_side',
                [
                    'label'   => esc_html__('Show Image Side', 'anila'),
                    'default' => 'no',
                    'type'    => Controls_Manager::SWITCHER,
                    'render_type'        => 'template',
                    'selectors_dictionary' => [
                        'yes' => 'flex',
                        'no' => 'block',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.elementor_inner_item_banner' => 'display: {{VALUE}}',
                    ],
                ]
            );

            $repeater->add_control(
                'image_link_source_side',
                [
                    'label'      => esc_html__('Choose Image Side', 'anila'),
                    'default'    => [
                        'url' => Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'type'       => Controls_Manager::MEDIA,
                    'show_label' => false,
                    'condition'   => [
                        'image_side' => 'yes'
                    ]
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
                'image_link',
                [
                    'label'       => esc_html__('Link to', 'anila'),
                    'placeholder' => esc_html__('https://your-link.com', 'anila'),
                    'type'        => Controls_Manager::URL,
                    'default'     => [
                        'url' => '#',
                    ],
                ]
            );

            $repeater->add_control(
                'target_link',
                [
                    'label'   => esc_html__('Target', 'anila'),
                    'default' => 'yes',
                    'type'    => Controls_Manager::SWITCHER,
                ]
            );

            $repeater->add_control(
                'banner_background_color',
                [
                    'label'     => esc_html__('Background Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    // 'selectors' => [
                    //     '{{WRAPPER}} {{CURRENT_ITEM}} .banner-carousel-image' => 'background-color: {{VALUE}}',
                    // ],
                ]
            );

            $repeater->add_control(
                'image_show_button',
                [
                    'label' => esc_html__('Show Button', 'anila'),
                    'type'  => Controls_Manager::SWITCHER,
                    'default' => 'no'
                ]
            );


            $repeater->add_control(
                'image_button_text',
                [
                    'label'       => esc_html__('Button Text', 'anila'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => esc_html__('Button', 'anila'),
                    'default'     => esc_html__('Button', 'anila'),
                    'condition'   => [
                        'image_show_button' => 'yes'
                    ]
                ]
            );

            $repeater->add_control(
                'image_button_link',
                [
                    'label'       => esc_html__('Button Link', 'anila'),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'anila'),
                    'default'     => [
                        'url' => '#',
                    ],
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'condition'   => [
                        'image_show_button' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'image-carousel',
                [
                    'label'       => esc_html__('Items', 'anila'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    'title_field' => '{{{ image_title }}}',
                ]
            );

            $this->add_control(
                'box-image-height',
                [
                    'label'        => esc_html__('Box Image Height', 'anila'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'auto',
                    'options'      => [
                        'auto' => __('Auto', 'anila'),
                        'full' => __('Full', 'anila'),
                    ],
                    'prefix_class' => 'elementor-box-height-',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `brand_image_size` and `brand_image_custom_dimension`.
                    'default'   => 'full',
                    'separator' => 'none',
                ]
            );

            
            $this->add_responsive_control(
                'image_inline_title',
                [
                    'label'       => esc_html__('Inline Title', 'anila'),
                    'type'    => Controls_Manager::SWITCHER,
                    'selectors_dictionary' => [
                        'yes' => 'inline',
                        'no' => 'block',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-title' => 'display: {{VALUE}}',
                        '{{WRAPPER}} .elementor-banner-description' => 'display: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'view',
                [
                    'label'   => esc_html__('View', 'anila'),
                    'type'    => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                ]
            );
            
        $this->end_controls_section();


        $this->start_controls_section(
            'banner_style',
            [
                'label' => esc_html__('Banner Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'heading_box_side_image',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box Side Image', 'anila'),
                ]
            );

            $this->add_responsive_control(
                'banner_img_side_width',
                [
                    'label'      => esc_html__('Image Width', 'anila'),
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
                    'selectors'  => [
                        '{{WRAPPER}} .elementor_box_image_side' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    
                ]
            );

            $this->add_control(
                'heading_box_image',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box Image', 'anila'),
                    'separator'    => 'before',
                ]
            );

            $this->add_responsive_control(
                'banner_img_width',
                [
                    'label'      => esc_html__('Image Width', 'anila'),
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
                    'selectors'  => [
                        '{{WRAPPER}} .img-banner-carousel' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->add_responsive_control(
            'banner_img_height',
            [
                'label'      => esc_html__('Image height', 'anila'),
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
                'selectors'  => [
                    '{{WRAPPER}} .img-banner-carousel'       => 'height: {{SIZE}}{{UNIT}}; overflow: hidden',
                    '{{WRAPPER}} .banner-carousel-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

            $this->add_responsive_control(
                'banner_border_radius',
                [
                    'label'      => esc_html__('Border Radius', 'anila'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .img-banner-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_margin',
                [
                    'label'      => esc_html__('Margin', 'anila'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .banner-carousel-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );


        $this->end_controls_section();

        // Box Text
        $this->start_controls_section(
            'box_text_style',
            [
                'label' => esc_html__('Box Text', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            // Position Box
            $this->add_control(
                'heading_box_position',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box Position', 'anila'),
                ]
            );

            $this->add_responsive_control(
                'box-text_margin',
                [
                    'label'      => esc_html__('Margin', 'anila'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-wrap-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Box Title      
            $this->add_control(
                'heading_box_title',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box Title', 'anila'),
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label'     => esc_html__('Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-title' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Title Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor_inner_item_banner:hover .elementor-banner-title' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .elementor-banner-title',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Stroke::get_type(),
                [
                    'name'     => 'text_stroke',
                    'selector' => '{{WRAPPER}} .elementor-banner-title',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'     => 'text_shadow',
                    'selector' => '{{WRAPPER}} .elementor-banner-title',
                ]
            );

            $this->add_responsive_control(
                'box-text-title-padding',
                [
                    'label' => esc_html__( 'Padding', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'box-text-title-margin',
                [
                    'label' => esc_html__( 'Margin', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            // Box SubTitle      
            $this->add_control(
                'heading_box_description',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box description', 'anila'),
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'description_color',
                [
                    'label'     => esc_html__('Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-description' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Anila_Group_Control_Typography::get_type(),
                [
                    'name'     => 'sub-typography',
                    'global'   => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                    'selector' => '{{WRAPPER}} .elementor-banner-description',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Stroke::get_type(),
                [
                    'name'     => 'sub_text_stroke',
                    'selector' => '{{WRAPPER}} .elementor-banner-description',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'     => 'sub_text_shadow',
                    'selector' => '{{WRAPPER}} .elementor-banner-description',
                ]
            );

            $this->add_responsive_control(
                'box-text-description-padding',
                [
                    'label' => esc_html__( 'Padding', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'box-text-description-margin',
                [
                    'label' => esc_html__( 'Margin', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            //Box Button
            $this->add_control(
                'heading_box_button',
                [
                    'type'      => Controls_Manager::HEADING,
                    'label'     => esc_html__('Box Button', 'anila'),
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'box-text-button-background',
                [
                    'label'     => esc_html__('Button Background Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-button' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'box-text-button-hover-background',
                [
                    'label'     => esc_html__('Button Hover Background Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-button:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'box-text-button-color',
                [
                    'label'     => esc_html__('Button Text Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'box-text-button-hover-color',
                [
                    'label'     => esc_html__('Button Hover Text Color', 'anila'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-banner-button:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'box-text-button-padding',
                [
                    'label' => esc_html__( 'Button Padding', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'box-text-button-margin',
                [
                    'label' => esc_html__( 'Button Margin', 'anila' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .elementor-banner-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->get_controls_column();
        // Carousel options
        $this->get_control_carousel();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['image-carousel']) && is_array($settings['image-carousel'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-image-carousel-item-wrapper');

            $this->get_data_elementor_columns();

            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['image-carousel'] as $index => $item):
                            $repeater_image_link_key = $this->get_repeater_setting_key('image_link', 'image-carousel', $index);

                            $this->add_render_attribute($repeater_image_link_key, 'href', $item['image_link']['url']);

                            if ($item['target_link']) {
                                $this->add_render_attribute($repeater_image_link_key, 'target', '_blank');
                            }
                            if ($item['banner_background_color']) {
                                $this->remove_render_attribute('color');   
                                $this->add_render_attribute('color', 'style ', 'background-color: '.$item['banner_background_color']);   
                            }

                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <div class="elementor_inner_item_banner elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                                    <?php
                                    if($item['image_side'] == 'yes') {
                                        $this->add_render_attribute($repeater_image_link_key, 'href', $item['image_link']['url']);
                                        $image_url_side = Group_Control_Image_Size::get_attachment_image_src($item['image_link_source_side']['id'], 'image', $settings);
                                        ?>
                                        <figure class="elementor_box_image_side">
                                            <img class="image_side" src="<?php echo esc_url($image_url_side); ?>" alt="image">
                                        </figure>
                                        <?php
                                    }
                                    ?>
                                    <div class="banner-carousel-image" <?php $this->print_render_attribute_string('color'); ?>>
                                        <?php
                                        $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image_link_source']['id'], 'image', $settings);
                                        if (!$image_url && isset($attachment['url'])) {
                                            $image_url = $item['url'];
                                        } 
                                        ?>
                                        <img class="image img-banner-carousel" src="<?php echo esc_url($image_url); ?>" alt="image">
                                    </div>
                                    <div class="elementor-banner-wrap-title">
                                         <?php if ($item['image_title']) : ?>
                                             <div class="elementor-banner-title">
                                                    <?php printf('%s', $item['image_title']); ?>
                                             </div>
                                         <?php endif; ?>

                                         <?php if ($item['image_description']) : ?>
                                             <div class="elementor-banner-description">
                                                 <?php printf('%s', $item['image_description']); ?>
                                             </div>
                                         <?php endif; ?>


                                         <?php if ($item['image_show_button'] == 'yes'): ?>
                                                <a class="elementor-banner-button" href="<?php printf('%s', $item['image_button_link']['url']); ?>"
                                                   title="title">
                                                    <span class="button-text"><?php printf('%s', $item['image_button_text']); ?></span>
                                                </a>
                                         <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php $this->get_swiper_navigation(count($settings['image-carousel'])); ?>
            </div>
            
            <?php
        }
    }

}

$widgets_manager->register(new Anila_Elementor_Banner_Carousel());


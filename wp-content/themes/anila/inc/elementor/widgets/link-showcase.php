<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Anila\Elementor\Anila_Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Anila_Elementor_Link_Showcase extends Widget_Base {

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
        return 'anila-link-showcase';
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
        return esc_html__('Anila Link Showcase', 'anila');
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
        return 'eicon-tabs';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since 2.1.0
     * @access public
     *
     */
    public function get_keywords() {
        return ['tabs', 'accordion', 'toggle', 'link', 'showcase'];
    }

    public function get_script_depends() {
        return ['anila-elementor-link-showcase'];
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
            'section_items',
            [
                'label' => esc_html__('Items', 'anila'),
            ]
        );

        $this->add_control(
            'block_style',
            [
                'label'     => esc_html__('Block Style', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'render_type'        => 'template',
                'options'   => [
                    '1'  => esc_html__('Style 1', 'anila'),
                    '2'  => esc_html__('Style 2', 'anila'),
                ],
                'prefix_class' => 'link-showcase-block-style-',
            ]
        );

        $repeater = new Repeater();



        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'anila'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Title', 'anila'),
                'placeholder' => esc_html__('Title', 'anila'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'number',
            [
                'label'     => esc_html__('Number', 'anila'),
                'type'      => Controls_Manager::NUMBER,
                'default'     => esc_html__('Number', 'anila'),
                'label_block' => true,
            ]
        );

        $repeater->add_responsive_control(
            'text-horizontal',
            [
                'label'      => esc_html__('Position Horizontal', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-title-inner {{CURRENT_ITEM}}.elementor-link-showcase-title' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'image_style',
            [
                'label'     => esc_html__('Image Style', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'single',
                'render_type'        => 'template',
                'options'   => [
                    'single'  => esc_html__('Single Image', 'anila'),
                    'multiple'  => esc_html__('Multiple Images', 'anila'),
                ],
                'description' => 'Multiple Images Only works in Block Style 2',
                'prefix_class' => 'image-style-',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'   => esc_html__('Choose Image', 'anila'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_responsive_control(
            'border_radius_img',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .link-showcase-contnet-inner  {{CURRENT_ITEM}}.elementor-link-showcase-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'image_2',
            [
                'label'   => esc_html__('Choose Image', 'anila'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'image_style' => 'multiple'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'border_radius_img_2',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .link-showcase-contnet-inner  {{CURRENT_ITEM}}.elementor-link-showcase-content img:nth-of-type(2)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'items',
            [
                'label'       => esc_html__('Items', 'anila'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'    => esc_html__('Title #1', 'anila'),
                        'subtitle' => esc_html__('Subtitle #1', 'anila'),
                        'link'     => esc_html__('#', 'anila'),
                    ],
                    [
                        'title'    => esc_html__('Title #2', 'anila'),
                        'subtitle' => esc_html__('Subtitle #2', 'anila'),
                        'link'     => esc_html__('#', 'anila'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .elementor-link-showcase-inner' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-link-showcase-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .elementor-link-showcase-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-link-showcase-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name'     => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-link-showcase-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-link-showcase-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => esc_html__('Blend Mode', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => esc_html__('Normal', 'anila'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-link-showcase-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-link-showcase-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_number_style',
            [
                'label' => esc_html__('Number', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'     => esc_html__('Number Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-number a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'number_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .showcase-number a',
            ]
        );

        $this->add_responsive_control(
            'number-vertical',
            [
                'label'      => esc_html__('Position Vertical', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.showcase-number a' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'number-horizontal',
            [
                'label'      => esc_html__('Position Horizontal', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .showcase-number a' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_style' => '2'
                ]
            ]
        );

        $this->add_control(
            'heading_style_image',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Image 1', 'anila'),
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'image-width',
            [
                'label'      => esc_html__('Image Width', 'anila'),
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
                'default'     => [
                    'size' => 300,
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(1)' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image-vertical',
            [
                'label'      => esc_html__('Position Vertical', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(1)' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'image-horizontal',
            [
                'label'      => esc_html__('Position Horizontal', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(1)' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_effect_img');

        $this->start_controls_tab(
            'tab_normal_img',
            [
                'label' => esc_html__('Normal', 'anila'),
            ]
        );

        $this->add_responsive_control(
            'border_radius_img',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(1)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_hover_img',
            [
                'label' => esc_html__('Hover', 'anila'),
            ]
        );

        $this->add_responsive_control(
            'border_radius_hover_img',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(1):hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'heading_style_image-2',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Image 2', 'anila'),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image-width-2',
            [
                'label'      => esc_html__('Image Width', 'anila'),
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
                'default'     => [
                    'size' => 300,
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(2)' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image-vertical-2',
            [
                'label'      => esc_html__('Position Vertical', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper {{CURRENT_ITEM}}.elementor-link-showcase-content img:nth-of-type(2)' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image-horizontal-2',
            [
                'label'      => esc_html__('Position Horizontal', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper  {{CURRENT_ITEM}}.elementor-link-showcase-content img:nth-of-type(2)' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_effect_img_2');

        $this->start_controls_tab(
            'tab_normal_img_2',
            [
                'label' => esc_html__('Normal', 'anila'),
            ]
        );

        $this->add_responsive_control(
            'border_radius_img_2',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(2)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_hover_img_2',
            [
                'label' => esc_html__('Hover', 'anila'),
            ]
        );

        $this->add_responsive_control(
            'border_radius_hover_img_2',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.link-showcase-block-style-2 .link-showcase-contnet-wrapper .elementor-link-showcase-content img:nth-of-type(2):hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


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
        // echo '<pre>'; print_r($settings); echo '</pre>';
        if (!empty($settings['items']) && is_array($settings['items'])) {
            $items = $settings['items'];
            // Row
            $this->add_render_attribute('wrapper', 'class', 'elementor-link-showcase-wrapper');
            $this->add_render_attribute('row', 'class', 'elementor-link-showcase-inner');
            $this->add_render_attribute('row', 'role', 'tablist');
            $id_int = substr($this->get_id_int(), 0, 3);
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('row'); ?>>
                    <div class="link-showcase-item link-showcase-title-wrapper">
                        <div class="link-showcase-title-inner">
                            <?php foreach ($items as $index => $item) :
                                $count = $index + 1;
                                $item_title_setting_key = $this->get_repeater_setting_key('item_title', 'items', $index);
                                $item_number_setting_key = $this->get_repeater_setting_key('item_number', 'items', $index);
                                $this->add_render_attribute($item_title_setting_key, [
                                    'id'            => 'elementor-link-showcase-title-' . $id_int . $count,
                                    'class'         => [
                                        'elementor-link-showcase-title',
                                        ($index == 0) ? 'elementor-active' : '',
                                        'elementor-repeater-item-' . $item['_id']
                                    ],
                                    'data-tab'      => $count,
                                    'role'          => 'tab',
                                    'aria-controls' => 'elementor-link-showcase-content-' . $id_int . $count,
                                ]);


                                $title = $item['title'];
                                $number = $item['number'];
                                if (!empty($item['link']['url'])) {
                                    $title = '<a href="' . esc_url($item['link']['url']) . '">' . $title . '</a>';
                                    $number = '<a href="' . esc_url($item['link']['url']) . '">' . $number . '</a>';
                                }
                                ?>

                                <div <?php $this->print_render_attribute_string($item_title_setting_key); ?>>
                                    <?php echo wp_kses_post($title); ?>
                                    <span class="showcase-number">
                                       <?php echo wp_kses_post($number); ?>
                                     </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="link-showcase-item link-showcase-contnet-wrapper">
                        <div class="link-showcase-contnet-inner">
                            <?php foreach ($items as $index => $item) :
                                $count = $index + 1;
                                $item_content_setting_key = $this->get_repeater_setting_key('item_content', 'items', $index);
                                $this->add_render_attribute($item_content_setting_key, [
                                    'id'            => 'elementor-link-showcase-content-' . $id_int . $count,
                                    'class'         => [
                                        'elementor-link-showcase-content',
                                        'elementor-repeater-item-' . $item['_id'],
                                        ($index == 0) ? 'elementor-active' : '',
                                    ],
                                    'data-tab'      => $count,
                                    'role'          => 'tab',
                                    'aria-controls' => 'elementor-link-showcase-title-' . $id_int . $count,
                                ]);
                                ?>
                                <div <?php $this->print_render_attribute_string($item_content_setting_key); ?>>
                                    <?php $this->render_image($settings, $item); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $item) {
        // for ($i = 1; $i <= 3 ; $i++) { 
        //     $img = ($i == 1) ? '' : '_'.$i;
        //     if($i == 1 || $settings['block_style'] == '2') {
        //         $item['image_size']             = $settings['image_size'];
        //         $item['image_custom_dimension'] = $settings['image_custom_dimension'];
        //         echo Group_Control_Image_Size::get_attachment_image_html($item, 'image'.$img);
        //     }
        // }
        if (!empty($item['image']['url'])) {
            $item['image_size']             = $settings['image_size'];
            $item['image_custom_dimension'] = $settings['image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($item, 'image');
        }
        if (!empty($item['image_2']['url']) && $settings['block_style'] == '2') {
            $item['image_size']             = $settings['image_size'];
            $item['image_custom_dimension'] = $settings['image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($item, 'image_2');
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Link_Showcase());

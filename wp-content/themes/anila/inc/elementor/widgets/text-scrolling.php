<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;


use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Box_Shadow;


/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Anila_Elementor_Text_Scrolling extends Elementor\Widget_Base {

    public function get_categories() {
        return array('portfolio-addons');
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
        return 'portfolio-text-scrolling';
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
        return esc_html__('Anila Text Scrolling', 'anila');
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
        return 'eicon-post-slider';
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

        $this->add_responsive_control(
            'duration',
            [
                'label'     => esc_html__('Scrolling duration', 'anila'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 10,
                'selectors' => [
                    '{{WRAPPER}} .elementor-scrolling-inner' => 'animation-duration: {{VALUE}}s',
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


        $repeater->add_control(
            'text_stroke',
            [
                'label'     => esc_html__('Text Stroke', 'anila'),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.scrolling-title a' => ' -webkit-text-fill-color: transparent;',
                ],

            ]
        );

        $repeater->add_responsive_control(
            'width',
            [
                'label'      => esc_html__('Width Stroke', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'condition'  => [
                    'text_stroke' => 'yes',
                ],

                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.scrolling-title a' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_control(
            'color_stroke',
            [
                'label'     => esc_html__('Color Stroke', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.scrolling-title a' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_stroke' => 'yes',
                ],
            ]
        );


        $repeater->add_control(
            'color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.scrolling-title a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'text_stroke!' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'anila' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
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
//                     '{{WRAPPER}} .elementor-scrolling-wrapper .elementor-scrolling-inner' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
'{{WRAPPER}} .elementor-scrolling-wrapper .elementor-scrolling-item'  => 'margin-left: calc({{SIZE}}{{UNIT}}/2); margin-right: calc({{SIZE}}{{UNIT}}/2);',
                ],
            ]
        );

        $this->add_control(
            'border_style',
            [
                'label'        => esc_html__('Border', 'anila'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'portfolio-scrolling-border-'
            ]
        );

        $this->add_control(
            'stroke-style',
            [
                'label'        => esc_html__('Stroke style', 'anila'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'portfolio-stroke-style-'
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

        // Title.
        $this->start_controls_section(
            'section_style_scrolling_title',
            [
                'label' => esc_html__('Title', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .scrolling-title a'  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-scrolling-item:before ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .scrolling-title:hover a' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .scrolling-title',
            ]
        );

        $this->add_control(
            'color_icon_space',
            [
                'label'     => esc_html__('Icon Space Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-icon' => 'color: {{VALUE}};',

                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'          => esc_html__('Icon size', 'anila'),
                'type'           => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 30,
                        'max' => 500,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'      => [
                    '{{WRAPPER}}.elementor-widget-portfolio-text-scrolling .elementor-text-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-text-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                    <?php
                    for ($i = 0; $i <= 3; $i++) {
                        ?>
                        <div class="elementor-scrolling-inner">
                            <?php foreach ($settings['scrolling'] as $item) : 
                                $has_icon = ! empty( $item['selected_icon']['value'] );

                                if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                                    // add old default
                                    $item['icon'] = 'fa fa-star';
                                }
                        
                                $this->remove_render_attribute('i');
                                if ( ! empty( $item['icon'] ) ) {
                                    $this->add_render_attribute( 'i', 'class', $item['icon'] );
                                    $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
                                }
                        
                                $migrated = isset( $item['__fa4_migrated']['selected_icon'] );
                                $is_new = ! isset( $item['icon'] ) && Icons_Manager::is_migration_allowed();
                                ?>
                                <div <?php $this->print_render_attribute_string('item'); ?>>
                                    <div class="elementor-scrolling-item-inner">
                                    <?php if ( $has_icon ) : ?>
                                    <span class="elementor-text-icon">
                                        <?php
                                        if ( $is_new || $migrated ) {
                                            Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                        } elseif ( ! empty( $item['icon'] ) ) {
                                            ?><i <?php $this->print_render_attribute_string( 'i' ); ?>></i><?php
                                        }
                                        ?>
                                    </span>
                                    <?php endif; ?>
                                        <?php if ($item['scrolling_title']) { ?>
                                            <div class="scrolling-title elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                                                <?php
                                                if (!empty($item['link'])) {
                                                    if (!empty($item['link']['is_external'])) {
                                                        $this->add_render_attribute('scrolling-title', 'target', '_blank');
                                                    }

                                                    if (!empty($item['link']['nofollow'])) {
                                                        $this->add_render_attribute('scrolling-title', 'rel', 'nofollow');
                                                    }

                                                    echo '<a href="' . esc_url($item['link']['url'] ? $item['link']['url'] : '#') . '" ' . $this->get_render_attribute_string('scrolling-title') . ' title="' . esc_attr($item['scrolling_title']) . '">';
                                                } ?>
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
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Text_Scrolling());

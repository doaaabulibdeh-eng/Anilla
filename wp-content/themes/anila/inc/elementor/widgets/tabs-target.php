<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!anila_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Anila\Elementor\Anila_Base_Widgets;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;

/**
 * Elementor Anila_Elementor_Tabs_Target
 * @since 1.0.0
 */
class Anila_Elementor_Tabs_Target extends Anila_Base_Widgets {

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
        return 'anila-tabs-target';
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
        return esc_html__('Anila Tabs Target', 'anila');
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
        return 'eicon-lightbox';
    }

    public function get_script_depends() {
        return ['anila-elementor-tabs-target'];
    }

    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Tabs', 'anila'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Title', 'anila'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'tab_target',
            [
                'label' => esc_html__('Target', 'anila'),
                'type'  => Controls_Manager::TEXT,
                'render_type' => 'template',
                'description' => __('Add Target ID (CSS ID in Advanced tab setting of Target) WITHOUT the Pound key. e.g: my-id', 'anila')
            ]
        );

        $repeater->add_control(
            'tab_icon',
            [
                'label' => esc_html__('Icon', 'anila'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'tab_list',
            [
                'label'       => esc_html__('Items', 'anila'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__( 'Tab #1', 'anila' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Tab #2', 'anila' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
                'button_text' => 'Add Tab',
            ]
        );

        $this->add_responsive_control( 'tabs_direction', [
			'label' => esc_html__( 'Direction', 'anila' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'row' => [
                    'title' => esc_html__( 'Row - horizontal', 'anila' ),
                    'icon' => 'eicon-navigation-horizontal',
                ],
				'column' => [
                    'title' => esc_html__( 'Column - vertical', 'anila' ),
                    'icon' => 'eicon-navigation-vertical',
                ],
			],
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}}' => '--tabs-target-flex-flow: {{VALUE}}',
			]
		] );

        $this->add_responsive_control( 'tabs_justify', [
			'label' => esc_html__( 'Justify', 'anila' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-start-h',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-center-h',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-end-h',
				],
				'space-between' => [
					'title' => esc_html__( 'Space Between', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-space-between-h',
				],
			],
			'selectors' => [
				'{{WRAPPER}}' => '--tabs-target-justify-content: {{VALUE}}',
			],
		] );
        
        $this->add_responsive_control( 'tabs_align', [
			'label' => esc_html__( 'Align', 'anila' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-start-v',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-center-v',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'anila' ),
					'icon' => 'eicon-flex eicon-justify-end-v',
				],
			],
			'selectors' => [
				'{{WRAPPER}}' => '--tabs-target-align-items: {{VALUE}}',
			],
		] );

        $this->add_responsive_control( 'tabs_spacing', [
			'label' => esc_html__( 'Tabs Gap', 'anila' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'unit' => 'px',
			],
			'size_units' => [ 'px' ],
			'selectors' => [
				'{{WRAPPER}}' => '--tabs-target-gap: {{SIZE}}{{UNIT}}',
			],
		] );

        $this->end_controls_section();

        $this->start_controls_section(
            'wrapper_style',
            [
                'label' => esc_html__('Button Tabs', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_wrapper',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Wrapper', 'anila'),
                // 'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-widget-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Button', 'anila'),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-target-item a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'button_radius',
			[
				'label' => esc_html__( 'Border Radius', 'anila' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tabs-target-item a.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tabs_title_normal',
			[
				'label' => esc_html__( 'Normal', 'anila' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tabs_title_background_color',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-tabs-target-item a.elementor-button',
				'fields_options' => [
					'color' => [
						'label' => esc_html__( 'Background Color', 'anila' ),
						'selectors' => [
							'{{SELECTOR}}' => 'background-color: {{VALUE}}',
						],
					],
				],
			]
		);

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-target-item a.elementor-button' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_title_hover',
			[
				'label' => esc_html__( 'Hover', 'anila' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tabs_title_background_color_hover',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-tabs-target-item a.elementor-button:hover',
				'fields_options' => [
					'color' => [
						'label' => esc_html__( 'Background Color', 'anila' ),
						'selectors' => [
							'{{SELECTOR}}' => 'background-color: {{VALUE}}',
						],
					],
				],
			]
		);

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-target-item a.elementor-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_title_active',
			[
				'label' => esc_html__( 'Active', 'anila' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tabs_title_background_color_actived',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-tabs-target-item.actived a.elementor-button',
				'fields_options' => [
					'color' => [
						'label' => esc_html__( 'Background Color', 'anila' ),
						'selectors' => [
							'{{SELECTOR}}' => 'background-color: {{VALUE}}',
						],
					],
				],
			]
		);

        $this->add_control(
            'title_color_actived',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-target-item.actived a.elementor-button' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->end_controls_tabs();


        $this->end_controls_section();


    }

    protected function enqueue($id) {
		wp_register_style( 'tabs-target-hidden-'.$id, false );
        wp_enqueue_style( 'tabs-target-hidden-'.$id );
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
        $id = $this->get_id();
        $this->enqueue($id);

        if (!empty($settings['tab_list']) && is_array($settings['tab_list'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-tabs-target-wrapper');
            $migration_allowed = Icons_Manager::is_migration_allowed();
            $targets_hidden = '';
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <?php foreach ($settings['tab_list'] as $index => $item): ?>
                    <?php
                    $migrated              = isset($item['__fa4_migrated']['selected_icon']);
                    $is_new                = !isset($item['icon']) && $migration_allowed;
                    $item_id            = 'item-' . $item['_id'];
                    $this->add_render_attribute($item_id, 'class', 'elementor-tabs-target-item');
                    if ($index == 0) {
                        $this->add_render_attribute($item_id, 'class', 'actived');
                        
                    }
                    else {
                        if ($targets_hidden != '') $targets_hidden .= ', ';
                        $targets_hidden .= '#'.esc_html($item['tab_target']);
                    }

                    ?>
                    <div <?php $this->print_render_attribute_string($item_id); ?>>
                        <a class="tab-target-link elementor-button" href="#<?php echo esc_html($item['tab_target']); ?>"
                            title="<?php echo esc_attr($item['tab_title']); ?>">
                          <span>
                                <?php
                                echo esc_html($item['tab_title']);
                                if ($is_new || $migrated) {
                                    Icons_Manager::render_icon($item['tab_icon'], ['aria-hidden' => 'true']);
                                }
                                ?>
                          </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
            if ($targets_hidden != '') {
                $custom_css = "
                    {$targets_hidden} {
                        display: none;
                    }
                ";
                wp_add_inline_style( 'tabs-target-hidden-'.$id, $custom_css );
            }
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Tabs_Target());


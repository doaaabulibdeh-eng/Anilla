<?php

namespace Elementor;

use Anila\Elementor\Anila_Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Anila_Widget_Button extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve button widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'anila-button';
    }

    /**
     * Get widget title.
     *
     * Retrieve button widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Anila Button', 'anila');
    }

    /**
     * Get widget icon.
     *
     * Retrieve button widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-button';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the button widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since 2.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['basic'];
    }

    /**
     * Get button sizes.
     *
     * Retrieve an array of button sizes for the button widget.
     *
     * @return array An array containing button sizes.
     * @since 3.4.0
     * @access public
     * @static
     *
     */
    public static function get_button_sizes()
    {
        return [
            'xs' => esc_html__('Extra Small', 'anila'),
            'sm' => esc_html__('Small', 'anila'),
            'md' => esc_html__('Medium', 'anila'),
            'lg' => esc_html__('Large', 'anila'),
            'xl' => esc_html__('Extra Large', 'anila'),
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__('Button', 'anila'),
            ]
        );

        $args = [];
        $default_args = [
            'section_condition' => [],
            'button_default_text' => esc_html__('Click here', 'anila'),
            'text_control_label' => esc_html__('Text', 'anila'),
            'alignment_control_prefix_class' => 'elementor%s-align-',
            'alignment_default' => '',
            'icon_exclude_inline_options' => [],
        ];
        $args = wp_parse_args($args, $default_args);

        $this->add_control(
            'button_typo',
            [
                'label' => esc_html__( 'Typo', 'anila' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'anila' ),
                    'link' => esc_html__( 'Link', 'anila' ),
                ]
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => esc_html__('Type', 'anila'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'anila'),
                    'info' => esc_html__('Info', 'anila'),
                    'success' => esc_html__('Success', 'anila'),
                    'warning' => esc_html__('Warning', 'anila'),
                    'danger' => esc_html__('Danger', 'anila'),
                ],
                'prefix_class' => 'elementor-button-',
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => $args['text_control_label'],
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => $args['button_default_text'],
                'placeholder' => $args['button_default_text'],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'anila'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'anila'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'anila'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'anila'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => $args['alignment_control_prefix_class'],
                'default' => $args['alignment_default'],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__('Size', 'anila'),
                'type' => Controls_Manager::SELECT,
                'default' => 'md',
                'options' => self::get_button_sizes(),
                'style_transfer' => true,
                'condition' => [
                    'button_typo' => 'default'
                ]
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'anila'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
                'condition' => $args['section_condition'],
                'icon_exclude_inline_options' => $args['icon_exclude_inline_options'],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label' => esc_html__('Icon Spacing', 'anila'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button:hover .right' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'anila'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'button_css_id',
            [
                'label' => esc_html__('Button ID', 'anila'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
                'title' => esc_html__('Add your custom id WITHOUT the Pound key. e.g: my-id', 'anila'),
                /* translators: %1$s Code open tag, %2$s: Code close tag. */
                'description' => esc_html__('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'anila'),
                'separator' => 'before',
                'condition' => $args['section_condition'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Button', 'anila'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $default_args = [
            'section_condition' => [],
        ];

        $args = wp_parse_args($args, $default_args);

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .elementor-button',
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
                'condition' => $args['section_condition'],
            ]
        );

        $this->start_controls_tabs('tabs_button_style', [
            'condition' => $args['section_condition'],
        ]);

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'anila'),
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label' => esc_html__('Icon Color', 'anila'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'anila'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => esc_html__('Background', 'anila'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .elementor-button',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'anila'),
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__('Icon Color Hover', 'anila'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => esc_html__('Text Color', 'anila'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover',
                'label' => esc_html__('Background', 'anila'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'anila'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'anila'),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'condition' => $args['section_condition'],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .elementor-button',
                'separator' => 'before',
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'anila'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
                'condition' => $args['section_condition'],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__('Padding', 'anila'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => $args['section_condition'],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $this->render_button();
    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_button(Widget_Base $instance = null)
    {
        if (empty($instance)) {
            $instance = $this;
        }

        $settings = $instance->get_settings_for_display();

        $instance->add_render_attribute('wrapper', 'class', 'elementor-button-wrapper');

        if (!empty($settings['button_typo'])) {
            $instance->add_render_attribute('button', 'class', 'elementor-btn-type-'.$settings['button_typo']);
        }

        if (!empty($settings['link']['url'])) {
            $instance->add_link_attributes('button', $settings['link']);
            $instance->add_render_attribute('button', 'class', 'elementor-button-link');
        }

        $instance->add_render_attribute('button', 'class', 'elementor-button');
        $instance->add_render_attribute('button', 'role', 'button');

        if (!empty($settings['button_css_id'])) {
            $instance->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        if (!empty($settings['size'])) {
            $instance->add_render_attribute('button', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['hover_animation'])) {
            $instance->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }
        ?>
        <div <?php $instance->print_render_attribute_string('wrapper'); ?>>
            <a <?php $instance->print_render_attribute_string('button'); ?>>
                <?php $this->render_text($instance); ?>
            </a>
        </div>
        <?php
    }

    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_text(Widget_Base $instance = null)
    {
        // The default instance should be `$this` (a Button widget), unless the Trait is being used from outside of a widget (e.g. `Skin_Base`) which should pass an `$instance`.
        if (empty($instance)) {
            $instance = $this;
        }

        $settings = $instance->get_settings_for_display();

        $migrated = isset($settings['__fa4_migrated']['selected_icon']);
        $is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

        $instance->add_render_attribute([
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ]);

        ?>
        <span <?php $instance->print_render_attribute_string('content-wrapper'); ?>>
			<?php if (!empty($settings['icon']) || !empty($settings['selected_icon']['value'])) : ?>
                <span class="elementor-button-icon left">
				<?php if ($is_new || $migrated) :
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                else : ?>
                    <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                <?php endif; ?>
			</span>
            <?php endif; ?>
			<span <?php $instance->print_render_attribute_string('text'); ?>><?php $this->print_unescaped_setting('text'); ?></span>
            <?php if (!empty($settings['icon']) || !empty($settings['selected_icon']['value'])) : ?>
                <span class="elementor-button-icon right">
                    <?php if ($is_new || $migrated) :
                        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                    else : ?>
                        <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                    <?php endif; ?>
			    </span>
            <?php endif; ?>
		</span>
        <?php
    }
}

$widgets_manager->register(new Anila_Widget_Button());

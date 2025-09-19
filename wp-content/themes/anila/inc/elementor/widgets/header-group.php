<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Anila_Elementor_Header_Group extends Elementor\Widget_Base {

    public function get_name() {
        return 'anila-header-group';
    }

    public function get_title() {
        return esc_html__('Anila Header Group', 'anila');
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_categories() {
        return array('anila-addons');
    }

    protected function register_controls() {

        $this->start_controls_section(
            'header_group_config',
            [
                'label' => esc_html__('Config', 'anila'),
            ]
        );

        $this->add_control(
            'show_search',
            [
                'label' => esc_html__('Show search', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_account',
            [
                'label' => esc_html__('Show account', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_wishlist',
            [
                'label' => esc_html__('Show wishlist', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_cart',
            [
                'label' => esc_html__('Show cart', 'anila'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header-group-style',
            [
                'label' => esc_html__('Icon', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:not(:hover) i:before'             => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:not(:hover):before'               => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div .button-content:not(:hover) > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:hover i:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:hover:before'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Font Size', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a i:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:before'   => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'elementor-header-group-wrapper');
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div class="header-group-action">

                <?php if ($settings['show_search'] === 'yes'):{
                    anila_header_search_button();
                }
                endif; ?>

                <?php if ($settings['show_account'] === 'yes'):{
                    anila_header_account();
                }
                endif; ?>

                <?php if ($settings['show_wishlist'] === 'yes' && anila_is_woocommerce_activated()):{
                    anila_header_wishlist();
                }
                endif; ?>

                <?php if ($settings['show_cart'] === 'yes' && anila_is_woocommerce_activated()):{
                    anila_header_cart();
                }
                endif; ?>

            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Anila_Elementor_Header_Group());

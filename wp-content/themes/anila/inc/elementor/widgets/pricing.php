<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Anila_Pricing extends Elementor\Widget_Base {

    public function get_name() {
        return 'anila-pricing';
    }

    public function get_title() {
        return esc_html__('Anila Pricing', 'anila');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_keywords() {
        return ['pricing', 'table', 'product', 'image', 'plan', 'button'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_header',
            [
                'label' => esc_html__('Header', 'anila'),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'   => esc_html__('Title', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Enter your title', 'anila'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label'   => esc_html__('Description', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Enter your description', 'anila'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label'   => esc_html__('Title HTML Tag', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default' => 'h3',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing',
            [
                'label' => esc_html__('Pricing', 'anila'),
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label'   => esc_html__('Currency Symbol', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''             => esc_html__('None', 'anila'),
                    'dollar'       => '&#36; ' . _x('Dollar', 'Currency', 'anila'),
                    'euro'         => '&#128; ' . _x('Euro', 'Currency', 'anila'),
                    'baht'         => '&#3647; ' . _x('Baht', 'Currency', 'anila'),
                    'franc'        => '&#8355; ' . _x('Franc', 'Currency', 'anila'),
                    'guilder'      => '&fnof; ' . _x('Guilder', 'Currency', 'anila'),
                    'krona'        => 'kr ' . _x('Krona', 'Currency', 'anila'),
                    'lira'         => '&#8356; ' . _x('Lira', 'Currency', 'anila'),
                    'peseta'       => '&#8359 ' . _x('Peseta', 'Currency', 'anila'),
                    'peso'         => '&#8369; ' . _x('Peso', 'Currency', 'anila'),
                    'pound'        => '&#163; ' . _x('Pound Sterling', 'Currency', 'anila'),
                    'real'         => 'R$ ' . _x('Real', 'Currency', 'anila'),
                    'ruble'        => '&#8381; ' . _x('Ruble', 'Currency', 'anila'),
                    'rupee'        => '&#8360; ' . _x('Rupee', 'Currency', 'anila'),
                    'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency', 'anila'),
                    'shekel'       => '&#8362; ' . _x('Shekel', 'Currency', 'anila'),
                    'yen'          => '&#165; ' . _x('Yen/Yuan', 'Currency', 'anila'),
                    'won'          => '&#8361; ' . _x('Won', 'Currency', 'anila'),
                    'custom'       => esc_html__('Custom', 'anila'),
                ],
                'default' => 'dollar',
            ]
        );

        $this->add_control(
            'currency_symbol_custom',
            [
                'label'     => esc_html__('Custom Symbol', 'anila'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'currency_symbol' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'price',
            [
                'label'   => esc_html__('Price', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => '39.99',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'currency_format',
            [
                'label'   => esc_html__('Currency Format', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''  => '1,234.56 (Default)',
                    ',' => '1.234,56',
                ],
            ]
        );

        $this->add_control(
            'sale',
            [
                'label'     => esc_html__('Sale', 'anila'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('On', 'anila'),
                'label_off' => esc_html__('Off', 'anila'),
                'default'   => '',
            ]
        );

        $this->add_control(
            'original_price',
            [
                'label'     => esc_html__('Original Price', 'anila'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '59',
                'condition' => [
                    'sale' => 'yes',
                ],
                'dynamic'   => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'period',
            [
                'label'   => esc_html__('Period', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Monthly', 'anila'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features',
            [
                'label' => esc_html__('Features', 'anila'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label'   => esc_html__('Text', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('List Item', 'anila'),
            ]
        );

        $default_icon = [
            'value'   => 'far fa-check-circle',
            'library' => 'fa-regular',
        ];

        $repeater->add_control(
            'selected_item_icon',
            [
                'label'            => esc_html__('Icon', 'anila'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'item_icon',
                'default'          => $default_icon,
            ]
        );

        $repeater->add_control(
            'item_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} i'   => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'item_text_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} span'   => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_control(
            'features_list',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_text'          => esc_html__('List Item #1', 'anila'),
                        'selected_item_icon' => $default_icon,
                    ],
                    [
                        'item_text'          => esc_html__('List Item #2', 'anila'),
                        'selected_item_icon' => $default_icon,
                    ],
                    [
                        'item_text'          => esc_html__('List Item #3', 'anila'),
                        'selected_item_icon' => $default_icon,
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer',
            [
                'label' => esc_html__('Footer', 'anila'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => esc_html__('Button Text', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Click Here', 'anila'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );


        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Icon', 'anila'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'button_icon_align',
            [
                'label'     => esc_html__('Icon Position', 'anila'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'left',
            ]
        );
        $this->add_responsive_control(
            'button_icon_spacing',
            [
                'label'     => esc_html__('Spacing', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => esc_html__('Link', 'anila'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'anila'),
                'default'     => [
                    'url' => '#',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => esc_html__('Wrapper', 'anila'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_background_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table'   => 'background-color: {{VALUE}}',
                ],
            ]
        );

          $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name'        => 'wrapper_border',
                 'placeholder' => '1px',
                 'default'     => '1px',
                 'selector'    => '{{WRAPPER}} .elementor-price-table',
                 'separator'   => 'before',

            ]
        );

        $this->add_control(
            'border_hover_color',
            [
                'label'     => esc_html__('Border Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table:hover'   => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_header_style',
            [
                'label'      => esc_html__('Header', 'anila'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'header_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__header' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'header_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-price-table__header',
                'separator'   => 'before',

            ]
        );

        $this->add_control(
            'heading_heading_style',
            [
                'label'     => esc_html__('Title', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__heading',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_sub_heading_style',
            [
                'label'     => esc_html__('Description', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__subheading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_heading_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__subheading',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_element_style',
            [
                'label'      => esc_html__('Pricing', 'anila'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'pricing_element_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_element_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__currency, {{WRAPPER}} .elementor-price-table__integer-part, {{WRAPPER}} .elementor-price-table__fractional-part' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                // Targeting also the .elementor-price-table class in order to get a higher specificity from the inline CSS.
                'selector' => '{{WRAPPER}} .elementor-price-table__integer-part',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'heading_currency_style',
            [
                'label'     => esc_html__('Currency Symbol', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'currency_symbol!' => '',
                ],
            ]
        );

        $this->add_control(
            'currency_size',
            [
                'label'     => esc_html__('Size', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price > .elementor-price-table__currency' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'currency_symbol!' => '',
                ],
            ]
        );

        $this->add_control(
            'currency_position',
            [
                'label'   => esc_html__('Position', 'anila'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'before',
                'options' => [
                    'before' => [
                        'title' => esc_html__('Before', 'anila'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'after'  => [
                        'title' => esc_html__('After', 'anila'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
            ]
        );

        $this->add_control(
            'currency_vertical_position',
            [
                'label'                => esc_html__('Vertical Position', 'anila'),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => [
                    'top'    => [
                        'title' => esc_html__('Top', 'anila'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'anila'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'anila'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'              => 'top',
                'selectors_dictionary' => [
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'selectors'            => [
                    '{{WRAPPER}} .elementor-price-table__currency' => 'align-self: {{VALUE}}',
                ],
                'condition'            => [
                    'currency_symbol!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_original_price_style',
            [
                'label'     => esc_html__('Original Price', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'sale'            => 'yes',
                    'original_price!' => '',
                ],
            ]
        );

        $this->add_control(
            'original_price_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__original-price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elementor-typo-excluded > .elementor-price-table__currency' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'sale'            => 'yes',
                    'original_price!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'      => 'original_price_typography',
                'selector'  => '{{WRAPPER}} .elementor-price-table__original-price',
                'global'    => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'condition' => [
                    'sale'            => 'yes',
                    'original_price!' => '',
                ],
            ]
        );

        $this->add_control(
            'original_price_vertical_position',
            [
                'label'                => esc_html__('Vertical Position', 'anila'),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => [
                    'top'    => [
                        'title' => esc_html__('Top', 'anila'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'anila'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'anila'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors_dictionary' => [
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'default'              => 'bottom',
                'selectors'            => [
                    '{{WRAPPER}} .elementor-price-table__original-price' => 'align-self: {{VALUE}}',
                ],
                'condition'            => [
                    'sale'            => 'yes',
                    'original_price!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_period_style',
            [
                'label'     => esc_html__('Period', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'period!' => '',
                ],
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__period' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'period!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'selector'  => '{{WRAPPER}} .elementor-price-table__period',
                'global'    => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'condition' => [
                    'period!' => '',
                ],
            ]
        );

        $this->add_control(
            'period_position',
            [
                'label'       => esc_html__('Position', 'anila'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => [
                    'below'  => esc_html__('Below', 'anila'),
                    'beside' => esc_html__('Beside', 'anila'),
                ],
                'default'     => 'below',
                'condition'   => [
                    'period!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features_list_style',
            [
                'label'      => esc_html__('Features', 'anila'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'features_list_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'features_list_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'features_list_color',
            [
                'label'     => esc_html__('Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => '--e-price-table-features-list-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'features_list_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__features-list li',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            'features_list_alignment',
            [
                'label'     => esc_html__('Alignment', 'anila'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
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
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer_style',
            [
                'label'      => esc_html__('Footer', 'anila'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'footer_bg_color',
            [
                'label'     => esc_html__('Background Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'footer_padding',
            [
                'label'      => esc_html__('Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_footer_button',
            [
                'label'     => esc_html__('Button', 'anila'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'     => esc_html__('Size', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'md',
                'options'   => [
                    'xs' => esc_html__('Extra Small', 'anila'),
                    'sm' => esc_html__('Small', 'anila'),
                    'md' => esc_html__('Medium', 'anila'),
                    'lg' => esc_html__('Large', 'anila'),
                    'xl' => esc_html__('Extra Large', 'anila'),
                ],
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'     => esc_html__('Normal', 'anila'),
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer .elementor-price-table__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .elementor-price-table__button',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'button_background',
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '{{WRAPPER}} .elementor-price-table__footer .elementor-price-table__button',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );
        $this->add_control(
            'button_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer .elementor-button .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'      => 'button_border',
                'selector'  => '{{WRAPPER}} .elementor-price-table__button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_padding',
            [
                'label'      => esc_html__('Button Padding', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_button_size',
            [
                'label'     => esc_html__('Icon Size', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'     => esc_html__('Hover', 'anila'),
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer .elementor-price-table__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'button_background_hover',
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '{{WRAPPER}} .elementor-price-table__footer .elementor-price-table__button:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer .elementor-price-table__button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_animation',
            [
                'label' => esc_html__('Animation', 'anila'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->add_control(
            'button_hover_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__footer .elementor-button:hover .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    private function render_currency_symbol($symbol, $location) {
        $currency_position = $this->get_settings('currency_position');
        $location_setting  = !empty($currency_position) ? $currency_position : 'before';
        if (!empty($symbol) && $location === $location_setting) {
            echo '<span class="elementor-price-table__currency">' . esc_html($symbol) . '</span>';
        }
    }

    private function get_currency_symbol($symbol_name) {
        $symbols = [
            'dollar'       => '&#36;',
            'euro'         => '&#128;',
            'franc'        => '&#8355;',
            'pound'        => '&#163;',
            'ruble'        => '&#8381;',
            'shekel'       => '&#8362;',
            'baht'         => '&#3647;',
            'yen'          => '&#165;',
            'won'          => '&#8361;',
            'guilder'      => '&fnof;',
            'peso'         => '&#8369;',
            'peseta'       => '&#8359',
            'lira'         => '&#8356;',
            'rupee'        => '&#8360;',
            'indian_rupee' => '&#8377;',
            'real'         => 'R$',
            'krona'        => 'kr',
        ];

        return isset($symbols[$symbol_name]) ? $symbols[$symbol_name] : '';
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $symbol   = '';
        $has_icon = !empty($settings['button_icon']);

        if ($has_icon) {
            $this->add_render_attribute('button-icon', 'class', $settings['button_icon']);
            $this->add_render_attribute('button-icon', 'aria-hidden', 'true');
        }

        if (empty($settings['button_icon']) && !Icons_Manager::is_migration_allowed()) {
            $settings['button_icon'] = 'fa fa-star';
        }

        if (!empty($settings['currency_symbol'])) {
            if ('custom' !== $settings['currency_symbol']) {
                $symbol = $this->get_currency_symbol($settings['currency_symbol']);
            } else {
                $symbol = $settings['currency_symbol_custom'];
            }
        }
        $currency_format = empty($settings['currency_format']) ? '.' : $settings['currency_format'];
        $price           = explode($currency_format, $settings['price']);
        $intpart         = $price[0];
        $fraction        = '';
        if (2 === count($price)) {
            $fraction = $price[1];
        }

        $this->add_render_attribute('button_text', 'class', [
            'elementor-price-table__button',
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        $this->add_render_attribute('button_icon', 'class', ['elementor-button-icon button-icon']);

        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('button_text', $settings['link']);
        }

        if (!empty($settings['button_hover_animation'])) {
            $this->add_render_attribute('button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        if (!empty($settings['button_icon_align'])) {
            $this->add_render_attribute('button_icon', 'class', 'elementor-align-icon-' . $settings['button_icon_align']);
        }

        $this->add_render_attribute('heading', 'class', 'elementor-price-table__heading');
        $this->add_render_attribute('sub_heading', 'class', 'elementor-price-table__subheading');
        $this->add_render_attribute('period', 'class', ['elementor-price-table__period', 'elementor-typo-excluded']);

        $this->add_inline_editing_attributes('heading', 'none');
        $this->add_inline_editing_attributes('sub_heading', 'none');
        $this->add_inline_editing_attributes('period', 'none');
        $this->add_inline_editing_attributes('button_text');

        $period_position = $settings['period_position'];
        $period_element  = '<span ' . $this->get_render_attribute_string('period') . '>' . $settings['period'] . '</span>';

        $heading_tag     = Utils::validate_html_tag($settings['heading_tag']);

        $migration_allowed = Icons_Manager::is_migration_allowed();
        ?>

        <div class="elementor-price-table">
            <div class="elementor-price-table-deco">
                <?php if ($settings['heading'] || $settings['sub_heading']) : ?>
                    <div class="elementor-price-table__header">
                    <?php if (!empty($settings['heading'])) : ?>
                        <<?php Utils::print_validated_html_tag($heading_tag); ?> <?php $this->print_render_attribute_string('heading'); ?>>
                        <?php $this->print_unescaped_setting('heading'); ?>
                        </<?php Utils::print_validated_html_tag($heading_tag); ?>>
                    <?php endif; ?>
                    <?php if (!empty($settings['sub_heading'])) : ?>
                        <span <?php $this->print_render_attribute_string('sub_heading'); ?>>
                        <?php $this->print_unescaped_setting('sub_heading'); ?>
                        </span>
                     <?php endif; ?>
                <div class="elementor-price-table__price">
                    <?php if ('yes' === $settings['sale'] && !empty($settings['original_price'])) : ?>
                        <div class="elementor-price-table__original-price elementor-typo-excluded">
                            <?php
                            $this->render_currency_symbol($symbol, 'before');
                            $this->print_unescaped_setting('original_price');
                            $this->render_currency_symbol($symbol, 'after');
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php $this->render_currency_symbol($symbol, 'before'); ?>
                    <?php if (!empty($intpart) || 0 <= $intpart) : ?>
                        <span class="elementor-price-table__integer-part">
                                <?php
                                // PHPCS - the main text of a widget should not be escaped.
                                echo sprintf('%s', $intpart);  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </span>
                    <?php endif; ?>

                    <?php $this->render_currency_symbol($symbol, 'after'); ?>

                    <?php if ('' !== $fraction || (!empty($settings['period']) && 'beside' === $period_position)) : ?>
                        <div class="elementor-price-table__after-price">

                            <?php if (!empty($settings['period']) && 'beside' === $period_position) : ?>
                                <?php
                                // PHPCS - already escaped before
                                echo sprintf('%s', $period_element); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <?php if (!empty($settings['period']) && 'below' === $period_position) : ?>
                        <?php
                        // PHPCS - already escaped before
                        echo sprintf('%s', $period_element); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        ?>
                    <?php endif; ?>

                </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($settings['features_list'])) : ?>
                    <ul class="elementor-price-table__features-list">
                        <?php
                        foreach ($settings['features_list'] as $index => $item) :
                            $repeater_setting_key = $this->get_repeater_setting_key('item_text', 'features_list', $index);
                            $this->add_inline_editing_attributes($repeater_setting_key);

                            $migrated = isset($item['__fa4_migrated']['selected_item_icon']);
                            // add old default
                            if (!isset($item['item_icon']) && !$migration_allowed) {
                                $item['item_icon'] = 'fa fa-check-circle';
                            }
                            $is_new = !isset($item['item_icon']) && $migration_allowed;
                            ?>
                            <li class="elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                                <div class="elementor-price-table__feature-inner">
                                    <?php if (!empty($item['item_icon']) || !empty($item['selected_item_icon'])) :
                                        if ($is_new || $migrated) :
                                            Icons_Manager::render_icon($item['selected_item_icon'], ['aria-hidden' => 'true']);
                                        else : ?>
                                            <i class="<?php echo esc_attr($item['item_icon']); ?>" aria-hidden="true"></i>
                                        <?php
                                        endif;
                                    endif; ?>
                                    <?php if (!empty($item['item_text'])) : ?>
                                        <span <?php $this->print_render_attribute_string($repeater_setting_key); ?>>
                                                <?php $this->print_unescaped_setting('item_text', 'features_list', $index); ?>
                                            </span>
                                    <?php
                                    else :
                                        echo '&nbsp;';
                                    endif;
                                    ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($settings['button_text'])) : ?>
                    <div class="elementor-price-table__footer">
                        <?php if (!empty($settings['button_text'])) : ?>
                            <a <?php $this->print_render_attribute_string('button_text'); ?>>
                                <span class="elementor-button-content-wrapper">
                                    <?php if (!empty($settings['button_icon']['value'])) : ?>
                                        <span class="elementor-button-icon left">
                                            <i <?php $this->print_render_attribute_string('button-icon'); ?>></i>
                                        </span>
                                    <?php endif; ?>
                                    <span class="elementor-button-text"><?php $this->print_unescaped_setting('button_text'); ?></span>
                                    <?php if (!empty($settings['button_icon']['value'])) : ?>
                                        <span class="elementor-button-icon right">
                                        <i <?php $this->print_render_attribute_string('button-icon'); ?>></i>
                                    </span>
                                    <?php endif; ?>
                                </span>
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}

$widgets_manager->register(new Anila_Pricing());

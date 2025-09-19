<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!anila_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Anila\Elementor\Anila_Group_Control_Typography;

class Anila_Elementor_Breadcrumb extends Elementor\Widget_Base {

    public function get_name() {
        return 'woocommerce-breadcrumb';
    }

    public function get_title() {
        return esc_html__('Anila WooCommerce Breadcrumbs', 'anila');
    }

    public function get_icon() {
        return 'eicon-product-breadcrumbs';
    }

    public function get_categories() {
        return ['anila-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_product_rating_style',
            [
                'label' => esc_html__('Style Breadcrumb', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wc_style_warning',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'anila'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-breadcrumb' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-breadcrumb i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Link Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-breadcrumb > a:not(:hover)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color_hover',
            [
                'label'     => esc_html__('Link Hover', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-breadcrumb > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__('Typography Link', 'anila'),
                'name'     => 'text_link_typography',
                'selector' => '{{WRAPPER}} .woocommerce-breadcrumb a',
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__('Typography Text', 'anila'),
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .woocommerce-breadcrumb',
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                    '{{WRAPPER}} .woocommerce-breadcrumb'    => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .anila-woocommerce-title' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'breadcrumb_size',
            [
                'label'   => esc_html__('HTML Tag', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'div',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_product_rating_style_title',
            [
                'label' => esc_html__('Style Title', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color_title',
            [
                'label'     => esc_html__('Title Color', 'anila'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .anila-woocommerce-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .anila-woocommerce-title',
            ]
        );

        $this->add_control(
            'display_title',
            [
                'label'        => esc_html__('Hidden Title', 'anila'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'hidden-anila-title-'
            ]
        );

        $this->add_control(
            'display_title_single',
            [
                'label'        => esc_html__('Hidden Title Single', 'anila'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'hidden-anila-title-single-'
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .anila-woocommerce-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tag = $settings['breadcrumb_size'] ? $settings['breadcrumb_size'] : 'div';
        $args        = apply_filters(
            'woocommerce_breadcrumb_defaults',
            array(
                'delimiter'   => '<i class="anila-icon-breadcrumb"></i>',
                'wrap_before' => '<nav class="woocommerce-breadcrumb">',
                'wrap_after'  => '</nav>',
                'before'      => '',
                'after'       => '',
                'home'        => _x(' Home', 'breadcrumb', 'anila'),
            )
        );

        if (!class_exists('WC_Breadcrumb')) {
            return;
        }

        $breadcrumbs = new WC_Breadcrumb();
        if (!empty($args['home'])) {
            $breadcrumbs->add_crumb($args['home'], apply_filters('woocommerce_breadcrumb_home_url', home_url()));
        }
        $args['breadcrumb'] = $breadcrumbs->generate();

        /**
         * WooCommerce Breadcrumb hook
         *
         * @see WC_Structured_Data::generate_breadcrumblist_data() - 10
         */
        do_action('woocommerce_breadcrumb', $breadcrumbs, $args);
        if (isset($args['breadcrumb']) && isset(end($args['breadcrumb'])[0])) {
            printf('<%1s class="anila-woocommerce-title">%2s</%3s>', $tag, end($args['breadcrumb'])[0], $tag);
        }
        wc_get_template('global/breadcrumb.php', $args);
    }

    public function render_plain_content() {
    }
}

$widgets_manager->register(new Anila_Elementor_Breadcrumb());

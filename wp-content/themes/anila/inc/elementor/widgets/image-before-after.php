<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Anila_Elementor_Image_Before_After extends Elementor\Widget_Base {

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
        return 'anila-image-before-after';
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
        return esc_html__('Anila Image Before After', 'anila');
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
        return 'eicon-image-before-after';
    }

    public function get_script_depends() {
        return ['anila-elementor-image-before-after', 'beforeafter'];
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
            'section_content',
            [
                'label' => esc_html__('Image', 'anila'),
            ]
        );

        $this->add_control(
            'image_before',
            [
                'label'      => esc_html__('Choose Image Before', 'anila'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'image_after',
            [
                'label'      => esc_html__('Choose Image After', 'anila'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Wrapper', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'          => esc_html__('Width', 'anila'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                    'size' => '970',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['px', '%'],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 1500,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image-before-after' => 'max-width: {{SIZE}}{{UNIT}};',
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
                    'size' => '600',
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
                    '{{WRAPPER}} .elementor-image-before-after-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-image-before-after'         => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
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
        if (!empty($settings['image_before']) && !empty($settings['image_after'])) {

            // wrapper
            $this->add_render_attribute('wrapper', 'class', 'elementor-image-before-after-wrapper');
            $this->add_render_attribute('inner', 'class', 'elementor-image-before-after');
            $image_before = Group_Control_Image_Size::get_attachment_image_src($settings['image_before']['id'], 'image', $settings);
            $image_after  = Group_Control_Image_Size::get_attachment_image_src($settings['image_after']['id'], 'image', $settings);
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok.?>>
                <div <?php $this->print_render_attribute_string('inner'); // WPCS: XSS ok.?>>
                    <img class="content-image" src="<?php echo esc_url($image_before); ?>" draggable="false"/>
                    <img class="content-image" src="<?php echo esc_url($image_after); ?>" draggable="false"/>
                </div>
            </div>
            <?php
        }
    }
}

$widgets_manager->register(new Anila_Elementor_Image_Before_After());


<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!anila_is_contactform_activated()) {
    return;
}

use Elementor\Controls_Manager;


class Anila_Elementor_ContactForm extends Elementor\Widget_Base {

    public function get_name() {
        return 'anila-contactform';
    }

    public function get_title() {
        return esc_html__('Anila Contact Form', 'anila');
    }

    public function get_categories() {
        return array('anila-addons');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => esc_html__('General', 'anila'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7               = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
        $contact_forms[''] = esc_html__('Please select form', 'anila');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $hash = get_post_meta( $cform->ID, '_hash', true );
                if ($hash) {
                    $contact_forms[$hash] = $cform->post_title;
                }
            }
        } else {
            $contact_forms[0] = esc_html__('No contact forms found', 'anila');
        }

        $this->add_control(
            'cf_id',
            [
                'label'   => esc_html__('Select contact form', 'anila'),
                'type'    => Controls_Manager::SELECT,
                'options' => $contact_forms,
                'default' => ''
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label'   => esc_html__('Form name', 'anila'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Contact form', 'anila'),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__('Alignment', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'contact-form-align-',
            ]
        );
        $this->add_control(
            'style_special',
            [
                'label'        => esc_html__('Style special', 'anila'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'contact-form-special-',
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!$settings['cf_id'] || empty($settings['cf_id'])) {
            return;
        }


        $form = wpcf7_get_contact_form_by_hash($settings['cf_id']);

        if (!$form) return;
        $id = $form->id();
        
        $args['id']    = $id;
        $args['title'] = $settings['form_name'];

        echo anila_do_shortcode('contact-form-7', $args);
    }
}

$widgets_manager->register(new Anila_Elementor_ContactForm());

<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Anila_Customize')) {

    class Anila_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        private function get_block($kw) {
            global $post;

            $options[''] = esc_html__('Select Block', 'anila');
            if (!anila_is_elementor_activated()) {
                return;
            }
            $args = array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                's'              =>  $kw,
                'order'          => 'ASC',
            );

            $query1 = new WP_Query($args);
            while ($query1->have_posts()) {
                $query1->the_post();
                $options[$post->post_name] = $post->post_title;
            }

            wp_reset_postdata();
            return $options;
        }
        
        public function get_cf7_forms() {
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

            wp_reset_postdata();
            return $contact_forms;
        }

        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */
            require_once get_theme_file_path('inc/customize-control/editor.php');
            $this->init_anila_blog($wp_customize);
            $this->anila_register_theme_customizer($wp_customize);


            if (anila_is_woocommerce_activated()) {
                $this->init_woocommerce($wp_customize);
            }
            
            if (post_type_exists('service')) {
                $this->init_anila_service($wp_customize);
            }
            
            if (post_type_exists('coach')) {
                $this->init_anila_coach($wp_customize);
            }

            do_action('anila_customize_register', $wp_customize);
        }

        function anila_register_theme_customizer($wp_customize) {

        } // end anila_register_theme_customizer

        public function anila_active_callback_show_top_block($control) {
            $setting = $control->manager->get_setting( 'anila_options_show_top_blog' );
            $show = $setting->value();

            return $show === 'yes';
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_anila_blog($wp_customize) {

            $wp_customize->add_panel('anila_blog', array(
                'title' => esc_html__('Blog', 'anila'),
            ));

            // =========================================
            // Blog Archive
            // =========================================
            $wp_customize->add_section('anila_blog_archive', array(
                'title'      => esc_html__('Archive', 'anila'),
                'panel'      => 'anila_blog',
                'capability' => 'edit_theme_options',
            ));

            if (anila_is_elementor_activated()) {
                $wp_customize->add_setting('anila_options_show_top_blog', array(
                    'type'              => 'option',
                    'default'           => 'no',
                    'sanitize_callback' => 'sanitize_text_field',
                ));
    
                $wp_customize->add_control('anila_options_show_top_blog', array(
                    'section' => 'anila_blog_archive',
                    'label'   => esc_html__('Show Top Block', 'anila'),
                    'type'    => 'select',
                    'choices' => [
                        'no' => esc_html__('No', 'anila'),
                        'yes' => esc_html__('Yes', 'anila'),
                    ]
                ));

                $wp_customize->add_setting('anila_options_top_blog_template', array(
                    'type'              => 'option',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('anila_options_top_blog_template', array(
                    'section'     => 'anila_blog_archive',
                    'label'       => esc_html__('Choose Block', 'anila'),
                    'type'        => 'select',
                    'description' => __('Block will take templates name prefix is "Blog"', 'anila'),
                    'choices'     => $this->get_block('Blog'),
                    'active_callback' => [$this, 'anila_active_callback_show_top_block'],
                ));
            }

            $wp_customize->add_setting('anila_options_blog_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_sidebar', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'anila'),
                    'left'  => esc_html__('Left', 'anila'),
                    'right' => esc_html__('Right', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_style', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Blog style', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'anila'),
                    'list'     => esc_html__('Blog List', 'anila'),
                    'style-1'  => esc_html__('Blog Grid', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_blog_columns', array(
                'type'              => 'option',
                'default'           => 3,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_columns', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Colunms', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'anila'),
                    2 => esc_html__('2', 'anila'),
                    3 => esc_html__('3', 'anila'),
                    4 => esc_html__('4', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_blog_columns_laptop', array(
                'type'              => 'option',
                'default'           => 3,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_columns_laptop', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Colunms Laptop', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'anila'),
                    2 => esc_html__('2', 'anila'),
                    3 => esc_html__('3', 'anila'),
                    4 => esc_html__('4', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_blog_columns_tablet', array(
                'type'              => 'option',
                'default'           => 2,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_columns_tablet', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Colunms Tablet', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'anila'),
                    2 => esc_html__('2', 'anila'),
                    3 => esc_html__('3', 'anila'),
                    4 => esc_html__('4', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_blog_columns_mobile', array(
                'type'              => 'option',
                'default'           => 1,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_columns_mobile', array(
                'section' => 'anila_blog_archive',
                'label'   => esc_html__('Colunms Mobile', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'anila'),
                    2 => esc_html__('2', 'anila'),
                    3 => esc_html__('3', 'anila'),
                    4 => esc_html__('4', 'anila'),
                ),
            ));

            // =========================================
            // Blog Single
            // =========================================
            $wp_customize->add_section('anila_blog_single', array(
                'title'      => esc_html__('Singular', 'anila'),
                'panel'      => 'anila_blog',
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting('anila_options_blog_single_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_single_sidebar', array(
                'section' => 'anila_blog_single',
                'label'   => esc_html__('Sidebar Position', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'anila'),
                    'left'  => esc_html__('Left', 'anila'),
                    'right' => esc_html__('Right', 'anila'),
                ),
            ));
            
            $wp_customize->add_setting('anila_options_blog_single_style', array(
                'type'              => 'option',
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_blog_single_style', array(
                'section' => 'anila_blog_single',
                'label'   => esc_html__('Template style', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    ''  => esc_html__('Style 1', 'anila'),
                    '2'  => esc_html__('Style 2', 'anila'),
                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */


        public function init_woocommerce($wp_customize) {

            $wp_customize->add_panel('woocommerce', array(
                'title' => esc_html__('Woocommerce', 'anila'),
            ));

            $wp_customize->add_section('anila_woocommerce_archive', array(
                'title'      => esc_html__('Archive', 'anila'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            if (anila_is_elementor_activated()) {
                $wp_customize->add_setting('anila_options_shop_banner', array(
                    'type'              => 'option',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('anila_options_shop_banner', array(
                    'section'     => 'anila_woocommerce_archive',
                    'label'       => esc_html__('Banner', 'anila'),
                    'type'        => 'select',
                    'description' => __('Banner will take templates name prefix is "Banner"', 'anila'),
                    'choices'     => $this->get_block('Banner')
                ));

                $wp_customize->add_setting('anila_options_shop_banner_position', array(
                    'type'              => 'option',
                    'default'           => 'top',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('anila_options_shop_banner_position', array(
                    'section' => 'anila_woocommerce_archive',
                    'label'   => esc_html__('Banner Position', 'anila'),
                    'type'    => 'select',
                    'choices' => array(
                        'top'     => __('Top Page', 'anila'),
                        'content' => __('Before Products', 'anila'),
                    ),
                ));

            }

            $wp_customize->add_setting('anila_options_woocommerce_archive_layout', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_woocommerce_archive_layout', array(
                'section' => 'anila_woocommerce_archive',
                'label'   => esc_html__('Layout Style', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Sidebar', 'anila'),
                    'canvas'   => esc_html__('Canvas Filter', 'anila'),
                    'dropdown' => esc_html__('Dropdown Filter', 'anila'),
                    'drawing'  => esc_html__('Drawing Filter', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_woocommerce_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_woocommerce_archive_sidebar', array(
                'section' => 'anila_woocommerce_archive',
                'label'   => esc_html__('Sidebar Position', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'anila'),
                    'right' => esc_html__('Right', 'anila'),

                ),
            ));

            $wp_customize->add_setting('anila_options_woocommerce_shop_pagination', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_woocommerce_shop_pagination', array(
                'section' => 'anila_woocommerce_archive',
                'label'   => esc_html__('Products pagination', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Pagination', 'anila'),
                    'more-btn' => esc_html__('Load More', 'anila'),
                    'infinit'  => esc_html__('Infinit Scroll', 'anila'),
                ),
            ));

            // =========================================
            // Single Product
            // =========================================

            $wp_customize->add_section('anila_woocommerce_single', array(
                'title'      => esc_html__('Singular', 'anila'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            $wp_customize->add_setting('anila_options_wocommerce_single_style', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_single_style', array(
                'section' => 'anila_woocommerce_single',
                'label'   => esc_html__('Single Style', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('Default', 'anila'),
                    '2' => esc_html__('With Background', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_wocommerce_single_sidebar', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_control('anila_options_wocommerce_single_sidebar', array(
                'section' => 'anila_woocommerce_single',
                'label'   => esc_html__('Single Sidebar', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    '' => esc_html__('Hidden', 'anila'),
                    'show' => esc_html__('Show Sidebar', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_single_product_gallery_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('anila_options_single_product_gallery_layout', array(
                'section' => 'anila_woocommerce_single',
                'label'   => esc_html__('Gallery Style', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'horizontal'     => esc_html__('Bottom Thumbnail', 'anila'),
                    'vertical'       => esc_html__('Left Thumbnail', 'anila'),
                    'right_vertical' => esc_html__('Right Thumbnail', 'anila'),
                    'without-thumb'  => esc_html__('Without Thumbnail', 'anila'),
                    'gallery'        => esc_html__('Gallery Thumbnail', 'anila'),
                    'sticky'         => esc_html__('Sticky Content', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_single_product_tab_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('anila_options_single_product_tab_layout', array(
                'section'     => 'anila_woocommerce_single',
                'label'       => esc_html__('Content In Tabs?', 'anila'),
                'description' => esc_html__('Show content in tabs or accordion .....?', 'anila'),
                'type'        => 'select',
                'choices'     => array(
                    'default'       => esc_html__('Default Tabs', 'anila'),
                    'vertical'      => esc_html__('Vertical Tabs', 'anila'),
                    'accordion'     => esc_html__('Accordion', 'anila'),
                    'expand'        => esc_html__('Expand all', 'anila'),
                ),
            ));

            $wp_customize->add_setting(
                'anila_options_single_security_logo',
                array(
                    /* translators: %s privacy policy page name and link */
                    'type'              => 'upload',
                    'sanitize_callback' => 'wp_kses_post',
                    'capability'        => 'edit_theme_options',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'anila_options_single_security_logo',
                array(

                    'label'    => esc_html__('Security logo', 'anila'),
                    'section'  => 'anila_woocommerce_single',
                    'settings' => 'anila_options_single_security_logo',
                    'context'    => '' ,
                    'priority'   => 30,
                )
            );

            $wp_customize->add_setting(
                'anila_options_single_product_content_meta',
                array(
                    /* translators: %s privacy policy page name and link */
                    'type'              => 'option',
                    'sanitize_callback' => 'wp_kses_post',
                    'capability'        => 'edit_theme_options',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(new Anila_Customize_Control_Editor($wp_customize, 'anila_options_single_product_content_meta', array(
                'section' => 'anila_woocommerce_single',
                'label'   => esc_html__('Single extra description', 'anila'),
            )));
            
            $wp_customize->add_setting('anila_options_single_product_ask', array(
                'type'              => 'option',
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_single_product_ask', array(
                'section'     => 'anila_woocommerce_single',
                'label'       => esc_html__('Form asking question', 'anila'),
                'type'        => 'select',
                'choices'     => $this->get_cf7_forms()
            ));

            // =========================================
            // Product Item Reponsive
            // =========================================
            $wp_customize->add_setting('anila_options_wocommerce_row_laptop', array(
                'type'              => 'option',
                'default'           => 3,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_row_laptop', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row Laptop', 'anila'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('anila_options_wocommerce_row_tablet', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_row_tablet', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row tablet', 'anila'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('anila_options_wocommerce_row_mobile', array(
                'type'              => 'option',
                'default'           => 1,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_row_mobile', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row mobile', 'anila'),
                'type'    => 'number',
            ));

            // =========================================
            // Product Item Reponsive List View
            // =========================================
            $wp_customize->add_setting('anila_options_wocommerce_column_list_view', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_column_list_view', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row list view Laptop', 'anila'),
                'description' => esc_html__('The number of products in each row of the list view)', 'anila'),
                'type'    => 'number',
            ));

            // =========================================
            // Product
            // =========================================


            $wp_customize->add_section('anila_woocommerce_product', array(
                'title'      => esc_html__('Product Block', 'anila'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));
            $attribute_array      = [
                '' => esc_html__('None', 'anila')
            ];
            $attribute_taxonomies = wc_get_attribute_taxonomies();

            if (!empty($attribute_taxonomies)) {
                foreach ($attribute_taxonomies as $tax) {
                    if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))) {
                        $attribute_array[$tax->attribute_name] = $tax->attribute_label;
                    }
                }
            }

            $wp_customize->add_setting('anila_options_wocommerce_attribute', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('anila_options_wocommerce_attribute', array(
                'section' => 'anila_woocommerce_product',
                'label'   => esc_html__('Attributes Show', 'anila'),
                'type'    => 'select',
                'choices' => $attribute_array,
            ));

            $wp_customize->add_setting('anila_options_wocommerce_grid_list_layout', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('anila_options_wocommerce_grid_list_layout', array(
                'section' => 'anila_woocommerce_product',
                'label'   => esc_html__('Grid - List Layout', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    ''     => esc_html__('Grid', 'anila'),
                    'list' => esc_html__('List', 'anila'),
                ),
            ));

            $wp_customize->add_setting('anila_options_woocommerce_product_hover', array(
                'type'              => 'option',
                'default'           => 'none',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('anila_options_woocommerce_product_hover', array(
                'section' => 'anila_woocommerce_product',
                'label'   => esc_html__('Animation Image Hover', 'anila'),
                'type'    => 'select',
                'choices' => array(
                    'none'          => esc_html__('None', 'anila'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'anila'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'anila'),
                    'right-to-left' => esc_html__('Right to Left', 'anila'),
                    'left-to-right' => esc_html__('Left to Right', 'anila'),
                    'swap'          => esc_html__('Swap', 'anila'),
                    'fade'          => esc_html__('Fade', 'anila'),
                    'zoom-in'       => esc_html__('Zoom In', 'anila'),
                    'zoom-out'      => esc_html__('Zoom Out', 'anila'),
                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_anila_service($wp_customize) {

            $wp_customize->add_panel('anila_service', array(
                'title' => esc_html__('Service', 'anila'),
            ));
            
            $wp_customize->add_section('anila_service_settings', array(
                'title'      => esc_html__('Settings', 'anila'),
                'panel'      => 'anila_service',
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting(
                'anila_options_service_slug',
                array(
                    'default'    => anila_get_theme_option('service_slug', ''),
                    'type'       => 'option',
                    'sanitize_callback' => 'sanitize_title'
                    // 'capability' => 'manage_options',
                )
            );
    
            $wp_customize->add_control(
                'anila_options_service_slug',
                array(
                    'label'   => __( 'Service Slug', 'anila' ),
                    'section' => 'anila_service_settings',
                    /* translators: %s: Admin Url */
                    'description' => sprintf(__('After change the slug, If error 404 appears, please update <a target="_blank" href="%s">the permalinks</a> in the Settings page', 'anila'), esc_url(admin_url('options-permalink.php'))),
                )
            );
            
            $wp_customize->add_setting(
                'anila_options_service_label',
                array(
                    'default'    => anila_get_theme_option('service_label', ''),
                    'type'       => 'option',
                    'sanitize_callback' => 'sanitize_text_field'
                    // 'capability' => 'manage_options',
                )
            );
    
            $wp_customize->add_control(
                'anila_options_service_label',
                array(
                    'label'   => __( 'Service Label', 'anila' ),
                    'section' => 'anila_service_settings',
                )
            );
        }
        
        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_anila_coach($wp_customize) {

            $wp_customize->add_panel('anila_coach', array(
                'title' => esc_html__('Coach', 'anila'),
            ));

            $wp_customize->add_section('anila_coach_settings', array(
                'title'      => esc_html__('Settings', 'anila'),
                'panel'      => 'anila_coach',
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting(
                'anila_options_coach_slug',
                array(
                    'default'    => anila_get_theme_option('coach_slug', ''),
                    'type'       => 'option',
                    'sanitize_callback' => 'sanitize_title'
                    // 'capability' => 'manage_options',
                )
            );
    
            $wp_customize->add_control(
                'anila_options_coach_slug',
                array(
                    'label'   => __( 'Coach Slug', 'anila' ),
                    'section' => 'anila_coach_settings',
                    /* translators: %s: Admin Url */
                    'description' => sprintf(__('After change the slug, If error 404 appears, please update <a target="_blank" href="%s">the permalinks</a> in the Settings page', 'anila'), esc_url(admin_url('options-permalink.php'))),
                )
            );
            
            $wp_customize->add_setting(
                'anila_options_coach_label',
                array(
                    'default'    => anila_get_theme_option('coach_label', ''),
                    'type'       => 'option',
                    'sanitize_callback' => 'sanitize_text_field'
                    // 'capability' => 'manage_options',
                )
            );
    
            $wp_customize->add_control(
                'anila_options_coach_label',
                array(
                    'label'   => __( 'Coach Label', 'anila' ),
                    'section' => 'anila_coach_settings',
                )
            );

            if (anila_is_elementor_activated()) {
                $wp_customize->add_section('anila_coach_single', array(
                    'title'      => esc_html__('Single Coach', 'anila'),
                    'panel'      => 'anila_coach',
                    'capability' => 'edit_theme_options',
                ));

                $wp_customize->add_setting('anila_options_coach_bottom_template', array(
                    'type'              => 'option',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('anila_options_coach_bottom_template', array(
                    'section'     => 'anila_coach_single',
                    'label'       => esc_html__('Choose Block', 'anila'),
                    'type'        => 'select',
                    'description' => __('Block will take templates name prefix is "Coach"', 'anila'),
                    'choices'     => $this->get_block('Coach'),
                ));
            }
            
        }
    }
}
return new Anila_Customize();

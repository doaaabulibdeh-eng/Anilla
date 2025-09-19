<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Anila_CMB2_Options_Admin')) :

    /**
     * Custom Admin Field By CMB2
     */
    class Anila_CMB2_Options_Admin {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'cmb2_init', [$this, 'cmb2_add_coach_metabox'] );
            add_action( 'cmb2_init', [$this, 'cmb2_add_event_metabox'] );
        }

        public function cmb2_add_coach_metabox() {

            $objs = apply_filters('anila_meta_apply_for_coach', ['coach']);

            $cmb = new_cmb2_box( array(
                'id'           => 'coach_meta',
                'title'        => __( 'Coach Meta', 'anila' ),
                'object_types' => $objs,
                'context'      => 'normal',
                'priority'     => 'high',
            ) );

            do_action('anila_before_coach_meta', $cmb);

            $cmb->add_field( array(
                'name' => __( 'Job', 'anila' ),
                'id' => 'coach_job',
                'type' => 'text',
            ) );

            $cmb->add_field( array(
                'name' => __( 'Phone number', 'anila' ),
                'id' => 'coach_phone',
                'type' => 'text',
            ) );

            $cmb->add_field( array(
                'name' => __( 'Email', 'anila' ),
                'id' => 'coach_email',
                'type' => 'text_email',
            ) );

            $group_field_id = $cmb->add_field( array(
                'id'          => 'coach_socials_group',
                'type'        => 'group',
                'repeatable'  => false,
                'options'     => array(
                    'closed'         => false,
                    'group_title' => __('Coach socials', 'anila')
                ),
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'Facebook', 'anila' ),
                'id'   => 'coach_fb',
                'type' => 'text_url',
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'X', 'anila' ),
                'id'   => 'coach_x',
                'type' => 'text_url',
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'Instagram', 'anila' ),
                'id'   => 'coach_ig',
                'type' => 'text_url',
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'LinkedIn', 'anila' ),
                'id'   => 'coach_in',
                'type' => 'text_url',
            ) );

            do_action('anila_coach_socials', $group_field_id, $cmb);

            $cmb->add_field( array(
                'name' => __( 'Award', 'anila' ),
                'id' => 'coach_award',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => true, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                    'tabindex' => '',
                    'editor_css' => '',
                    'editor_class' => '',
                    'teeny' => false,
                    'dfw' => false,
                    'tinymce' => true,
                    'quicktags' => true
                ),
            ) );

            $cmb->add_field( array(
                'name' => __('Professional Skills', 'anila'),
                'id'   => 'coach_professional_title',
                'type' => 'title',
            ) );

            $cmb->add_field( array(
                'name' => 'Professional Skills Description',
                'id' => 'coach_description',
                'type' => 'textarea_small'
            ) );

            $group_field_id = $cmb->add_field( array(
                'id'          => 'coach_skills_group',
                'type'        => 'group',
                // 'repeatable'  => false, // use false if you want non-repeatable group
                'options'     => array(
                    'group_title'       => __( 'Skill {#}', 'anila' ),
                    'add_button'        => __( 'Add Another Skill', 'anila' ),
                    'remove_button'     => __( 'Remove Skill', 'anila' ),
                    'sortable'          => true,
                    'closed'         => false,
                ),
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => 'Skill Title',
                'id'   => 'title',
                'type' => 'text_small',
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => 'Skill Level',
                'id'   => 'level',
                'type' => 'text_small',
                'attributes' => array(
                    'type' => 'number',
                    'pattern' => '\d*',
                    'min' => 0,
                    'max' => 100,
                ),
                'sanitization_cb' => 'absint',
                'escape_cb'       => 'absint',
            ) );
            
            do_action('anila_coach_skills_group', $group_field_id, $cmb);

            do_action('anila_after_coach_meta', $cmb);
        }

        public function cmb2_add_event_metabox() {

            $objs = apply_filters('anila_meta_apply_for_event', ['event']);

            $cmb = new_cmb2_box( array(
                'id'           => 'event_meta',
                'title'        => __( 'Event Detail', 'anila' ),
                'object_types' => $objs,
                'context'      => 'normal',
                'priority'     => 'high',
            ) );

            do_action('anila_before_event_meta', $cmb);

            $cmb->add_field( array(
                'name' => __( 'Time start', 'anila' ),
                'id' => 'event_time_start',
                'type' => 'text_datetime_timestamp',
                'attributes' => array(
                    'required' => true
                )
            ) );
            
            $cmb->add_field( array(
                'name' => __( 'Time end', 'anila' ),
                'id' => 'event_time_end',
                'type' => 'text_datetime_timestamp',
                'attributes' => array(
                    'required' => true
                )
            ) );

            $cmb->add_field( array(
                'name'    => __( 'Participation fee', 'anila' ),
                'id'      => 'event_fee',
                'type'    => 'text_medium'
            ) );

            $group_field_id = $cmb->add_field( array(
                'id'          => 'event_contact_group',
                'type'        => 'group',
                'repeatable'  => false,
                'options'     => array(
                    'closed'         => false,
                    'group_title' => __('Contact', 'anila')
                ),
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'Phone number', 'anila' ),
                'id' => 'event_phone',
                'type' => 'text',
                'attributes' => array(
                    'required' => true
                )
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'Email', 'anila' ),
                'id' => 'event_email',
                'type' => 'text_email',
                'attributes' => array(
                    'required' => true
                )
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __('Address', 'anila'),
                'id' => 'event_address',
                'type' => 'textarea_small',
                'attributes' => array(
                    'required' => true
                )
            ) );
            $cmb->add_group_field( $group_field_id, array(
                'name' => __( 'Link Google Map', 'anila' ),
                'id'   => 'event_link_map',
                'type' => 'text_url',
            ) );

            do_action('anila_event_socials', $group_field_id, $cmb);

            do_action('anila_after_event_meta', $cmb);
        }

    }

endif;

return new Anila_CMB2_Options_Admin();
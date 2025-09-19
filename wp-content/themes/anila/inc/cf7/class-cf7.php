<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Anila_CF7')) :

    /**
     * The CF7 Anila class
     */
    class Anila_CF7 {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {

            add_action( 'wpcf7_init', [$this, 'wpcf7_add_form_tag_time'], 10, 0 );
            add_action( 'wpcf7_swv_create_schema', [$this, 'wpcf7_swv_add_time_rules'], 10, 2 );
            add_action( 'wpcf7_admin_init', [$this, 'wpcf7_add_tag_generator_time'], 19, 0 );

            add_filter( 'wpcf7_messages', [$this, 'wpcf7_time_messages'], 10, 1 );

        }

        /**
         * Add Time Tag
         */
        public function wpcf7_add_form_tag_time() {
            wpcf7_add_form_tag( array( 'time', 'time*' ),
                [$this, 'wpcf7_time_form_tag_handler'],
                array(
                    'name-attr' => true,
                )
            );
        }

        public function wpcf7_time_form_tag_handler( $tag ) {
            if ( empty( $tag->name ) ) {
                return '';
            }
        
            $validation_error = wpcf7_get_validation_error( $tag->name );
        
            $class = wpcf7_form_controls_class( $tag->type );
        
            $class .= ' wpcf7-validates-as-time';
        
            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }
        
            $atts = array();
        
            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();
            $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
            $atts['min'] = $tag->get_date_option( 'min' );
            $atts['max'] = $tag->get_date_option( 'max' );
            $atts['readonly'] = $tag->has_option( 'readonly' );
        
            $atts['autocomplete'] = false;
        
            if ( $tag->is_required() ) {
                $atts['aria-required'] = 'true';
            }
        
            if ( $validation_error ) {
                $atts['aria-invalid'] = 'true';
                $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
                    $tag->name
                );
            } else {
                $atts['aria-invalid'] = 'false';
            }
        
            $value = (string) reset( $tag->values );
        
            $value = $tag->get_default_option( $value );
        
            $value = wpcf7_get_hangover( $tag->name, $value );
        
            $atts['value'] = $value;
            $atts['type'] = $tag->basetype;
            $atts['name'] = $tag->name;
        
            $html = sprintf(
                '<span class="wpcf7-form-control-wrap" data-name="%1$s"><input %2$s />%3$s</span>',
                esc_attr( $tag->name ),
                wpcf7_format_atts( $atts ),
                $validation_error
            );
        
            return $html;
        }
        
        public function wpcf7_swv_add_time_rules( $schema, $contact_form ) {
            $tags = $contact_form->scan_form_tags( array(
                'basetype' => array( 'time' ),
            ) );
        
            foreach ( $tags as $tag ) {
                if ( $tag->is_required() ) {
                    $schema->add_rule(
                        wpcf7_swv_create_rule( 'required', array(
                            'field' => $tag->name,
                            'error' => wpcf7_get_message( 'invalid_required' ),
                        ) )
                    );
                }
        
                $schema->add_rule(
                    wpcf7_swv_create_rule( 'time', array(
                        'field' => $tag->name,
                        'error' => wpcf7_get_message( 'invalid_time' ),
                    ) )
                );
            }
        }

        public function wpcf7_time_messages( $messages ) {
            return array_merge( $messages, array(
                'invalid_time' => array(
                    'description' => __( "Date format that the sender entered is invalid", 'anila' ),
                    'default' => __( "Please enter a date in YYYY-MM-DD format.", 'anila' ),
                ),
            ) );
        }

        public function wpcf7_add_tag_generator_time() {
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->add( 'time', __( 'time', 'anila' ),
                [$this, 'wpcf7_tag_generator_time'], ['version' => '2'] );
        }

        public function wpcf7_tag_generator_time( $contact_form, $args = '' ) {
            $args = wp_parse_args( $args, array() );
            $type = 'time';
        
            $description = __( "Generate a form-tag for a time input field", 'anila' );
        
            ?>
            <div class="control-box">
                <fieldset>
                    <legend><?php echo sprintf( esc_html( $description ) ); ?></legend>
                    
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo esc_html( __( 'Field type', 'anila' ) ); ?></th>
                                <td>
                                    <fieldset>
                                    <legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'anila' ) ); ?></legend>
                                    <label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'anila' ) ); ?></label>
                                    </fieldset>
                                </td>
                            </tr>
                        
                            <tr>
                                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'anila' ) ); ?></label></th>
                                <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                            </tr>
                        
                            <tr>
                                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Default value', 'anila' ) ); ?></label></th>
                                <td><input type="time" name="values" class="oneline" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>" /><br />
                                </td>
                            </tr>
                        
                            <tr>
                                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'anila' ) ); ?></label></th>
                                <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
                            </tr>
                        
                            <tr>
                                <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'anila' ) ); ?></label></th>
                                <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
            </div>
            
            <div class="insert-box">
                <input type="text" name="<?php echo esc_attr($type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
            
                <div class="submitbox">
                    <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'anila' ) ); ?>" />
                </div>
            
                <br class="clear" />
            
            </div>
            <?php
        }
    
    }

endif;

return new Anila_CF7();
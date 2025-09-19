<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Anila_WooSW')) :

    /**
     * The CF7 Anila class
     */
    class Anila_WooSW {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {

            add_action('woosw_wishlist_item_actions_before', [$this, 'anila_woosw_wishlist_item_actions_before'], 10, 2);
            add_action('woosw_wishlist_item_actions_after', [$this, 'anila_woosw_wishlist_item_actions_after'], 10, 2);
        }


        public function anila_woosw_wishlist_item_actions_before($product, $key) {
    
            echo <<<HTML
            <div class="anila_woosw_item_wrapper">
            HTML;
            
        }
    
    
        public function anila_woosw_wishlist_item_actions_after($product, $key) {
    
            echo <<<HTML
            </div>
            HTML;
            
        }
        
        

    }        

endif;

return new Anila_WooSW();
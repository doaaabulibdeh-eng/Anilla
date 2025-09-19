
		</div><!-- .col-full -->
        <?php
		/**
		 * Functions hooked in to anila_after_container action
		 *
         * @see anila_output_related_products - 20
         * 
		 */
		do_action('anila_after_container');
		?>
	</div><!-- #content -->

	<?php
    /**
     * Functions hooked in to anila_before_footer action
     *
     * @see anila_coach_bottom_template - 10
     *
     */
    do_action( 'anila_before_footer' );
    if (anila_is_elementor_activated() && function_exists('hfe_init') && (hfe_footer_enabled() || hfe_is_before_footer_enabled())) {
        do_action('hfe_footer_before');
        do_action('hfe_footer');
    } else {
        ?>

        <footer id="colophon" class="site-footer" role="contentinfo">
            <?php
            /**
             * Functions hooked in to anila_footer action
             *
             * @see anila_footer_default - 20
             *
             *
             */
            do_action('anila_footer');

            ?>

        </footer><!-- #colophon -->

        <?php
    }

		/**
		 * Functions hooked in to anila_after_footer action
		 * @see anila_sticky_single_add_to_cart 	- 999 - woo
		 */
		do_action( 'anila_after_footer' );
	?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see anila_template_account_dropdown 	- 1
 * @see anila_mobile_nav - 1
 * @see anila_render_woocommerce_shop_canvas - 1 - woo
 */

wp_footer();
?>
</body>
</html>

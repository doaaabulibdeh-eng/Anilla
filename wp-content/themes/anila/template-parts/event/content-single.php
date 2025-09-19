<article id="event-<?php the_ID(); ?>">
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to anila_single_event_top action
         *
         */
        do_action('anila_single_event_top');

        /**
         * Functions hooked in to anila_single_event action
         * @see anila_event_header        - 10
         * @see anila_event_thumbnail     - 10
         * @see anila_post_content       - 30
         */
        do_action('anila_single_event');

        /**
         * Functions hooked in to anila_single_event_bottom action
         * @see anila_event_tags       - 10
         */
        do_action('anila_single_event_bottom');
        ?>

    </div>

</article><!-- #event-## -->

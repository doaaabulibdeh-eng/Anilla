<header id="masthead" class="site-header header-1" role="banner">
    <div class="header-container">
        <div class="container header-main">
            <div class="header-left">
                <?php
                anila_site_branding();
                if (anila_is_woocommerce_activated()) {
                    ?>
                    <div class="site-header-cart header-cart-mobile">
                        <?php anila_cart_link(); ?>
                    </div>
                    <?php
                }
                ?>
                <?php anila_mobile_nav_button(); ?>
            </div>
            <div class="header-center">
                <?php anila_primary_navigation(); ?>
            </div>
            <div class="header-right desktop-hide-down">
                <div class="header-group-action">
                    <?php
                    anila_header_account();
                    if (anila_is_woocommerce_activated()) {
                        anila_header_wishlist();
                        anila_header_cart();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header><!-- #masthead -->

<?php
// ===============================
// 1. عرض الفورم أسفل صفحة الـ Event
// ===============================
add_filter('the_content', function($content) {
    if (get_post_type() === 'event') {
        global $post;
        $event_id = $post->ID;

        // جرّب عدة مفاتيح محتملة
        $price = get_post_meta($event_id, 'participation_fee', true);
        if (!$price) {
            $price = get_post_meta($event_id, '_EventCost', true); // شائع مع The Events Calendar
        }
        if (!$price) {
            $price = get_post_meta($event_id, 'price', true);
        }
        if (!$price) {
            $price = 0;
        }

        ob_start(); ?>
        
        <form method="post" class="event-subscribe-form" style="margin:20px 0; padding:15px; border:1px solid #ddd;">
            <h3>Subscribe Now</h3>
            
            <p>
                <label>Full Name *</label><br>
                <input type="text" name="full_name" required>
            </p>
            
            <p>
                <label>Email *</label><br>
                <input type="email" name="email" required>
            </p>
            
            <p>
                <label>Phone *</label><br>
                <input type="text" name="phone" required>
            </p>
            
            <p>
                <strong>Participation Fee: <?php echo esc_html($price); ?> $</strong>
            </p>
            
            <input type="hidden" name="event_id" value="<?php echo esc_attr($event_id); ?>">
            <input type="hidden" name="event_price" value="<?php echo esc_attr($price); ?>">
            
            <button type="submit" name="event_subscribe" style="background:#0073aa; color:#fff; padding:10px 20px; border:none; cursor:pointer;">
                Proceed to Checkout
            </button>
        </form>

        <?php
        $content .= ob_get_clean();
    }
    return $content;
});

// ===============================
// 2. معالجة الفورم وإنشاء طلب WooCommerce
// ===============================
add_action('init', function() {
    if (isset($_POST['event_subscribe'])) {
        $event_id = intval($_POST['event_id']);
        $price    = floatval($_POST['event_price']);
        $name     = sanitize_text_field($_POST['full_name']);
        $email    = sanitize_email($_POST['email']);
        $phone    = sanitize_text_field($_POST['phone']);

        // إنشاء Order جديد
        $order = wc_create_order();

        // 🔹 إضافة منتج افتراضي (Virtual product) مخصص للطلب
        $product = new WC_Product_Simple();
        $product->set_name("Event Registration: " . get_the_title($event_id));
        $product->set_price($price);
        $product->set_regular_price($price);
        $product->set_virtual(true);
        $product->set_catalog_visibility('hidden'); // يخفيه من الـ Shop
        $product->save();

        // إضافة المنتج للطلب
        $order->add_product($product, 1);

        // إضافة ملاحظة داخل الطلب
        $order->add_order_note("Event Registration:\n".
            "Name: $name\n".
            "Email: $email\n".
            "Phone: $phone\n".
            "Event: " . get_the_title($event_id) . "\n".
            "Price: $price $"
        );

        // حفظ الطلب
        $order->calculate_totals();
        $order->save();

        // إعادة توجيه المستخدم لصفحة الدفع
        wp_safe_redirect($order->get_checkout_payment_url());
        exit;
    }
});







 
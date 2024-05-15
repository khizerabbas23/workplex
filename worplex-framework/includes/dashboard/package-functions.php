<?php

defined('ABSPATH') || exit;

class Worplex_Plugin_Packages_Funcs {
    
    public function __construct() {
        add_action('save_post', array($this, 'save_meta_fields'), 5);
        add_action('add_meta_boxes', array($this, 'wc_prod_metaboxes'));

        add_action('wp_ajax_worplex_member_pckgbuy_call', array($this, 'member_pckgbuy_call'));
        add_action('wp_ajax_nopriv_worplex_member_pckgbuy_call', array($this, 'member_pckgbuy_call'));

        add_action('woocommerce_checkout_order_processed', array($this, 'woocommerce_after_checkout_process'));
        add_action('woocommerce_order_status_completed', array($this, 'woocommerce_order_status_complete'));
    }

    public function wc_prod_metaboxes() {
        add_meta_box('worplex-product-attachment', esc_html__('Package Settings', 'worplex-frame'), array($this, 'prod_package_meta'), 'product', 'normal', 'high');
    }

    public function prod_package_meta() {
        global $post;
        $prod_with_pkg = get_post_meta($post->ID, 'worplex_field_prod_attachwith_pkg', true);
        $prod_pkg_type = get_post_meta($post->ID, 'worplex_field_prod_pkgtype', true);
        $num_of_jobs = get_post_meta($post->ID, 'worplex_field_numof_jobs', true);
        $num_of_applics = get_post_meta($post->ID, 'worplex_field_numof_applics', true);
        ?>
        <div class="worplex-post-layout">
            <div class="worplex-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Attach Product with Package?', 'worplex-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="worplex_field_prod_attachwith_pkg">
                        <option value="no"<?php echo ($prod_with_pkg == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'worplex-frame') ?></option>
                        <option value="yes"<?php echo ($prod_with_pkg == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'worplex-frame') ?></option>
                    </select>
                </div>
            </div>
            <div class="worplex-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Package Type', 'worplex-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="worplex_field_prod_pkgtype">
                        <option value="emp_jobs"<?php echo ($prod_pkg_type == 'emp_jobs' ? ' selected' : '') ?>><?php esc_html_e('Employer Jobs', 'worplex-frame') ?></option>
                        <option value="cand_applics"<?php echo ($prod_pkg_type == 'cand_applics' ? ' selected' : '') ?>><?php esc_html_e('Candidate (Job Applications)', 'worplex-frame') ?></option>
                    </select>
                </div>
            </div>
            <div class="pkg-elementry-fields pkg-emp_jobs-field"<?php echo ($prod_pkg_type == 'cand_applics' ? ' style="display: none;"' : '') ?>>
                <div class="worplex-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Number of Jobs', 'worplex-frame') ?></label>
                    </div>
                    <div class="elem-field">
                        <input type="number" name="worplex_field_numof_jobs" min="1" value="<?php echo ($num_of_jobs) ?>">
                    </div>
                </div>
            </div>
            <div class="pkg-elementry-fields pkg-cand_applics-field"<?php echo ($prod_pkg_type == 'cand_applics' ? '' : ' style="display: none;"') ?>>
                <div class="worplex-element-field">
                    <div class="elem-label">
                        <label><?php esc_html_e('Number of Applications', 'worplex-frame') ?></label>
                    </div>
                    <div class="elem-field">
                        <input type="number" name="worplex_field_numof_applics" min="1" value="<?php echo ($num_of_applics) ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php
        add_action('admin_footer', function() {
            ?>
            <script>
                jQuery('select[name="worplex_field_prod_pkgtype"]').on('change', function() {
                    var this_f = jQuery(this);
                    var this_val = this_f.val();
                    jQuery('.pkg-elementry-fields').hide();
                    jQuery('.pkg-' + this_val + '-field').removeAttr('style');
                });
            </script>
            <?php
        }, 35);
    }

    public function save_meta_fields($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (get_post_type($post_id) == 'product') {
            if (isset($_POST['worplex_field_prod_attachwith_pkg']) && $_POST['worplex_field_prod_attachwith_pkg'] == 'yes') {
                $_product = wc_get_product($post_id);
                if ($_product) {
                    update_post_meta($post_id, '_manage_stock', 'no');
                    update_post_meta($post_id, '_virtual', 'yes');
                    update_post_meta($post_id, '_downloadable', 'no');

                    //
                    $_product->set_catalog_visibility('hidden');
                    $_product->save();
                }
            }
        }
    }

    public function member_pckgbuy_call() {
        global $current_user;

        if (is_user_logged_in()) {

            if (!class_exists('WooCommerce')) {
                $ret_data = array('error' => '1', 'msg' => esc_html__('WooCommerce Plugin not installed/activate.', 'worplex-frame'));
                wp_send_json($ret_data);
            }

            $product_id = $_POST['pkg_id'];
            if (get_post_type($product_id) != 'product') {
                $ret_data = array('error' => '2', 'msg' => esc_html__('No product found for this package.', 'worplex-frame'));
                wp_send_json($ret_data);
            }
            $prod_with_pkg = get_post_meta($product_id, 'worplex_field_prod_attachwith_pkg', true);
            $prod_pkg_type = get_post_meta($product_id, 'worplex_field_prod_pkgtype', true);
            if ($prod_with_pkg != 'yes') {
                $ret_data = array('error' => '2', 'msg' => esc_html__('No product found for this package.', 'worplex-frame'));
                wp_send_json($ret_data);
            }

            $user_id = $current_user->ID;
            $candidate_id = worplex_user_candidate_id($user_id);
            $employer_id = worplex_user_employer_id($user_id);

            if ($prod_pkg_type == 'cand_applics') {
                if (!$candidate_id) {
                    $ret_data = array('error' => '2', 'msg' => esc_html__('Only a candidate member can buy this package.', 'worplex-frame'));
                    wp_send_json($ret_data);
                }
            } else {
                if (!$employer_id) {
                    $ret_data = array('error' => '2', 'msg' => esc_html__('Only an employer member can buy this package.', 'worplex-frame'));
                    wp_send_json($ret_data);
                }
            }

            $checkout_url = self::prod_payment_checkout($product_id, 'checkout_url');
            $ret_data = array('error' => '0', 'msg' => esc_html__('Package added to cart successfully.', 'worplex-frame'), 'redirect' => $checkout_url);
            wp_send_json($ret_data);

        } else {
            $ret_data = array('error' => '2', 'msg' => esc_html__('Only a logged in member can buy this package.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
    }

    public static function prod_payment_checkout($product_id, $return_type = 'redirect', $all_clear = true) {

        global $woocommerce;

        //
        if (WC()->cart->get_cart_contents_count() > 0 && $all_clear !== false) {
            WC()->cart->empty_cart();
        }
        $woocommerce->cart->add_to_cart($product_id);
        if ($return_type != 'no_where') {
            if ($return_type == 'checkout_url') {
                return wc_get_checkout_url();
            } else {
                wp_safe_redirect(wc_get_checkout_url());
                exit();
            }
        }
    }

    public function woocommerce_after_checkout_process($order_id) {
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();

            foreach (WC()->cart->get_cart() as $cart_item) {
                //var_dump($cart_item);
                $product_id = isset($cart_item['product_id']) ? $cart_item['product_id'] : '';

                $prod_with_pkg = get_post_meta($product_id, 'worplex_field_prod_attachwith_pkg', true);

                if ($prod_with_pkg == 'yes') {

                    $prod_pkg_name = get_the_title($product_id);

                    $prod_pkg_type = get_post_meta($product_id, 'worplex_field_prod_pkgtype', true);
                    update_post_meta($order_id, 'order_attach_with_pkg', 'yes');
                    update_post_meta($order_id, 'order_pkg_type', $prod_pkg_type);
                    update_post_meta($order_id, 'order_pkg_name', $prod_pkg_name);
                    update_post_meta($order_id, 'order_user_id', $user_id);

                    // job pakage fields
                    if ($prod_pkg_type == 'emp_jobs') {
                        $total_num_jobs = get_post_meta($product_id, 'worplex_field_numof_jobs', true);
                        update_post_meta($order_id, 'order_numof_jobs', $total_num_jobs);
                    }

                    // candidate pakage fields
                    if ($prod_pkg_type == 'cand_applics') {
                        $total_num_applics = get_post_meta($product_id, 'worplex_field_numof_applics', true);
                        update_post_meta($order_id, 'order_numof_applics', $total_num_applics);
                    }
                }
            }
        }
    }

    public function woocommerce_order_status_complete($order_id) {

        $order_type = get_post_meta($order_id, 'order_pkg_type', true);

        if ($order_type == 'cand_applics') {
            update_post_meta($order_id, 'order_cand_application_ids', '');
        } else {
            update_post_meta($order_id, 'order_employer_job_ids', '');
        }
    }
}

new Worplex_Plugin_Packages_Funcs;

// job package functions

function worplex_employer_jobs_pkg_used_credits($order_id) {
    $used_credits_num = 0;
    $used_credits = get_post_meta($order_id, 'order_employer_job_ids', true);
    if ($used_credits != '') {
        $used_credits_arr = explode(',', $used_credits);
        $used_credits_num = !empty($used_credits_arr) ? sizeof($used_credits_arr) : 0;
    }

    return absint($used_credits_num);
}

function worplex_employer_jobs_pkg_remainin_credits($order_id) {
    $total_credits = get_post_meta($order_id, 'order_numof_jobs', true);

    $used_credits = worplex_employer_jobs_pkg_used_credits($order_id);

    $remaining_credits = 0;
    if ($total_credits > $used_credits) {
        $remaining_credits = $total_credits - $used_credits;
    }

    return absint($remaining_credits);
}

function worplex_employer_jobs_pkg_expired($order_id) {
    $remainin_credits = worplex_employer_jobs_pkg_remainin_credits($order_id);
    if ($remainin_credits <= 0) {
        return true;
    }
}

// candidate applications package functions

function worplex_candidate_applics_pkg_used_credits($order_id) {
    $used_credits_num = 0;
    $used_credits = get_post_meta($order_id, 'order_cand_application_ids', true);
    if ($used_credits != '') {
        $used_credits_arr = explode(',', $used_credits);
        $used_credits_num = !empty($used_credits_arr) ? sizeof($used_credits_arr) : 0;
    }

    return absint($used_credits_num);
}

function worplex_candidate_applics_pkg_remainin_credits($order_id) {
    $total_credits = get_post_meta($order_id, 'order_numof_applics', true);

    $used_credits = worplex_candidate_applics_pkg_used_credits($order_id);

    $remaining_credits = 0;
    if ($total_credits > $used_credits) {
        $remaining_credits = $total_credits - $used_credits;
    }

    return absint($remaining_credits);
}

function worplex_candidate_applics_pkg_expired($order_id) {
    $remainin_credits = worplex_candidate_applics_pkg_remainin_credits($order_id);
    if ($remainin_credits <= 0) {
        return true;
    }
}










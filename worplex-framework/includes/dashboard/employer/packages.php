<?php

add_filter('worplex_dashboard_employer_packages_html', 'worplex_dashboard_employer_packages_html');

function worplex_dashboard_employer_packages_html() {
    global $current_user;
    $user_id = $current_user->ID;
    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="mb-4 tbl-lg rounded overflow-hidden">
                    <div class="table-responsive bg-white">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID.</th>
                                    <th scope="col">Package Title</th>
                                    <th scope="col">Total Jobs</th>
                                    <th scope="col">Used</th>
                                    <th scope="col">Remain</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <?php
                            $args = array(
                                'post_type' => 'shop_order',
                                'posts_per_page' => '50',
                                'post_status' => array('wc-completed'),
                                'order' => 'DESC',
                                'orderby' => 'ID',
                                'meta_query' => array(
                                    array(
                                        'key' => 'order_attach_with_pkg',
                                        'value' => 'yes',
                                        'compare' => '=',
                                    ),
                                    array(
                                        'key' => 'order_user_id',
                                        'value' => $user_id,
                                        'compare' => '=',
                                    ),
                                ),
                            );
                            $posts_query = new WP_Query($args);
                            ?>
                            <tbody>
                                <?php
                                if ($posts_query->have_posts()) {
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                        $order_id = get_the_id();
                                        $trans_order_name = get_post_meta($order_id, 'order_pkg_name', true);

                                        $trans_order_obj = wc_get_order($order_id);

                                        if ($trans_order_name == '') {
                                            foreach ($trans_order_obj->get_items() as $oitem_id => $oitem_product) {
                                                //Get the WC_Product object
                                                $oproduct = $oitem_product->get_product();

                                                if (is_object($oproduct)) {
                                                    $trans_order_name = get_the_title($oproduct->get_ID());
                                                }
                                            }
                                        }

                                        $order_date_obj = $trans_order_obj->get_date_created();
                                        $order_date_array = json_decode(json_encode($order_date_obj), true);
                                        $order_date = isset($order_date_array['date']) ? date_i18n(get_option('date_format'), strtotime($order_date_array['date'])) : '';
                                        
                                        $total_credits = get_post_meta($order_id, 'order_numof_jobs', true);
                                        $used_credits = worplex_employer_jobs_pkg_used_credits($order_id);
                                        $remainin_credits = worplex_employer_jobs_pkg_remainin_credits($order_id);

                                        $pkg_expired = worplex_employer_jobs_pkg_expired($order_id);
                                        $pkg_status = esc_html__('Active', 'worplex_frame');
                                        $status_class = 'theme-cl';
                                        if ($pkg_expired) {
                                            $pkg_status = esc_html__('Expired', 'worplex_frame');
                                            $status_class = 'text-danger';
                                        }
                                        ?>
                                        <tr>
                                            <td><span><?php echo ($order_id) ?></span></td>
                                            <td><a href="javascript:void(0);" class="theme-cl"><?php echo ($trans_order_name) ?></a></td>
                                            <td><?php echo ($total_credits) ?></td>
                                            <td><?php echo ($used_credits) ?></td>
                                            <td><?php echo ($remainin_credits) ?></td>
                                            <td><?php echo ($order_date) ?></td>
                                            <td><span class="<?php echo ($status_class) ?>"><?php echo ($pkg_status) ?></span></td>
                                        </tr>
                                        <?php
                                        endwhile;
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">No package found.</td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}

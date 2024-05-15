<?php

add_filter('worplex_dashboard_employer_manage_jobs_html', 'worplex_dashboard_employer_manage_jobs_html');

function worplex_dashboard_employer_manage_jobs_html() {
    global $current_user, $worplex_framework_options;
    $user_id = $current_user->ID;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }
    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="mb-4 tbl-lg rounded overflow-hidden">
                    <div class="table-responsive bg-white worplex-mangjobs-con" style="position: relative;">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Filled</th>
                                    <th scope="col">Posted Date</th>
                                    <th scope="col">Application Deadline</th>
                                    <th scope="col">Applications</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <?php
                            $args = array(
                                'post_type' => 'jobs',
                                'posts_per_page' => '50',
                                'post_status' => 'publish',
                                'author' => $user_id,
                                'order' => 'DESC',
                                'orderby' => 'ID',
                            );
                            $posts_query = new WP_Query($args);
                            ?>
                            <tbody>
                                <?php
                                if ($posts_query->have_posts()) {
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                        $job_id = get_the_id();
                                        $job_obj = get_post($job_id);
                                        $job_post_date = $job_obj->post_date;

                                        $application_deadline = get_post_meta($job_id, 'worplex_field_job_deadline', true);
                                        ?>
                                        <tr>
                                            <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm"><?php echo get_the_title($job_id) ?><span style="display: none;" class="medium theme-cl rounded text-success bg-light-success ms-1 py-1 px-2">Pending</span></h4></div></td>
                                            <td><div class="dash-filled"><span class="p-2 circle gray d-inline-flex align-items-center justify-content-center"><i class="lni lni-minus"></i></span></div></td>
                                            <td><?php echo date_i18n(get_option('date_format'), strtotime($job_post_date)) ?></td>
                                            <?php
                                            if ($application_deadline != '') {
                                                ?>
                                                <td><?php echo date_i18n(get_option('date_format'), strtotime($application_deadline)) ?></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td><span class="gray rounded px-3 py-2 ft-medium">----</span></td>
                                                <?php
                                            }
                                            ?>
                                            <td><a href="" class="gray rounded px-3 py-2 ft-medium">----</a></td>
                                            <td>
                                                <div class="dash-action">
                                                    <a href="<?php echo get_permalink($job_id) ?>" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                                    <a href="<?php echo add_query_arg(array('account_tab' => 'post-job', 'id' => $job_id, 'action' => 'update'), $account_page_url) ?>" class="p-2 circle text-success bg-light-success d-inline-flex align-items-center justify-content-center"><i class="lni lni-pencil"></i></a>
                                                    <a href="javascript:void(0);" data-id="<?php echo ($job_id) ?>" class="worplex-mangjob-delbtn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    endwhile;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No job found.</td>
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

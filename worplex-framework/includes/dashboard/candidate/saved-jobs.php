<?php

add_filter('worplex_dashboard_candidate_saved_jobs_html', 'worplex_dashboard_candidate_saved_jobs_html');

function worplex_dashboard_candidate_saved_jobs_html() {
    ob_start();
    ?>

    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <?php
            global $current_user;
            $user_id = $current_user->ID;
            $faver_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
            if (!empty($faver_jobs)) {
                ?>
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="cl-justify">

                        <div class="cl-justify-first">
                            <p class="m-0 p-0 ft-sm">You have saved <span class="text-dark ft-medium" id="totalFavoritesCount"><?php echo count($faver_jobs) ?></span> jobs</p>
                        </div>

                        <div class="cl-justify-last">
                            <div class="d-flex align-items-center justify-content-left">
                            <div class="dlc-list">
                                <form id="jobForm">
                                    <select class="form-control sm rounded" name="sortby" onchange="submitForm()">
                                    <option value="">All Jobs</option>
                                    <option value="asc">Sort By Name</option>
                                    <option value="recent">Recent jobs</option>
                                    </select>
                                    <input type="hidden" name="account_tab" value="saved-jobs">
                                </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="mb-4 tbl-lg rounded overflow-hidden">
                        <div class="table-responsive bg-white">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Job Title</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sort_key = isset($_GET['sortby']) ? $_GET['sortby'] : '';

                                    if ($sort_key == 'asc') {
                                        $favjobs_with_titles = $new_fav_jobs = [];
                                        foreach ($faver_jobs as $candidateId) {
                                            $favjobs_with_titles[$candidateId] = get_the_title($candidateId);
                                        }
                                        asort($favjobs_with_titles);
                                        foreach ($favjobs_with_titles as $fav_id => $fav_title) {
                                            $new_fav_jobs[] = $fav_id;
                                        }
                                        $faver_jobs = $new_fav_jobs;
                                    } else {
                                        rsort($faver_jobs);
                                    }
                                    foreach ($faver_jobs as $candidateId) {
                                        $time_tag = get_post_meta($candidateId, 'worplex_field_time_tag', true);
                                        $experiance = get_post_meta($candidateId, 'worplex_field_experiance', true);
                                        $location = get_post_meta($candidateId, 'worplex_field_location', true);
                                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($candidateId), '96');
                                        $postid = $candidateId; // Use candidateId as the post ID
                                        
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="worplex-post-item cats-box rounded bg-white d-flex align-items-center">
                                                    <div class="text-center"><img src="<?php echo $image[0] ?>" class="img-fluid" width="55" alt=""></div>
                                                    <div class="cats-box-caption px-2">
                                                        <h4 class="fs-md mb-0 ft-medium"><?php echo get_the_title($candidateId); ?> (<?php echo $experiance ?> Exp.)</h4>
                                                        <div class="d-block mb-2 position-relative">
                                                            <span class="text-muted medium"><i class="lni lni-map-marker me-1"></i><?php echo  $location ?></span>
                                                            <span class="muted medium ms-2 theme-cl"><i class="lni lni-briefcase me-1"></i><?php echo $time_tag ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="text-info">Active</span></td>
                                            <td>10 Sep 2021</td>
                                            <td>
                                                <div class="dash-action">
                                                    <a class="worplex-delete-post-btn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1" data-id="<?php echo $postid ?>"><i class="lni lni-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="col-xl-12 col-lg-12 col-md-12">';
                echo '<div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3"><p>' . esc_html__('No results found.', 'worplex-frame') . '</p></div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('.worplex-delete-post-btn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('id');
                var button = $(this);

                // Perform an AJAX request to unlike the post
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'unlike_post',
                        post_id: postId,
                    },
                    success: function(response) {
                        // Assuming the unlike operation is successful, remove the table row from the DOM
                        button.closest('tr').remove();
                    },
                });
            });
        });
    </script>

    <?php
    $html = ob_get_clean();
    return $html;
}

// Add AJAX handler to unlike the post
add_action('wp_ajax_unlike_post', 'unlike_post_ajax_callback');
add_action('wp_ajax_nopriv_unlike_post', 'unlike_post_ajax_callback');
function unlike_post_ajax_callback() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        global $current_user;
        $user_id = $current_user->ID;
        
        // Remove the post from the user's favorite list
        $faver_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
        if (($key = array_search($post_id, $faver_jobs)) !== false) {
            unset($faver_jobs[$key]);
        }
        update_user_meta($user_id, 'fav_jobs_list', $faver_jobs);
    }
    wp_die();
}

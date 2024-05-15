<?php

add_filter('worplex_dashboard_candidate_change_password_html', 'worplex_dashboard_change_password_html');
add_filter('worplex_dashboard_employer_change_password_html', 'worplex_dashboard_change_password_html');
add_filter('worplex_dashboard_change_password_html', 'worplex_dashboard_change_password_html');

function worplex_dashboard_change_password_html() {
    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="_dashboard_content bg-white rounded mb-4">
                    <div class="_dashboard_content_header br-bottom py-3 px-3">
                        <div class="_dashboard__header_flex">
                            <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fa worplex-faicon-lock me-1 theme-cl fs-sm"></i>Change Password</h4>	
                        </div>
                    </div>
                    
                    <div class="_dashboard_content_body py-3 px-3">
                        <form method="post" class="worplex-dashb-form">
                            <div class="row">
                                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="text-dark ft-medium">Old Password</label>
                                        <input type="password" name="old_pass" class="form-control rounded" required placeholder="password">
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="text-dark ft-medium">New Password</label>
                                        <input type="password" name="new_pass" class="form-control rounded" required placeholder="password">
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="text-dark ft-medium">Confirm Password</label>
                                        <input type="password" name="conf_pass" class="form-control rounded" required placeholder="password">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="hidden" name="action" value="worplex_user_dashb_change_pass_call">
                                        <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}

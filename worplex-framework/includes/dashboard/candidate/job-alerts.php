<?php

add_filter('worplex_dashboard_candidate_job_alerts_html', 'worplex_dashboard_candidate_job_alerts_html');

function worplex_dashboard_candidate_job_alerts_html() {
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
                                <th scope="col">Title</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Posted Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm">Senior Web Developer</h4><div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>San Francisco</span></div></div></td>
                                <td>Manager</td>
                                <td>10 Jun 2023</td>
                                <td>
                                    <div class="dash-action">
                                        <a href="javascript:void(0);" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                        <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm">Experienced UI/UX Product Designer</h4><div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>Denver, USA</span></div></div></td>
                                <td>Team Leader</td>
                                <td>18 Jun 2023</td>
                                <td>
                                    <div class="dash-action">
                                        <a href="javascript:void(0);" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                        <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm">WordPress Developer &amp; Database Management System</h4><div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>Melbourn</span></div></div></td>
                                <td>Manager</td>
                                <td>21 Jun 2023</td>
                                <td>
                                    <div class="dash-action">
                                        <a href="javascript:void(0);" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                        <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm">Senior Web Developer</h4><div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>Liverpool</span></div></div></td>
                                <td>Human Resource</td>
                                <td>10 Jul 2023</td>
                                <td>
                                    <div class="dash-action">
                                        <a href="javascript:void(0);" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                        <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="dash-title"><h4 class="mb-0 ft-medium fs-sm">Experienced UI/UX Product Designer</h4><div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>Liverpool</span></div></div></td>
                                <td>Sr, Human Resource</td>
                                <td>15 Jul 2023</td>
                                <td>
                                    <div class="dash-action">
                                        <a href="javascript:void(0);" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                        <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
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
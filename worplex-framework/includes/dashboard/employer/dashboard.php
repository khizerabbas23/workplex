<?php

function worplex_dashb_employer_dashboard() {
    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="dash-widgets py-5 px-4 bg-success rounded">
                    <h2 class="ft-medium mb-1 fs-xl text-light">46</h2>
                    <p class="p-0 m-0 text-light fs-md">Submit Jobs</p>
                    <i class="lni lni-empty-file"></i>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="dash-widgets py-5 px-4 bg-purple rounded">
                    <h2 class="ft-medium mb-1 fs-xl text-light">87</h2>
                    <p class="p-0 m-0 text-light fs-md">Applications</p>
                    <i class="lni lni-users"></i>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="dash-widgets py-5 px-4 bg-danger rounded">
                    <h2 class="ft-medium mb-1 fs-xl text-light">312</h2>
                    <p class="p-0 m-0 text-light fs-md">Notifications</p>
                    <i class="lni lni-bar-chart"></i>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="dash-widgets py-5 px-4 bg-blue rounded">
                    <h2 class="ft-medium mb-1 fs-xl text-light">32</h2>
                    <p class="p-0 m-0 text-light fs-md">Bookmark</p>
                    <i class="lni lni-heart"></i>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="dashboard-gravity-list with-icons">
                    <h4 class="mb-0 ft-medium">Recent Activities</h4>
                    <ul>
                        <li>
                            <i class="dash-icon-box ti-layers text-purple bg-light-purple"></i> Your job for <strong class="ft-medium text-dark"><a href="#">IOS Developer</a></strong> has been approved!
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-star text-success bg-light-success"></i> Jodie Farrell left a review <div class="numerical-rating high" data-rating="5.0"></div> for<strong class="ft-medium text-dark"><a href="#"> Real Estate Logo</a></strong>
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-heart text-warning bg-light-warning"></i> Someone bookmarked your <strong class="ft-medium text-dark"><a href="#">SEO Expert Job</a></strong> listing!
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-star text-info bg-light-info"></i> Gracie Mahmood left a review <div class="numerical-rating mid" data-rating="3.8"></div> on <strong class="ft-medium text-dark"><a href="#">Product Design</a></strong>
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-heart text-danger bg-light-danger"></i> Your Magento Developer job expire<strong class="ft-medium text-dark"><a href="#">Renew</a></strong> now it!
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-star text-success bg-light-success"></i> Ethan Barrett left a review <div class="numerical-rating high" data-rating="4.7"></div> on <strong class="ft-medium text-dark"><a href="#">New Logo</a></strong>
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>

                        <li>
                            <i class="dash-icon-box ti-star text-purple bg-light-purple"></i> Your Magento Developer job expire <strong class="ft-medium text-dark"><a href="#">Renew</a></strong> now it.
                            <a href="#" class="close-list-item"><i class="fas fa-times"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12">
                <div class="dashboard-gravity-list invoices with-icons">
                    <h4 class="mb-0 ft-medium">Invoices</h4>
                    <ul>
                        
                        <li><i class="dash-icon-box ti-files text-warning bg-light-warning"></i>
                            <strong class="ft-medium text-dark">Starter Plan</strong>
                            <ul>
                                <li class="unpaid">Unpaid</li>
                                <li>Order: #20551</li>
                                <li>Date: 01/08/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>
                        
                        <li><i class="dash-icon-box ti-files text-success bg-light-success"></i>
                            <strong class="ft-medium text-dark">Basic Plan</strong>
                            <ul>
                                <li class="paid">Paid</li>
                                <li>Order: #20550</li>
                                <li>Date: 01/07/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>

                        <li><i class="dash-icon-box ti-files text-danger bg-light-danger"></i>
                            <strong class="ft-medium text-dark">Extended Plan</strong>
                            <ul>
                                <li class="paid">Paid</li>
                                <li>Order: #20549</li>
                                <li>Date: 01/06/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>
                        
                        <li><i class="dash-icon-box ti-files text-success bg-light-success"></i>
                            <strong class="ft-medium text-dark">Platinum Plan</strong>
                            <ul>
                                <li class="paid">Paid</li>
                                <li>Order: #20548</li>
                                <li>Date: 01/05/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>
                        
                        <li><i class="dash-icon-box ti-files text-warning bg-light-warning"></i>
                            <strong class="ft-medium text-dark">Extended Plan</strong>
                            <ul>
                                <li class="paid">Paid</li>
                                <li>Order: #20547</li>
                                <li>Date: 01/04/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>
                        
                        <li><i class="dash-icon-box ti-files text-info bg-light-info"></i>
                            <strong class="ft-medium text-dark">Platinum Plan</strong>
                            <ul>
                                <li class="paid">Paid</li>
                                <li>Order: #20546</li>
                                <li>Date: 01/03/2019</li>
                            </ul>
                            <div class="buttons-to-right">
                                <a href="javascript:void(0);" class="button text-light bg-warning">View Invoice</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>	
        </div>	
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}

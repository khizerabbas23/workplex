<?php
function mange_applic_sys(){
    vc_map(
        array(
            'name' => __('Manage Application'),
            'base' => 'mange_applic_sys',
            'category' => __('Workplex'),
            'params' => array(
            )
            )
            );   
}
add_action('vc_before_init', 'mange_applic_sys');

function mange_applic_sys_frontend($atts, $content){

    $atts = shortcode_atts(
        $atts,
        'mange_applic_sys'
    );
    
    $output = '';
$output.='<div class="dashboard-wrap bg-light">
				<a class="mobNavigation" data-bs-toggle="collapse" href="#MobNav" role="button" aria-expanded="false" aria-controls="MobNav">
					<i class="fas fa-bars me-2"></i>Dashboard Navigation
				</a>
				 <div class="collapse" id="MobNav">
					<div class="dashboard-nav">
						<div class="dashboard-inner">
							<ul data-submenu-title="Main Navigation">
								<li><a href="employer-dashboard.html"><i class="lni lni-dashboard me-2"></i>Dashboard</a></li>
								<li><a href="dashboard-post-job.html"><i class="lni lni-files me-2"></i>Post New Job</a></li>
								<li><a href="dashboard-manage-jobs.html"><i class="lni lni-add-files me-2"></i>Manage Jobs</a></li>
								<li class="active"><a href="dashboard-manage-applications.html"><i class="lni lni-briefcase me-2"></i>Manage Applicants</a></li>
								<li><a href="dashboard-shortlisted-resume.html"><i class="lni lni-bookmark me-2"></i>BookmarkResumes<span class="count-tag bg-warning">4</span></a></li>
								<li><a href="dashboard-packages.html"><i class="lni lni-mastercard me-2"></i>Packages</a></li>
								<li><a href="dashboard-messages.html"><i class="lni lni-envelope me-2"></i>Messages<span class="count-tag">4</span></a></li>
							</ul>
							<ul data-submenu-title="My Accounts">
								<li><a href="dashboard-my-profile.html"><i class="lni lni-user me-2"></i>My Profile </a></li>
								<li><a href="dashboard-change-password.html"><i class="lni lni-lock-alt me-2"></i>Change Password</a></li>
								<li><a href="javascript:void(0);"><i class="lni lni-trash-can me-2"></i>Delete Account</a></li>
								<li><a href="index.html"><i class="lni lni-power-switch me-2"></i>Log Out</a></li>
							</ul>
						</div>					
					</div>
				</div>
				
				<div class="dashboard-content">
					<div class="dashboard-tlbar d-block mb-5">
						<div class="row">
							<div class="colxl-12 col-lg-12 col-md-12">
								<h1 class="ft-medium">Manage Jobs</h1>
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item text-muted"><a href="#">Home</a></li>
										<li class="breadcrumb-item text-muted"><a href="#">Dashboard</a></li>
										<li class="breadcrumb-item"><a href="#" class="theme-cl">Manage Jobs</a></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					
					<div class="dashboard-widg-bar d-block">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
							
								<div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3">
									<div class="flixors">
										<div class="row align-items-center justify-content-between">
											<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
												<h6 class="mb-0 ft-medium fs-sm">07 New Applicants Found</h6>
											</div>
											
											<div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
												<div class="filter_wraps elspo_wrap d-flex align-items-center justify-content-end">
													<div class="single_fitres me-2">
														<select class="form-select simple">
														  <option value="1" selected="">Default Sorting</option>
														  <option value="2">Short By Name</option>
														  <option value="3">Short By Rating</option>
														  <option value="4">Short By Trending</option>
														  <option value="5">Shot By Recent</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								
								<div class="data-responsive">';
		global $current_user;
		global $post_id;
		

    $user_id = $current_user->ID;

    // $post_id = $_POST['post_id'];
    // $application_id = get_user_meta($user_id, 'application_mangae', true);
    $user = get_user_by('ID', $user_id);
    $username = $user->user_login;
    $user_avatar = get_avatar($current_user->ID, 96);

								
									$output.='<div class="dashed-list-wrap bg-white rounded mb-3">
										<div class="dashed-list-full bg-white rounded p-3 mb-3">
											<div class="dashed-list-short d-flex align-items-center">
												<div class="dashed-list-short-first">
													<div class="dashed-avater data-id="'.$post_id.'""><img src="'.$user_avatar.'" class="img-fluid circle" width="70" alt="" /></div>
												</div>
												<div class="dashed-list-short-last">
													<div class="cats-box-caption px-2">
														<h4 class="fs-lg mb-0 ft-medium theme-cl">'.$username.'</h4>
														<div class="d-block mb-2 position-relative">
															<span><i class="lni lni-map-marker me-1"></i>United States</span>
															<span class="ms-2"><i class="lni lni-briefcase me-1"></i>Web Designer</span>
														</div>
														<div class="ico-content">
															<ul>
																<li><a href="javascript:void(0);" class="px-2 py-1 medium bg-light-success rounded text-success"><i class="lni lni-download me-1"></i>Download CV</a></li>
																<li><a href="#" data-bs-toggle="modal" data-bs-target="#message" class="px-2 py-1 medium bg-light-info rounded text-info"><i class="lni lni-envelope me-1"></i>Message</a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<div class="dashed-list-last">
												<div class="text-left">
													<a href="#" data-bs-toggle="modal" data-bs-target="#edit" class="btn gray ft-medium apply-btn fs-sm rounded me-1"><i class="lni lni-arrow-right-circle me-1"></i>Edit</a>
													<a href="#" data-bs-toggle="modal" data-bs-target="#note" class="btn gray ft-medium apply-btn fs-sm rounded me-1"><i class="lni lni-add-files me-1"></i>Note</a>
													<a href="javascript:void(0);" class="btn gray ft-medium apply-btn fs-sm rounded"><i class="lni lni-heart me-1"></i>Save</a>
												</div>
											</div>
										</div>
										<div class="dashed-list-footer p-3 br-top">
											<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
											</div>
											<div class="ico-content">
												<ul>
													<li><span><i class="lni lni-calendar me-1"></i>07 July 2017</span></li>
													<li><span><i class="lni lni-add-files me-1"></i>Recent</span></li>
												</ul>
											</div>
										</div>
									</div>
									
								
									
								</div>
							</div>
						</div>
							
					</div>
					
					<!-- footer -->
					<div class="row">
						<div class="col-md-12">
							<div class="py-3">© 2023 Workplex. Designd By ThemezHub.</div>
						</div>
					</div>
		
				</div>
				
			</div>';
			 return $output;
}
add_shortcode('mange_applic_sys', 'mange_applic_sys_frontend');
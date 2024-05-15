<?php

add_filter('worplex_dashboard_employer_saved_resumes_html', 'worplex_dashboard_employer_saved_resumes_html');

function worplex_dashboard_employer_saved_resumes_html() {
    ob_start();
    ?>
					<div class="dashboard-widg-bar d-block">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
							    <div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3">
									<div class="flixors">
										<div class="row align-items-center justify-content-between">
											<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
												<h6 class="mb-0 ft-medium fs-sm">07 Shortlisted Resume</h6>
											</div>
											
											<div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
												<div class="filter_wraps elspo_wrap d-flex align-items-center justify-content-end">
													<div class="single_fitres me-2">
													    <form method="GET" class="worplex-sort-name">
													        <input type="hidden" name="account_tab" value="saved-resumes">
														<select name="sortby" class="form-select simple">
														  <option selected="">Default Sorting</option>
														  <option value="asc">Short By Name</option>
														  <option value="recent">Shot By Recent</option>
														</select>
														</form>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
								
								<div class="data-responsive">
					
					 <?php
     	global $current_user;
   
    $user_id = $current_user->ID;
    $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
    
    
     $sort_key = isset($_GET['sortby']) ? $_GET['sortby'] : '';

                                if ($sort_key == 'asc') {
                                    $favjobs_with_titles = $new_fav_jobs = [];
                                    foreach ($fav_jobs as $emplpostId) {
                                        $favjobs_with_titles[$emplpostId] = get_the_title($emplpostId);
                                        asort($favjobs_with_titles);
                                    }
                                    foreach ($favjobs_with_titles as $fav_id => $fav_title) {
                                        $new_fav_jobs[] = $fav_id;
                                    }
                                    $fav_jobs = $new_fav_jobs;
                                } elseif ($sort_key == 'recent') {
                                    rsort($fav_jobs);
                                }
    
    foreach ($fav_jobs as $emplpostId) {
     
     $permalink = get_the_permalink();
     $location = get_post_meta($emplpostId, 'worplex_field_location', true);
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($emplpostId), '96');
  $postid = $emplpostId; // Use candidateId as the post ID
?>
    				
									<div class="worplex-post-item dashed-list-wrap bg-white rounded mb-3">
										<div class="dashed-list-full bg-white rounded p-3 mb-3">
											<div class="dashed-list-short d-flex align-items-center">
												<div class="dashed-list-short-first">
													<div class="dashed-avater"><img src="<?php echo $image[0] ?>" class="img-fluid circle" width="70" alt="" /></div>
												</div>
												<div class="dashed-list-short-last">
													<div class="cats-box-caption px-2">
														<h4 class="fs-lg mb-0 ft-medium theme-cl"><?php echo get_the_title($emplpostId); ?></h4>
														<div class="d-block mb-2 position-relative">
															<span><i class="lni lni-map-marker me-1"></i><?php echo $location; ?></span>
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
												<div class="dash-action">
													<a href="<?php echo $permalink; ?>" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
													<a class="worplex-delete-post-btn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1" data-id="<?php echo $postid ?>"><i class="lni lni-trash-can"></i></a>
												</div>
											</div>
										</div>
									</div>
							<?php 
        }
								?>	
									</div>
									</div>
							</div>
						</div>

						
						<?php
    $html = ob_get_clean();
    return $html;
}

// Add AJAX handler to unlike the post


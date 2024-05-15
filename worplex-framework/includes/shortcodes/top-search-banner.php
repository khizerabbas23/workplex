<?php

function top_search_banner()
{

  vc_map(

    array(
      'name' => __('Top Search Banner'),
      'base' => 'top_search_banner',
      'category' => __('Workplex'),
      'params' => array(

        array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Top Banner Style', 'workplex' ),
					'param_name' => 'top_search_banner_style',
					'description' => __('Select Top BAnner Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
                        'Style 1' => 'view_1',
                        'Style 2' => 'view_2',
                        'Style 3' => 'view_3',
                        'Style 4' => 'view_4',
                        'Style 5' => 'view_5',
                        'Style 6' => 'view_6',
                        'Style 7' => 'view_7',
                        'Style 8' => 'view_8',
						
					),
				   ),
				   
                   
        array(
        'type' => 'worplex_browse_img',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background Image'),
        'param_name' => 'bg_image',
        ),         
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Title'),
          'param_name' => 'title',
        ),
        array(
          'type' => 'textfield',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Sub Title'),
          'param_name' => 'sub_title',
        ),
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Number'),
            'param_name' => 'number',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_2')
            ),
          ),
          array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Color Word'),
            'param_name' => 'color_word',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_4','view_5','view_6','view_7')
            ),
          ),
          array(
            'type' => 'textarea',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Description'),
            'param_name' => 'description',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_4' ,'view_5' , 'view_6','view_7')
            ),
          ),
          array(
            'type' => 'textfield',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Banner Title'),
            'param_name' => 'banner_title',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_5' , 'view_6')
            ),
          ),
          array(
            'type' => 'worplex_browse_img',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Banner Image One'),
            'param_name' => 'banner_image_one',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_5')
            ),
          ),
          array(
            'type' => 'worplex_browse_img',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Banner Image Two'),
            'param_name' => 'banner_image_two',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_5')
            ),
          ),
          array(
            'type' => 'worplex_browse_img',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Banner Image three'),
            'param_name' => 'banner_image_three',
            'dependency' => array(
                'element' => 'top_search_banner_style',
                'value' => array('view_5')
            ),
          ),
          
         
      ),
    )
  );
}
add_action('vc_before_init', 'top_search_banner');

//welcome Massage frontend
function top_search_bannerfrontend($atts, $content)
{

  $atts = shortcode_atts(
    array(
        
      'top_search_banner_style' => '',

      'title' => '',
      'sub_title' => '',
      'number' => '',
      'color_word' => '',

      'description' => '',
      'banner_title' => '',      

      'bg_image' => '',

      'banner_image_one' => '',
      'banner_image_two' => '',
      'banner_image_three' => '',

      
    ),
    $atts,
    'top_search_banner'
  );

  $im_app_services = vc_param_group_parse_atts($atts['title']);

  $top_search_banner_style = isset($atts['top_search_banner_style']) ? $atts['top_search_banner_style'] : '';

  $title = isset($atts['title']) ? $atts['title'] : '';
  $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
  $color_word = isset($atts['color_word']) ? $atts['color_word'] : '';
  $description = isset($atts['description']) ? $atts['description'] : '';
  $banner_title = isset($atts['banner_title']) ? $atts['banner_title'] : '';



  $number = isset($atts['number']) ? $atts['number'] : '';

  $bg_image = $atts["bg_image"];

  $banner_image_one = $atts["banner_image_one"];
  $banner_image_two = $atts["banner_image_two"];
  $banner_image_three = $atts["banner_image_three"];
  
  
  global $worplex_framework_options;

        $select_job_page = isset($worplex_framework_options['job_select_page']) ? $worplex_framework_options['job_select_page'] : '';

        $job_page_id = worplex_get_page_id_from_name($select_job_page);

        $job_page_url = '';
        if ($job_page_id > 0) {
            $job_page_url = get_permalink($job_page_id);
        }


  $output = '';

  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';


  if($atts['top_search_banner_style'] == 'view_1'){
    $output .= '<div class="home-banner margin-bottom-0" style="background:#17b67c url('.$bg_image.') no-repeat;" data-overlay="4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="banner_caption text-center mb-5">
                    <h1 class="banner_title ft-bold mb-1">'.$title.'</h1>
                    <p class="fs-md ft-medium">'.$sub_title.'</p>
                </div>
                
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="location" placeholder="Location or Zip Code" />
                                <i class="bnc-ico lni lni-target"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                                
                                  $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>';
  }elseif($atts['top_search_banner_style'] == 'view_2'){

    $output .= '<div class="home-banner margin-bottom-0" style="background:#00ab46 url('.$bg_image.') no-repeat;" data-overlay="5">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
						
							<div class="banner_caption text-center mb-5">
								<h1 class="banner_title ft-bold mb-1"><span class="count">'.$number.'</span> '.$title.'</h1>
								<p class="fs-md ft-medium">'.$sub_title.'</p>
							</div>
							
							<form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
								<div class="row gx-0">
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="form-group mb-0 position-relative">
											<input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
											<i class="bnc-ico lni lni-search-alt"></i>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
										<div class="form-group mb-0 position-relative">
											<input type="text" class="form-control lg left-ico" name="location" placeholder="Location or Zip Code" />
											<i class="bnc-ico lni lni-target"></i>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
										<div class="form-group mb-0 position-relative">
											<select class="form-select lg b-0" name="job_category">';
											
											 $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
										<div class="form-group mb-0 position-relative">
											<button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
										</div>
									</div>
									
								</div>
							</form>
							
							<div class="text-center align-items-center justify-content-center mt-5">
								<a href="javascript:void(0);" class="btn bg-white hover-theme ft-regular me-1"><i class="lni lni-user me-2"></i>Create Account</a>
								<a href="javascript:void(0);" class="btn bg-dark hover-theme text-light ft-regular ms-1"><i class="lni lni-upload me-2"></i>Upload Resume</a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
';
}elseif($atts['top_search_banner_style'] == 'view_3'){

    $output .= '<div class="home-banner margin-bottom-0" style="background:#00ab46 url('.$bg_image.') no-repeat;" data-overlay="5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
                
                <div class="banner_caption text-center mb-5">
                    <h1 class="banner_title ft-bold mb-1">'.$title.'</h1>
                    <p class="fs-md ft-medium">'.$sub_title.'</p>
                </div>
                
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="location" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-target"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                               $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
';
}elseif($atts['top_search_banner_style'] == 'view_4'){

    $output .= '<div class="home-banner margin-bottom-0" style="background:#eff6f2 url('.$bg_image.') no-repeat;">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-xl-6 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="banner_caption text-left mb-4">
                    <h1 class="banner_title ft-bold mb-1">'.$title.' <span class="theme-cl">'.$color_word.'</span><br>'.$sub_title.'</h1>
                    <p class="fs-md ft-regular">'.$description.'</p>
                </div>
            </div>
            <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 col-12">
                
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                                $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="top-searches-key">
                    <ul class="p-0 mt-4 align-items-center d-flex">
                        <li><span class="text-dark ft-medium medium">Top Searches:</span></li>
                        <li><a href="javascript:void(0);" class="">WordPress</a></li>
                        <li><a href="javascript:void(0);" class="">Magento</a></li>
                        <li><a href="javascript:void(0);" class="">HTML5</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
';
}elseif($atts['top_search_banner_style'] == 'view_5'){

    $output .= '<div class="home-banner margin-bottom-0 intro-bg">
    <div class="container">
        
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                <div class="banner_caption text-left mb-4">
                    <div class="d-block mb-2"><span class="px-3 py-1 medium theme-bg-light theme-cl rounded">'.$banner_title.'</span></div>
                    <h1 class="banner_title ft-bold mb-1">'.$title.'<br><span class="theme-cl">'.$color_word.'</span> '.$sub_title.'</h1>
                    <p class="fs-md ft-regular">'.$description.'</p>
                </div>
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                               $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                <div class="bnr_thumb position-relative">
                    <img src="'.$bg_image.'" class="img-fluid bnr_img" alt="" />
                    <div class="list_crs_img">
                        <img src="'.$banner_image_one.'" class="img-fluid elsio cirl animate-fl-y" alt="">
                        <img src="'.$banner_image_two.'" class="img-fluid elsio arrow animate-fl-x" alt="">
                        <img src="'.$banner_image_three.'" class="img-fluid elsio moon animate-fl-x" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';
}elseif($atts['top_search_banner_style'] == 'view_6'){

    $output .= '<div class="home-banner margin-bottom-0" style="background:#f6f7f9;">
    <div class="container">
        
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                <div class="banner_caption text-left mb-4">
                    <div class="d-block mb-2"><span class="px-3 py-1 medium bg-light-danger text-danger rounded">'.$banner_title.'</span></div>
                    <h1 class="banner_title ft-bold mb-1">'.$title.'<br><span class="text-danger">'.$color_word.'</span> Jobs</h1>
                    <p class="fs-md ft-regular">'.$description.'</p>
                </div>
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                                 $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg bg-danger text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                <div class="bnr_thumb">
                    <img src="'.$bg_image.'" class="img-fluid bnr_img" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
';
}elseif($atts['top_search_banner_style'] == 'view_7'){

    $output .= '<div class="home-banner margin-bottom-0" style="background:#eff6f2 url('.$bg_image.') no-repeat;">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-xl-6 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="banner_caption text-left mb-4">
                    <h1 class="banner_title ft-bold mb-1">'.$title.' <span class="theme-cl">'.$color_word.'</span><br>'.$sub_title.'</h1>
                    <p class="fs-md ft-regular">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
                </div>
            </div>
            <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 col-12">
                
                <form class="bg-white rounded p-1" method="get" action="'.$job_page_url.'">
                    <div class="row gx-0">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" class="form-control lg left-ico" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <select class="form-select lg b-0" name="job_category">';
                                
                                  $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group mb-0 position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="top-searches-key">
                    <ul class="p-0 mt-4 align-items-center d-flex">
                        <li><span class="text-dark ft-medium medium">Top Searches:</span></li>
                        <li><a href="javascript:void(0);" class="">WordPress</a></li>
                        <li><a href="javascript:void(0);" class="">Magento</a></li>
                        <li><a href="javascript:void(0);" class="">HTML5</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
';
}elseif($atts['top_search_banner_style'] == 'view_8'){

    $output .= '<div class="home-banner margin-bottom-0 intro-bg intro-banner">
    <div class="container">
        
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-5 col-lg-7 col-md-7 col-sm-12 col-12">
                <form class="bg-white rounded p-4" method="get" action="'.$job_page_url.'">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group mb-4">
                                <h2 class="mb-0 ft-bold">'.$title.'</h2>
                                <p class="fs-md text-muted">'.$sub_title.'</p>
                            </div>
                            
                            <div class="form-group position-relative mb-3">
                                <input type="text" class="form-control lg form-ico border rounded" name="keyword" placeholder="Job Title, Keyword or Company" />
                                <i class="bnc-ico lni lni-search-alt"></i>
                            </div>
                            <div class="form-group position-relative mb-3">
                                <input type="text" class="form-control lg form-ico rounded" name="location" placeholder="Location or Zip Code" />
                                <i class="bnc-ico lni lni-target"></i>
                            </div>
                            <div class="form-group position-relative mb-3">
                                <select class="form-select lg border" name="job_category">';
                                
                                  $cat_terms = get_terms( array(
								'taxonomy'   => 'job_category',
								'hide_empty' => false,
							) );

							if (!empty($cat_terms)) {
								foreach ($cat_terms as $cat_term) {
									$output .=' <option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
								}
							}
                                 
                                  $output.='</select>
                            </div>
                            <div class="form-group position-relative">
                                <button type="submit" class="btn full-width custom-height-lg theme-bg text-white fs-md">Find Job</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="top-searches-key">
                    <ul class="p-0 mt-4 align-items-center d-flex">
                        <li><span class="text-dark ft-medium medium">Top Searches:</span></li>
                        <li><a href="javascript:void(0);" class="">WordPress</a></li>
                        <li><a href="javascript:void(0);" class="">Magento</a></li>
                        <li><a href="javascript:void(0);" class="">HTML5</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-5 col-md-5 col-sm-12 col-12">
                <div class="bnr_thumb position-relative">
                    <img src="'.$bg_image.'" class="img-fluid bnr_img" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
';
}
  return $output;

}
add_shortcode('top_search_banner', 'top_search_bannerfrontend');
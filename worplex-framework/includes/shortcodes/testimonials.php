<?php

function testimonial_section()
{
  vc_map(
    array(
      'name' => __('Testimonials Section'),
      'base' => 'testimonial_section',
      'category' => __('Workplex'),
      'params' => array(
        array(
          'type' => 'dropdown',
          'holder' => 'div',
          'class' => '',
          'heading' => __('Testimonial Style', 'workplex'),
          'param_name' => 'testimonial_style',
          'description' => __('Select Testmonial Style ', 'workplex'),
          'value' => array(
            'Select Style' => '',
            'Style 1' => 'view_style_one',
            'Style 2' => 'view_style_two',
          ),
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
          'heading' => __('Colored Heading'),
          'param_name' => 'color_heading',
        ),
        //group
        array(
          'type' => 'param_group',
          'value' => '',
          'param_name' => 'com_inner_testi',
          'params' => array(
            array(
              'type' => 'worplex_browse_img',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Images'),
              'param_name' => 'images',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Reviewer Name'),
              'param_name' => 'reviewname',
            ),
            array(
              'type' => 'textfield',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Reviewer Position'),
              'param_name' => 'reviewposition',
            ),
            array(
              'type' => 'textarea',
              'holder' => 'div',
              'class' => '',
              'heading' => __('Reviews'),
              'param_name' => 'reviews',
            ),
          )
        )
      ),
    )
  );
}
add_action('vc_before_init', 'testimonial_section');

//welcome Massage frontend
function testimonial_sectionfrontend($atts, $content)
{

  $atts = shortcode_atts(
    array(

      'testimonial_style' => '',
      'color_heading' => '',
      'title' => '',
      'sub_title' => '',

      'com_inner_testi' => '',

    ),
    $atts,
    'testimonial_section'
  );

  $im_app_services = vc_param_group_parse_atts($atts['title']);

  $testimonial_style = isset($atts['testimonial_style']) ? $atts['testimonial_style'] : '';

  $title = isset($atts['title']) ? $atts['title'] : '';
  $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
  $color_heading = isset($atts['color_heading']) ? $atts['color_heading'] : '';

  $output = '';

  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

  if ($atts['testimonial_style'] == 'view_style_two') {

    $output .= '<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">' . $title . '</h6>
								<h2 class="ft-bold">' . $sub_title . ' <span class="theme-cl">' . $color_heading . '</span></h2>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="review-slide px-3">';

    $l_teamlist = vc_param_group_parse_atts($atts['com_inner_testi']);

    foreach ($l_teamlist as $key => $value) {

      $images = $value["images"];

      $reviewname = isset($value['reviewname']) ? $value['reviewname'] : '';
      $reviewposition = isset($value['reviewposition']) ? $value['reviewposition'] : '';
      $reviews = isset($value['reviews']) ? $value['reviews'] : '';


      $output .= '<div class="single_review px-2">
    <div class="reviews_wrap position-relative bg-white rounded py-4 px-4">
        <div class="rw-header d-flex align-items-center justify-content-start">
            <div class="rv-110-thumb position-relative verified-author"><img src="' . $images. '" class="img-fluid circle" width="70" alt="" /></div>
            <div class="rv-110-caption ps-3">
                <h4 class="ft-medium fs-md mb-0 lh-1">' . $reviewname . '</h4>
                <p class="p-0 m-0">' . $reviewposition . '</p>
            </div>
        </div>
        <div class="rw-header d-flex mt-3">
            <p>' . $reviews . '</p>
        </div>
    </div>
</div>';
    }

    $output .= '	
  </div>
</div>
</div>';
  } elseif ($atts['testimonial_style'] == 'view_style_one') {

    $output .= '<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-5">
            <h6 class="text-muted mb-0">' . $title . '</h6>
            <h2 class="ft-bold">' . $sub_title . ' <span class="theme-cl">' . $color_heading . '</span></h2>
        </div>
    </div>
</div>

<div class="row justify-content-center g-xl-3 g-lg-3 g-md-3 g-3">
    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12">
        <div class="reviews-slide px-3">';

    $l_teamlist = vc_param_group_parse_atts($atts['com_inner_testi']);

    foreach ($l_teamlist as $key => $value) {

      $images = $value["images"];

      $reviewname = isset($value['reviewname']) ? $value['reviewname'] : '';
      $reviewposition = isset($value['reviewposition']) ? $value['reviewposition'] : '';
      $reviews = isset($value['reviews']) ? $value['reviews'] : '';


      $output .= '<div class="single_review">
    <div class="sng_rev_thumb"><figure><img src="' . $images . '" class="img-fluid circle" alt="" /></figure></div>
    <div class="sng_rev_caption text-center">
        <div class="rev_desc mb-4">
            <p class="fs-md">' . $reviews . '</p>
        </div>
        <div class="rev_author">
            <h4 class="mb-0">' . $reviewname . '</h4>
            <span class="fs-sm">' . $reviewposition . '</span>
        </div>
    </div>
</div>';
    }

    $output .= '	
  </div>
  </div>
</div>';


  }
  return $output;

}
add_shortcode('testimonial_section', 'testimonial_sectionfrontend');
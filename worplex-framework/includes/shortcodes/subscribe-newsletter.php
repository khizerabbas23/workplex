<?php

function subscribe_newsletter()
{

  vc_map(

    array(
      'name' => __('Subscribe Now Section'),
      'base' => 'subscribe_newsletter',
      'category' => __('Workplex'),
      'params' => array(

        array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Subscribe Style', 'workplex' ),
					'param_name' => 'subscribe_style',
					'description' => __('Select Subscribe Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
                        'Subscribe Style 1' => 'home_style_one',
                        'Subscribe Style 2' => 'home_style_two',
						
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
         
      ),
    )
  );
}
add_action('vc_before_init', 'subscribe_newsletter');

//welcome Massage frontend
function subscribe_newsletterfrontend($atts, $content)
{

  $atts = shortcode_atts(
    array(
        
      'subscribe_style' => '',

      'title' => '',
      'sub_title' => '',

    ),
    $atts,
    'subscribe_newsletter'
  );

  $im_app_services = vc_param_group_parse_atts($atts['title']);

  $subscribe_style = isset($atts['subscribe_style']) ? $atts['subscribe_style'] : '';

  $title = isset($atts['title']) ? $atts['title'] : '';
  $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';

  $output = '';

  $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';


  if($atts['subscribe_style'] == 'home_style_one'){
    $output .= '<section class="space bg-cover">
				<div class="container py-5">
    <div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-5">
            <h6 class="text-light mb-0">'.$title.'</h6>
            <h2 class="ft-bold text-light">'.$sub_title.'</h2>
        </div>
    </div>
</div>

<div class="row align-items-center justify-content-center">
    <div class="col-xl-7 col-lg-10 col-md-12 col-sm-12 col-12">
        <form class="bg-white rounded p-1">
            <div class="row gx-0">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-8">
                    <div class="form-group mb-0 position-relative">
                        <input type="text" class="form-control lg left-ico" placeholder="Enter Your Email Address">
                        <i class="bnc-ico lni lni-envelope"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                    <div class="form-group mb-0 position-relative">
                        <button class="btn full-width custom-height-lg bg-dark text-white fs-md" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</section>';
  }elseif($atts['subscribe_style'] == 'home_style_two'){

    $output .= '<section class="space bg-cover">
				<div class="container py-5">
    <div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-5">
            <h6 class="text-light mb-0">'.$title.'</h6>
            <h2 class="ft-bold text-light">'.$sub_title.'</h2>
        </div>
    </div>
</div>

<div class="row align-items-center justify-content-center">
    <div class="col-xl-7 col-lg-10 col-md-12 col-sm-12 col-12">
        <form class="bg-white rounded p-1">
            <div class="row gx-0">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-8">
                    <div class="form-group mb-0 position-relative">
                        <input type="text" class="form-control lg left-ico" placeholder="Enter Your Email Address">
                        <i class="bnc-ico lni lni-envelope"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                    <div class="form-group mb-0 position-relative">
                        <button class="btn full-width custom-height-lg theme-bg text-light fs-md" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</section>';


  }
  return $output;

}
add_shortcode('subscribe_newsletter', 'subscribe_newsletterfrontend');
<?php

function choose_our_price_section()
{
    $all_pckgs = array(esc_html__("Select Package Product", "worplex-frame") => '');
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'key' => 'worplex_field_prod_attachwith_pkg',
                'value' => 'yes',
            ),
        ),
    );
    $pkgs_query = new WP_Query($args);
    if ($pkgs_query->found_posts > 0) {
        $pkgs_list = $pkgs_query->posts;
        if (!empty($pkgs_list)) {
            foreach ($pkgs_list as $pkg_item) {
                $pkg_post = get_post($pkg_item);
                $pkg_post_name = isset($pkg_post->post_name) ? $pkg_post->post_name : '';
                $all_pckgs[get_the_title($pkg_item)] = $pkg_post_name;
            }
        }
    }
    vc_map(
        array(
            'name' => __('Pricing Package'),
            'base' => 'choose_our_price_section',
            'category' => __('Workplex'),
            'params' => array(
                
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Pricing Package Style', 'workplex'),
                'param_name' => 'pricing_package_styles',
                'description' => __('Select Pricing Package Style ', 'workplex'),
                'value' => array(
                    'Select Style' => '',
                    'View Style 1' => 'view_style_one',
                    'View Style 2' => 'view_style_two',
                    'View Style 3' => 'view_style_three',
                ),
           ),              
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Pricing Tag'),
                    'param_name' => 'pricing_tag',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Choose Heading'),
                    'param_name' => 'choose_heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Package Heading'),
                    'param_name' => 'package_heading',
                    'dependency' => array(
                        'element' => 'pricing_package_styles',
                        'value' => array('view_style_two', 'view_style_three')
                    ),
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'pricing_pack_multi_inner',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package Type'),
                            'param_name' => 'package_type',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package Amount'),
                            'param_name' => 'package_amount',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Package Short Description'),
                            'param_name' => 'package_short_description',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Guarantee'),
                            'param_name' => 'list_guarantee',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Bandwidth'),
                            'param_name' => 'list_bandwidth',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Storage'),
                            'param_name' => 'list_storage',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Support'),
                            'param_name' => 'list_support',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('List Enterprise'),
                            'param_name' => 'list_enterprise',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Button  Label'),
                            'param_name' => 'button_label',
                        ),
                        array(
                            'type' => 'dropdown',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Pacakge Product'),
                            'param_name' => 'pkg_prod',
                            'value' => $all_pckgs
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'choose_our_price_section');

function choose_our_price_section_frontend($atts, $content){

    $atts = shortcode_atts(
        array(

            'pricing_package_styles' => '',
            'pricing_tag' => '',
            'choose_heading' => '',
            'package_heading' => '',
            'pricing_pack_multi_inner' => '',
        ),
        $atts,'choose_our_price_section'
    );

    $pricing_package_styles = isset($atts['pricing_package_styles']) ? $atts['pricing_package_styles'] : '';
    $pricing_tag = isset($atts['pricing_tag']) ? $atts['pricing_tag'] : '';
    $choose_heading = isset($atts['choose_heading']) ? $atts['choose_heading'] : '';
    $package_heading = isset($atts['package_heading']) ? $atts['package_heading'] : '';

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if ($atts['pricing_package_styles'] == 'view_style_one' || 'view_style_two' || 'view_style_three') {

        $output.='<div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-9 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">';
                if(!empty($pricing_tag)){
                    $output.='<h6 class="text-muted mb-0">'.$pricing_tag.'</h6>';
                }
                    if(!empty($choose_heading)){
                    $output.='<h2 class="ft-bold">'.$choose_heading.' ';
                    }
                    
                    if ($atts['pricing_package_styles'] == 'view_style_two') {
                        if(!empty($package_heading)){
                    $output.='<span class="text-danger"> '.$package_heading.'</span>';
                        }
                    }
                    
                    if ($atts['pricing_package_styles'] == 'view_style_three') {
                        if(!empty($package_heading)){
                    $output.='<span class="theme-cl"> '.$package_heading.'</span>';
                        }
                    }
                    
                    $output.='</h2>
                </div>
            </div>
        </div>
    <div class="row align-items-center  g-xl-4 g-lg-3 g-md-3 g-3">';

        $lm_team_list = vc_param_group_parse_atts($atts['pricing_pack_multi_inner']);
        $counter = 1;
        foreach ($lm_team_list as $key => $value) {
            
            $package_type = isset($value['package_type']) ? $value['package_type'] : '';
            $package_amount = isset($value['package_amount']) ? $value['package_amount'] : '';
            $package_short_description = isset($value['package_short_description']) ? $value['package_short_description'] : '';
            $list_guarantee = isset($value['list_guarantee']) ? $value['list_guarantee'] : '';
            $list_bandwidth = isset($value['list_bandwidth']) ? $value['list_bandwidth'] : '';
            $list_storage = isset($value['list_storage']) ? $value['list_storage'] : '';
            $list_support = isset($value['list_support']) ? $value['list_support'] : '';
            $list_enterprise = isset($value['list_enterprise']) ? $value['list_enterprise'] : '';
            $button_label = isset($value['button_label']) ? $value['button_label'] : '';
            $pkg_prod = isset($value['pkg_prod']) ? $value['pkg_prod'] : '';

            $pkg_prod_id = 0;
            if ($pkg_prod != '') {
                $pkg_prod_id = worplex_get_page_id_from_name($pkg_prod, 'product');
            }

            if($counter == 1){
                $recommended = '';
                $clsonnone = 'none';
                $clstwnone = 'none';
                $btnact = '';
            }if($counter == 2){
                $recommended = 'Best Value';
                $clsonnone = '';
                $clstwnone = 'none';
                $btnact = 'active';
            }if($counter == 3){
                $recommended = '';
                $clsonnone = '';
                $clstwnone = '';
                $btnact = '';
            }

            $output.='<div class="col-lg-4 col-md-4">
							<div class="pricing_wrap">
								<div class="prt_head">';
								if(!empty($recommended)){
									$output.='<div class="recommended">'.$recommended.'</div>';
								}
								if(!empty($package_type)){
									$output.='<h4 class="ft-medium">'.$package_type.'</h4>';
								}
								$output.='</div>
								<div class="prt_price">';
								if(!empty($package_amount)){
									$output.='<h2 class="ft-bold"><span>$</span>'.$package_amount.'</h2>';
								}
								if(!empty($package_short_description)){
									$output.='<span class="fs-md">'.$package_short_description.'</span>';
								}
								$output.='</div>
								<div class="prt_body">
									<ul>';
									if(!empty($list_guarantee)){
										$output.='<li>'.$list_guarantee.'</li>';
									}
									if(!empty($list_bandwidth)){
									    $output.='<li>'.$list_bandwidth.'</li>';
									}
									if(!empty($list_storage)){
									    $output.='<li>'.$list_storage.'</li>';
									}
									if(!empty($list_support)){
									    $output.='<li class="'.$clsonnone.'">'.$list_support.'</li>';
									}
									if(!empty($list_enterprise)){
									    $output.='<li class="'.$clstwnone.'">'.$list_enterprise.'</li>';
									}
									$output.='</ul>
								</div>
								<div class="prt_footer">';
								if(!empty($button_label)){
									$output.='<a href="#" class="btn choose_package '.$btnact.' worplex-user-pkg-buybtn" data-id="' . $pkg_prod_id . '">'.$button_label.'</a>';
								}
								$output.='</div>
							</div>
						</div>';
						$counter++;
        }
        $output.='</div>';
    } 
    
    return $output;
}
add_shortcode('choose_our_price_section', 'choose_our_price_section_frontend');
<?php
function workplex_contact_us_form()
{

    vc_map(

        array(
            'name' => __('Contact Us '),
            'base' => 'workplex_contact_us_form',
            'category' => __('Workplex'),
            'params' => array(
               
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading '),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Cell Heading '),
                    'param_name' => 'call_heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Address'),
                    'param_name' => 'address',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Emali'),
                    'param_name' => 'email',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Email Heading '),
                    'param_name' => 'email_heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Customer Care: Cell '),
                    'param_name' => 'customer_care',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Careers:: Cell '),
                    'param_name' => 'career_cell',
                ),
               
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Office @Email '),
                    'param_name' => 'ofice_email',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Home @Gmail '),
                    'param_name' => 'home_gmail',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact ID'),
                    'param_name' => 'contact_id',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Contact Title'),
                    'param_name' => 'contact_title',
                ),
             
             

            )
            )
            );   
}
add_action('vc_before_init', 'workplex_contact_us_form');

//welcome Massage frontend
function workplex_contact_us_form_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'heading' => '',
            'call_heading' => '',
            'address' => '',
            'email' => '',
            'email_heading' => '',
            'customer_care' => '',
            'career_cell' => '',
            'ofice_email' => '',
            'home_gmail' => '',
            'contact_id' => '',
            'contact_title' => '',
        ),
        $atts,
        'workplex_contact_us_form'
    );
    $im_app_services = vc_param_group_parse_atts($atts['heading']);

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $call_heading = isset($atts['call_heading']) ? $atts['call_heading'] : '';
    $address = isset($atts['address']) ? $atts['address'] : '';
    $email = isset($atts['email']) ? $atts['email'] : '';
    $email_heading = isset($atts['email_heading']) ? $atts['email_heading'] : '';
    $customer_care = isset($atts['customer_care']) ? $atts['customer_care'] : '';
    $career_cell = isset($atts['career_cell']) ? $atts['career_cell'] : '';
    $ofice_email = isset($atts['ofice_email']) ? $atts['ofice_email'] : '';
    $home_gmail = isset($atts['home_gmail']) ? $atts['home_gmail'] : '';
    $contact_id = isset($atts['contact_id']) ? $atts['contact_id'] : '';
    $contact_title = isset($atts['contact_title']) ? $atts['contact_title'] : '';

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

   

    $output .= '<div class="row justify-content-center mb-5">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">'. $heading.'</h2>
                </div>
            </div>
        </div>
        
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card-wrap-body mb-4 gray rounded p-3">
                    <h4 class="ft-medium mb-3 theme-cl">'.$call_heading.'</h4>
                    <p>'.$address.'</p>
                    <p class="lh-1"><span class="text-dark ft-medium">Email:</span> ' .$email.'</p>
                </div>
                
                <div class="card-wrap-body mb-3 gray rounded p-3">
                    <h4 class="ft-medium mb-3 theme-cl">'.$call_heading.'</h4>
                    <h6 class="ft-medium mb-1">Customer Care:</h6>
                    <p class="mb-2">'.$customer_care.'</p>
                    <h6 class="ft-medium mb-1">Careers::</h6>
                    <p>'.$career_cell.'</p>
                </div>
                
                <div class="card-wrap-body mb-3 gray rounded p-3">
                    <h4 class="ft-medium mb-3 theme-cl">'.$email_heading.'</h4>
                    <p>Fill out our form and we will contact you within 24 hours.</p>
                    <p class="lh-1 text-dark">'. $ofice_email.'</p>
                    <p class="lh-1 text-dark">'. $home_gmail.'</p>
                </div>
            </div>
            
            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">';
            
            $output.= do_shortcode('[contact-form-7 id="'. $contact_id.'" title="'.$contact_title.'"]');
                
            $output.='</div>
            
        </div>
    </div>
</section>';

    return $output;
}
add_shortcode('workplex_contact_us_form', 'workplex_contact_us_form_frontend');
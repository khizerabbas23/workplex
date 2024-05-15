<?php
function fqsct_akfrqest(){
    vc_map(
        array(
            'name' => __('FaQs Question '),
            'base' => 'fqsct_akfrqest',
            'category' => __('Workplex'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('FaQ Tag'),
                    'param_name' => 'faq_tag',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Question Heading'),
                    'param_name' => 'question_heading',
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'faq_outer_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('FaQ Question Heading'),
                            'param_name' => 'faq_question_heading',
                        ),
                    )
                ),
                
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'faq_inner_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('FaQ Question'),
                            'param_name' => 'faq_question',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('FaQ Answer'),
                            'param_name' => 'faq_answer',
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'fqsct_akfrqest');

function fqsct_akfrqest_frontend($atts, $content){

    $atts = shortcode_atts(
        array(

            'faq_tag' => '',
            'question_heading' => '',
            'faq_outer_multi' => '',
            'faq_inner_multi' => '',
            
        ),
        $atts,'fqsct_akfrqest'
    );

    $faq_tag = isset($atts['faq_tag']) ? $atts['faq_tag'] : '';
    $question_heading = isset($atts['question_heading']) ? $atts['question_heading'] : '';
   
    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';


        $output .= '<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-4">
            <h1 class="ft-bold mb-0">' . $faq_tag . '</h1>
            <h3 class="ft-medium pt-1 mb-3">' . $question_heading . '</h3>
        </div>
    </div>
</div>

<div class="row align-items-center justify-content-between">
    <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12">';

$lm_team_list_outer = vc_param_group_parse_atts($atts['faq_outer_multi']);

$outcntr = 0;
foreach ($lm_team_list_outer as $key_outer => $value_outer) {
    if ($outcntr == 0) {
        $acrdin = 'accordion';
    } elseif ($outcntr == 1) {
        $acrdin = 'accordion1';
    } elseif ($outcntr == 2) {
        $acrdin = 'accordion2';
    }
    $faq_question_heading = isset($value_outer['faq_question_heading']) ? $value_outer['faq_question_heading'] : '';

    $output .= '<div class="d-block position-relative border rounded py-3 px-3 mb-4">
        <h4 class="ft-medium">' . $faq_question_heading . '</h4>
        <div id="' . $acrdin . '" class="accordion">';


    $lm_team_list_inner = vc_param_group_parse_atts($atts['faq_inner_multi']);

    $inrcntr = 1;
    $incnid = 'h';
    $ordid = 'ord';
    foreach ($lm_team_list_inner as $key_inner => $value_inner) {
        if ($inrcntr == $inrcntr) {
            $crdid = $incnid . $inrcntr;
            $ordrid = $ordid . $inrcntr;
        }
        $faq_question = isset($value_inner['faq_question']) ? $value_inner['faq_question'] : '';
        $faq_answer = isset($value_inner['faq_answer']) ? $value_inner['faq_answer'] : '';

        $output .= '<div class="card">
            <div class="card-header" id="' . $crdid . '">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#' .$ordrid . '" aria-expanded="true" aria-controls="' .$ordrid. '">
                    ' . $faq_question . '
                    </button>
                </h5>
            </div>
            <div id="' .$ordrid. '" class="collapse show" aria-labelledby="' . $crdid . '" data-parent="#' . $acrdin . '">
                <div class="card-body">
                    ' . $faq_answer . '
                </div>
            </div>
        </div>';
     $inrcntr ++;
    }
    $output .= '</div>
        </div>';
    $outcntr++;
}
$output .= '</div>
</div>';

    
    return $output;
}
add_shortcode('fqsct_akfrqest', 'fqsct_akfrqest_frontend');
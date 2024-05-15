<?php
function counters_sections() {
    vc_map(
        array(
            'name' => __('Counter'),
            'base' => 'counters_sections',
            'category' => __('Workplex'),
            'params' => array(
               
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_counters',
                    'params' => array(
                        array(
                            'type' => 'iconpicker',
                            'value' => '',
                            'heading' => 'Icon',
                            'param_name' => 'icons',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Title',
                            'param_name' => 'title',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textarea',
                            'value' => '',
                            'heading' => 'Description',
                            'param_name' => 'desc',
                            'value' => ''
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'counters_sections');
function counters_sections_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'multi_counters' => '',
    
       ),
  $atts,
  'counters_sections'
 );

    $output = '';
 

       $output .= '<div class="row justify-content-center">
               <div class="col-lg-12 col-md-12 col-sm-12">
                   <div class="crp_box fl_color ovr_top">
                       <div class="row align-items-center">';

        $l_teamlist = vc_param_group_parse_atts($atts['multi_counters']);

        foreach ($l_teamlist as $key => $value) {

            $icons = isset($value['icons']) ? $value['icons'] : '';
            $title = isset($value['title']) ? $value['title'] : '';
            $desc = isset($value['desc']) ? $value['desc'] : '';
    
            $output .= '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="dro_140">
                <div class="dro_141 de"><i class="'.$icons.'"></i></div>
                <div class="dro_142">
                    <h6>'.$title.'</h6>
                    <p>'.$desc.'</p>
                </div>
            </div>
        </div>';
        }
        $output .= '</div>
        </div>
    </div>
</div>';

    return $output;

}
add_shortcode('counters_sections', 'counters_sections_frontend');
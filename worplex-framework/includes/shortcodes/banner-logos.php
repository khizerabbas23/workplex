<?php
function banner_logos() {
    
    vc_map(
        
        array(
            'name' => __( 'Banner Logos' ),
            'base' => 'banner_logos',
            'category' => __( 'Workplex' ),
            'params' => array(
				                                
		            array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'banner_logos_multi',
                    'params' => array(
                        array(
                            'type' => 'worplex_browse_img',
                            'value' => '',
                            'heading' => 'Image',
                            'param_name' => 'image',
                            'value' => ''
                        ),
                        
                         array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Logo Url',
                            'param_name' => 'logo_url',
                           'value' => ''
                        ),				                   
                            
                    )
                ),
                   
            )
       
            )

            );
           
}
add_action( 'vc_before_init', 'banner_logos' );


function banner_logos_frontend( $atts, $content ) {
  
    $atts = shortcode_atts(
    array(		 
		
         'banner_logos_multi' => '',


         
    ), $atts, 'banner_logos'
);

$output ='
<div class="imployer-explore">
				';
	
$l_teamlist = vc_param_group_parse_atts( $atts['banner_logos_multi'] ); 

 
        foreach ( $l_teamlist as $key => $value) {
            $image = $value["image"];
      
            //$image = wp_get_attachment_image_src($value["image"], 'full'); 
    
            $logo_url = isset($value['logo_url']) ? $value['logo_url'] : '';
			
			
$output  .='<div class="impl-thumb">
<img src="'.$image.'" class="" alt="">
</div>
';
		}

		$output.='
		</div>';
return $output;

}
add_shortcode( 'banner_logos', 'banner_logos_frontend' );

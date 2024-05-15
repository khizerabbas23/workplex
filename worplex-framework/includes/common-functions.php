<?php

function worplex_pagination($worplex_query = '', $return = false) {

    global $wp_query;

    $worplex_big = 999999999; // need an unlikely integer

    $worplex_cus_query = $wp_query;

    if (!empty($worplex_query)) {
        $worplex_cus_query = $worplex_query;
    }

    $worplex_pagination = paginate_links(array(
        'base' => str_replace($worplex_big, '%#%', esc_url(get_pagenum_link($worplex_big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $worplex_cus_query->max_num_pages,
        'prev_text' => '<i class="worplex-fas worplex-faicon-arrow-circle-left"></i> <span>' . esc_html__('Prev', 'worplex-frame') . '</span>',
        'next_text' => '<span>' . esc_html__('Next', 'worplex-frame') . '</span> <i class="worplex-fas worplex-faicon-arrow-circle-right"></i>',
        'type' => 'array'
    ));


    if (is_array($worplex_pagination) && sizeof($worplex_pagination) > 0) {
        $worplex_html = '<nav class="worplex-pagination">';
        $worplex_html .= '<ul class="pagination">';
        foreach ($worplex_pagination as $worplex_link) {
            if (strpos($worplex_link, 'current') !== false) {
                $worplex_html .= '<li class="page-item active"><a class="page-link">' . preg_replace("/[^0-9]/", "", $worplex_link) . '</a></li>';
            } else {
                $worplex_html .= '<li class="page-item">' . $worplex_link . '</li>';
            }
        }
        $worplex_html .= '</ul>';

        $worplex_html .= '</nav>';

        if ($return === false) {
            echo ($worplex_html);
        } else {
            return $worplex_html;
        }
    }
}

// For wp bakery image field
add_action('vc_before_init', function() {
    if (function_exists('vc_add_shortcode_param')) {
        vc_add_shortcode_param('worplex_browse_img', 'bassetth_vc_image_browse_field');
    }
});

function bassetth_vc_image_browse_field($settings, $value) {
    $_class = 'wpb_vc_param_value wpb-textinput ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field';
    $id = esc_attr($settings['param_name']) . rand(1000000, 9999999);
    $image_display = $value == '' ? 'none' : 'block';

    $_html = '
    <div class="bkimg-uploder-con">
    <div id="' . $id . '-box" class="worplex-browse-med-image" style="display: ' . $image_display . ';">
        <a class="worplex-rem-media-b" data-id="' . $id . '"><i class="worplex-fa worplex-faicon-times"></i></a>
        <img id="' . $id . '-img" src="' . $value . '" alt="" />
    </div>';

    $_html .= '<input type="hidden" id="' . $id . '" class="' . esc_html($_class) . '" name="' . esc_attr($settings['param_name']) . '" value="' . $value . '" />';
    $_html .= '<input type="button" class="worplex-upload-media worplex-bk-btn button" data-id="' . $id . '" value="' . __('Browse', 'worplex-frame') . '" />';
    $_html .= '</div>';
    return $_html;
}

function worplex_post_page_title() {

	if (function_exists('is_shop') && is_shop()) {
		$worplex_page_id = wc_get_page_id('shop');
		echo get_the_title($worplex_page_id);
	} else if (is_404()) {
		echo '404';
	} else if (is_page() || is_singular()) {
		echo apply_filters('worplex_post_page_title', get_the_title(), get_the_ID());
	} else if (is_search()) {
		printf(__('Search for : %s', 'worplex-frame'), '<span>' . get_search_query() . '</span>');
	} else {
		the_archive_title();
	}
}

function worplex_icon_picker($name = '', $value = '') {
    $id = rand(10000000, 99999999);
    $html = "
    <script>
    jQuery(document).ready(function ($) {
        var this_icons;
        var rand_num = " . $id . ";
        var e9_element = $('#e9_element_' + rand_num).fontIconPicker({
            theme: 'fip-bootstrap'
        });
        icons_load_call.always(function () {
            this_icons = loaded_icons;
            // Get the class prefix
            var classPrefix = this_icons.preferences.fontPref.prefix,
                icomoon_json_icons = [],
                icomoon_json_search = [];
            $.each(this_icons.icons, function (i, v) {
                icomoon_json_icons.push(classPrefix + v.properties.name);
                if (v.icon && v.icon.tags && v.icon.tags.length) {
                    icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
                } else {
                    icomoon_json_search.push(v.properties.name);
                }
            });
            // Set new fonts on fontIconPicker
            e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
            // Show success message and disable
            $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
        })
        .fail(function () {
            // Show error message and enable
            $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
        });
    });
    </script>";

    $html .= '
    <input type="text" id="e9_element_' . $id . '" class="worplex-icon-pickerr" name="' . $name . '" value="' . $value . '">
    <span id="e9_buttons_' . $id . '" style="display:none">\
        <button autocomplete="off" type="button" class="btn btn-primary">Load from IcoMoon selection.json</button>
    </span>';

    return $html;
}

function get_total_post_count() {
    global $wp_query;
    return $wp_query->found_posts;
}

function worplex_get_page_id_from_name($page_name, $post_type = 'page') {
    global $wpdb;
    if ($page_name != '') {
        $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
        $post_query .= " WHERE posts.post_name='{$page_name}' AND posts.post_type='{$post_type}'";
        $post_query .= " LIMIT 1";
        $get_db_res = $wpdb->get_col($post_query);
        if (isset($get_db_res[0])) {
            return $get_db_res[0];
        }
    }
    return 0;
}

function worplex_esc_the_input($input) {
    if ($input != '') {
        $input = wp_kses($input, array());
        $input = str_replace(array("='", '="', 'alert(', '<script'), array('', '', '', ''), $input);
    }
    return $input;
}

function worplex_inhereted_array_field_validation($input) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = $input_val;
                } else {
                    $new_valid_input[$input_key] = worplex_esc_the_input($input_val);
                }
            }
        }
        return $new_valid_input;
    }
    return $input;
}

function worplex_esc_html($input) {
    if (is_array($input) && !empty($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = worplex_inhereted_array_field_validation($input_val);
                } else {
                    $new_valid_input[$input_key] = worplex_esc_the_input($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        if ($input != '') {
            $input = worplex_esc_the_input($input);
        }
    }
    return $input;
}

function worplex_esc_the_textarea($input) {
    $allowed_tags = array();

    $allowed_atts = array(
        'class' => array(),
        'style' => array(),
        'href' => array(),
        'rel' => array(),
        'target' => array(),
        'width' => array(),
        'height' => array(),
        'title' => array(),
    );
    $allowed_tags['label'] = $allowed_atts;
    $allowed_tags['div'] = $allowed_atts;
    $allowed_tags['strong'] = $allowed_atts;
    $allowed_tags['small'] = $allowed_atts;
    $allowed_tags['span'] = $allowed_atts;
    $allowed_tags['table'] = $allowed_atts;
    $allowed_tags['tbody'] = $allowed_atts;
    $allowed_tags['thead'] = $allowed_atts;
    $allowed_tags['tfoot'] = $allowed_atts;
    $allowed_tags['th'] = $allowed_atts;
    $allowed_tags['tr'] = $allowed_atts;
    $allowed_tags['td'] = $allowed_atts;
    $allowed_tags['h1'] = $allowed_atts;
    $allowed_tags['h2'] = $allowed_atts;
    $allowed_tags['h3'] = $allowed_atts;
    $allowed_tags['h4'] = $allowed_atts;
    $allowed_tags['h5'] = $allowed_atts;
    $allowed_tags['h6'] = $allowed_atts;
    $allowed_tags['ol'] = $allowed_atts;
    $allowed_tags['ul'] = $allowed_atts;
    $allowed_tags['li'] = $allowed_atts;
    $allowed_tags['em'] = $allowed_atts;
    $allowed_tags['hr'] = $allowed_atts;
    $allowed_tags['br'] = $allowed_atts;
    $allowed_tags['p'] = $allowed_atts;
    $allowed_tags['a'] = $allowed_atts;
    $allowed_tags['b'] = $allowed_atts;
    $allowed_tags['i'] = $allowed_atts;

    if ($input != '') {
        $input = wp_kses($input, $allowed_tags);
        $input = str_replace(array('alert(', '<script'), array('', ''), $input);
    }
    return $input;
}

function worplex_esc_wp_editor($input) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = ($input_val);
                } else {
                    $new_valid_input[$input_key] = worplex_esc_the_textarea($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        $input = worplex_esc_the_textarea($input);
    }
    return $input;
}

function worplex__public_upload_files_path($dir = '') {
    global $worplex__upload_files_extpath;
    
    $cus_dir = 'wp-worplex' . ($worplex__upload_files_extpath != '' ? '/' . $worplex__upload_files_extpath : '');
    
    $sub_dir = isset($dir['subdir']) && $dir['subdir'] != '' ? $dir['subdir'] : '';
    $dir_path = array(
        'path' => $dir['basedir'] . '/' . $cus_dir . $sub_dir,
        'url' => $dir['baseurl'] . '/' . $cus_dir . $sub_dir,
        'subdir' => $sub_dir,
    );
    return $dir_path + $dir;
}

//add_action('init', 'worplex_check_public_folder');

function worplex_check_public_folder() {
    //global $worplex__upload_files_extpath;
    //$worplex__upload_files_extpath = 'wp-worplex-files';
    
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;

    add_filter('upload_dir', 'worplex__public_upload_files_path');
    $wp_upload_dir = wp_upload_dir();
    echo '<pre>';
    var_dump($wp_upload_dir);
    echo '</pre>';

    remove_filter('upload_dir', 'worplex__public_upload_files_path');
}

function worplex_salary_units_list() {
    $items = [
        'monthly' => esc_html__('Monthly', 'worplex-frame'),
        'annually' => esc_html__('Annually', 'worplex-frame'),
        'weekly' => esc_html__('Weekly', 'worplex-frame'),
        'daily' => esc_html__('Daily', 'worplex-frame'),
        'hourly' => esc_html__('Hourly', 'worplex-frame'),
    ];

    return $items;
}

function worplex_post_location_str($id) {
    $loc_addr = get_post_meta($id, 'worplex_field_loc_address', true);
    $loc_city = get_post_meta($id, 'worplex_field_loc_city', true);
    $loc_country = get_post_meta($id, 'worplex_field_loc_country', true);
    
    if ($loc_city != '' && $loc_country != '') {
        $str = $loc_city . ', ' . $loc_country;
    } else {
        $str = $loc_addr;
    }
    
    return $str;
}

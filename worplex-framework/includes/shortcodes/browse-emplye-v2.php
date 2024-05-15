<?php
// Home Startup Recent Portfolio
function browse_employe_vtwo() {
    vc_map(
        array(
            'name' => __('Browse Employers V2'),
            'base' => 'browse_employe_vtwo',
            'category' => __('Workplex'),
            'params' => array()
        )
    );
}
add_action('vc_before_init', 'browse_employe_vtwo');

function browse_employe_vtwo_frontend($atts, $content) {

    $atts = shortcode_atts(
        array(),
        $atts, 'browse_employe_vtwo'
    );

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    $output .= '<section>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="company-letters">';
    // Array of letters from 'A' to 'Z'
    $letters = range('A', 'Z');

    // Iterate through each letter
    foreach ($letters as $letter) {
        $output .= '<a href="#' . $letter . '">' . $letter . '</a>';
    }

    $output .= '</div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <ul class="company-summeries-list">';

    // Get the terms from the taxonomy 'job_category' alphabetically
    $categories = get_terms(array(
        'taxonomy' => 'job_category',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC'
    ));

    foreach ($letters as $letter) {
        $output .= '<li>';
        $output .= '<div class="d-inline-flex px-4 py-2 bg-light rounded fs-xl ft-medium theme-cl mb-2">' . $letter . '</div>';
        $output .= '<ul class="cmp-overview">';
        // Filter and display terms starting with the current letter
        foreach ($categories as $category) {
            if (strtoupper(substr($category->name, 0, 1)) === $letter) {
                $output .= '<li><a href="javascript:void(0);">' . $category->name . '</a></li>';
            }
        }
        $output .= '</ul>';
        $output .= '</li>';
    }

    $output .= '</ul>
            </div>
        </div>
    </div>
</section>';

    // JavaScript to handle filtering based on the selected letter
    $output .= '<script>
    document.addEventListener("DOMContentLoaded", function() {
        var alphabetLinks = document.querySelectorAll(".company-letters a");
        var categoryListItems = document.querySelectorAll(".cmp-overview li");
        
        alphabetLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                
                var selectedLetter = this.innerHTML;
                
                // Hide all category list items
                categoryListItems.forEach(function(item) {
                    item.style.display = "none";
                });
                
                // Show only category list items starting with the selected letter
                var selectedCategoryItems = document.querySelectorAll(".cmp-overview li a:first-child");
                selectedCategoryItems.forEach(function(item) {
                    if (item.innerHTML.charAt(0).toUpperCase() === selectedLetter) {
                        item.parentNode.style.display = "block";
                    }
                });
            });
        });
    });
    </script>';

    return $output;
}
add_shortcode('browse_employe_vtwo', 'browse_employe_vtwo_frontend');

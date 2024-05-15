<?php

add_filter('worplex_footer_content_markup', function () {
    ob_start();
    ?>
    <footer class="dark-footer skin-dark-footer style-2">
				<div class="footer-middle">
					<div class="container">
						<div class="row">
                <?php worplex_footer_sidebar_widgets() ?>
           </div>
					</div>
				</div>
				
				<div class="footer-bottom br-top">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-12 col-md-12 text-center">
                <p>&copy; <?php echo date('Y') ?> <?php echo esc_html_e('Workplex', 'worplex-frame') ?></p>
           </div>
						</div>
					</div>
				</div>
			</footer>
    <?php
    $html = ob_get_clean();
    return $html;
});

add_action('wp_footer','searchfeature');
function searchfeature(){
    
    ?>
    
    <script>
			function openSearch() {
				document.getElementById("Search").style.display = "block";
			}
			function closeSearch() {
				document.getElementById("Search").style.display = "none";
			}
		</script>	
    <?php
    
}

	

function worplex_footer_sidebar_widgets() {
	global $worplex_framework_options;
	$worplex_sidebars = isset($worplex_framework_options['worplex-footer-sidebars']) ? $worplex_framework_options['worplex-footer-sidebars'] : '';
	$worplex_sidebars_switch = isset($worplex_framework_options['worplex-footer-sidebar-switch']) ? $worplex_framework_options['worplex-footer-sidebar-switch'] : '';
	
	if ($worplex_sidebars_switch == 'on' && isset($worplex_sidebars['col_width']) && is_array($worplex_sidebars['col_width']) && sizeof($worplex_sidebars['col_width']) > 0) {

		?>
        <div class="row">
            <?php
            $sidebar_counter = 0;
            foreach ($worplex_sidebars['col_width'] as $sidebar_col) {
                $sidebar = isset($worplex_sidebars['sidebar_name'][$sidebar_counter]) ? $worplex_sidebars['sidebar_name'][$sidebar_counter] : '';
                if ($sidebar != '') {
                    $sidebar_col_arr = explode('_', $sidebar_col);
                    $sidebar_col_class = isset($sidebar_col_arr[0]) && $sidebar_col_arr[0] != '' ? 'col-md-' . $sidebar_col_arr[0] : 'col-md-12';
                    $sidebar_id = sanitize_title($sidebar);
                    if (is_active_sidebar($sidebar_id)) {
                        ?>
                        <div class="<?php echo ($sidebar_col_class) ?> col-sm-6 col-xs-6">
                            <?php dynamic_sidebar($sidebar_id) ?>
                        </div>
                        <?php
                    }
                }
                $sidebar_counter++;
            }
            ?>
        </div>
		<?php
	}
}

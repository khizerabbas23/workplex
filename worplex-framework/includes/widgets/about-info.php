<?php
/*
 * widget for about us in footer
 */
if (!class_exists('Mediclf_about_Infos')) {

    class Mediclf_about_Infos extends WP_Widget
    {
        /**
         * Sets up a new mediclf   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'mediclf_about_infos',
                // Base ID.
                __('Logo & Desc', 'mediclf'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('About info widget for contact.', 'mediclf'))
            );
        }

        /**
         * Outputs the mediclf   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $mediclf_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            
            
            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $address = isset($instance['address']) ? esc_attr($instance['address']) : '';
            $braddress = isset($instance['braddress']) ? esc_attr($instance['braddress']) : '';
            $number = isset($instance['number']) ? esc_attr($instance['number']) : '';
            $brnumber = isset($instance['brnumber']) ? esc_attr($instance['brnumber']) : '';
            $fburl = isset($instance['fburl']) ? esc_attr($instance['fburl']) : '';
            $twturl = isset($instance['twturl']) ? esc_attr($instance['twturl']) : '';
            $ytburl = isset($instance['ytburl']) ? esc_attr($instance['ytburl']) : '';
            $instaurl = isset($instance['instaurl']) ? esc_attr($instance['instaurl']) : '';
            $linkdinurl = isset($instance['linkdinurl']) ? esc_attr($instance['linkdinurl']) : '';
          
 
            ?>
            <div class="mediclf-element-field text-widget-fields">
                 <p>
                    <label>
                        <?php esc_html_e('Logo', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('logo')) ?>" value="<?php echo ($logo) ?>">
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Address', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('address')) ?>" value="<?php echo ($address) ?>">
                </p>
               
                 <p>
                    <label>
                        <?php esc_html_e('Braddress', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('braddress')) ?>" value="<?php echo ($braddress) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Number', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('number')) ?>" value="<?php echo ($number) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Brnumber', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('brnumber')) ?>" value="<?php echo ($brnumber) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Fburl', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('fburl')) ?>" value="<?php echo ($fburl) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Twturl', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('twturl')) ?>" value="<?php echo ($twturl) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Ytburl', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('ytburl')) ?>" value="<?php echo ($ytburl) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Instaurl', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('instaurl')) ?>" value="<?php echo ($instaurl) ?>">
                </p>
                 <p>
                    <label>
                        <?php esc_html_e('Linkdinurl', 'mediclf') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('linkdinurl')) ?>" value="<?php echo ($linkdinurl) ?>">
                </p>
 
            </div>

        <?php
        }

        /**
         * Handles updating settings for the current mediclf   widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['logo'] = $new_instance['logo'];
            $instance['address'] = $new_instance['address'];
            $instance['braddress'] = $new_instance['braddress'];
            $instance['number'] = $new_instance['number'];
            $instance['brnumber'] = $new_instance['brnumber'];
            $instance['fburl'] = $new_instance['fburl'];
            $instance['twturl'] = $new_instance['twturl'];
            $instance['ytburl'] = $new_instance['ytburl'];
            $instance['instaurl'] = $new_instance['instaurl'];
            $instance['linkdinurl'] = $new_instance['linkdinurl'];
 
            return $instance;
        }

        /**
         * Outputs the content for the current mediclf   widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         * 'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current Text widget instance.
         */
        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));

            $logo = isset($instance['logo']) ? esc_attr($instance['logo']) : '';
            $address = isset($instance['address']) ? esc_attr($instance['address']) : '';
            $braddress = isset($instance['braddress']) ? esc_attr($instance['braddress']) : '';
            $number = isset($instance['number']) ? esc_attr($instance['number']) : '';
            $brnumber = isset($instance['brnumber']) ? esc_attr($instance['brnumber']) : '';
            $fburl = isset($instance['fburl']) ? esc_attr($instance['fburl']) : '';
            $twturl = isset($instance['twturl']) ? esc_attr($instance['twturl']) : '';
            $ytburl = isset($instance['ytburl']) ? esc_attr($instance['ytburl']) : '';
            $instaurl = isset($instance['instaurl']) ? esc_attr($instance['instaurl']) : '';
            $linkdinurl = isset($instance['linkdinurl']) ? esc_attr($instance['linkdinurl']) : '';
 

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget)
           

            ?>
         
             
             
								<div class="footer_widget">
									<img src=" <?php echo $logo ?>" class="img-footer small mb-2" alt="" />
									
									<div class="address mt-2">
										<?php echo $address ?><br><?php echo $braddress ?>	
									</div>
									<div class="address mt-3">
										<?php echo $number ?><br><?php echo $brnumber ?>
									</div>
									<div class="address mt-2">
										<ul class="list-inline">
											<li class="list-inline-item"><a href="<?php echo $fburl ?>" class="theme-cl"><i class="lni lni-facebook-filled"></i></a></li>
											<li class="list-inline-item"><a href="<?php echo $twturl ?>" class="theme-cl"><i class="lni lni-twitter-filled"></i></a></li>
											<li class="list-inline-item"><a href="<?php echo $ytburl ?>" class="theme-cl"><i class="lni lni-youtube"></i></a></li>
											<li class="list-inline-item"><a href="<?php echo $instaurl ?>" class="theme-cl"><i class="lni lni-instagram-filled"></i></a></li>
											<li class="list-inline-item"><a href="<?php echo $linkdinurl ?>" class="theme-cl"><i class="lni lni-linkedin-original"></i></a></li>
										</ul>
									</div>
									</div>
							
             
            <?php

            echo ($after_widget);
        }

    }

}
add_action('widgets_init', function () {
    return register_widget("mediclf_about_infos");
});
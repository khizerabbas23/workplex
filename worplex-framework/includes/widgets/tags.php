<?php
/*
 * widget for about us in footer
 */
if (!class_exists('Worplex_tags')) {

    class Worplex_tags extends WP_Widget
    {
        /**
         * Sets up a new base-frame   widget instance.
         */
        public function __construct()
        {
            parent::__construct(
                'Worplex_tags',
                // Base ID.
                __('Custom Tags', 'base-frame'),
                // Name.
                array('classname' => 'widget_footer_contact', 'description' => __('About info widget for contact.', 'base-frame'))
            );
        }

        /**
         * Outputs the base-frame   widget settings form.
         *
         * @param array $instance Current settings.
         */
        function form($instance)
        {

            global $base_frame_form_fields;

            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';



            ?>


            <div class="base-frame-element-field text-widget-fields">
                <p>
                    <label>
                        <?php esc_html_e('Post Heading', 'base-frame') ?>
                    </label>
                    <input type="text" name="<?php echo ($this->get_field_name('post_heading')) ?>"
                        value="<?php echo ($post_heading) ?>">
                </p>
         

            </div>

            <?php
        }

        /**
         * Handles updating settings for the current base-frame   widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;
            $instance['post_heading'] = $new_instance['post_heading'];

            return $instance;
        }

        /**
         * Outputs the content for the current base-frame   widget instance.
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

            $post_heading = isset($instance['post_heading']) ? esc_attr($instance['post_heading']) : '';

            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';

            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo ($before_widget);

            if ('' !== $title) {
                echo ($before_title) . esc_html($title) . ($after_title);
            }

            ?>
<div class="single_widgets widget_tags">
								<h4 class="title"><?php echo  $post_heading ?></h4>
								<ul>

 <?php
 $categories = get_terms([
    'taxonomy' => 'post_tag',
    'hide_empty' => false,
]);
  if ($categories) {
    foreach ($categories as $tag) {
        $term_link = get_term_link($tag);
  ?>
               <li><a href="<?php echo ($term_link) ?>"><?php echo $tag->name?></a></li><?php
               }
} 
  ?>
                                            
                           
                                    </ul>
							</div>
            <?php

            echo ($after_widget);
}       

}

}
add_action('widgets_init', function () {
    return register_widget("Worplex_tags");
});
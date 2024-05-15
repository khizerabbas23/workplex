<?php

class cstmfield_relationship extends cstmfield_field
{

    function __construct() {
        $this->name = 'relationship';
        $this->label = __( 'Relationship', 'worplex-frame' );
    }


    function html( $field ) {
        global $wpdb;

        $selected_posts = [];
        $available_posts = [];

        $post_types = [];
        if ( ! empty( $field->options['post_types'] ) ) {
            foreach ( $field->options['post_types'] as $type ) {
                $post_types[] = $type;
            }
        }
        else {
            $post_types = get_post_types( [ 'exclude_from_search' => true ] );
        }

        $args = [
            'post_type'         => $post_types,
            'post_status'       => [ 'publish', 'private' ],
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC'
        ];

        $args = apply_filters( 'cstmfield_field_relationship_query_args', $args, [ 'field' => $field ] );
        $query = new WP_Query( $args );

        foreach ( $query->posts as $post_obj ) {
            $post_title = ( 'private' == $post_obj->post_status ) ? '(Private) ' . $post_obj->post_title : $post_obj->post_title;
            $available_posts[] = (object) [
                'ID'            => $post_obj->ID,
                'post_type'     => $post_obj->post_type,
                'post_status'   => $post_obj->post_status,
                'post_title'    => $post_title,
            ];
        }

        if ( ! empty( $field->value ) ) {
            $results = $wpdb->get_results( "SELECT ID, post_status, post_title FROM $wpdb->posts WHERE ID IN ($field->value) ORDER BY FIELD(ID,$field->value)" );
            foreach ( $results as $result ) {
                $result->post_title = ( 'private' == $result->post_status ) ? '(Private) ' . $result->post_title : $result->post_title;
                $selected_posts[ $result->ID ] = $result;
            }
        }
    ?>
        <div class="filter_posts">
            <input type="text" class="cstmfield_filter_input" autocomplete="off" placeholder="<?php _e( 'Search posts', 'worplex-frame' ); ?>" />
        </div>

        <div class="available_posts post_list">
        <?php foreach ( $available_posts as $post ) : ?>
            <?php $class = ( isset( $selected_posts[ $post->ID ] ) ) ? ' class="used"' : ''; ?>
            <div rel="<?php echo $post->ID; ?>"<?php echo $class; ?> title="<?php echo $post->post_type; ?>"><?php echo apply_filters( 'cstmfield_relationship_display', $post->post_title, $post->ID, $field ); ?></div>
        <?php endforeach; ?>
        </div>

        <div class="selected_posts post_list">
        <?php foreach ( $selected_posts as $post ) : ?>
            <div rel="<?php echo $post->ID; ?>"><span class="remove"></span><?php echo apply_filters( 'cstmfield_relationship_display', $post->post_title, $post->ID, $field ); ?></div>
        <?php endforeach; ?>
        </div>
        <div class="clear"></div>
        <input type="hidden" name="<?php echo $field->input_name; ?>" class="<?php echo $field->input_class; ?>" value="<?php echo $field->value; ?>" />
    <?php
    }


    function options_html( $key, $field ) {
        $args = [ 'exclude_from_search' => false ];
        $choices = apply_filters( 'cstmfield_field_relationship_post_types', get_post_types( $args ) );

    ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e('Post Types', 'worplex-frame'); ?></label>
                <p class="description"><?php _e('Limit posts to the following types', 'worplex-frame'); ?></p>
            </td>
            <td>
                <?php
                    WORPLEX_CFS()->create_field( [
                        'type'          => 'select',
                        'input_name'    => "cstmfield[fields][$key][options][post_types]",
                        'options'       => [ 'multiple' => '1', 'choices' => $choices ],
                        'value'         => $this->get_option( $field, 'post_types' ),
                    ] );
                ?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Limits', 'worplex-frame' ); ?></label>
            </td>
            <td>
                <input type="text" name="cstmfield[fields][<?php echo $key; ?>][options][limit_min]" value="<?php echo $this->get_option( $field, 'limit_min' ); ?>" placeholder="min" style="width:60px" />
                <input type="text" name="cstmfield[fields][<?php echo $key; ?>][options][limit_max]" value="<?php echo $this->get_option( $field, 'limit_max' ); ?>" placeholder="max" style="width:60px" />
            </td>
        </tr>
    <?php
    }


    function input_head( $field = null ) {
    ?>
        <script>
        (function($) {
            update_relationship_values = function(field) {
                var post_ids = [];
                field.find('.selected_posts div').each(function(idx) {
                    post_ids[idx] = $(this).attr('rel');
                });
                field.find('input.relationship').val(post_ids.join(','));
            }

            $(function() {
                $(document).on('cstmfield/ready', '.cstmfield_add_field', function() {
                    $('.cstmfield_relationship:not(.ready)').init_relationship();
                });
                $('.cstmfield_relationship').init_relationship();

                // add selected post
                $(document).on('click', '.cstmfield_relationship .available_posts div', function() {
                    var parent = $(this).closest('.field');
                    var post_id = $(this).attr('rel');
                    var html = $(this).html();
                    $(this).addClass('used');
                    parent.find('.selected_posts').append('<div rel="'+post_id+'"><span class="remove"></span>'+html+'</div>');
                    update_relationship_values(parent);
                });

                // remove selected post
                $(document).on('click', '.cstmfield_relationship .selected_posts .remove', function() {
                    var div = $(this).parent();
                    var parent = div.closest('.field');
                    var post_id = div.attr('rel');
                    parent.find('.available_posts div[rel='+post_id+']').removeClass('used');
                    div.remove();
                    update_relationship_values(parent);
                });

                // filter posts
                $(document).on('keyup', '.cstmfield_relationship .cstmfield_filter_input', function() {
                    var input = $(this).val();
                    var parent = $(this).closest('.field');
                    var regex = new RegExp(input, 'i');
                    parent.find('.available_posts div:not(.used)').each(function() {
                        if (-1 < $(this).html().search(regex)) {
                            $(this).removeClass('hidden');
                        }
                        else {
                            $(this).addClass('hidden');
                        }
                    });
                });
            });

            $.fn.init_relationship = function() {
                this.each(function() {
                    var $this = $(this);
                    $this.addClass('ready');

                    // sortable
                    $this.find('.selected_posts').sortable({
                        axis: 'y',
                        update: function(event, ui) {
                            var parent = $(this).closest('.field');
                            update_relationship_values(parent);
                        }
                    });
                });
            }
        })(jQuery);
        </script>
    <?php
    }


    function prepare_value( $value, $field = null ) {
        return $value;
    }


    function format_value_for_input( $value, $field = null ) {
        return empty( $value ) ? '' : implode( ',', $value );
    }


    function pre_save( $value, $field = null ) {
        if ( ! empty( $value ) ) {

            // Inside a loop, the value is $value[0]
            $value = (array) $value;

            // The raw input saves a comma-separated string
            if ( false !== strpos( $value[0], ',' ) ) {
                return explode( ',', $value[0] );
            }

            return $value;
        }

        return [];
    }
}

<?php

class cstmfield_init
{

    function __construct() {
        add_action( 'init', [ $this, 'init' ] );
    }


    function init() {

        add_action( 'admin_head',                       [ $this, 'admin_head' ] );
        add_action( 'admin_menu',                       [ $this, 'admin_menu' ] );
        add_action( 'admin_footer',                     [ $this, 'show_credits' ] );
        add_action( 'save_post',                        [ $this, 'save_post' ] );
        add_action( 'delete_post',                      [ $this, 'delete_post' ] );
        add_action( 'add_meta_boxes',                   [ $this, 'add_meta_boxes' ] );
        add_action( 'wp_ajax_cstmfield_ajax_handler',         [ $this, 'ajax_handler' ] );
        add_filter( 'manage_cstmfield_posts_columns',         [ $this, 'cstmfield_columns' ] );
        add_action( 'manage_cstmfield_posts_custom_column',   [ $this, 'cstmfield_column_content' ], 10, 2 );

        include( WORPLEX_CFS_DIR . '/includes/api.php' );
        include( WORPLEX_CFS_DIR . '/includes/upgrade.php' );
        include( WORPLEX_CFS_DIR . '/includes/field.php' );
        include( WORPLEX_CFS_DIR . '/includes/field_group.php' );
        include( WORPLEX_CFS_DIR . '/includes/session.php' );
        include( WORPLEX_CFS_DIR . '/includes/form.php' );
        include( WORPLEX_CFS_DIR . '/includes/third_party.php' );
        include( WORPLEX_CFS_DIR . '/includes/revision.php' );


        $this->register_post_type();
        WORPLEX_CFS()->fields = $this->get_field_types();

        // WORPLEX_CFS is ready
        do_action( 'cstmfield_init' );
    }


    /**
     * Register the field group post type
     */
    function register_post_type() {
        register_post_type( 'cstmfield', [
            'public'            => false,
            'show_ui'           => true,
            'show_in_menu'      => 'options-general.php',
            'capability_type'   => 'page',
            'hierarchical'      => false,
            'supports'          => [ 'title' ],
            'query_var'         => false,
            'labels'            => [
                'name'                  => __( 'Field Groups', 'worplex-frame' ),
                'singular_name'         => __( 'Field Group', 'worplex-frame' ),
                'all_items'             => __( 'Worplex Custom Field', 'worplex-frame' ),
                'add_new_item'          => __( 'Add New Field Group', 'worplex-frame' ),
                'edit_item'             => __( 'Edit Field Group', 'worplex-frame' ),
                'new_item'              => __( 'New Field Group', 'worplex-frame' ),
                'view_item'             => __( 'View Field Group', 'worplex-frame' ),
                'search_items'          => __( 'Search Field Groups', 'worplex-frame' ),
                'not_found'             => __( 'No Field Groups found', 'worplex-frame' ),
                'not_found_in_trash'    => __( 'No Field Groups found in Trash', 'worplex-frame' ),
            ],
        ] );
    }


    /**
     * Register field types
     */
    function get_field_types() {

        // support custom field types
        $field_types = apply_filters( 'cstmfield_field_types', [
            'text'          => WORPLEX_CFS_DIR . '/includes/fields/text.php',
            'textarea'      => WORPLEX_CFS_DIR . '/includes/fields/textarea.php',
            'wysiwyg'       => WORPLEX_CFS_DIR . '/includes/fields/wysiwyg.php',
            'date'          => WORPLEX_CFS_DIR . '/includes/fields/date/date.php',
            'true_false'    => WORPLEX_CFS_DIR . '/includes/fields/true_false.php',
            'select'        => WORPLEX_CFS_DIR . '/includes/fields/select.php',
        ] );

        foreach ( $field_types as $type => $path ) {
            $class_name = 'cstmfield_' . $type;

            // allow for multiple classes per file
            if ( ! class_exists( $class_name ) ) {
                include_once( $path );
            }

            $field_types[ $type ] = new $class_name();
        }

        return $field_types;
    }


    /**
     * admin_head
     */
    function admin_head() {
        $screen = get_current_screen();

        if ( is_object( $screen ) && 'post' == $screen->base ) {
            include( WORPLEX_CFS_DIR . '/templates/admin_head.php' );
        }
    }


    /**
     * show_credits
     */
    function show_credits() {
        $screen = get_current_screen();

        if ( 'edit' == $screen->base && 'cstmfield' == $screen->post_type ) {
            include( WORPLEX_CFS_DIR . '/templates/credits.php' );
        }
    }

    /**
    * admin_menu
    */
    function admin_menu() {
        if ( false === apply_filters( 'cstmfield_disable_admin', false ) ) {
            add_submenu_page( 'tools.php', __( 'Custom Fields Tools', 'worplex-frame' ), __( 'Custom Fields Tools', 'worplex-frame' ), 'manage_options', 'cstmfield-tools', [ $this, 'page_tools' ] );
        }
    }

    /**
     * add_meta_boxes
     */
    function add_meta_boxes() {
        add_meta_box( 'cstmfield_fields', __('Fields', 'worplex-frame'), [ $this, 'meta_box' ], 'cstmfield', 'normal', 'high', [ 'box' => 'fields' ] );
        add_meta_box( 'cstmfield_rules', __('Placement Rules', 'worplex-frame'), [ $this, 'meta_box' ], 'cstmfield', 'normal', 'high', [ 'box' => 'rules' ] );
        add_meta_box( 'cstmfield_extras', __('Extras', 'worplex-frame'), [ $this, 'meta_box' ], 'cstmfield', 'normal', 'high', [ 'box' => 'extras' ] );
    }


    /**
     * meta_box
     * @param object $post
     * @param array $metabox
     */
    function meta_box( $post, $metabox ) {
        $box = $metabox['args']['box'];
        include( WORPLEX_CFS_DIR . "/templates/meta_box_$box.php" );
    }


    /**
     * page_tools
     */
    function page_tools() {
        include( WORPLEX_CFS_DIR . '/templates/page_tools.php' );
    }


    /**
     * save_post
     */
    function save_post( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! isset( $_POST['cstmfield']['save'] ) ) {
            return;
        }

        if ( false !== wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( wp_verify_nonce( $_POST['cstmfield']['save'], 'cstmfield_save_fields' ) ) {
            $fields = isset( $_POST['cstmfield']['fields'] ) ? $_POST['cstmfield']['fields'] : [];
            $rules = isset( $_POST['cstmfield']['rules'] ) ? $_POST['cstmfield']['rules'] : [];
            $extras = isset( $_POST['cstmfield']['extras'] ) ? $_POST['cstmfield']['extras'] : [];

            WORPLEX_CFS()->field_group->save( [
                'post_id'   => $post_id,
                'fields'    => $fields,
                'rules'     => $rules,
                'extras'    => $extras,
            ] );
        }
    }


    /**
     * delete_post
     * @return boolean
     */
    function delete_post( $post_id ) {
        global $wpdb;

        if ( 'cstmfield' != get_post_type( $post_id ) ) {
            $post_id = (int) $post_id;
            $wpdb->query( "DELETE FROM {$wpdb->prefix}cstmfield_values WHERE post_id = $post_id" );
        }

        return true;
    }


    /**
     * ajax_handler
     */
    function ajax_handler() {
        if ( ! current_user_can( 'manage_options' ) ) {
            exit;
        }

        if ( ! check_ajax_referer( 'cstmfield_admin_nonce', 'nonce', false ) ) {
            exit;
        }

        $ajax_method = isset( $_POST['action_type'] ) ? $_POST['action_type'] : false;

        if ( $ajax_method && is_admin() ) {
            include( WORPLEX_CFS_DIR . '/includes/ajax.php' );
            $ajax = new cstmfield_ajax();

            if ( 'import' == $ajax_method ) {
                $options = [
                    'import_code' => json_decode( stripslashes( $_POST['import_code'] ), true ),
                ];
                echo WORPLEX_CFS()->field_group->import( $options );
            }
            elseif ('export' == $ajax_method) {
                echo json_encode( WORPLEX_CFS()->field_group->export( $_POST ) );
            }
            elseif ('reset' == $ajax_method) {
                $ajax->reset();
                deactivate_plugins( plugin_basename( __FILE__ ) );
                echo admin_url( 'plugins.php' );
            }
            elseif ( method_exists( $ajax, $ajax_method ) ) {
                echo $ajax->$ajax_method( $_POST );
            }
        }

        exit;
    }


    /**
     * Customize table columns on the Field Group listing
     */
    function cstmfield_columns() {
        return [
            'cb'            => '<input type="checkbox" />',
            'title'         => __( 'Title', 'worplex-frame' ),
            'placement'     => __( 'Placement', 'worplex-frame' ),
        ];
    }


    /**
     * Populate the "Placement" column on the Field Group listing
     */
    function cstmfield_column_content( $column_name, $post_id ) {
        if ( 'placement' == $column_name ) {
            global $wpdb;

            $labels = [
                'post_types'        => __( 'Post Types', 'worplex-frame' ),
                //'user_roles'        => __( 'User Roles', 'worplex-frame' ),
                //'post_ids'          => __( 'Posts', 'worplex-frame' ),
                //'term_ids'          => __( 'Term IDs', 'worplex-frame' ),
                //'page_templates'    => __( 'Page Templates', 'worplex-frame' ),
                //'post_formats'      => __( 'Post Formats', 'worplex-frame' )
            ];

            $field_groups = WORPLEX_CFS()->field_group->load_field_groups();

            // Make sure the field group exists
            $rules = [];
            if ( isset( $field_groups[ $post_id ] ) ) {
                $rules = $field_groups[ $post_id ]['rules'];
            }

            foreach ( $rules as $criteria => $data ) {
                $label = $labels[ $criteria ];
                $values = $data['values'];
                $operator = ( '==' == $data['operator'] ) ? '=' : '!=';

                // Get post titles
                if ( 'post_ids' == $criteria ) {
                    $temp = [];
                    foreach ( $values as $val ) {
                        $temp[] = get_the_title( (int) $val );
                    }
                    $values = $temp;
                }

                echo "<div><strong>$label</strong> " . $operator . ' ' . esc_html( implode( ', ', $values ) ) . '</div>';
            }
        }
    }
}

new cstmfield_init();

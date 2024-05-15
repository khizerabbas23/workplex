<?php  

// Register Custom Sectors
function worplex_lited_post_type() {

	$labels = array(
		'name'                  => _x( 'Jobs', 'Jobs General Name', 'worplex' ),
		'singular_name'         => _x( 'Jobs', 'Jobs Singular Name', 'worplex' ),
		'menu_name'             => __( 'Jobs', 'worplex' ),
		'name_admin_bar'        => __( 'Jobs', 'worplex' ),
		'archives'              => __( 'Item Archives', 'worplex' ),
		'attributes'            => __( 'Item Attributes', 'worplex' ),
		'parent_item_colon'     => __( 'Parent Item:', 'worplex' ),
		'all_items'             => __( 'All Items', 'worplex' ),
		'add_new_item'          => __( 'Add New Item', 'worplex' ),
		'add_new'               => __( 'Add New', 'worplex' ),
		'new_item'              => __( 'New Item', 'worplex' ),
		'edit_item'             => __( 'Edit Item', 'worplex' ),
		'update_item'           => __( 'Update Item', 'worplex' ),
		'view_item'             => __( 'View Item', 'worplex' ),
		'view_items'            => __( 'View Items', 'worplex' ),
		'search_items'          => __( 'Search Item', 'worplex' ),
		'not_found'             => __( 'Not found', 'worplex' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'worplex' ),
		'featured_image'        => __( 'Featured Image', 'worplex' ),
		'set_featured_image'    => __( 'Set featured image', 'worplex' ),
		'remove_featured_image' => __( 'Remove featured image', 'worplex' ),
		'use_featured_image'    => __( 'Use as featured image', 'worplex' ),
		'insert_into_item'      => __( 'Insert into item', 'worplex' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'worplex' ),
		'items_list'            => __( 'Items list', 'worplex' ),
		'items_list_navigation' => __( 'Items list navigation', 'worplex' ),
		'filter_items_list'     => __( 'Sectors items list', 'worplex' ),
	);
	$args = array(
		'label'                 => __( 'Jobs', 'worplex' ),
		'description'           => __( 'Jobs Description', 'worplex' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'jobs', $args );

}
add_action( 'init', 'worplex_lited_post_type', 0 );

// taxonomy


// Register Custom Filters


function popular_listed_job_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Skills', 'Filters General Name', 'worplex' ),
		'singular_name'              => _x( 'Skills', 'Filters Singular Name', 'worplex' ),
		'menu_name'                  => __( 'Skills', 'worplex' ),
		'all_items'                  => __( 'All Items', 'worplex' ),
		'parent_item'                => __( 'Parent Item', 'worplex' ),
		'parent_item_colon'          => __( 'Parent Item:', 'worplex' ),
		'new_item_name'              => __( 'New Item Name', 'worplex' ),
		'add_new_item'               => __( 'Add New Item', 'worplex' ),
		'edit_item'                  => __( 'Edit Item', 'worplex' ),
		'update_item'                => __( 'Update Item', 'worplex' ),
		'view_item'                  => __( 'View Item', 'worplex' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'worplex' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'worplex' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'worplex' ),
		'popular_items'              => __( 'Popular Items', 'worplex' ),
		'search_items'               => __( 'Search Items', 'worplex' ),
		'not_found'                  => __( 'Not Found', 'worplex' ),
		'no_terms'                   => __( 'No items', 'worplex' ),
		'items_list'                 => __( 'Items list', 'worplex' ),
		'items_list_navigation'      => __( 'Items list navigation', 'worplex' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'job_skill', array( 'jobs' ), $args );

}
add_action( 'init', 'popular_listed_job_taxonomy', 0 );

// Pop Top Categories Taxonomy

function popular_top_categories_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Job Categories', 'Category General Name', 'worplex' ),
		'singular_name'              => _x( 'Job Categories', 'Category Singular Name', 'worplex' ),
		'menu_name'                  => __( 'Job Categories', 'worplex' ),
		'all_items'                  => __( 'All Items', 'worplex' ),
		'parent_item'                => __( 'Parent Item', 'worplex' ),
		'parent_item_colon'          => __( 'Parent Item:', 'worplex' ),
		'new_item_name'              => __( 'New Item Name', 'worplex' ),
		'add_new_item'               => __( 'Add New Item', 'worplex' ),
		'edit_item'                  => __( 'Edit Item', 'worplex' ),
		'update_item'                => __( 'Update Item', 'worplex' ),
		'view_item'                  => __( 'View Item', 'worplex' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'worplex' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'worplex' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'worplex' ),
		'popular_items'              => __( 'Popular Items', 'worplex' ),
		'search_items'               => __( 'Search Items', 'worplex' ),
		'not_found'                  => __( 'Not Found', 'worplex' ),
		'no_terms'                   => __( 'No items', 'worplex' ),
		'items_list'                 => __( 'Items list', 'worplex' ),
		'items_list_navigation'      => __( 'Items list navigation', 'worplex' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'job_category', array( 'jobs' ), $args );

}
add_action( 'init', 'popular_top_categories_taxonomy', 0 );
// Our Team 


// top cvandidaTESA

function worplex_candidates_post_type() {

	$labels = array(
		'name'                  => _x( 'Candidate', 'Candidate General Name', 'worplex' ),
		'singular_name'         => _x( 'Candidate', 'Candidate Singular Name', 'worplex' ),
		'menu_name'             => __( 'Candidate', 'worplex' ),
		'name_admin_bar'        => __( 'Candidate', 'worplex' ),
		'archives'              => __( 'Item Archives', 'worplex' ),
		'attributes'            => __( 'Item Attributes', 'worplex' ),
		'parent_item_colon'     => __( 'Parent Item:', 'worplex' ),
		'all_items'             => __( 'All Items', 'worplex' ),
		'add_new_item'          => __( 'Add New Item', 'worplex' ),
		'add_new'               => __( 'Add New', 'worplex' ),
		'new_item'              => __( 'New Item', 'worplex' ),
		'edit_item'             => __( 'Edit Item', 'worplex' ),
		'update_item'           => __( 'Update Item', 'worplex' ),
		'view_item'             => __( 'View Item', 'worplex' ),
		'view_items'            => __( 'View Items', 'worplex' ),
		'search_items'          => __( 'Search Item', 'worplex' ),
		'not_found'             => __( 'Not found', 'worplex' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'worplex' ),
		'featured_image'        => __( 'Featured Image', 'worplex' ),
		'set_featured_image'    => __( 'Set featured image', 'worplex' ),
		'remove_featured_image' => __( 'Remove featured image', 'worplex' ),
		'use_featured_image'    => __( 'Use as featured image', 'worplex' ),
		'insert_into_item'      => __( 'Insert into item', 'worplex' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'worplex' ),
		'items_list'            => __( 'Items list', 'worplex' ),
		'items_list_navigation' => __( 'Items list navigation', 'worplex' ),
		'filter_items_list'     => __( 'Sectors items list', 'worplex' ),
	);
	$args = array(
		'label'                 => __( 'Candidate', 'worplex' ),
		'description'           => __( 'Candidate Description', 'worplex' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'candidates', $args );

}
add_action( 'init', 'worplex_candidates_post_type', 0 );

// taxonomy
 // taxonomy Condidate 

function candidate_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Categories General Name', 'worplex' ),
		'singular_name'              => _x( 'Categories', 'Categories Singular Name', 'worplex' ),
		'menu_name'                  => __( 'Categories', 'worplex' ),
		'all_items'                  => __( 'All Items', 'worplex' ),
		'parent_item'                => __( 'Parent Item', 'worplex' ),
		'parent_item_colon'          => __( 'Parent Item:', 'worplex' ),
		'new_item_name'              => __( 'New Item Name', 'worplex' ),
		'add_new_item'               => __( 'Add New Item', 'worplex' ),
		'edit_item'                  => __( 'Edit Item', 'worplex' ),
		'update_item'                => __( 'Update Item', 'worplex' ),
		'view_item'                  => __( 'View Item', 'worplex' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'worplex' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'worplex' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'worplex' ),
		'popular_items'              => __( 'Popular Items', 'worplex' ),
		'search_items'               => __( 'Search Items', 'worplex' ),
		'not_found'                  => __( 'Not Found', 'worplex' ),
		'no_terms'                   => __( 'No items', 'worplex' ),
		'items_list'                 => __( 'Items list', 'worplex' ),
		'items_list_navigation'      => __( 'Items list navigation', 'worplex' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'candidate_cat', array( 'candidates' ), $args );

	//
	$labels = array(
		'name'                       => _x( 'Categories', 'Categories General Name', 'worplex' ),
		'singular_name'              => _x( 'Categories', 'Categories Singular Name', 'worplex' ),
		'menu_name'                  => __( 'Categories', 'worplex' ),
		'all_items'                  => __( 'All Items', 'worplex' ),
		'parent_item'                => __( 'Parent Item', 'worplex' ),
		'parent_item_colon'          => __( 'Parent Item:', 'worplex' ),
		'new_item_name'              => __( 'New Item Name', 'worplex' ),
		'add_new_item'               => __( 'Add New Item', 'worplex' ),
		'edit_item'                  => __( 'Edit Item', 'worplex' ),
		'update_item'                => __( 'Update Item', 'worplex' ),
		'view_item'                  => __( 'View Item', 'worplex' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'worplex' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'worplex' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'worplex' ),
		'popular_items'              => __( 'Popular Items', 'worplex' ),
		'search_items'               => __( 'Search Items', 'worplex' ),
		'not_found'                  => __( 'Not Found', 'worplex' ),
		'no_terms'                   => __( 'No items', 'worplex' ),
		'items_list'                 => __( 'Items list', 'worplex' ),
		'items_list_navigation'      => __( 'Items list navigation', 'worplex' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'employer_cat', array( 'employer' ), $args );

	//
	$labels = array(
		'name'                       => _x( 'Skills', 'Skills General Name', 'worplex' ),
		'singular_name'              => _x( 'Skills', 'Skills Singular Name', 'worplex' ),
		'menu_name'                  => __( 'Skills', 'worplex' ),
		'all_items'                  => __( 'All Items', 'worplex' ),
		'parent_item'                => __( 'Parent Item', 'worplex' ),
		'parent_item_colon'          => __( 'Parent Item:', 'worplex' ),
		'new_item_name'              => __( 'New Item Name', 'worplex' ),
		'add_new_item'               => __( 'Add New Item', 'worplex' ),
		'edit_item'                  => __( 'Edit Item', 'worplex' ),
		'update_item'                => __( 'Update Item', 'worplex' ),
		'view_item'                  => __( 'View Item', 'worplex' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'worplex' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'worplex' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'worplex' ),
		'popular_items'              => __( 'Popular Items', 'worplex' ),
		'search_items'               => __( 'Search Items', 'worplex' ),
		'not_found'                  => __( 'Not Found', 'worplex' ),
		'no_terms'                   => __( 'No items', 'worplex' ),
		'items_list'                 => __( 'Items list', 'worplex' ),
		'items_list_navigation'      => __( 'Items list navigation', 'worplex' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'candidate_skill', array( 'candidates' ), $args );

}
add_action( 'init', 'candidate_taxonomy', 0 );



// Employee  Post Type 
function worplex_employee_type() {

	$labels = array(
		'name'                  => _x( 'Employer', 'Employers General Name', 'worplex' ),
		'singular_name'         => _x( 'Employer', 'Employers Singular Name', 'worplex' ),
		'menu_name'             => __( 'Employer', 'worplex' ),
		'name_admin_bar'        => __( 'Employer', 'worplex' ),
		'archives'              => __( 'Item Archives', 'worplex' ),
		'attributes'            => __( 'Item Attributes', 'worplex' ),
		'parent_item_colon'     => __( 'Parent Item:', 'worplex' ),
		'all_items'             => __( 'All Items', 'worplex' ),
		'add_new_item'          => __( 'Add New Item', 'worplex' ),
		'add_new'               => __( 'Add New', 'worplex' ),
		'new_item'              => __( 'New Item', 'worplex' ),
		'edit_item'             => __( 'Edit Item', 'worplex' ),
		'update_item'           => __( 'Update Item', 'worplex' ),
		'view_item'             => __( 'View Item', 'worplex' ),
		'view_items'            => __( 'View Items', 'worplex' ),
		'search_items'          => __( 'Search Item', 'worplex' ),
		'not_found'             => __( 'Not found', 'worplex' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'worplex' ),
		'featured_image'        => __( 'Featured Image', 'worplex' ),
		'set_featured_image'    => __( 'Set featured image', 'worplex' ),
		'remove_featured_image' => __( 'Remove featured image', 'worplex' ),
		'use_featured_image'    => __( 'Use as featured image', 'worplex' ),
		'insert_into_item'      => __( 'Insert into item', 'worplex' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'worplex' ),
		'items_list'            => __( 'Items list', 'worplex' ),
		'items_list_navigation' => __( 'Items list navigation', 'worplex' ),
		'filter_items_list'     => __( 'Sectors items list', 'worplex' ),
	);
	$args = array(
		'label'                 => __( 'Employers', 'worplex' ),
		'description'           => __( 'Employers Description', 'worplex' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'employer', $args );

}
add_action( 'init', 'worplex_employee_type', 0 );


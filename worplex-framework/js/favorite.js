function enqueue_favorite_script() {
    wp_enqueue_script( 'favorite-script', get_template_directory_uri() . '/js/favorite.js', array( 'jquery', 'wp-ajax' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_favorite_script' );

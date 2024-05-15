<?php

add_filter('worplex_posts_item_content_markup', function () {
    ob_start();
    ?>
    <div <?php post_class(); ?>>
        <div>
            <?php echo get_the_date() ?>
        </div>
        <?php
        if (has_post_thumbnail()) {
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'medium');
            $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
            if ($post_thumbnail_src != '') {
                ?>
                <div class="worplex-post-thumb">
                    <img src="<?php echo esc_url($post_thumbnail_src) ?>" alt="<?php the_title() ?>">
                </div>
                <?php
            }
        }
        ?>
        <div class="item-excerpt-content">
            <?php
            the_excerpt();
            ?>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
});

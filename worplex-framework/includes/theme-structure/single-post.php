<?php

add_filter('worplex_single_post_page_markup', function () {
    ob_start();
    ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
        if (has_post_thumbnail()) {
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'large');
            $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
            
$comment_count = get_comments_number(get_the_ID());
$author_id = get_post_field('post_author', get_the_ID());
$author_name = get_the_author_meta('display_name', $author_id);
$author_id = get_the_author_meta('ID');
$user_bio = get_the_author_meta('description', $author_id);
            if ($post_thumbnail_src != '') {
                ?>
                <div class="single_article_wrap ">
                    <img src="<?php echo esc_url($post_thumbnail_src) ?>" alt="<?php the_title() ?>">
                </div>
                <?php
            }
        }
        ?>
       
							<div class="article_detail_wrapss single_article_wrap format-standard">
								<div class="article_body_wrap">
								
									<div class="article_featured_image">
										<?php  echo get_avatar( $author_id,96);?>
									</div>
									
									<div class="article_top_info">
										<ul class="article_middle_info">
											<li><a href="#"><span class="icons"><i class="ti-user"></i></span>by <?php echo $author_name ?></a></li>
											<li><a href="#"><span class="icons"><i class="ti-comment-alt"></i></span> <?php echo $comment_count ?> Comments</a></li>
										</ul>
									</div>
									<h2 class="post-title"><?php echo get_the_title() ?></h2>
									<p><?php echo get_the_content() ?></p>
								</div>
							</div>
							
							<!-- Author Detail -->
							<div class="article_detail_wrapss single_article_wrap format-standard">
								
								<div class="article_posts_thumb">
									<span class="img"><?php echo get_avatar( $author_id,115); ?></span>
									<h3 class="pa-name"><?php echo $author_name ?></h3>
									<ul class="social-links">
										<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
										<li><a href="#"><i class="fab fa-twitter"></i></a></li>
										<li><a href="#"><i class="fab fa-behance"></i></a></li>
										<li><a href="#"><i class="fab fa-youtube"></i></a></li>
										<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
									</ul>
									<p class="pa-text"><?php echo $user_bio ?></p>
								</div>
								
							</div>
							
							
							
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        
        ?>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
});

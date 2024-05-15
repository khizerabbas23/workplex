<?php

add_filter('worplex_comments_form_markup', function () {
    ob_start();
    ?>
  <div class="blog-page">
        <div class="article_detail_wrapss single_article_wrap format-standard">
            <div class="comment-area">
				<div class="all-comments">
 

    	<?php
    	/**
    	 * worplex_inside_comments hook.
    	 *
    	 */
    	do_action( 'worplex_inside_comments' );
    
    	if ( have_comments() ) :

    		$comments_number = get_comments_number();
    		$comments_title = apply_filters(
    			'worplex_comment_form_title',
    			sprintf(
    				esc_html(
    					/* translators: 1: number of comments, 2: post title */
    					_nx(
    						'%1$s Comments ',
    						'%1$s Comments',
    						$comments_number,
    						'comments title',
    						'worplex'
    					)
    				),
    				number_format_i18n( $comments_number ),
    				get_the_title()
    			)
    		);
    
    		// phpcs:ignore -- Title escaped in output.
    		echo apply_filters(
    			'worplex_comments_title_output',
    			sprintf(
    				'<h3 class="comments-title">%s</h3>',
    				esc_html( $comments_title )
    			),
    			$comments_title,
    			$comments_number
    		);
    
    		/**
    		 * worplex_below_comments_title hook.
    		 *
    		 */
    		do_action( 'worplex_below_comments_title' );
    
    		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    			?>
    			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
    				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'worplex' ); ?></h2>
    				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'worplex' ) ); ?></div>
    				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'worplex' ) ); ?></div>
    			</nav><!-- #comment-nav-above -->
    		<?php endif; ?>
    		
    <div class="comment-list">
    		<ul>
    		   
    			<?php
    			/*
    			 * Loop through and list the comments. Tell wp_list_comments()
    			 * to use worplex_comment() to format the comments.
    			 * If you want to override this in a child theme, then you can
    			 * define worplex_comment() and that will be used instead.
    			 * See worplex_comment() in inc/template-tags.php for more.
    			 */
    			wp_list_comments(
    				array(
    					'callback' => 'worplex_comments_html',
    				)
    			);
    			?>
    		</ul><!-- .comment-list -->
    </div>
    		<?php
    		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    			?>
    			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
    				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'worplex' ); ?></h2>
    				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'worplex' ) ); ?></div>
    				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'worplex' ) ); ?></div>
    			</nav><!-- #comment-nav-below -->
    			<?php
    		endif;
    
    	endif;
    
    	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
    	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    		?>
    		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'worplex' ); ?></p>
    		<?php
    	endif;
   
        $defaults = array(
            
            'title_reply' => '
            <div class="section-details section-comments">
            <header class="section-head">
                                    <i class="icon icon-Typing"></i>
                                    <h4 class="text-uppercase">'.esc_html__('YOUR COMMENTS','worplex-frame').'</h4>
                                </header>',
            'title_reply_before' => '<div class="adhividayam-title"><h2>',
            'title_reply_after' => '</h2></div>',
            'comment_notes_before' => '',
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '
				<div class="row">
                <div class="col-12 col-md-6">
				<div class="input-holder">
                <div class="input-frame">
                <input class="form-control form-control-sm" placeholder="' . esc_html__('Your Name', 'worplex') . '" required type="text" tabindex="1">
                ' .
                '</div>'.
                '</div>'.
                '</div>',

                'email' => '' .
                '<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
                <label></label>
                <input id="email" name="email" class="form-control" type="text" placeholder="' . esc_html__('Enter Your Email', 'adhividayam') . '" required tabindex="2">
                ' .
				'</div>'.
                '</div>'.
                '</div>',


                    )
            ),
            'comment_field' => '
            <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
                <label></label>
                <textarea id="comment" name="comment" class=" form-control adhividayam-textarea" placeholder="' . esc_html__('Type Your Comment', 'adhividayam') . '"></textarea>
            </div>
            </div>
            </div>',



			'submit_button' => '
			<div class="row">
			<div class="btn-block pt-xl-10">
				<button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
			</div>
			</div>'


        );
    	comment_form($defaults, get_the_id());
    	?>
    
    </div>
    </div>
    </div>
    </div>
		
    <?php
    $html = ob_get_clean();
    return $html;
});

function worplex_comments_html($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $wpdb;

	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = '<i class="adhicon adhicon-share"></i> ' . esc_html__('Reply to this comment', 'adhividayam') . '';
	$args['after'] = '';
	$_comment_type = $comment->comment_type;

	switch ($_comment_type) {
		case ($_comment_type == '' || $_comment_type == 'comment') :

			$comment_time = strtotime($comment->comment_date);

			$get_author = get_comment_author();
			$author_obj = get_user_by('login', $get_author);
			?>
		

			<li <?php comment_class('article_comments_wrap'); ?> id="li-comment-<?php comment_ID(); ?>">
			    		<article>					
													
															<?php
						$avatar_link = get_avatar_url($comment, array('size' => 83));
						if (@getimagesize($avatar_link)) {
							$avatar_link = $avatar_link;
						} else {
							$avatar_link = get_template_directory_uri() . '/images/default_avatar.jpg';
						}
						?>
			
						<div class="article_comments_thumb">
						<img src="<?php echo esc_url_raw($avatar_link); ?>" alt="">
						</div>
						<div class="comment-details">
							<div class="comment-meta">
								<div class="comment-left-meta">
									<h4 class="author-name"><?php comment_author(); ?></h4>
									<div class="comment-date"><time datetime="2016-10-10"><a> <?php echo date_i18n(get_option('date_format'), strtotime($comment->comment_date)) ?></a></time></div>
								</div>
								<div class="comment-reply">
									<a href="#" class="reply"><span class="icons"><i class="ti-back-left"></i></span> <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'reply_text' => __('<i class="adhicon adhicon-mail-reply"></i> Reply', 'adhividayam'),))); ?></a>
								</div>
							</div>
							<div class="comment-text">
								<p><?php comment_text(); ?></p>
							</div>
						</div>
					</article>
																
														
						
						
				
			<?php
			break;
		case 'pingback' :
		case 'trackback' :
			?>
			<li class="post pingback">
			<p><?php comment_author_link(); ?><?php edit_comment_link(esc_html__('Edit Comment', 'adhividayam'), ' '); ?></p>
			<?php
			break;
	}
}

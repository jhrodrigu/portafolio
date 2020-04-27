<?php get_header(); ?>
    <section id="main">
        <?php get_template_part('lib/sub-header'); ?>
        <div class="single-blog-style"> 
            <div class="container single-wrapper-content mythos">
                <div class="row mythos-row">
                    <div id="content" class="site-content col-md-12 blog-content-wrapper thos-wrap" role="main">
                        
                        <?php if ( have_posts() ) :  ?> 
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>   
                            <?php endwhile; ?>    
                        <?php else: ?>
                            <?php get_template_part( 'post-format/content', 'none' ); ?>
                        <?php endif; ?>

                        <?php 

                            if ( get_theme_mod( 'blog_comment_single', true ) ) {
                                if ( comments_open() || get_comments_number() ) { ?>
                                    <div class="blog-comments-section">  
                                    <?php comments_template();?>
                                    </div>
                                <?php }
                            }  
                        ?>

                        <!-- Related post -->
                        <?php get_template_part( 'lib/related-post', 'none' ); ?>
                        <!-- End Post -->
                        
                    </div> <!-- #content -->
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div> <!-- .single-blog-style -->
    </section> <!-- #main -->
<?php get_footer();


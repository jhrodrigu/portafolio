<?php get_header(); ?>
<?php get_template_part('lib/sub-header'); ?>

<section id="main">
    <div class="container blog-full-container">

        <div class="row">
            <div id="content" class="site-content col-sm-8" role="main">
                <?php
                $mythos_index = 1;
                $mythos_col = get_theme_mod( 'blog_column', 12 );
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        if ( $mythos_index == '1' ) { ?>
                            <div class="row">
                        <?php }?>
                            <div class="col-md-<?php echo esc_attr($mythos_col);?>">
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                            </div>
                        <?php if ( $mythos_index == (12/esc_attr($mythos_col) )) { ?>
                            </div><!--/row-->
                        <?php $mythos_index = 1;
                        }else{
                            $mythos_index++;   
                        }  
                    endwhile;
                else:
                    get_template_part( 'post-format/content', 'none' );
                endif;
                if($mythos_index !=  1 ){ ?>
                   </div><!--/row-->
                <?php } ?>
                <?php
                    $mythos_page_numb = max( 1, get_query_var('paged') );
                    $mythos_max_page = $wp_query->max_num_pages;
                    if($mythos_max_page>=2){
                        echo wp_kses_post(mythos_pagination( $mythos_page_numb, $mythos_max_page ));  
                    } 
                ?>
            </div>
            <?php get_sidebar();?>
        </div> <!-- .row -->
    </div><!-- .container -->
</section> 

<?php get_footer();
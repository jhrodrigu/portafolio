<?php $mythos_col = get_theme_mod( 'bottom_column', 3 ); ?>
<div id="bottom-wrap"  class="footer"> 
    <div class="container">
        <div class="row clearfix border-wrap">
            <?php if (is_active_sidebar('bottom1')):?>
                <div class="btn-padding col-sm-6 col-md-6 col-lg-<?php echo esc_attr($mythos_col);?>">
                    <?php dynamic_sidebar('bottom1'); ?>
                </div>
            <?php endif; ?> 
            <?php if (is_active_sidebar('bottom2')):?>
                <div class="btn-padding col-sm-6 col-md-6 col-lg-<?php echo esc_attr($mythos_col);?>">
                    <?php dynamic_sidebar('bottom2'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('bottom3')):?>
                <div class="btn-padding col-sm-6 col-md-6 col-lg-<?php echo esc_attr($mythos_col);?>">
                    <?php dynamic_sidebar('bottom3'); ?>
                </div>  
            <?php endif; ?>  
            <?php if (is_active_sidebar('bottom4')):?>                 
                <div class="btn-padding col-sm-6 col-md-6 col-lg-<?php echo esc_attr($mythos_col);?>">
                    <?php dynamic_sidebar('bottom4'); ?>
                </div>
            <?php endif; ?>  
        </div>
    </div>
</div><!--/#bottom-wrap-->


    <?php if ( get_theme_mod( 'footer_en', true )) { ?>
        <footer id="footer-wrap"> 
            <div class="container">
                <div class="row clearfix">
                    <?php if ( get_theme_mod( 'copyright_en', true )) { ?>

                        <?php if (get_theme_mod( 'bottom_footer_menu', true ) ) { ?>
                        <div class="col-sm-12 text-sm-center text-md-left col-md-6">
                        <?php } else{?>
                        <div class="col-sm-12 col-md-12 text-center">
                        <?php }?>
                            <div class="footer-copyright">
                                <?php $mythos_footer_logo = get_theme_mod( 'footer_logo', false );
                                    if( !empty($mythos_footer_logo) ) { ?>
                                        <img class="enter-logo img-responsive" src="<?php echo esc_url( $mythos_footer_logo ); ?>" alt="<?php esc_html_e( 'Logo', 'mythos' ); ?>" title="<?php esc_html_e( 'Logo', 'mythos' ); ?>"> 
                                <?php } ?>

                                <?php if( get_theme_mod( 'copyright_en', true ) ) { ?>
                                    <?php echo wp_kses_post( get_theme_mod( 'copyright_text', '2019 Mythos. All Rights Reserved.')); ?>
                                <?php } ?>
                            </div> <!-- col-md-6 -->
                        </div> <!-- end footer-copyright -->
                    <?php } ?>   

                    <?php if ( get_theme_mod( 'theme_design', true )) { ?>
                        <?php if( get_theme_mod( 'copyright_en', true ) ) { ?>
                        <div class="col-sm-12 col-md-6 text-right">
                        <?php }else{ ?>
                        <div class="col-sm-12 col-md-12 text-center">
                        <?php } ?>
                            <?php if ( get_theme_mod( 'theme_design', true )) { ?>
                                <span class="footer-theme-design"><?php echo wp_kses_post( get_theme_mod( 'theme_design', 'Design & Development by Themeum.') ); ?></span>
                            <?php } ?>  
                        </div>
                    <?php } ?>   
                    
                </div><!--/.row clearfix-->    
            </div><!--/.container-->    
        </footer><!--/#footer-wrap-->    
    <?php } ?>

    </div> <!-- #page -->
<?php wp_footer(); ?>
</body>
</html>

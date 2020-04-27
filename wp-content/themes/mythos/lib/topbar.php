<div class="topbar">
    <div class="container">
        <div class="row">
            <?php 
            $mythos_topbaremail    = get_theme_mod( 'topbar_email', 'support@mythos.com' );
            $mythos_topbarphone    = get_theme_mod( 'topbar_phone', '+00 44 123 456 78910' );
            ?>
            
            <?php if ( $mythos_topbaremail || $mythos_topbarphone ) {  ?>
                <div class="col-lg-6">
                    <div class="topbar-contact">
                        <span>
                            <a href="mailto:<?php echo esc_attr( antispambot( sanitize_email( $mythos_topbaremail ) ) );?>">
                                <i class="far fa-envelope"></i>
                                <?php print esc_attr($mythos_topbaremail);?>
                            </a>
                        </span>
                        <span class="top-contact-phone">
                            <a href="tel:<?php echo esc_attr($mythos_topbarphone); ?>">
                            <i class="fas fa-phone-volume"></i>
                                <?php echo esc_attr($mythos_topbarphone);?>
                            </a>
                        </span>
                    </div>
                </div>
            <?php } ?>

            <div class="col-lg-6 top-social-wrap text-right">
                <div class="topbar-menu social_icons">
                    <!-- Social Share -->
                    <?php get_template_part('lib/social-link'); ?>  
                    <!-- End Social Share -->
                </div>
            </div>
        </div>
    </div>
</div>











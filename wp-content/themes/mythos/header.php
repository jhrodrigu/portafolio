<!DOCTYPE html> 
<html <?php language_attributes(); ?>> 
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>> 
    <?php
    //wp_body_open hook from WordPress 5.2
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }?>
	<div id="page" class="hfeed site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mythos' ); ?></a>
	    <header id="masthead" class="site-header">  	
		<?php if ( get_theme_mod( 'topbar_enable', false ) ) { get_template_part('lib/topbar'); } ?>
		<div class="container">
			<div class="row">
				<?php if( ! class_exists('wp_megamenu_initial_setup')) { ?>
					<div class="col-md-12">
						<div class="primary-menu">
							<div class="row">
								<div class="col-sm-6 col-md-4 col-6">
									<div class="mythos-navbar-header">
										<div class="logo-wrapper">
											
											<?php if( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
												the_custom_logo();
											}else { ?>
												<a class="mythos-navbar-brand" href="<?php echo esc_url(home_url()); ?>"><h1><?php echo esc_html(get_bloginfo('name'));?> </h1></a>
											<?php } ?>
											
										</div>   
									</div> <!--/#mythos-navbar-header-->   
								</div> <!--/.col-sm-2-->

								<!-- Mobile Monu -->
								<div class="col-sm-6 col-md-8 col-6 mythos-menu hidden-lg-up">
									<!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fas fa-bars"></i></button> -->

									<button id="hamburger-menu" type="button" class="navbar-toggle hamburger-menu-button" data-toggle="collapse" data-target=".navbar-collapse">
										<span class="hamburger-menu-button-open"></span>
									</button>
								</div>
								<div id="mobile-menu" class="thm-mobile-menu"> 
									<div class="collapse navbar-collapse">
										<?php 
											if ( has_nav_menu( 'primary' ) ) {
												wp_nav_menu( 
													array(
														'theme_location'    => 'primary',
														'container'         => false,
														'menu_class'        => 'nav navbar-nav',
														'fallback_cb'       => 'wp_page_menu',
														'depth'             => 3,
														'walker'            => new wp_bootstrap_mobile_navwalker()
													)
												); 
											} 
										?>
									</div>
								</div> <!-- thm-mobile-menu -->
								
								<!-- Primary Menu -->
								<div class="col-md-12 col-lg-8 common-menu space-wrap">
									<div class="header-common-menu">
										<?php if ( has_nav_menu( 'primary' ) ) { ?>
											<div id="main-menu" class="common-menu-wrap">
												<?php 
													wp_nav_menu(  
														array(
															'theme_location'  => 'primary',
															'container'       => '', 
															'menu_class'      => 'nav',
															'fallback_cb'     => 'wp_page_menu',
															'depth'            => 4,
															'walker'          => new Megamenu_Walker()
														)
													); 
												?>  
											</div><!--/.col-sm-9--> 
										<?php } else{ ?>
										<div class="no-menu-action">
											<a href="<?php echo home_url()?>/wp-admin/nav-menus.php">
											<i class="fas fa-bars"></i>
											Set a Menu</a>
										</div>
										<?php }?>
									</div><!-- header-common-menu -->
								</div><!-- common-menu -->
							</div>
						</div>
					</div>
				<?php } ?>

				<!-- For Megamenu -->
				<?php if( class_exists('wp_megamenu_initial_setup') ) { ?>
					<div class="col-md-12 col-lg-12 common-menu common-main-menu">
						<div class="header-common-menu">
							<?php if ( has_nav_menu( 'primary' ) ) { ?>
								<div id="main-menu" class="common-menu-wrap">
									<?php 
										wp_nav_menu(  
											array(
												'theme_location'  => 'primary',
												'container'       => '', 
												'menu_class'      => 'nav',
												'fallback_cb'     => 'wp_page_menu',
												'depth'            => 4,
												'walker'          => new Megamenu_Walker()
											)
										); 
									?>  
								</div><!--/.col-sm-9--> 
							<?php } else{ ?>
							<div class="no-menu-action">
								<a href="<?php echo home_url()?>/wp-admin/nav-menus.php">
								<i class="fas fa-bars"></i>
								Set a Menu</a>
							</div>
							<?php }?>
						</div><!-- header-common-menu -->
					</div><!-- common-menu -->
				<?php } ?>
			</div><!--row-->  
		</div><!--/.container--> 
	</header> <!-- header -->
	
<?php get_header();
/*
*Template Name: 404 Page Template
*/
?>
 
<?php $mythos_logo_404   = get_theme_mod( 'logo_404', false ); ?>

<div class="mythos-error">
	<div class="mythos-error-wrapper">
		<div class="row">
		    <div class="col-md-12 info-wrapper">

		    	<a class="error-logo" href="<?php echo esc_url(home_url('/')); ?>">
		    		<?php if ($mythos_logo_404){ ?>
			    		<img class="enter-logo img-responsive" src="<?php echo esc_url( $mythos_logo_404 ); ?>" alt="<?php  esc_html_e( 'Logo', 'mythos' ); ?>" title="<?php esc_html_e( 'Logo', 'mythos' ); ?>">
		    		<?php }else { ?>
		    			<h1> <?php echo esc_html(get_bloginfo('name')); ?> </h1>
		    		<?php } ?>
			    </a>

		    	<h1 class="error-title"><?php esc_html_e('404','mythos'); ?></h1>
		    	<h2 class="error-message-title"><?php echo esc_html(get_theme_mod( '404_title', '' )); ?></h2>
		    	<p class="error-message"><?php echo esc_html(get_theme_mod( '404_description', '' )); ?></p>
		    	
	            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-secondary">
	            	<span class="fas fa-home" aria-hidden="true"></span>
	            	<?php echo esc_html(get_theme_mod( '404_btn_text', 'Go Home' )); ?>
	            </a>
		    	
		    </div>
	    </div>
	</div>
</div>
<?php get_footer();

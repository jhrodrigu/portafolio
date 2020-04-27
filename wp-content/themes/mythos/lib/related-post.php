<!-- Related Post -->
<div class="related-entries">
	<div class="row">
		<?php 
		global $post;
		$mythos_categories = get_the_category($post->ID);
		if ($mythos_categories) { ?>
			<!-- Title -->
			<div class="col-md-12">
				<h3 class="related-post-title"><?php esc_html_e('Related Posts', 'mythos') ?></h3>
			</div>

			<?php 
			$mythos_category_ids = array();
			foreach($mythos_categories as $mythos_individual_category) $mythos_category_ids[] = $mythos_individual_category->term_id;
			$mythos_args=array(
				'category__in' 		=> $mythos_category_ids,
				'post__not_in' 		=> array($post->ID),
				'posts_per_page'	=> 3,
				'ignore_sticky_posts'	=>1
			);
			$mythos_thequery = new wp_query( $mythos_args );
			if( $mythos_thequery->have_posts() ) { ?>

				<?php while( $mythos_thequery->have_posts() ) {
					$mythos_thequery->the_post();?>

					<div class="col-md-4">
						<div class="relatedthumb">
							<a href="<?php echo esc_url(get_permalink()); ?>" class="img-wrapper">
								<?php echo get_the_post_thumbnail(get_the_ID(), 'mythos-medium', array('class' => 'img-responsive')); ?>
							</a>
						</div>
						<div class="relatedcontent">
							<span class="datetime"><?php echo get_the_date(); ?></span>
							<h3><a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a></h3>
						</div>
					</div>
				<?php } ?>

			<?php } }
			wp_reset_postdata();  
		?>
	</div> <!-- Row end -->

</div>


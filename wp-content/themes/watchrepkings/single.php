<?php
/*
Template Name: Gallery page
*/

get_header(); ?>

<section class="padding-t-b-100 cont-single-post">
	<div class="container">
		<div class="row">
			<div class="col-12 single-post-inn">
				<div class="cont-featured-img">
					<?php 
						if (has_post_thumbnail()) {
							the_post_thumbnail('full', array('class' => 'img-fluid'));
						} else {
							echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/default-image.jpg') . '" alt="Default Image" class="img-fluid">';
						}
					?>
				</div>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
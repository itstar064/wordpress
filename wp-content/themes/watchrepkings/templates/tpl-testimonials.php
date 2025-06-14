<?php
/*
Template Name: Testimonials page
*/

get_header(); ?>

<section class="padding-t-b-100 cont-testimonials-sec">
	<div class="container">
		<div class="row">
			<div class="col-12 section-top">
				<div class="testimonials-top-midd">
					<h2 class="title title-46"><?php echo get_field('reviews_list_title'); ?></h2>
				</div>
			</div>
			<?php if( have_rows('reviews_list') ): ?>
			<div class="col-12 display-flex testimonials-list">
				<?php while( have_rows('reviews_list') ): the_row(); ?>
				<div class="col-md-4 col-sm-12 col-12 single-testimonial">
					<div class="col-12 testi-list-inn">
						<div class="col-12 testi-star-otr">
							<?php 
								$image = get_sub_field('reviews_list_stars');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; 
							?>
						</div>
						<p><?php echo get_sub_field('reviews_list_review_content'); ?></p>
						<h5><?php echo get_sub_field('reviews_list_author'); ?></h5>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>
			<div class="col-12 load-testimonial">
				<a id="loadMore" href="javascript:;"><?php echo get_field('load_button_text'); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
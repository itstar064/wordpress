<?php
/*
Template Name: FAQs page
*/

get_header(); ?>

<section class="padding-t-b-100 page-attorney-sec cont-faq-page">
	<div class="container">
		<div class="row">
			<div class="col-12 section-top">
				<div class="testimonials-top-midd">
					<h2 class="title title-46"><?php echo get_field('faq_title'); ?></h2>
				</div>
			</div>
		</div>
		<div class="row cont-faq-content">
			<div class="attorney-sec-left">
				<div class="col-12 attorney-img">
					<?php 
						$image = get_field('faq_image');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php endif; 
					?>
				</div>
			</div>
			<div class="attorney-sec-right">
				<div class="accordion mydesign-accordion" id="accordionExample">
					<?php if( have_rows('faq_list') ): 
						$incr = 1;
					?>
					<?php while( have_rows('faq_list') ): the_row(); ?>
					<div class="accordion-item">
						<h2 class="accordion-header">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $incr; ?>">
							<?php the_sub_field('faq_list_question'); ?>
						  </button>
						</h2>
						<div id="collapse-<?php echo $incr; ?>" class="accordion-collapse collapse <?php if($incr == 1) { ?><?php } ?>" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<?php the_sub_field('faq_list_answer'); ?>
						  </div>
						</div>
					</div>
					<?php $incr++; endwhile; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
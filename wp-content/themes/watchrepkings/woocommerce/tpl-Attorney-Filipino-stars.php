<?php
/*
Template Name: Attorney to the Filipino Stars page
*/

get_header(); ?>

<section class="padding-t-b-100 cont-attorney-sec page-attorney-sec">
	<div class="container">
		<div class="row">
			<div class="attorney-sec-left">
				<div class="col-12 attorney-img">
					<?php 
						$image = get_field('attorney_image');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php endif; 
					?>
				</div>
			</div>
			<div class="attorney-sec-right">
				<h2 class="title title-46"><?php echo get_field('attorney_title'); ?></h3>
				<p><?php echo get_field('attorney_content'); ?></p>
				<div class="subtitle"><?php echo get_field('attorney_sub_title'); ?></div>
				<?php if( have_rows('attorney_matters_list') ): ?>
				<ul class="attorney-list">
					<?php while( have_rows('attorney_matters_list') ): the_row(); ?>					
					<li>
						<div class="list-icon">
							<?php 
								$image = get_sub_field('attorney_matters_list_icon');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; 
							?>
						</div>
						<h5><?php echo get_sub_field('attorney_matters_list_title'); ?></h5>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
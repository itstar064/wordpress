<?php
/*
Template Name: Prices
*/

get_header();

$currentData = get_queried_object();

?>

<?php
if (isset($currentData->ID)) {
	$thumbnail_url = get_the_post_thumbnail_url($currentData->ID, 'full');
?>
<section class="custNotificationbar">
	<div class="push-notificationbar">
		<div class="container">
			<?php 
				$notification_label = get_field('notification_label' , 25);
				if( !empty($notification_label) ): ?>
					<p><?php echo esc_html($notification_label); ?></p>
				<?php endif; 
			?>
		</div>
	</div>
</section>
<section class="custInrCatBnr" style="background-image:url(<?php echo esc_url($thumbnail_url); ?>);"></section>
<?php } ?>
<section class="realdeals prices-bannerr">
    <div class="container">
        <div class="titlebar">
            <?php 
                if ($currentData->post_name): ?>
                    <h1><?php echo $currentData->post_name; ?></h1>
                <?php endif; 
                if ($currentData->post_content): ?>
                    <p><?php echo $currentData->post_content; ?></p>
                <?php endif; 
            ?>
        </div>
        </div>
    </div>
</section>
<section class="custCatsFilter filter-best-seller">
	<div class="container">
		<div class="custCatsFilterMn">
			<div class="custCatsFilterLft">
				<div class="custCatsFilterTtl">
					<h2>CATEGORY</h2>
				</div>
				<div class="custCatsFilterList">
					<ul>
						<li class="">
							<a href="<?php echo site_url(); ?>/collection/">Brands
							  <span class="checkmark"></span>
							</a>
						</li>
						<li class="active">
							<a href="<?php echo site_url(); ?>/prices/">Prices
							  <span class="checkmark"></span>
							</a>
						</li>
						<li class="">
							<a href="<?php echo site_url(); ?>/best-seller/">Best Sellers
							  <span class="checkmark"></span>
							</a>
						</li>
						<li class="">
							<a href="<?php echo site_url(); ?>/newest/">Newest Release
							  <span class="checkmark"></span>
							</a>
						</li>
						<li class="custLastLi ">
							<a href="<?php echo site_url(); ?>/special-reductions/">Special Reductions
							  <span class="checkmark"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="custCatsFilterRt">
				<div class="allnewest-products">
					<?php echo do_shortcode('[pricecustomproducts categoryshow="newest" order="DESC" itemtoshow="10"]'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

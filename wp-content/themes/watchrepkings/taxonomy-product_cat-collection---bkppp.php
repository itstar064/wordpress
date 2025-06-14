<?php
/**
 * Custom Template for "collection" Category
 */

get_header();
$category_id = get_queried_object_id();
$thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
$image_url = wp_get_attachment_url($thumbnail_id);
$category_detail_page_heading = get_field('category_detail_page_heading' , 'product_cat_' . $category_id);
$category_description = term_description($category_id, 'product_cat');
?>

<?php
if ($image_url) {
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
<section class="custInrCatBnr" style="background-image:url(<?php echo esc_url($image_url); ?>);"></section>
<?php } ?>
<section class="realdeals">
    <div class="container">
        <div class="titlebar">
            <?php 
                if (!empty($category_detail_page_heading)): ?>
                    <h1><?php echo esc_html($category_detail_page_heading); ?></h1>
                <?php endif; 
                if (!empty($category_description)): ?>
                    <p><?php echo $category_description; ?></p>
                <?php endif; 
            ?>
        </div>
        </div>
    </div>
</section>
<section class="custCatsFilter">
	<div class="container">
		<div class="custCatsFilterMn">
			<div class="custCatsFilterLft">
				<div class="custCatsFilterTtl">
					<h2>CATEGORY</h2>
				</div>
				<div class="custCatsFilterList">
					<ul>
						<li class="active">
							<a href="<?php echo site_url(); ?>/collection/">Brands
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
				<?php
				$brands = get_terms(array(
					'taxonomy'   => 'product_brand',
					'hide_empty' => false,
				));
				if (!empty($brands) && !is_wp_error($brands)) {
					echo '<div class="allcategoryblock"><div class="product-categories-list">';
					foreach ($brands as $brand) {
						$thumbnail_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
						$thumbnail_url = wp_get_attachment_url($thumbnail_id);
						if ($thumbnail_url) {
						?>
						<div class="product-category-item">
							<a href="<?php echo esc_url(get_term_link($brand)); ?>"><img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($brand->name); ?>"></a>
						</div>
						<?php
						}
					}
					echo '</div></div>';
				}
				?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

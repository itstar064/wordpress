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
<section class="custCatsFilter filter-best-seller">
	<div class="container">
		<div class="custCatsFilterMn">
			<div class="custCatsFilterRt shopcat_myc">
				<div class="allnewest-products">
					<?php echo do_shortcode('[customproducts categoryshow="audemars-piguet" order="DESC" itemtoshow="10"]'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

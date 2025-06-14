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
			<?php echo do_shortcode('[custom_product_filter]'); ?>
		</div>
	</div>
</section>





<!-- lookfeel section start from here  -->
<section class="lookfeel collection-lookfeel">
    <div class="container-fluid p-0">
        <?php 
            // Fetch the ACF fields
            $background_image = get_field('look_background_image', '25'); 
            $look_title = get_field('look-title', '25'); 
            // Ensure URL exists, otherwise set an empty string
            $background_url = $background_image ? esc_url($background_image['url']) : ''; 
        ?>
        
        <div class="lookfeel-bg" style="<?php echo $background_url ? "background-image: url('$background_url');" : ''; ?>">
            <!-- <div class="bg-color" ></div> -->
           

			<h2>LOOKS AND BUILT JUST LIKE THE ORIGINAL</h2>
        </div>
    </div>

</section>
<!-- lookfeel section ends from here  -->

<?php get_footer(); ?>

<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

<section class="single-breadcrumb2">
   <div class="container">
      <?php
         function custom_woocommerce_breadcrumb() {
             echo '<nav class="custom-breadcrumb">';
             echo '<a href="' . home_url() . '">Home</a> / ';
             echo '<a href="' . get_permalink(wc_get_page_id('shop')) . '">Collection</a> / ';
         
             $categories = get_the_terms(get_the_ID(), 'product_cat');
             if ($categories && !is_wp_error($categories)) {
                 $first_category = $categories[0];
                 echo '<a href="' . get_term_link($first_category) . '">' . esc_html($first_category->name) . '</a> / ';
             }
         
             $product_title = get_the_title();
             $ref_number = get_field('ref_no') ? esc_html(get_field('ref_no')) : 'No Ref';
             $product_size = get_field('product-size') ? esc_html(get_field('product-size')) : 'No Size Available';
         
             echo '<span class="active">' . esc_html($product_title); 
             echo ' ' . $product_size;
             echo ' Ref: ' . $ref_number;
             echo '</span>';
         
             echo '</nav>';
         }
         
         custom_woocommerce_breadcrumb();
         ?>
   </div>
</section>

<?php
$term = get_queried_object();
?>


<!-- section start from here  -->
<section class="Newest f archive-products-list2">
    <div class="container">
        <div class="titleinlinebar">
            <h3><?php echo $term->name; ?></h3>
            
        </div>
        <div class="allnewest-products">
            <?php
			
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 12,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $term->slug,
					),
				),
			);

			$loop = new WP_Query($args);
			if ($loop->have_posts()) :
				while ($loop->have_posts()) : $loop->the_post();
					?>
					<div class="products-listing">
						<div class="products-listingin">
							<div class="products-listingin-row">
								<div class="product-thumbanil">
									<?php 
									$label_hot_now_active = get_field('label_hot_now_active'); 
									if ($label_hot_now_active) : ?>
										<div class="label-hotted">
											<label><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg" alt="fireicon"/> Hot Right Now</label>
										</div>
									<?php endif; ?>

									<div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
										<div class="carousel-indicators">
											<?php
											$product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
											$attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
											$active_class = 'active';
											foreach ($attachment_ids as $index => $attachment_id) :
												?>
												<button type="button" data-bs-target="#carouselproductsIndicators-<?php the_ID(); ?>" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $active_class; ?>" aria-current="<?php echo $active_class == 'active' ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
												<?php
												$active_class = '';
											endforeach;
											?>
										</div>
										<div class="carousel-inner">
											<?php
											$active_class = 'active';
											foreach ($attachment_ids as $attachment_id) :
												$image_url = wp_get_attachment_url($attachment_id);
												?>
												<div class="carousel-item <?php echo $active_class; ?>">
													<a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image_url); ?>" class="d-block w-100" alt="Product Image">
													
													
													</a>
													
												</div>
												<?php
												$active_class = '';
											endforeach;
											?>
											<div class="quick-view-btnn" style="display:none;">
												<a href="<?php the_permalink();?>">Quick View </a>
											</div>
										</div>
									</div>
								</div>
								<div class="product-detail">
									<div class="left">
										 <h4>
											<?php 
											$watch_name = get_field('watch_name'); 
											echo $watch_name ? esc_html($watch_name) : '';  
											?>
										</h5>
										<h5>
											<?php 
											$product_size = get_field('product-size'); 
											echo $product_size ? esc_html($product_size) : 'No Size Available'; 
											?>
										</h5>
										<h5>Ref: <?php echo esc_html(get_field('ref_no') ? get_field('ref_no') : 'No Ref'); ?></h5>
									</div>
									<div class="ryt">
									
										<?php 
										$product = wc_get_product(get_the_ID());

										if ($product) {
											$regular_price = $product->get_regular_price();
											$sale_price = $product->get_sale_price();

											// Format prices without decimals
											$formatted_regular_price = explode('.', wc_price($regular_price))[0];
											$formatted_sale_price = $sale_price ? explode('.', wc_price($sale_price))[0] : '';

											if (!empty($sale_price) && $sale_price < $regular_price) : ?>
												<span class="regular-price">
													<span class="from-text">From</span> <del> <?php echo $formatted_regular_price; ?></del>
												</span>
												<span class="discount-price">
													<?php echo $formatted_sale_price; ?>
												</span>
											<?php else : ?>
												<span class="regular-price">
													<?php echo $formatted_regular_price; ?>
												</span>
											<?php endif; ?>
										<?php } ?>


									</div>
								</div>
								<div class="addtocart">
									<?php woocommerce_template_loop_add_to_cart(); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No products found.</p>';
			endif;
			
			// Add JavaScript to initialize carousels for dynamic elements
			?>
			<script>
				jQuery(document).ready(function($) {
					// Initialize all carousels
					$('.carousel').each(function() {
						var carousel = $(this);
						if (!carousel.hasClass('initialized')) {
							carousel.carousel(); // Initialize the carousel
							carousel.addClass('initialized'); // Add class to avoid re-initializing
						}
					});
				});
			</script>
			
        </div>
    </div>
</section>
<!-- section ends from here  -->




<?php
get_footer( 'shop' );

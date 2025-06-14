<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
   exit; // Exit if accessed directly
}

get_header('shop');

global $product;

if (!is_a($product, 'WC_Product')) {
   $product_id = get_the_ID(); // Get current product ID
   $product = wc_get_product($product_id); // Manually get product object
}

// Check if product is valid
if (!$product) {
   echo "<p>Product not found!</p>";
   return;
}

// Get Main Product Image
$main_image_id = $product->get_image_id();
$main_image_url = wp_get_attachment_url($main_image_id);

// Get Gallery Images
$attachment_ids = $product->get_gallery_image_ids();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
   .main-image-container {
      overflow: hidden;
      width: 100%;
      text-align: center;
   }

   .zoomable {
      width: 100%;
      transition: transform 0.3s ease-in-out;
   }

   .thumbnail {
      cursor: pointer;
   }

   .has-thumb img#mainProductImage {
      object-fit: cover !important;
   }
</style>
<section class="single-breadcrumb2 ffvd">
   <div class="container">
      <?php
      function custom_woocommerce_breadcrumb()
      {
         echo '<nav class="custom-breadcrumb">';
         echo '<a href="' . home_url() . '">Home</a> / ';

         // Get product brand
         $brands = get_the_terms(get_the_ID(), 'product_brand');
         if ($brands && !is_wp_error($brands)) {
            $first_brand = $brands[0];
            echo '<a href="' . get_permalink(wc_get_page_id('shop')) . '">Brands</a> / ';
            echo '<a href="' . get_term_link($first_brand) . '">' . esc_html($first_brand->name) . '</a> / ';
         } else {
            // If no brand, fallback to product category
            $categories = get_the_terms(get_the_ID(), 'product_cat');
            if ($categories && !is_wp_error($categories)) {
               $first_category = $categories[0];
               echo '<a href="' . get_permalink(wc_get_page_id('shop')) . '">Collection</a> / ';
               echo '<a href="' . get_term_link($first_category) . '">' . esc_html($first_category->name) . '</a> / ';
            }
         }

         // Product title, size, ref
         $product_title = get_the_title();
         $ref_number = get_field('ref_no') ? esc_html(get_field('ref_no')) : 'No Ref';
         $product_size = get_field('product-size') ? esc_html(get_field('product-size')) : 'No Size Available';

         echo '<span class="active">' . esc_html($product_title) . ' ' . $product_size . ' Ref: ' . $ref_number . '</span>';
         echo '</nav>';
      }

      custom_woocommerce_breadcrumb();
      ?>
   </div>
</section>

<section class="custSingleProSec1 single-product-mainn">
   <div class="container desktopview">
      <div class="custSingleProSec1Mn">
         <div class="custSingleProSec1Lft">
            <!-- Additional Gallery Images -->
            <div class="slider-container">
               <!-- Main Slider -->
               <div class="main-image-container deskvew ">
                  <img id="mainProductImage" src="<?php echo esc_url($main_image_url); ?>" alt="Main Product Image"
                     class="zoomable">
                  <img class="showthumb"
                     src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/05/image.png"
                     alt="brandname" />
               </div>
               <!-- Thumbnail Navigation -->
               <?php if (!empty($attachment_ids)): ?>
                  <div class="swiper thumbnail-slider">
                     <div class="swiper-wrapper">
                        <?php foreach ($attachment_ids as $attachment_id): ?>
                           <div class="swiper-slide custThumbItem">
                              <img class="thumbnail" src="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>"
                                 alt="Gallery Image"
                                 data-large="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>">
                           </div>
                        <?php endforeach; ?>
                     </div>
                     <!-- Navigation Arrows -->
                     <div class="swiper-button-prev"></div>
                     <div class="swiper-button-next"></div>
                  </div>
               <?php endif; ?>
            </div>

            <!-- <div class="sn-prodcut-featurde-info">
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Online-Support.png"
                        alt="Icon">
                  </div>
                  <h6>Reliable <br> Replacements</h6>
               </div>
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Guarantee.png"
                        alt="Icon">
                  </div>
                  <h6>Real <br> UA Deal</h6>
               </div>
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Delivery.png"
                        alt="Icon">
                  </div>
                  <h6>Guaranteed <br> Delivery</h6>
               </div>
            </div> -->

            <div class="sn-prodcut-video">
               <?php echo get_field('single-roduct_videos_iframe'); ?>
            </div>


         </div>
         <div class="custSingleProSec1Rt">
            <h1>
               <?php
               $product_title = get_the_title();
               $words = explode(' ', $product_title, 2);
               $ref_number = get_field('ref_no') ? esc_html(get_field('ref_no')) : 'No Ref';
               $product_size = get_field('product-size') ? esc_html(get_field('product-size')) : 'No Size Available';

               echo '<span class="">' . esc_html($product_title);
               echo ' ' . $product_size;
               echo '<br> Ref: ' . $ref_number;
               echo '</span>'; ?>
            </h1>
            <div class="product-customer-review-prc-panel">
               <div class="product-review-prc-panel-left">
                  <div class="product-customer-review">
                     <?php
                     global $product;
                     $average = $product->get_average_rating();
                     $review_count = $product->get_review_count();
                     ?>
                     <div class="custom-rating">
                        <span class="stars">
                           <?php for ($i = 1; $i <= 5; $i++) { ?>
                              <i class="fa <?php echo ($i <= $average) ? 'fa-star' : 'fa-star-o'; ?>"></i>
                           <?php } ?>
                        </span>
                        <span class="review-count">(<?php echo $review_count; ?> Customer
                           Review<?php echo ($review_count == 1) ? '' : 's'; ?>)</span>
                     </div>
                  </div>
                  <div class="custm-price">
                     <?php
                     global $product;

                     if (!$product) {
                        $product = wc_get_product(get_the_ID());
                     }

                     if ($product && $product->is_type('variable')) {
                        // Default variation price lo
                        $default_variation = $product->get_available_variations()[0];
                        echo !empty($default_variation['price_html']) ? $default_variation['price_html'] : wc_price($product->get_price());
                     } else {
                        echo wc_price($product->get_price());
                     }
                     ?>
                  </div>

                  <script>
                     jQuery(function ($) {
                        // Jab bhi variation select ho
                        $(document).on('found_variation', 'form.variations_form', function (event, variation) {
                           if (variation) {
                              // Sale ya regular price ko check karo
                              let price_html = variation.price_html;

                              // Custom price div me update karo
                              $('.custm-price').html(price_html);
                           }
                        });

                        // Jab reset variation button dabaye
                        $(document).on('click', '.reset_variations', function () {
                           // Default price wapas lao
                           $('.custm-price').html('<?php echo wc_price($product->get_price()); ?>');
                        });
                     });
                  </script>

               </div>
               <div class="product-review-prc-panel-right">
                  <div class="browse-whishlist-collection">
                     <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                     <a href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/collection/"><span><img
                              src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/collectionns.png"></span>Check
                        Rolex Collection</a>
                  </div>
               </div>
            </div>
            <div class="border-spacer"></div>
            <div class="short-spn-content">
               <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
            </div>
            <div class="border-spacer"></div>
            <div class="product-quality-opt">
               <?php
               global $product;

               if ($product->is_type('variable')) {
                  woocommerce_template_single_add_to_cart();
               }
               ?>

               <style>
                  .product-quality-opt .single_variation_wrap .woocommerce-variation-price {
                     display: none;
                  }

                  .product-quality-opt .single_variation_wrap .woocommerce-variation-add-to-cart {
                     display: none;
                  }
               </style>




               <div class="product-quality-opt-row" style="display: none;">
                  <?php if (have_rows('quality_tabs_row')):
                     $tabId = 1; ?>
                     <div class="tabs">
                        <?php while (have_rows('quality_tabs_row')):
                           the_row();
                           $tabs_name = get_sub_field('quality_tabs_row_tabs_name');
                           $active_class = ($tabId == 1) ? ' active' : '';
                           ?>
                           <button class="tab-button<?php echo $active_class; ?>" data-tab="Tab<?php echo $tabId; ?>">
                              <?php echo $tabs_name; ?>
                           </button>
                           <?php $tabId++; endwhile; ?>
                     </div>

                     <?php $tabId = 1; ?>
                     <?php while (have_rows('quality_tabs_row')):
                        the_row();
                        $tab_content = get_sub_field('quality_tabs_row_description');
                        $active_class = ($tabId == 1) ? ' active' : '';
                        ?>
                        <div id="Tab<?php echo $tabId; ?>" class="tab-content<?php echo $active_class; ?>">
                           <?php echo $tab_content; ?>
                        </div>
                        <?php $tabId++; endwhile; ?>
                  <?php endif; ?>
               </div>

            </div>
            <div class="single-qt-cart">
               <?php
               global $product;
               if (!$product) {
                  $product = wc_get_product(get_the_ID()); // Get current product
               }

               if ($product) {
                  echo '<form class="cart" action="' . esc_url(wc_get_cart_url()) . '" method="post" enctype="multipart/form-data">';
                  woocommerce_quantity_input(array(
                     'min_value' => 1,
                     'max_value' => $product->get_max_purchase_quantity(),
                     'input_value' => 1, // Default quantity
                  ));

                  echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($product->get_id()) . '">';

                  echo '<div class="btnbar">
                              <button type="submit" class="single_add_to_cart_button button alt stillbtn-wrap btnlearnmre">'
                     . esc_html($product->single_add_to_cart_text()) .
                     '</button>
                              <a href="' . esc_url(wc_get_checkout_url() . '?add-to-cart=' . $product->get_id()) . '" 
                                 class="buy-now-button button alt " 
                               >
                                  Buy Now
                              </a>
                            </div>';
                  echo '</form>';
               } else {
                  echo '<p>Product not found.</p>';
               }
               ?>
            </div>
            <?php
            // Get the current product ID
            global $product;
            $cross_sells = $product->get_cross_sells();

            if (!empty($cross_sells)): ?>
               <!-- You may be interested in -->
               <div class='interest-bar'>
                  <p>You may be interested in...</p>
                  <div class="cross-sell-products">
                     <?php foreach ($cross_sells as $cross_sell_id):
                        $cross_sell = wc_get_product($cross_sell_id); ?>
                        <div class="cross-sell-item">
                           <div class="sell-in">
                              <div class='pr-img'><?php echo $cross_sell->get_image(); ?></div>
                              <div class="detail">
                                 <div class='leftbar'>
                                    <h4><?php echo $cross_sell->get_name(); ?></h4>
                                    <div class="pricingbar"><span
                                          class="price"><?php echo $cross_sell->get_price_html(); ?></span></div>
                                 </div>
                                 <div class='rytbar'>
                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            <?php endif; ?>
            <div class="accordion-wrap-sec single-accodian-tabs dsf">
               <?php
               $accordion_rows = get_field('accordion_section');
               if (!empty($accordion_rows)):
                  $latest_three = array_slice($accordion_rows, -3);
                  $parent_id = 'accordion_' . uniqid(); // unique ID per instance
                  ?>
                  <div class="accordion" id="<?php echo esc_attr($parent_id); ?>">
                     <?php
                     $i = 0;
                     foreach ($latest_three as $row):
                        $unique_id = $parent_id . '_collapse' . $i;
                        $heading_id = $parent_id . '_heading' . $i;
                        ?>
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#<?php echo esc_attr($unique_id); ?>" aria-expanded="false"
                                 aria-controls="<?php echo esc_attr($unique_id); ?>">
                                 <?php echo esc_html($row['accordion-tilte']); ?>
                              </button>
                           </h2>
                           <div id="<?php echo esc_attr($unique_id); ?>" class="accordion-collapse collapse"
                              aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                              data-bs-parent="#<?php echo esc_attr($parent_id); ?>">
                              <div class="accordion-body">
                                 <?php echo wp_kses_post($row['accordion-content']); ?>
                              </div>
                           </div>
                        </div>
                        <?php $i++; endforeach; ?>
                  </div>
               <?php endif; ?>
            </div>







         </div>
      </div>
      <div class="reviewcustSingle">
      </div>
   </div>
   <div class="container mobileview">
      <div class="custSingleProSec1Mn">
         <div class="custSingleProSec1Lft mobileviewnewslide">
            <h1>
               <?php
               $product_title = get_the_title();
               $words = explode(' ', $product_title, 2);
               $ref_number = get_field('ref_no') ? esc_html(get_field('ref_no')) : 'No Ref';
               $product_size = get_field('product-size') ? esc_html(get_field('product-size')) : 'No Size Available';

               echo '<span class="">' . esc_html($product_title);
               echo ' ' . $product_size;
               echo '<br> Ref: ' . $ref_number;
               echo '</span>'; ?>
            </h1>
            <div class="product-customer-review">
               <?php
               global $product;
               $average = $product->get_average_rating();
               $review_count = $product->get_review_count();
               ?>
               <div class="custom-rating">
                  <span class="stars">
                     <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i class="fa <?php echo ($i <= $average) ? 'fa-star' : 'fa-star-o'; ?>"></i>
                     <?php } ?>
                  </span>
                  <span class="review-count">(<?php echo $review_count; ?> Customer
                     Review<?php echo ($review_count == 1) ? '' : 's'; ?>)</span>
               </div>
            </div>

            <!-- Additional Gallery Images -->
            <div class="slider-container">
               <!-- Main Slider -->
               <div class="main-image-container">
                  <img id="mainProductImage" src="<?php echo esc_url($main_image_url); ?>" alt="Main Product Image"
                     class="zoomable">
               </div>
               <!-- Thumbnail Navigation -->
               <?php if (!empty($attachment_ids)): ?>
                  <div class="swiper thumbnail-slider">
                     <div class="swiper-wrapper">
                        <?php foreach ($attachment_ids as $attachment_id): ?>
                           <div class="swiper-slide custThumbItem">
                              <img class="thumbnail" src="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>"
                                 alt="Gallery Image"
                                 data-large="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>">
                           </div>
                        <?php endforeach; ?>
                     </div>
                     <!-- Navigation Arrows -->
                     <div class="swiper-button-prev"></div>
                     <div class="swiper-button-next"></div>
                  </div>
               <?php endif; ?>
            </div>
            <div class="product-review-prc-panel-left">

               <div class="custm-price">
                  <?php
                  global $product;

                  if (!$product) {
                     $product = wc_get_product(get_the_ID());
                  }

                  if ($product && $product->is_type('variable')) {
                     // Default variation price lo
                     $default_variation = $product->get_available_variations()[0];
                     echo !empty($default_variation['price_html']) ? $default_variation['price_html'] : wc_price($product->get_price());
                  } else {
                     echo wc_price($product->get_price());
                  }
                  ?>
               </div>

               <script>
                  jQuery(function ($) {
                     // Jab bhi variation select ho
                     $(document).on('found_variation', 'form.variations_form', function (event, variation) {
                        if (variation) {
                           // Sale ya regular price ko check karo
                           let price_html = variation.price_html;

                           // Custom price div me update karo
                           $('.custm-price').html(price_html);
                        }
                     });

                     // Jab reset variation button dabaye
                     $(document).on('click', '.reset_variations', function () {
                        // Default price wapas lao
                        $('.custm-price').html('<?php echo wc_price($product->get_price()); ?>');
                     });
                  });
               </script>

            </div>
            <div class="product-quality-opt">
               <?php
               global $product;

               if ($product->is_type('variable')) {
                  woocommerce_template_single_add_to_cart();
               }
               ?>

               <style>
                  .product-quality-opt .single_variation_wrap .woocommerce-variation-price {
                     display: none;
                  }

                  .product-quality-opt .single_variation_wrap .woocommerce-variation-add-to-cart {
                     display: none;
                  }
               </style>




               <div class="product-quality-opt-row" style="display: none;">
                  <?php if (have_rows('quality_tabs_row')):
                     $tabId = 1; ?>
                     <div class="tabs">
                        <?php while (have_rows('quality_tabs_row')):
                           the_row();
                           $tabs_name = get_sub_field('quality_tabs_row_tabs_name');
                           $active_class = ($tabId == 1) ? ' active' : '';
                           ?>
                           <button class="tab-button<?php echo $active_class; ?>" data-tab="Tab<?php echo $tabId; ?>">
                              <?php echo $tabs_name; ?>
                           </button>
                           <?php $tabId++; endwhile; ?>
                     </div>

                     <?php $tabId = 1; ?>
                     <?php while (have_rows('quality_tabs_row')):
                        the_row();
                        $tab_content = get_sub_field('quality_tabs_row_description');
                        $active_class = ($tabId == 1) ? ' active' : '';
                        ?>
                        <div id="Tab<?php echo $tabId; ?>" class="tab-content<?php echo $active_class; ?>">
                           <?php echo $tab_content; ?>
                        </div>
                        <?php $tabId++; endwhile; ?>
                  <?php endif; ?>
               </div>

            </div>
            <div class="single-qt-cart">
               <?php
               global $product;
               if (!$product) {
                  $product = wc_get_product(get_the_ID()); // Get current product
               }

               if ($product) {
                  echo '<form class="cart" action="' . esc_url(wc_get_cart_url()) . '" method="post" enctype="multipart/form-data">';
                  woocommerce_quantity_input(array(
                     'min_value' => 1,
                     'max_value' => $product->get_max_purchase_quantity(),
                     'input_value' => 1, // Default quantity
                  ));

                  echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($product->get_id()) . '">';

                  echo '<div class="btnbar">
                              <button type="submit" class="single_add_to_cart_button button alt stillbtn-wrap btnlearnmre">'
                     . esc_html($product->single_add_to_cart_text()) .
                     '</button>
                              <a href="' . esc_url(wc_get_checkout_url() . '?add-to-cart=' . $product->get_id()) . '" 
                                 class="buy-now-button button alt " 
                               >
                                  Buy Now
                              </a>
                            </div>';
                  echo '</form>';
               } else {
                  echo '<p>Product not found.</p>';
               }
               ?>
            </div>
            <?php
            // Get the current product ID
            global $product;
            $cross_sells = $product->get_cross_sells();

            if (!empty($cross_sells)): ?>
               <!-- You may be interested in -->
               <div class='interest-bar'>
                  <p>You may be interested in...</p>
                  <div class="cross-sell-products">
                     <?php foreach ($cross_sells as $cross_sell_id):
                        $cross_sell = wc_get_product($cross_sell_id); ?>
                        <div class="cross-sell-item">
                           <div class="sell-in">
                              <div class='pr-img'><?php echo $cross_sell->get_image(); ?></div>
                              <div class="detail">
                                 <div class='leftbar'>
                                    <h4><?php echo $cross_sell->get_name(); ?></h4>
                                    <div class="pricingbar"><span
                                          class="price"><?php echo $cross_sell->get_price_html(); ?></span></div>
                                 </div>
                                 <div class='rytbar'>
                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            <?php endif; ?>
            <div class="sn-prodcut-featurde-info">
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Online-Support.png"
                        alt="Icon">
                  </div>
                  <h6>Reliable <br> Replacements</h6>
               </div>
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Guarantee.png"
                        alt="Icon">
                  </div>
                  <h6>Real <br> UA Deal</h6>
               </div>
               <div class="gridd">
                  <div class="image-icon">
                     <img
                        src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/Delivery.png"
                        alt="Icon">
                  </div>
                  <h6>Guaranteed <br> Delivery</h6>
               </div>
            </div>
            <div class="accordion-wrap-sec single-accodian-tabs sdfsdf 23">
               <?php
               if (have_rows('accordion_section')):
                  $parent_id = 'accordion_' . uniqid(); // Unique parent ID
                  $rows = []; // Store all rows
                  while (have_rows('accordion_section')):
                     the_row();
                     $rows[] = [
                        'title' => get_sub_field('accordion-tilte'),
                        'content' => get_sub_field('accordion-content'),
                     ];
                  endwhile;

                  // Take the first 3
                  $first_three = array_slice($rows, 0, 3);
                  ?>
                  <div class="accordion" id="<?php echo esc_attr($parent_id); ?>">
                     <?php foreach ($first_three as $i => $row):
                        $unique_id = $parent_id . '_collapse' . $i;
                        $heading_id = $parent_id . '_heading' . $i;
                        ?>
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#<?php echo esc_attr($unique_id); ?>" aria-expanded="false"
                                 aria-controls="<?php echo esc_attr($unique_id); ?>">
                                 <?php echo esc_html($row['title']); ?>
                              </button>
                           </h2>
                           <div id="<?php echo esc_attr($unique_id); ?>" class="accordion-collapse collapse"
                              aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                              data-bs-parent="#<?php echo esc_attr($parent_id); ?>">
                              <div class="accordion-body">
                                 <?php echo wp_kses_post($row['content']); ?>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; ?>
                  </div>
               <?php endif; ?>
            </div>

            <div class="sn-prodcut-video">
               <?php echo get_field('single-roduct_videos_iframe'); ?>


            </div>


         </div>
         <div class="custSingleProSec1Rt">

            <div class="product-customer-review-prc-panel">

               <div class="product-review-prc-panel-right">
                  <div class="browse-whishlist-collection">
                     <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                     <a href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/collection/"><span><img
                              src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/collectionns.png"></span>Check
                        Rolex Collection</a>
                  </div>
               </div>
            </div>
            <div class="border-spacer"></div>
            <div class="short-spn-content">
               <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
            </div>
            <div class="border-spacer"></div>









         </div>
      </div>
      <div class="reviewcustSingle">
      </div>
   </div>
</section>
<?php
// Description content
$description_iframe = get_field('product_video_iframe');
$description_content = get_the_content();
$show_description = $description_iframe || !empty(trim(strip_tags($description_content)));

// Charts content
$chart_table = get_field('product_chart_table');
$show_charts = !empty($chart_table) && is_array($chart_table);

// Reviews count
global $product;
$total_reviews = $product->get_review_count();
$show_reviews = $total_reviews > 0 || comments_open();

// FAQs
$show_faqs = have_rows('accordion_section');
?>

<section class="single-prodcut-bottm">
   <div class="container">

      <!-- Tabs -->
      <div class="tabs">
         <?php if ($show_description): ?>
            <div class="tab active" data-tab="description">Description</div>
         <?php endif; ?>

         <?php if ($show_charts): ?>
            <div class="tab <?php echo !$show_description ? 'active' : ''; ?>" data-tab="charts">Charts</div>
         <?php endif; ?>

         <?php if ($show_reviews): ?>
            <div class="tab <?php echo (!$show_description && !$show_charts) ? 'active' : ''; ?>" data-tab="reviews">
               Reviews (<?php echo esc_html($total_reviews); ?>)
            </div>
         <?php endif; ?>

         <?php if ($show_faqs): ?>
            <div class="tab <?php echo (!$show_description && !$show_charts && !$show_reviews) ? 'active' : ''; ?>"
               data-tab="faqs">FAQ's</div>
         <?php endif; ?>
      </div>

      <!-- Tab Content: Description -->
      <?php if ($show_description): ?>
         <div class="tab-content active" id="description">
            <div class="reviews-content-inn">
               <h4 class="rv-title">Description</h4>
               <?php if ($description_iframe): ?>
                  <div class="videobar">
                     <?php echo $description_iframe ? $description_iframe : '<p>No iframe found</p>'; ?>
                  </div>
               <?php endif; ?>

               <div class="short-desc">
                  <?php the_content(); ?>
               </div>
               <img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Lorem.svg"
                  class="loremtableimg" alt="loremtable">
            </div>
         </div>
      <?php endif; ?>

      <!-- Tab Content: Charts -->
      <?php if ($show_charts): ?>
         <div class="tab-content <?php echo !$show_description ? 'active' : ''; ?>" id="charts">
            <div class="reviews-content-inn">
               <h4 class="rv-title">Charts</h4>
               <div class="table-responsive">
                  <table class="product-chart-table">
                     <?php if (isset($chart_table['header']) && is_array($chart_table['header'])): ?>
                        <thead>
                           <tr>
                              <?php foreach ($chart_table['header'] as $th): ?>
                                 <th><?php echo esc_html(is_array($th) ? implode(', ', $th) : $th); ?></th>
                              <?php endforeach; ?>
                           </tr>
                        </thead>
                     <?php endif; ?>

                     <?php if (isset($chart_table['body']) && is_array($chart_table['body'])): ?>
                        <tbody>
                           <?php foreach ($chart_table['body'] as $tr): ?>
                              <tr>
                                 <?php foreach ($tr as $td): ?>
                                    <td><?php echo esc_html(is_array($td) ? implode(', ', $td) : $td); ?></td>
                                 <?php endforeach; ?>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     <?php endif; ?>
                  </table>
               </div>
            </div>
         </div>
      <?php endif; ?>

      <!-- Tab Content: Reviews -->
      <?php if ($show_reviews): ?>
         <div class="tab-content <?php echo (!$show_description && !$show_charts) ? 'active' : ''; ?>" id="reviews">
            <div class="reviews-content-inn">
               <div class="customdiv1">
                  <div class="reviews-content-row1">
                     <?php echo do_shortcode('[cusrev_all_reviews sort="DESC" sort_by="date" per_page="10" show_summary_bar="true" show_media="true" show_products="true" products="current" product_reviews="true" shop_reviews="true" show_replies="false" show_more="5" avatars="initials" add_review="false"]'); ?>
                  </div>
                  <div class="reviews-content-row2">
                     <?php
                     if (comments_open()) {
                        comments_template();
                     } else {
                        echo '<p>Reviews are closed for this product.</p>';
                     }
                     ?>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>

      <!-- Tab Content: FAQs -->
      <?php if ($show_faqs): ?>
         <div class="tab-content <?php echo (!$show_description && !$show_charts && !$show_reviews) ? 'active' : ''; ?>"
            id="faqs">
            <div class="reviews-content-inn">
               <div class="faq-container">

                  <!-- FAQ Item -->
                  <div class="faq-item">
                     <div class="faq-question active">
                        <span class="arrow">
                           <img
                              src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/v.svg"
                              alt="">
                        </span>
                        <span>How do I choose a trustworthy replica timepiece store?</span>
                     </div>
                     <div class="faq-answer" style="display: block;">
                        <p>The replica market is unregulated, so caution matters. Look for:</p>
                        <ul>
                           <li>• Real product photos/videos (not copied brand images)</li>
                           <li>• Clear return and refund policy</li>
                           <li>• Verified contact details & fast support</li>
                           <li>• Secure and flexible payment options</li>
                        </ul>
                        <p><strong>WRK checks every box, and we live and breathe this craft.</strong></p>
                     </div>
                  </div>

                  <!-- Add more FAQ items below -->
                  <div class="faq-item">
                     <div class="faq-question">
                        <span class="arrow">
                           <img
                              src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/v.svg"
                              alt="">
                        </span>
                        <span>Is Superclone really 1:1?</span>
                     </div>
                     <div class="faq-answer">
                        <p>Yes, Superclone watches are built to mirror original specs down to the smallest detail.</p>
                     </div>
                  </div>

                  <div class="faq-item">
                     <div class="faq-question">
                        <span class="arrow">
                           <img
                              src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/v.svg"
                              alt="">
                        </span>
                        <span>Can I get detailed pictures before ordering?</span>
                     </div>
                     <div class="faq-answer">
                        <p>Absolutely. WRK offers real product images and videos upon request.</p>
                     </div>
                  </div>

                  <!-- Add remaining items here following the same structure -->

               </div>
            </div>
         </div>
      </div>
   <?php endif; ?>

   </div>
</section>



<div class="container single-special-top-spacer">
   <div class="divider circle-shaped"></div>
</div>


<!-- BEST SELLERS section start from here  -->
<section class="Newest special-reduction no-gradient">
   <div class="container">
      <div class="titleinlinebar">
         <h3>RELATED PRODUCTS </h3>
         <div class="seemorebtn"><a class="seemre" href="#">See More <i class="fa-solid fa-caret-right"
                  style="color: #ffffff;"></i></a></div>
      </div>
   </div>
   <div class=" grad-add">
      <div class="container">
         <div class="allnewest-products">
            <?php echo do_shortcode('[customproductsslider categoryshow="special-reductions" order="DESC" itemtoshow="10"]'); ?>
         </div>
      </div>

   </div>

</section>
<!-- BEST SELLERS section ends from here  -->



<!-- trustpilot section ends here  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      var mainImage = document.getElementById("mainProductImage");
      var thumbnails = document.querySelectorAll(".thumbnail");

      thumbnails.forEach(function (thumbnail) {
         thumbnail.addEventListener("click", function () {
            var largeImageUrl = this.getAttribute("data-large");
            mainImage.src = largeImageUrl;
            // Add class to the parent container of the main image
            var mainContainer = document.querySelector(".main-image-container");
            if (mainContainer && !mainContainer.classList.contains("has-thumb")) {
               mainContainer.classList.add("has-thumb");
            }
         });
      });

      // Initialize Thumbnail Slider with Mobile Responsive Breakpoints
      var thumbnailSwiper = new Swiper(".thumbnail-slider", {
         spaceBetween: 12,
         slidesPerView: 4, // Default Desktop View
         watchSlidesProgress: true,
         navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
         },
         breakpoints: {
            320: { slidesPerView: 4, spaceBetween: 8 },  // Small phones
            480: { slidesPerView: 4, spaceBetween: 10 }, // Medium phones
            768: { slidesPerView: 4, spaceBetween: 12 }, // Tablets & Up
         },
      });

      // Initialize Main Slider with Thumbnails
      var mainSwiper = new Swiper(".main-slider", {
         spaceBetween: 12,
         thumbs: { swiper: thumbnailSwiper },
      });

      // Zoom effect for Desktop only
      if (window.innerWidth > 768) {
         $(document).ready(function () {
            $("#mainProductImage").mousemove(function (event) {
               var zoomer = event.currentTarget;
               var offsetX = event.offsetX ? event.offsetX : event.touches[0].pageX;
               var offsetY = event.offsetY ? event.offsetY : event.touches[0].pageY;
               var x = (offsetX / zoomer.offsetWidth) * 100;
               var y = (offsetY / zoomer.offsetHeight) * 100;
               zoomer.style.transformOrigin = x + "% " + y + "%";
               zoomer.style.transform = "scale(2)";
            }).mouseleave(function () {
               $(this).css("transform", "scale(1)");
            });
         });
      }
   });

</script>
<script>
   jQuery(document).ready(function ($) {
      $('.ratingbar').slick({
         slidesToShow: 5,  // Show 3 slides at a time
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 2000,
         arrows: false,
         dots: false,
         responsive: [
            {
               breakpoint: 1290,
               settings: {
                  slidesToShow: 4
               }
            },
            {
               breakpoint: 1024,
               settings: {
                  slidesToShow: 3
               }
            },
            {
               breakpoint: 768,
               settings: {
                  slidesToShow: 2
               }
            },
            {
               breakpoint: 574,
               settings: {
                  slidesToShow: 1
               }
            }
         ]
      });

      $(".tab").click(function () {
         var tabId = $(this).attr("data-tab");

         $(".tab").removeClass("active");
         $(this).addClass("active");

         $(".tab-content").removeClass("active");
         $("#" + tabId).addClass("active");
      });

      $(".tab-button").click(function () {
         $(".tab-button").removeClass("active");
         $(this).addClass("active");

         $(".tab-content").removeClass("active");
         $("#" + $(this).data("tab")).addClass("active");
      });



   });

</script>

<script>
   jQuery(document).ready(function ($) {
      jQuery("a.active").prevAll().addBack().css("color", "#ffcc00"); // Change to your desired color
      $('.faq-question').on('click', function () {
         const parent = $(this).parent();
         const isOpen = $(this).hasClass('active');

         // Close all
         $('.faq-answer').slideUp();
         $('.faq-question').removeClass('active');

         if (!isOpen) {
            $(this).addClass('active');
            parent.find('.faq-answer').slideDown();
         }
      });
   }); 
</script>



<?php
get_footer('shop');
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
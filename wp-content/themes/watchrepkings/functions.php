<?php
add_action('wp_enqueue_scripts', 'happenstance_remove_scripts', 20);
function happenstance_remove_scripts()
{
    wp_dequeue_style('parent-style');
    wp_deregister_style('twenty-twenty-one-style');
    wp_deregister_style('twenty-twenty-one-print-style');
    wp_dequeue_script('parent-style');

    wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style('fontawesome-style', get_stylesheet_directory_uri() . '/assets/fontawesome/css/all.css');
    wp_enqueue_style('slick-style', get_stylesheet_directory_uri() . '/assets/css/slick.css');
    wp_enqueue_style('fancylight-style', get_stylesheet_directory_uri() . '/assets/css/jquery.fancybox.min.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_script('bootstrapjs', get_stylesheet_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), '', true);
    wp_enqueue_script('slickjs', get_stylesheet_directory_uri() . '/assets/js/slick.js', array('jquery'), '', true);
    wp_enqueue_script('fancylightjs', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.min.js', array('jquery'), '', true);
    wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), '', true);
}

function redirect_yearly_archive()
{
    if (isset($_GET['year']) && is_numeric($_GET['year'])) {
        $year = intval($_GET['year']);
        wp_redirect(get_year_link($year));
        exit;
    }
}
add_action('template_redirect', 'redirect_yearly_archive');


/*ACF option Pages Start*/
if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Theme Header Settings',
        'menu_title' => 'Header',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Theme Footer Settings',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Quality Control',
        'menu_title' => 'Quality Control',
        'parent_slug' => 'theme-general-settings',
    ));

}




/*ACF option Pages End*/

// ACF Product Banner Slider shortcode 
function acf_product_banner_slider()
{
    if (have_rows('product_banner_slides')):
        ob_start(); ?>

        <div id="carouselBannerIndicators" class="carousel bannerslider slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="3000">
            <div class="carousel-indicators">
                <?php $i = 0;
                while (have_rows('product_banner_slides')):
                    the_row(); ?>
                    <button type="button" data-bs-target="#carouselBannerIndicators" data-bs-slide-to="<?php echo $i; ?>"
                        class="<?php echo $i == 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>">
                    </button>
                    <?php $i++; endwhile; ?>
            </div>

            <div class="carousel-inner">
                <?php $i = 0;
                while (have_rows('product_banner_slides')):
                    the_row();
                    $product_image = get_sub_field('product_image_');
                    $discount_amount = get_sub_field('discount_amount');
                    $link_url = get_sub_field('catlink'); // returns string now
                    ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($product_image); ?>" class="d-block w-100" alt="Slide Image">
                        <div class="mybanerbtn">
                            <a href="<?php echo esc_url($link_url); ?>" class="mystillbtn">
                                SHOP NOW
                                <span >Get <?php echo esc_html($discount_amount); ?> Off on First Order</span>
                            </a>
                        </div>
                    </div>
                    <?php $i++; endwhile; ?>


            </div>
            <!-- 
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBannerIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselBannerIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
        </div>

        <?php return ob_get_clean();
    endif;
}
add_shortcode('acf_product_slider', 'acf_product_banner_slider');



// Showing product category with thumbnail 
function display_product_categories_with_thumbnails($atts)
{
    // Set default attributes
    $atts = shortcode_atts(array(
        'order' => 'ASC',
        'itemshow' => -1, // Default to show all categories
        'idtoshowfirst' => '', // Comma-separated list of category IDs to show first
    ), $atts, 'product_categories_with_thumbnails');

    // Convert ID list to an array
    $priority_ids = !empty($atts['idtoshowfirst']) ? array_map('trim', explode(',', $atts['idtoshowfirst'])) : [];

    // Get all product categories
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'orderby' => 'name',
        'order' => $atts['order'],
        'hide_empty' => true, // Show only categories with products
    ));

    // Check if there are categories
    if (!empty($terms) && !is_wp_error($terms)) {
        $output = '<div class="product-categories-list">';

        // Separate priority and regular categories
        $priority_terms = [];
        $regular_terms = [];

        foreach ($terms as $term) {
            if (in_array($term->term_id, $priority_ids)) {
                $priority_terms[] = $term;
            } else {
                $regular_terms[] = $term;
            }
        }

        // Merge so that priority terms appear first
        $sorted_terms = array_merge($priority_terms, $regular_terms);

        $counter = 0; // Initialize counter for categories
        foreach ($sorted_terms as $term) {
            // If itemshow is set to a specific number, limit the number of items shown
            if ($atts['itemshow'] != -1 && $counter >= $atts['itemshow']) {
                break; // Stop after the specified number of items
            }

            // Get the category thumbnail URL
            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            $thumbnail_url = wp_get_attachment_url($thumbnail_id);

            // Display the category with its thumbnail
            $output .= '<div class="product-category-item">';
            $output .= '<a href="' . esc_url(get_term_link($term)) . '">';

            if ($thumbnail_url) {
                $output .= '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($term->name) . '" />';
            }

            $output .= '</a>';
            $output .= '</div>';

            $counter++;
        }

        $output .= '</div>'; // Close product-categories-list
    } else {
        $output = '<p>No product categories found.</p>';
    }

    return $output;
}
// Register the shortcode
add_shortcode('product_categories_with_thumbnails', 'display_product_categories_with_thumbnails');


// Custom products show shortcode 
function custom_products_shortcode($atts)
{
    ob_start();

    $atts = shortcode_atts([
        'categoryshow' => '',
        'order' => 'ASC',
        'itemtoshow' => '10',
    ], $atts, 'customproducts');

    $args = [
        'post_type' => 'product',
        'posts_per_page' => intval($atts['itemtoshow']),
        'order' => $atts['order'],
    ];

    if (!empty($atts['categoryshow'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $atts['categoryshow'],
            ]
        ];
    }

    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        while ($loop->have_posts()):
            $loop->the_post();
            ?>
            <div class="products-listing">
                <div class="products-listingin">
                    <div class="products-listingin-row">
                        <div class="product-thumbanil">
                            <?php
                            // Check if the 'label_hot_now_active' ACF field is true
                            $label_hot_now_active = get_field('label_hot_now_active');
                            if ($label_hot_now_active): ?>
                                <div class="label-hotted">
                                    <label><img
                                            src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg"
                                            alt="fireicon" /> Hot Right Now</label>
                                </div>
                            <?php endif; ?>

                            <div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide" data-bs-ride="carousel"
                                data-bs-interval="10000">
                                <div class="carousel-indicators">
                                    <?php
                                    $product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                                    $attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
                                    $active_class = 'active';
                                    foreach ($attachment_ids as $index => $attachment_id):
                                        ?>
                                        <button type="button" data-bs-target="#carouselproductsIndicators-<?php the_ID(); ?>"
                                            data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $active_class; ?>"
                                            aria-current="<?php echo $active_class == 'active' ? 'true' : 'false'; ?>"
                                            aria-label="Slide <?php echo $index + 1; ?>"></button>
                                        <?php
                                        $active_class = '';
                                    endforeach;
                                    ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php
                                    $active_class = 'active';
                                    foreach ($attachment_ids as $attachment_id):
                                        $image_url = wp_get_attachment_url($attachment_id);
                                        ?>
                                        <div class="carousel-item <?php echo $active_class; ?>">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>"
                                                    class="d-block w-100" alt="Product Image"></a>
                                        </div>
                                        <?php
                                        $active_class = '';
                                    endforeach;
                                    ?>
                                    <div class="quick-view-btnn" style="display:none;">
                                        <!--a href="<?php the_permalink(); ?>">Quick View </a-->
                                        <?php echo do_shortcode('[yith_quick_view product_id="' . get_the_ID() . '"]'); ?>


                                    </div>
                                </div>
                            </div>

                            <!-- Show Brand Logo on Product Thumbnail -->
                            <?php
                            // Check if the 'show_brand_label_on_product_thumbnail' ACF field is true
                            $label_ShowBrand_active = get_field('show_brand_label_on_product_thumbnail');
                            if (!empty($label_ShowBrand_active)): ?>
                                <div class="show-brandlogo">
                                    <label><img
                                            src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/YellowWRKLogo-1.svg"
                                            alt="Brand Logo" /></label>
                                </div>
                            <?php endif; ?>
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
                                    <div class="reviewbar-pr">
                                        <!-- Display Review Rating Stars -->
                                        <?php
                                        $product = wc_get_product(get_the_ID());
                                        if ($product) {
                                            echo wc_get_rating_html($product->get_average_rating()); // Display star ratings
                                        }
                                        ?>
                                    </div>

                            </div>
                            <div class="ryt">
                                <?php
                                $product = wc_get_product(get_the_ID());

                                if ($product) {
                                    if ($product->is_type('variable')) {
                                        // Get default variation ID
                                        $default_attributes = $product->get_default_attributes();
                                        $available_variations = $product->get_available_variations();
                                        $default_variation_price = '';

                                        foreach ($available_variations as $variation) {
                                            $variation_id = $variation['variation_id'];
                                            $variation_product = wc_get_product($variation_id);

                                            // Check if this variation matches default attributes
                                            $match = true;
                                            foreach ($default_attributes as $key => $value) {
                                                if (!isset($variation['attributes']['attribute_' . $key]) || $variation['attributes']['attribute_' . $key] !== $value) {
                                                    $match = false;
                                                    break;
                                                }
                                            }

                                            if ($match) {
                                                $default_variation_price = $variation_product->get_price();
                                                $regular_price = $variation_product->get_regular_price();
                                                $sale_price = $variation_product->get_sale_price();
                                                break;
                                            }
                                        }

                                        // If no default variation found, use the first variation price
                                        if (empty($default_variation_price) && !empty($available_variations)) {
                                            $first_variation = wc_get_product($available_variations[0]['variation_id']);
                                            $default_variation_price = $first_variation->get_price();
                                            $regular_price = $first_variation->get_regular_price();
                                            $sale_price = $first_variation->get_sale_price();
                                        }
                                    } else {
                                        // Simple Product
                                        $regular_price = $product->get_regular_price();
                                        $sale_price = $product->get_sale_price();
                                    }

                                    // Format prices
                                    $formatted_regular_price = wc_price($regular_price);
                                    $formatted_sale_price = !empty($sale_price) ? wc_price($sale_price) : '';

                                    if (!empty($sale_price) && $sale_price < $regular_price): ?>
                                        <span class="regular-price add1">
                                            <span class="from-text">From</span> <del> <?php echo $formatted_regular_price; ?></del>
                                        </span>
                                        <span class="discount-price">
                                            <?php echo $formatted_sale_price; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="regular-price">
                                            <?php echo $formatted_regular_price; ?>
                                        </span>
                                    <?php endif;
                                } ?>


                            </div>
                        </div>
                        <div class="addtocart newft fd">

                            <?php if (class_exists('YITH_WCWL')): ?>
                                <div class="wishlist-button">
                                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                                </div>
                            <?php endif; ?>

                            <?php woocommerce_template_loop_add_to_cart(); ?>

                            <div class="countdownbar">
                                <?php
                                global $product;
                                $sale_end_time = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

                                if (!empty($sale_end_time)):  // Check if sale is scheduled
                                    $sale_end_time = date('Y-m-d H:i:s', $sale_end_time); // Format sale end time
                                    ?>
                                    <div class="sale-countdown" data-time="<?php echo esc_attr($sale_end_time); ?>">
                                        Sale ends in <span class="countdown-timer"></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                        <script>
                            jQuery(document).ready(function ($) {
                                $(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
                                    // Remove View Cart button
                                    $('.added_to_cart').remove();
                                });
                            });
                        </script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let countdownElements = document.querySelectorAll(".sale-countdown"); // Select all countdowns

                                countdownElements.forEach(function (countdownElement) {
                                    let endTime = countdownElement.getAttribute("data-time");
                                    let endDate = new Date(endTime).getTime();
                                    let timerSpan = countdownElement.querySelector(".countdown-timer");

                                    function updateCountdown() {
                                        let now = new Date().getTime();
                                        let timeLeft = endDate - now;

                                        if (timeLeft > 0) {
                                            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                                            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                                            timerSpan.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                        } else {
                                            countdownElement.style.display = "none"; // Hide countdown if sale ends
                                        }
                                    }

                                    updateCountdown();
                                    setInterval(updateCountdown, 1000);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No products found.</p>';
    endif;

    // Add JavaScript to initialize carousels for dynamic elements
    ?>
    <script>
        jQuery(document).ready(function ($) {
            // Initialize all carousels
            $('.carousel').each(function () {
                var carousel = $(this);
                if (!carousel.hasClass('initialized')) {
                    carousel.carousel(); // Initialize the carousel
                    carousel.addClass('initialized'); // Add class to avoid re-initializing
                }
            });
        });
    </script>
    <?php

    return ob_get_clean();
}
add_shortcode('customproducts', 'custom_products_shortcode');




// BLOG-SHORTCODE
function recent_blog_posts($atts)
{
    ob_start(); // Start output buffering

    $atts = shortcode_atts(array(
        'itemtoshow' => 3, // Number of posts to display
    ), $atts, 'recent_blog_posts');

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => intval($atts['itemtoshow']), // Ensuring only the specified number of posts are shown
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()):
        echo '<div class="row">';
        while ($the_query->have_posts()):
            $the_query->the_post(); ?>
            <div class="col-md-4 blog-grid">
                <a class="review" href="<?php the_permalink(); ?>">
                    <div class="blog-featured-img">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>
                        <div class="blog-categories">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '';
                                $category_links = array();
                                foreach ($categories as $category) {
                                    $category_links[] = '<span>' . esc_html($category->name) . '</span>';
                                }
                                echo implode(', ', $category_links);
                            }
                            ?>
                        </div>
                    </div>
                    <h4 class="nm"><?php the_title(); ?></h4>
                    <h4 class="content"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></h4>

                </a>
            </div>
        <?php endwhile;
        echo '</div>';
    endif;

    wp_reset_postdata(); // Reset post data

    return ob_get_clean(); // Return buffered output
}

add_shortcode('recent_blog_posts', 'recent_blog_posts');







add_filter('term_link', 'custom_remove_product_category_base', 10, 3);
function custom_remove_product_category_base($url, $term, $taxonomy)
{
    if ($taxonomy === 'product_cat') {
        return home_url('/' . $term->slug . '/');
    }
    return $url;
}

// Add Rewrite Rules for Product Categories
function custom_product_category_rewrite_rules($rules)
{
    $new_rules = [];
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ]);

    if ($categories) {
        foreach ($categories as $category) {
            $new_rules[$category->slug . '/?$'] = 'index.php?product_cat=' . $category->slug;
            $new_rules[$category->slug . '/page/([0-9]{1,})/?$'] = 'index.php?product_cat=' . $category->slug . '&paged=$matches[1]';
        }
    }

    return $new_rules + $rules;
}
add_filter('rewrite_rules_array', 'custom_product_category_rewrite_rules');

// Flush Rewrite Rules on Theme Activation
function flush_product_category_rewrite_rules()
{
    flush_rewrite_rules();
}
add_action('init', 'flush_product_category_rewrite_rules');



// PRICES products show shortcode

function prices_products_shortcode($atts)
{
    ob_start();

    $atts = shortcode_atts([
        'categoryshow' => '',
        'order' => 'ASC',
        'itemtoshow' => '10',
    ], $atts, 'customproducts');

    $args = [
        'post_type' => 'product',
        'posts_per_page' => intval($atts['itemtoshow']),
        'order' => 'ASC', // Low to High
        'orderby' => 'meta_value_num',
        'meta_key' => '_price',
        'meta_query' => [
            [
                'key' => '_price',
                'value' => 0,
                'compare' => '>=', // Ensure we only get products with a valid price
                'type' => 'NUMERIC',
            ]
        ]
    ];
    if (!empty($atts['categoryshow'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $atts['categoryshow'],
            ]
        ];
    }

    $loop = new WP_Query($args);

    // Start the product listing wrapper outside the loop
    if ($loop->have_posts()):


        while ($loop->have_posts()):
            $loop->the_post();
            ?>
            <div class="products-listing">
                <div class="products-listingin">
                    <div class="products-listingin-row">
                        <div class="product-thumbanil">
                            <?php
                            // Check if the 'label_hot_now_active' ACF field is true
                            $label_hot_now_active = get_field('label_hot_now_active');
                            if ($label_hot_now_active): ?>
                                <div class="label-hotted">
                                    <label><img
                                            src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg"
                                            alt="fireicon" /> Hot Right Now</label>
                                </div>
                            <?php endif; ?>

                            <div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide" data-bs-ride="carousel"
                                data-bs-interval="10000">
                                <div class="carousel-indicators">
                                    <?php
                                    $product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                                    $attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
                                    $active_class = 'active';
                                    foreach ($attachment_ids as $index => $attachment_id):
                                        ?>
                                        <button type="button" data-bs-target="#carouselproductsIndicators-<?php the_ID(); ?>"
                                            data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $active_class; ?>"
                                            aria-current="<?php echo $active_class == 'active' ? 'true' : 'false'; ?>"
                                            aria-label="Slide <?php echo $index + 1; ?>"></button>
                                        <?php
                                        $active_class = '';
                                    endforeach;
                                    ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php
                                    $active_class = 'active';
                                    foreach ($attachment_ids as $attachment_id):
                                        $image_url = wp_get_attachment_url($attachment_id);
                                        ?>
                                        <div class="carousel-item <?php echo $active_class; ?>">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>"
                                                    class="d-block w-100" alt="Product Image"></a>
                                        </div>
                                        <?php
                                        $active_class = '';
                                    endforeach;
                                    ?>
                                    <div class="quick-view-btnn" style="display:none;">
                                        <!--a href="<?php the_permalink(); ?>">Quick View </a-->
                                        <?php echo do_shortcode('[yith_quick_view product_id="' . get_the_ID() . '"]'); ?>

                                    </div>
                                </div>
                            </div>

                            <!-- Show Brand Logo on Product Thumbnail -->
                            <?php
                            // Check if the 'show_brand_label_on_product_thumbnail' ACF field is true
                            $label_ShowBrand_active = get_field('show_brand_label_on_product_thumbnail');
                            if (!empty($label_ShowBrand_active)): ?>
                                <div class="show-brandlogo">
                                    <label><img
                                            src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/YellowWRKLogo-1.svg"
                                            alt="Brand Logo" /></label>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="product-detail">
                            <div class="left">
                                <h4>
                                    <?php
                                    $watch_name = get_field('watch_name');
                                    echo $watch_name ? esc_html($watch_name) : '';
                                    ?>
                                </h4>
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

                                    // Format prices properly with two decimal places
                                    $formatted_regular_price = wc_price($regular_price);
                                    $formatted_sale_price = $sale_price ? wc_price($sale_price) : '';

                                    if (!empty($sale_price) && $sale_price < $regular_price): ?>
                                        <span class="regular-price add1">
                                            <span class="from-text">From</span> <del> <?php echo $formatted_regular_price; ?></del>
                                        </span>
                                        <span class="discount-price">
                                            <?php echo $formatted_sale_price; ?>
                                        </span>
                                    <?php else: ?>
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
    else:
        echo '<p>No products found.</p>';
    endif;

    // Add JavaScript to initialize carousels for dynamic elements
    ?>
    <script>
        jQuery(document).ready(function ($) {
            // Initialize all carousels
            $('.carousel').each(function () {
                var carousel = $(this);
                if (!carousel.hasClass('initialized')) {
                    carousel.carousel(); // Initialize the carousel
                    carousel.addClass('initialized'); // Add class to avoid re-initializing
                }
            });
        });
    </script>
    <?php

    return ob_get_clean();
}
add_shortcode('pricecustomproducts', 'prices_products_shortcode');



add_action('woocommerce_single_product_summary', 'display_wishlist_button_on_single_product', 35);

function display_wishlist_button_on_single_product()
{
    if (function_exists('webtoffee_add_to_wishlist_button')) {
        // Display the Add to Wishlist button
        echo '<div class="product-wishlist-button">';
        webtoffee_add_to_wishlist_button(); // Function to display the wishlist button
        echo '</div>';
    }
}


function custom_product_filter_shortcode()
{
    // Get product brands
    $brands = get_terms(array(
        'taxonomy' => 'product_brand',
        'hide_empty' => false,
        'parent' => 0, // Fetch only parent brands
    ));

    // Get product categories
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    ob_start();
    ?>
    <div class="custCatsFilterLft">
        <div class="custCatsFilterTtl">
            <h2>CATEGORY</h2>
            <button class="filterbtn" type="button"><img
                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/04/filters.png"
                    alt="filterbtn"></button>
        </div>
        <div class="custCatsFilterList">
            <button class="filtercloseicoin" type="button">
                <img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/04/close.png"
                    alt="filterbtn">
            </button>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var filterBtn = document.querySelector(".filterbtn");
                    var filterList = document.querySelector(".custCatsFilterList");
                    var closeBtn = document.querySelector(".filtercloseicoin");
                    var body = document.querySelector("body");

                    // Toggle the active class on button click
                    filterBtn.addEventListener("click", function () {
                        filterList.classList.toggle("active");  // Show or hide the modal
                        body.classList.toggle("scrollstop");  // Show or hide the modal
                    });

                    // Close the modal when the close button is clicked
                    closeBtn.addEventListener("click", function () {
                        filterList.classList.remove("active");  // Hide the modal
                        body.classList.remove("scrollstop");
                    });
                });

            </script>
            <div class="custCatsFilter-left-grid brand-fltrr">
                <h4>Brand</h4>
                <ul class="brands-list">
                    <?php if (!empty($brands) && !is_wp_error($brands)): ?>
                        <?php foreach ($brands as $brand): ?>
                            <li>
                                <button class="brand-toggle" data-brand="<?php echo esc_attr($brand->slug); ?>">
                                    <?php echo esc_html($brand->name); ?>

                                </button>
                                <div class="brand-content">
                                    <div class="models">
                                        <p>Model:</p>
                                        <ul>
                                            <?php
                                            // Get brand sub names (child terms of the current brand)
                                            $sub_brands = get_terms(array(
                                                'taxonomy' => 'product_brand',
                                                'hide_empty' => false,
                                                'parent' => $brand->term_id,
                                            ));

                                            if (!empty($sub_brands) && !is_wp_error($sub_brands)):
                                                foreach ($sub_brands as $sub_brand):
                                                    ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="sub-brand"
                                                            data-brand="<?php echo esc_attr($sub_brand->slug); ?>"
                                                            data-parent="<?php echo esc_attr($brand->slug); ?>">
                                                            <?php echo esc_html($sub_brand->name); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No Models found.</p>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="custCatsFilter-left-grid price-filter">
                <h4>Prices</h4>
                <div class="fltr-by-price">Filter by Price</div>
                <div id="price-range"></div>
                <input type="hidden" id="min_price" name="min_price" value="0">
                <input type="hidden" id="max_price" name="max_price" value="1000">
                <p>Price: <span id="price-range-text">0 - 1000</span></p>
            </div>
            <div class="custCatsFilter-left-grid cate-bar">

                <div class="category-links">
                    <?php
                    // Define the specific categories you want to show
                    $specific_categories = array('best-seller', 'newest', 'flex-up', 'all-black', 'special-reductions');

                    if (!empty($categories) && !is_wp_error($categories)):
                        foreach ($categories as $category):
                            // Only display the category if its slug is in our specified list
                            if (in_array($category->slug, $specific_categories)):
                                ?>
                                <h4 href="javascript:void(0);" class="category-link"
                                    data-category="<?php echo esc_attr($category->slug); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </h4>
                                <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div class="custCatsFilterRt">
        <div class="allnewest-products" id="showresult">
            <?php
            // Initially load all products
            echo display_all_products();
            ?>
        </div>
    </div>

    <style>

    </style>

    <script>
        jQuery(document).ready(function ($) {

            // Handle the collapsible toggle button click
            $('.btncollapse').on('click', function (e) {
                e.stopPropagation(); // Prevent the click from triggering the parent button
                $(this).closest('.brand-toggle').next('.brand-content').slideToggle();

                // Toggle the plus/minus sign
                if ($(this).text() === '+') {
                    $(this).text('-');
                } else {
                    $(this).text('+');
                }
            });
            // Handle brand toggle click (for filtering)
            $('.brand-toggle').on('click', function (e) {
                if (!$(e.target).hasClass('btncollapse')) {
                    var selectedBrand = $(this).data('brand');

                    // Add active class to the clicked button
                    $('.brand-toggle').removeClass('active');
                    $(this).addClass('active');

                    // Update URL without reloading the page
                    updateURL('brand', selectedBrand);

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: {
                            action: 'filter_products',
                            brands: [selectedBrand],
                            show_all_subbrand: true // New parameter to show all subbrand products
                        },
                        beforeSend: function () {
                            $("#showresult").html("<p class='loaderbar'><span class='loader'></span></p>");
                        },
                        success: function (response) {
                            $("#showresult").html(response);
                        }
                    });
                }
            });

            // Handle sub-brand click
            // Handle sub-brand click
            $('.sub-brand').on('click', function () {
                var selectedBrand = $(this).data('brand');
                var parentBrand = $(this).data('parent');

                // Add active class to the clicked link
                $('.sub-brand').removeClass('active');
                $(this).addClass('active');

                // Update URL with the correct path
                updateURL('brand', parentBrand + '/' + selectedBrand);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'filter_products',
                        brands: [selectedBrand]
                    },
                    beforeSend: function () {
                        $("#showresult").html("<p class='loaderbar'><span class='loader'></span></p>");
                    },
                    success: function (response) {
                        $("#showresult").html(response);
                    }
                });
            });

            // Function to update the URL with filter parameters
            // Function to update the URL with filter parameters
            // Function to update the URL with filter parameters
            function updateURL(key, value) {
                if (history.pushState) {
                    // Start with the base URL (domain and path before any parameters)
                    var baseUrl = window.location.protocol + "//" + window.location.host + "/devsites/WBC213/watchrepkings/collection/";

                    // Create the new URL with the filter parameters
                    var newurl = baseUrl + key + '/' + value + '/';

                    window.history.pushState({ path: newurl }, '', newurl);
                }
            }

            // Handle category link click
            // Handle category link click
            $('.category-link').on('click', function () {
                var selectedCategory = $(this).data('category');

                // Add active class to the clicked link
                $('.category-link').removeClass('active');
                $(this).addClass('active');

                // Update URL with the category path
                updateURL('category', selectedCategory);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'filter_products',
                        categories: [selectedCategory]
                    },
                    beforeSend: function () {
                        $("#showresult").html("<p class='loaderbar'><span class='loader'></span></p>");
                    },
                    success: function (response) {
                        $("#showresult").html(response);
                    }
                });
            });

            // Price slider
            $("#price-range").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [0, 1000],
                slide: function (event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                    $("#price-range-text").text(ui.values[0] + " - " + ui.values[1]);
                },
                change: function (event, ui) {
                    filterProducts();
                }
            });

            // Function to trigger filter by price
            function filterProducts() {
                var minPrice = $("#min_price").val();
                var maxPrice = $("#max_price").val();

                // AJAX request
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'filter_products',
                        min_price: minPrice,
                        max_price: maxPrice
                    },
                    beforeSend: function () {
                        $("#showresult").html("<p class='loaderbar'><span class='loader'></span></p>");
                    },
                    success: function (response) {
                        $("#showresult").html(response);
                    }
                });
            }
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_product_filter', 'custom_product_filter_shortcode');

// Function to display all products (used on initial page load)
function display_all_products()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    ob_start();
    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            display_product_template();
        }
        wp_reset_postdata();
    } else {
        echo '<p>No products found.</p>';
    }

    return ob_get_clean();
}

// Function to display product template (used in both initial load and filtering)
function display_product_template()
{
    ?>
    <div class="products-listing">
        <div class="products-listingin">
            <div class="products-listingin-row">
                <div class="product-thumbanil">
                    <?php
                    // Check if the 'label_hot_now_active' ACF field is true
                    $label_hot_now_active = get_field('label_hot_now_active');
                    if ($label_hot_now_active): ?>
                        <div class="label-hotted">
                            <label><img
                                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg"
                                    alt="fireicon" /> Hot Right Now</label>
                        </div>
                    <?php endif; ?>

                    <div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide" data-bs-ride="carousel"
                        data-bs-interval="10000">
                        <div class="carousel-indicators">
                            <?php
                            $product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                            $attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
                            $active_class = 'active';
                            foreach ($attachment_ids as $index => $attachment_id):
                                ?>
                                <button type="button" data-bs-target="#carouselproductsIndicators-<?php the_ID(); ?>"
                                    data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $active_class; ?>"
                                    aria-current="<?php echo $active_class == 'active' ? 'true' : 'false'; ?>"
                                    aria-label="Slide <?php echo $index + 1; ?>"></button>
                                <?php
                                $active_class = '';
                            endforeach;
                            ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                            $active_class = 'active';
                            foreach ($attachment_ids as $attachment_id):
                                $image_url = wp_get_attachment_url($attachment_id);
                                ?>
                                <div class="carousel-item <?php echo $active_class; ?>">
                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>"
                                            class="d-block w-100" alt="Product Image"></a>
                                </div>
                                <?php
                                $active_class = '';
                            endforeach;
                            ?>
                            <div class="quick-view-btnn" style="display:none;">
                                <!--a href="<?php the_permalink(); ?>">Quick View ----- </a-->

                                <?php echo do_shortcode('[yith_quick_view product_id="' . get_the_ID() . '"]'); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Show Brand Logo on Product Thumbnail -->
                    <?php
                    // Check if the 'show_brand_label_on_product_thumbnail' ACF field is true
                    $label_ShowBrand_active = get_field('show_brand_label_on_product_thumbnail');
                    if (!empty($label_ShowBrand_active)): ?>
                        <div class="show-brandlogo">
                            <label><img
                                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/YellowWRKLogo-1.svg"
                                    alt="Brand Logo" /></label>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-detail dfdf">
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
                            <div class="reviewbar-pr">
                                <!-- Display Review Rating Stars -->
                                <?php
                                $product = wc_get_product(get_the_ID());
                                if ($product) {
                                    echo wc_get_rating_html($product->get_average_rating()); // Display star ratings
                                }
                                ?>
                            </div>

                    </div>
                    <div class="ryt">
                        <?php
                        $product = wc_get_product(get_the_ID());

                        if ($product) {
                            if ($product->is_type('variable')) {
                                // Get default variation ID
                                $default_attributes = $product->get_default_attributes();
                                $available_variations = $product->get_available_variations();
                                $default_variation_price = '';

                                foreach ($available_variations as $variation) {
                                    $variation_id = $variation['variation_id'];
                                    $variation_product = wc_get_product($variation_id);

                                    // Check if this variation matches default attributes
                                    $match = true;
                                    foreach ($default_attributes as $key => $value) {
                                        if (!isset($variation['attributes']['attribute_' . $key]) || $variation['attributes']['attribute_' . $key] !== $value) {
                                            $match = false;
                                            break;
                                        }
                                    }

                                    if ($match) {
                                        $default_variation_price = $variation_product->get_price();
                                        $regular_price = $variation_product->get_regular_price();
                                        $sale_price = $variation_product->get_sale_price();
                                        break;
                                    }
                                }

                                // If no default variation found, use the first variation price
                                if (empty($default_variation_price) && !empty($available_variations)) {
                                    $first_variation = wc_get_product($available_variations[0]['variation_id']);
                                    $default_variation_price = $first_variation->get_price();
                                    $regular_price = $first_variation->get_regular_price();
                                    $sale_price = $first_variation->get_sale_price();
                                }
                            } else {
                                // Simple Product
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                            }

                            // Format prices
                            $formatted_regular_price = wc_price($regular_price);
                            $formatted_sale_price = !empty($sale_price) ? wc_price($sale_price) : '';

                            if (!empty($sale_price) && $sale_price < $regular_price): ?>
                                <span class="regular-price add1">
                                    <span class="from-text">From</span> <del> <?php echo $formatted_regular_price; ?></del>
                                </span>
                                <span class="discount-price">
                                    <?php echo $formatted_sale_price; ?>
                                </span>
                            <?php else: ?>
                                <span class="regular-price">
                                    <?php echo $formatted_regular_price; ?>
                                </span>
                            <?php endif;
                        } ?>


                    </div>
                </div>
                <div class="addtocart newft fd">

                    <?php if (class_exists('YITH_WCWL')): ?>
                        <div class="wishlist-button">
                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                        </div>
                    <?php endif; ?>

                    <?php woocommerce_template_loop_add_to_cart(); ?>

                    <div class="countdownbar">
                        <?php
                        global $product;
                        $sale_end_time = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

                        if (!empty($sale_end_time)):  // Check if sale is scheduled
                            $sale_end_time = date('Y-m-d H:i:s', $sale_end_time); // Format sale end time
                            ?>
                            <div class="sale-countdown" data-time="<?php echo esc_attr($sale_end_time); ?>">
                                Sale ends in <span class="countdown-timer"></span>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
                            // Remove View Cart button
                            $('.added_to_cart').remove();
                        });
                    });
                </script>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let countdownElements = document.querySelectorAll(".sale-countdown"); // Select all countdowns

                        countdownElements.forEach(function (countdownElement) {
                            let endTime = countdownElement.getAttribute("data-time");
                            let endDate = new Date(endTime).getTime();
                            let timerSpan = countdownElement.querySelector(".countdown-timer");

                            function updateCountdown() {
                                let now = new Date().getTime();
                                let timeLeft = endDate - now;

                                if (timeLeft > 0) {
                                    let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                                    let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                    let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                                    timerSpan.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                } else {
                                    countdownElement.style.display = "none"; // Hide countdown if sale ends
                                }
                            }

                            updateCountdown();
                            setInterval(updateCountdown, 1000);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <?php
}

// AJAX handler to filter products
// Update the filter_products function to handle parent brands with all subbrands
function filter_products()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array('relation' => 'AND'),
        'meta_query' => array(),
    );

    // Filter by brand
    if (!empty($_POST['brands']) && is_array($_POST['brands'])) {
        // Check if we're showing all subbrands of a parent brand
        if (isset($_POST['show_all_subbrand']) && $_POST['show_all_subbrand'] == true) {
            // Get the parent brand
            $parent_brand = $_POST['brands'][0];

            // Get all subbrands of this parent
            $parent_term = get_term_by('slug', $parent_brand, 'product_brand');
            if ($parent_term) {
                $sub_brands = get_terms(array(
                    'taxonomy' => 'product_brand',
                    'hide_empty' => false,
                    'parent' => $parent_term->term_id,
                ));

                $brand_slugs = array($parent_brand); // Include parent brand

                // Add all subbrand slugs
                if (!empty($sub_brands) && !is_wp_error($sub_brands)) {
                    foreach ($sub_brands as $sub_brand) {
                        $brand_slugs[] = $sub_brand->slug;
                    }
                }

                $args['tax_query'][] = array(
                    'taxonomy' => 'product_brand',
                    'field' => 'slug',
                    'terms' => $brand_slugs,
                    'operator' => 'IN',
                );
            } else {
                // Fallback to just the selected brand
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_brand',
                    'field' => 'slug',
                    'terms' => $_POST['brands'],
                );
            }
        } else {
            // Normal brand filtering
            $args['tax_query'][] = array(
                'taxonomy' => 'product_brand',
                'field' => 'slug',
                'terms' => $_POST['brands'],
            );
        }
    }

    // Rest of your existing filter_products function...

    // Filter by category
    if (!empty($_POST['categories']) && is_array($_POST['categories'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $_POST['categories'],
        );
    }

    // Filter by price
    if (isset($_POST['min_price']) && isset($_POST['max_price'])) {
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => array((float) $_POST['min_price'], (float) $_POST['max_price']),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC',
        );
    }

    // Query products
    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            display_product_template();
        }
        wp_reset_postdata();
    } else {
        echo '<p>No products found matching your criteria.</p>';
    }

    die();
}
add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');

// Enqueue custom scripts and styles
function enqueue_custom_ajax_filter_scripts()
{
    wp_enqueue_script('jquery-ui-slider'); // jQuery UI slider for price range
    wp_enqueue_style('jquery-ui-style', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'); // jQuery UI styles
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_filter_scripts');


// Custom products show shortcode 
function custom_products_slider_shortcode($atts)
{
    ob_start();

    $atts = shortcode_atts([
        'categoryshow' => '',
        'order' => 'ASC',
        'itemtoshow' => '10',
    ], $atts, 'customproducts');

    $args = [
        'post_type' => 'product',
        'posts_per_page' => intval($atts['itemtoshow']),
        'order' => $atts['order'],
    ];

    if (!empty($atts['categoryshow'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $atts['categoryshow'],
            ]
        ];
    }

    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        $unique_id = uniqid('slider_');
        ?>
        <div class="allnewest-products sliderallnewest-container <?php echo $unique_id; ?>">
            <button class="prev-arrow">&#10094;</button>
            <div class="products-slider">
                <?php
                while ($loop->have_posts()):
                    $loop->the_post();
                    ?>
                    <div class="products-listing">
                        <div class="products-listingin">
                            <div class="products-listingin-row">
                                <div class="product-thumbanil">
                                    <?php
                                    // Check if the 'label_hot_now_active' ACF field is true
                                    $label_hot_now_active = get_field('label_hot_now_active');
                                    if ($label_hot_now_active): ?>
                                        <div class="label-hotted">
                                            <label><img
                                                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg"
                                                    alt="fireicon" /> Hot Right Now</label>
                                        </div>
                                    <?php endif; ?>

                                    <div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide"
                                        data-bs-ride="carousel" data-bs-interval="10000">
                                        <div class="carousel-inner">
                                            <?php
                                            $product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                                            $attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
                                            $active_class = 'active';
                                            foreach ($attachment_ids as $attachment_id):
                                                $image_url = wp_get_attachment_url($attachment_id);
                                                ?>
                                                <div class="carousel-item <?php echo $active_class; ?>">
                                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>"
                                                            class="d-block w-100" alt="Product Image"></a>
                                                </div>
                                                <?php
                                                $active_class = '';
                                            endforeach;
                                            ?>
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
                                            <h5>Ref: <?php echo esc_html(get_field('ref_no') ? get_field('ref_no') : 'No Ref'); ?>
                                            </h5>
                                            <div class="reviewbar-pr">
                                                <!-- Display Review Rating Stars -->
                                                <?php
                                                $product = wc_get_product(get_the_ID());
                                                if ($product) {
                                                    echo wc_get_rating_html($product->get_average_rating()); // Display star ratings
                                                }
                                                ?>
                                            </div>

                                    </div>
                                    <div class="ryt">
                                        <?php
                                        $product = wc_get_product(get_the_ID());

                                        if ($product) {
                                            if ($product->is_type('variable')) {
                                                // Get default variation ID
                                                $default_attributes = $product->get_default_attributes();
                                                $available_variations = $product->get_available_variations();
                                                $default_variation_price = '';

                                                foreach ($available_variations as $variation) {
                                                    $variation_id = $variation['variation_id'];
                                                    $variation_product = wc_get_product($variation_id);

                                                    // Check if this variation matches default attributes
                                                    $match = true;
                                                    foreach ($default_attributes as $key => $value) {
                                                        if (!isset($variation['attributes']['attribute_' . $key]) || $variation['attributes']['attribute_' . $key] !== $value) {
                                                            $match = false;
                                                            break;
                                                        }
                                                    }

                                                    if ($match) {
                                                        $default_variation_price = $variation_product->get_price();
                                                        $regular_price = $variation_product->get_regular_price();
                                                        $sale_price = $variation_product->get_sale_price();
                                                        break;
                                                    }
                                                }

                                                // If no default variation found, use the first variation price
                                                if (empty($default_variation_price) && !empty($available_variations)) {
                                                    $first_variation = wc_get_product($available_variations[0]['variation_id']);
                                                    $default_variation_price = $first_variation->get_price();
                                                    $regular_price = $first_variation->get_regular_price();
                                                    $sale_price = $first_variation->get_sale_price();
                                                }
                                            } else {
                                                // Simple Product
                                                $regular_price = $product->get_regular_price();
                                                $sale_price = $product->get_sale_price();
                                            }

                                            // Format prices
                                            $formatted_regular_price = wc_price($regular_price);
                                            $formatted_sale_price = !empty($sale_price) ? wc_price($sale_price) : '';

                                            if (!empty($sale_price) && $sale_price < $regular_price): ?>
                                                <span class="regular-price add1">
                                                    <span class="from-text">From</span> <del> <?php echo $formatted_regular_price; ?></del>
                                                </span>
                                                <span class="discount-price">
                                                    <?php echo $formatted_sale_price; ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="regular-price">
                                                    <?php echo $formatted_regular_price; ?>
                                                </span>
                                            <?php endif;
                                        } ?>


                                    </div>
                                </div>
                                <div class="addtocart newft fd">

                                    <?php if (class_exists('YITH_WCWL')): ?>
                                        <div class="wishlist-button">
                                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php woocommerce_template_loop_add_to_cart(); ?>

                                    <div class="countdownbar">
                                        <?php
                                        global $product;
                                        $sale_end_time = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

                                        if (!empty($sale_end_time)):  // Check if sale is scheduled
                                            $sale_end_time = date('Y-m-d H:i:s', $sale_end_time); // Format sale end time
                                            ?>
                                            <div class="sale-countdown" data-time="<?php echo esc_attr($sale_end_time); ?>">
                                                Sale ends in <span class="countdown-timer"></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                                <script>
                                    jQuery(document).ready(function ($) {
                                        $(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
                                            // Remove View Cart button
                                            $('.added_to_cart').remove();
                                        });
                                    });
                                </script>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let countdownElements = document.querySelectorAll(".sale-countdown"); // Select all countdowns

                                        countdownElements.forEach(function (countdownElement) {
                                            let endTime = countdownElement.getAttribute("data-time");
                                            let endDate = new Date(endTime).getTime();
                                            let timerSpan = countdownElement.querySelector(".countdown-timer");

                                            function updateCountdown() {
                                                let now = new Date().getTime();
                                                let timeLeft = endDate - now;

                                                if (timeLeft > 0) {
                                                    let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                                                    let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                                    let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                                                    timerSpan.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                                } else {
                                                    countdownElement.style.display = "none"; // Hide countdown if sale ends
                                                }
                                            }

                                            updateCountdown();
                                            setInterval(updateCountdown, 1000);
                                        });
                                    });
                                </script>



                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                ?>
            </div> <!-- End of .products-slider -->
            <button class="next-arrow">&#10095;</button>
        </div>
        <?php
        wp_reset_postdata();
    else:
        echo '<p>No products found.</p>';
    endif;

    // Add JavaScript to initialize slick slider
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var sliderContainer = $('.<?php echo $unique_id; ?>');
            sliderContainer.find('.products-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: sliderContainer.find('.prev-arrow'),
                nextArrow: sliderContainer.find('.next-arrow'),
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1540,
                        settings: {
                            slidesToShow: 3,
                        }
                    }, {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 574,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        });
    </script>
    <style>
        .slider-container {
            position: relative;
            max-width: 100%;
            overflow: hidden;
        }

        .prev-arrow,
        .next-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 10;
        }

        .products-slider {}

        .products-listing {
            width: 100%;
        }
    </style>
    <?php

    return ob_get_clean();
}
add_shortcode('customproductsslider', 'custom_products_slider_shortcode');


// Add diamonds user Roles in Wordpress backend 
function add_custom_user_roles_once()
{
    if (!get_option('custom_roles_created')) {
        remove_role('collector', 'Collector', ['read' => true]);
        add_role('time_keeper', 'Time Keeper', ['read' => true]);
        add_role('horologist', 'Horologist', ['read' => true]);
        add_role('master_watchmaker', 'Master Watchmaker', ['read' => true]);
        add_role('king_of_time', 'King of Time', ['read' => true]);

        update_option('custom_roles_created', true);
    }
}
add_action('init', 'add_custom_user_roles_once');


// Role Update Based on Total Spent
function update_user_role_based_on_total_spent($user_id)
{
    if (!$user_id)
        return;

    $total_spent = wc_get_customer_total_spent($user_id);

    if ($total_spent >= 50000) {
        $new_role = 'king_of_time';
    } elseif ($total_spent >= 10000) {
        $new_role = 'master_watchmaker';
    } elseif ($total_spent >= 5000) {
        $new_role = 'horologist';
    } elseif ($total_spent >= 2000) {
        $new_role = 'time_keeper';
    } else {
        $new_role = 'customer';
    }

    $user = new WP_User($user_id);

    if (!$user->has_role($new_role)) {
        // Remove all other roles first
        foreach ($user->roles as $role) {
            $user->remove_role($role);
        }
        // Add the new role
        $user->add_role($new_role);
    }
}

// Trigger Role Update After Every Purchase

add_action('woocommerce_order_status_completed', 'custom_check_user_rank_after_order');

function custom_check_user_rank_after_order($order_id)
{
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();

    if ($user_id) {
        update_user_role_based_on_total_spent($user_id);
    }
}


// Update the Function with <img> Tags
function get_user_rank_icon_by_role_img()
{
    if (!is_user_logged_in()) {
        return '<img class="user-rank-icon" src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/04/User-Male.png" alt="Guest Icon" />';
    }

    $user = wp_get_current_user();
    $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/04/User-Male.png'; // default

    if (in_array('king_of_time', $user->roles)) {
        $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/collector-2.png';
    } elseif (in_array('master_watchmaker', $user->roles)) {
        $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/collector-5.png';
    } elseif (in_array('horologist', $user->roles)) {
        $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/collector-3.png';
    } elseif (in_array('time_keeper', $user->roles)) {
        $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/collector-4.png';
    } elseif (in_array('customer', $user->roles)) {
        $icon_url = 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/collector-1.png';
    }

    return '<img class="user-rank-icon" src="' . esc_url($icon_url) . '" alt="User Icon" />';
}


// function enqueue_custom_mini_cart_script() {
//     wp_enqueue_script('mini-cart-script', get_stylesheet_directory_uri() . '/mini-cart.js', array('jquery'), null, true);
// }
// add_action('wp_enqueue_scripts', 'enqueue_custom_mini_cart_script');



add_filter('auth_cookie_expiration', 'custom_login_session_expiry', 99, 3);

function custom_login_session_expiry($expire, $user_id, $remember)
{
    // Set to 15 days in seconds
    return 15 * DAY_IN_SECONDS;
}


function custom_category_banner_shortcode() {
    if (!is_tax() && !is_category() && !is_tag()) {
        return ''; // Only show on taxonomy archive pages
    }

    ob_start();

    $category_id = get_queried_object_id();
    $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
    $term = get_queried_object();
    $taxonomy = isset($term->taxonomy) ? $term->taxonomy : null;
    $image_url = wp_get_attachment_url($thumbnail_id);

    if ($image_url) {
        ?>
        <section class="custNotificationbar">
            <div class="push-notificationbar">
                <div class="container">
                    <?php
                    $notification_label = get_field('notification_label', 25);
                    if (!empty($notification_label)) {
                        echo '<p>' . esc_html($notification_label) . '</p>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <section class="custInrCatBnr" id="customrorex" style="background-image:url(<?php echo esc_url($image_url); ?>);">
        </section>
        <?php
    }

    return ob_get_clean();
}
add_shortcode('custom_category_banner', 'custom_category_banner_shortcode');

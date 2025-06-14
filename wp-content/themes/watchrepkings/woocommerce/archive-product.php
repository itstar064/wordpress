<?php
defined('ABSPATH') || exit;

get_header('shop');
$category_id = get_queried_object_id();
$thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
$term = get_queried_object();
$taxonomy = isset($term->taxonomy) ? $term->taxonomy : null;
$image_url = wp_get_attachment_url($thumbnail_id);

?>
<?php
if ($image_url) {
    ?>

    <section class="custNotificationbar">
        <div class="push-notificationbar">
            <div class="container">
                <?php
                $notification_label = get_field('notification_label', 25);
                if (!empty($notification_label)): ?>
                    <p><?php echo esc_html($notification_label); ?></p>
                <?php endif;
                ?>
            </div>
        </div>
    </section>
    <section class="custInrCatBnr" id="customrorex" style="background-image:url(<?php echo esc_url($image_url); ?>);">
    </section>

<?php } ?>
<section>
    <h1 class="headtextmc">GET THE REAL UA DEAL</h1>
    <p>Lorem ipsum dolor sit amet. Ab galisum inventore eum dolores nostrum sit minima repellat est iste ipsum aut
        doloribus incidunt et architecto beatae eos repudiandae quisquam.</p>
    <div class="container who-we-are-spacer top">
        <div class="divider circle-shaped"></div>
    </div>
    <div class="headtabbutton">
        <button class="headbuttonmycss" >ALL FILTERS</button>
        <button class="headbuttonmycss1" >FAQs</button>
        <button class="headbuttonmycss">QUALITY GRADES</button>
    </div>
</section>
<section class="Newest f archive-products-list2">
    <div class="container" style="border: 1px solid #B5B5B5; border-radius: 10px;">
        <div class="titleinlinebar" style="display: flex; justify-content: center;">
            <h3 style="text-align: center;">
                <?php
                if ($taxonomy === 'product_cat' || $taxonomy === 'product_brand') {
                    echo esc_html($term->name);
                } else {
                    echo 'All Products';
                }
                ?>
            </h3>
        </div>
        <div class="shop-container">
            <div class="shop-header">
                <div class="shop-title">SHOP</div>
                <div class="sort-dropdown">
                    <div class="shop-results">Showing 1-24 of 842 results</div>
                    <select>
                        <option>SORT BY POPULARITY</option>
                        <!-- Add other sorting options if needed -->
                    </select>
                </div>
            </div>
            <div class="filter-section">
                <span class="filter-icon">&#9776;</span> Filter
            </div>
        </div>
        <div class="allnewest-products">
            <?php
            if ($taxonomy === 'product_cat' || $taxonomy === 'product_brand') {
                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => $taxonomy,
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ]
                    ]
                ];
                $loop = new WP_Query($args);
            } else {
                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => -1
                ];
                $loop = new WP_Query($args);
            }

            if ($loop->have_posts()):
                while ($loop->have_posts()):
                    $loop->the_post();
                    global $product;
                    $product_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                    $attachment_ids = !empty($product_gallery) ? explode(',', $product_gallery) : [];
                    ?>
                    <div class="products-listing">
                        <div class="products-listingin">
                            <div class="products-listingin-row">
                                <div class="product-thumbanil">
                                    <?php if (get_field('label_hot_now_active')): ?>
                                        <div class="label-hotted">
                                            <label><img
                                                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg"
                                                    alt="fireicon" /> Hot Right Now</label>
                                        </div>
                                    <?php endif; ?>

                                    <div id="carouselproductsIndicators-<?php the_ID(); ?>" class="carousel slide"
                                        data-bs-ride="carousel" data-bs-interval="10000">
                                        <div class="carousel-indicators">
                                            <?php
                                            $active_class = 'active';
                                            foreach ($attachment_ids as $index => $attachment_id) {
                                                echo '<button type="button" data-bs-target="#carouselproductsIndicators-' . get_the_ID() . '" data-bs-slide-to="' . $index . '" class="' . $active_class . '" aria-current="' . ($active_class === 'active' ? 'true' : 'false') . '" aria-label="Slide ' . ($index + 1) . '"></button>';
                                                $active_class = '';
                                            }
                                            ?>
                                        </div>
                                        <div class="carousel-inner">
                                            <?php
                                            $active_class = 'active';
                                            foreach ($attachment_ids as $attachment_id) {
                                                $image_url = wp_get_attachment_url($attachment_id);
                                                echo '<div class="carousel-item ' . $active_class . '">';
                                                echo '<a href="' . get_the_permalink() . '"><img src="' . esc_url($image_url) . '" class="d-block w-100" alt="Product Image"></a>';
                                                echo '</div>';
                                                $active_class = '';
                                            }
                                            ?>
                                            <div class="quick-view-btnn" style="display:none;">
                                                <a href="<?php the_permalink(); ?>">Quick View </a>
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
                                            <h5>Ref:
                                                <?php echo esc_html(get_field('ref_no') ? get_field('ref_no') : 'No Ref'); ?>
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
                                                <span class="regular-price">
                                                    <span class="from-text">From</span> <del>
                                                        <?php echo $formatted_regular_price; ?></del>
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
            ?>
        </div>
    </div>
</section>

<script>
    jQuery(document).ready(function ($) {
        $('.carousel').each(function () {
            var carousel = $(this);
            if (!carousel.hasClass('initialized')) {
                carousel.carousel();
                carousel.addClass('initialized');
            }
        });
    });
</script>

<?php
get_footer('shop');

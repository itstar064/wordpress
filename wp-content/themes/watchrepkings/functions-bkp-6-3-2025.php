<?php 
add_action( 'wp_enqueue_scripts', 'happenstance_remove_scripts', 20 );
function happenstance_remove_scripts() {
	wp_dequeue_style( 'parent-style' );
	wp_deregister_style( 'twenty-twenty-one-style' ); 
	wp_deregister_style( 'twenty-twenty-one-print-style' ); wp_dequeue_script( 'parent-style' );  

	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/css/bootstrap.css' );
	wp_enqueue_style( 'fontawesome-style', get_stylesheet_directory_uri() . '/assets/fontawesome/css/all.css' );
	wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
	wp_enqueue_style( 'fancylight-style', get_stylesheet_directory_uri() . '/assets/css/jquery.fancybox.min.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

	wp_enqueue_script( 'bootstrapjs', get_stylesheet_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery' ), '', true);
	wp_enqueue_script( 'slickjs', get_stylesheet_directory_uri() . '/assets/js/slick.js', array( 'jquery' ), '', true);
	wp_enqueue_script( 'fancylightjs', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script( 'customjs', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), '', true);
}

function redirect_yearly_archive() {
    if (isset($_GET['year']) && is_numeric($_GET['year'])) {
        $year = intval($_GET['year']);
        wp_redirect(get_year_link($year));
        exit;
    }
}
add_action('template_redirect', 'redirect_yearly_archive');


/*ACF option Pages Start*/
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));

}
/*ACF option Pages End*/

// ACF Product Banner Slider shortcode 
function acf_product_banner_slider() {
    if( have_rows('product_banner_slides') ) :
        ob_start(); ?>

        <div id="carouselBannerIndicators" class="carousel bannerslider slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators">
                <?php $i = 0; while( have_rows('product_banner_slides') ) : the_row(); ?>
                    <button type="button" data-bs-target="#carouselBannerIndicators" data-bs-slide-to="<?php echo $i; ?>" 
                        class="<?php echo $i == 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>">
                    </button>
                <?php $i++; endwhile; ?>
            </div>

            <div class="carousel-inner">
                <?php $i = 0; while( have_rows('product_banner_slides') ) : the_row();
                    $product_image = get_sub_field('product_image_');
                    $discount_amount = get_sub_field('discount_amount'); ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($product_image); ?>" class="d-block w-100" alt="Slide Image">
                        <div class="banner-btn">
                            <a href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/collection/" type="button" class="stillbtn">
                                SHOP NOW
                                <span>Get <?php echo esc_html($discount_amount); ?> Off on First Order </span>
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
function display_product_categories_with_thumbnails( $atts ) {
    // Set default attributes
    $atts = shortcode_atts( array(
        'order'       => 'ASC',
        'itemshow'    => -1, // Default to show all categories
        'idtoshowfirst' => '', // Comma-separated list of category IDs to show first
    ), $atts, 'product_categories_with_thumbnails' );

    // Convert ID list to an array
    $priority_ids = !empty($atts['idtoshowfirst']) ? array_map('trim', explode(',', $atts['idtoshowfirst'])) : [];

    // Get all product categories
    $terms = get_terms( array(
        'taxonomy'   => 'product_cat',
        'orderby'    => 'name',
        'order'      => $atts['order'],
        'hide_empty' => true, // Show only categories with products
    ));

    // Check if there are categories
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $output = '<div class="product-categories-list">';

        // Separate priority and regular categories
        $priority_terms = [];
        $regular_terms = [];

        foreach ( $terms as $term ) {
            if ( in_array( $term->term_id, $priority_ids ) ) {
                $priority_terms[] = $term;
            } else {
                $regular_terms[] = $term;
            }
        }

        // Merge so that priority terms appear first
        $sorted_terms = array_merge( $priority_terms, $regular_terms );

        $counter = 0; // Initialize counter for categories
        foreach ( $sorted_terms as $term ) {
            // If itemshow is set to a specific number, limit the number of items shown
            if ( $atts['itemshow'] != -1 && $counter >= $atts['itemshow'] ) {
                break; // Stop after the specified number of items
            }

            // Get the category thumbnail URL
            $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
            $thumbnail_url = wp_get_attachment_url( $thumbnail_id );

            // Display the category with its thumbnail
            $output .= '<div class="product-category-item">';
            $output .= '<a href="' . esc_url( get_term_link( $term ) ) . '">';

            if ( $thumbnail_url ) {
                $output .= '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( $term->name ) . '" />';
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
add_shortcode( 'product_categories_with_thumbnails', 'display_product_categories_with_thumbnails' );


// Custom products show shortcode 
function custom_products_shortcode($atts) {
    ob_start();
    
    $atts = shortcode_atts([
        'categoryshow' => '',
        'order' => 'ASC',
        'itemtoshow' => '10',
    ], $atts, 'customproducts');
    
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => intval($atts['itemtoshow']),
        'order'          => $atts['order'],
    ];
    
    if (!empty($atts['categoryshow'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $atts['categoryshow'],
            ]
        ];
    }
    
    $loop = new WP_Query($args);
    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();
            ?>
            <div class="products-listing">
                <div class="products-listingin">
                    <div class="products-listingin-row">
                    <div class="product-thumbanil">
                        <?php 
                        // Check if the 'label_hot_now_active' ACF field is true
                        $label_hot_now_active = get_field('label_hot_now_active'); 
                        if ($label_hot_now_active) : ?>
                            <div class="label-hotted">
                                <label><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg" alt="fireicon"/> Hot</label>
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
                                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>" class="d-block w-100" alt="Product Image"></a>
                                    </div>
                                    <?php
                                    $active_class = '';
                                endforeach;
                                ?>
                                <div class="quick-view-btnn" style="display:none;">
                                    <a href="<?php the_permalink(); ?>">Quick View </a>
                                </div>
                            </div>
                        </div>

                        <!-- Show Brand Logo on Product Thumbnail -->
                        <?php 
                        // Check if the 'show_brand_label_on_product_thumbnail' ACF field is true
                        $label_ShowBrand_active = get_field('show_brand_label_on_product_thumbnail'); 
                        if (!empty($label_ShowBrand_active)) : ?>
                            <div class="show-brandlogo">
                                <label><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/YellowWRKLogo-1.svg" alt="Brand Logo"/></label>
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
    <?php
    
    return ob_get_clean();
}
add_shortcode('customproducts', 'custom_products_shortcode');




// BLOG-SHORTCODE
function recent_blog_posts($atts) {
    ob_start(); // Start output buffering

    $atts = shortcode_atts(array(
        'itemtoshow' => 3, // Number of posts to display
    ), $atts, 'recent_blog_posts');

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => intval($atts['itemtoshow']), // Ensuring only the specified number of posts are shown
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
        echo '<div class="row">';
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
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
                    <h4 class="nm"><?php the_title();?></h4>
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
function custom_remove_product_category_base($url, $term, $taxonomy) {
    if ($taxonomy === 'product_cat') {
        return home_url('/' . $term->slug . '/'); 
    }
    return $url;
}

// Add Rewrite Rules for Product Categories
function custom_product_category_rewrite_rules($rules) {
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
function flush_product_category_rewrite_rules() {
    flush_rewrite_rules();
}
add_action('init', 'flush_product_category_rewrite_rules');



// PRICES products show shortcode
 
function prices_products_shortcode($atts) {
    ob_start();
    
    $atts = shortcode_atts([
        'categoryshow' => '',
        'order' => 'ASC',
        'itemtoshow' => '10',
    ], $atts, 'customproducts');
    
    $args = [
    'post_type'      => 'product',
    'posts_per_page' => intval($atts['itemtoshow']),
    'order'          => 'ASC', // Low to High
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_price',
		'meta_query'     => [
			[
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>=', // Ensure we only get products with a valid price
				'type'    => 'NUMERIC',
			]
		]
	];
    if (!empty($atts['categoryshow'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $atts['categoryshow'],
            ]
        ];
    }
    
    $loop = new WP_Query($args);

    // Start the product listing wrapper outside the loop
    if ($loop->have_posts()) :
        
        
        while ($loop->have_posts()) : $loop->the_post();
            ?>
			<div class="products-listing">
				<div class="products-listingin">
					<div class="products-listingin-row">
                        <div class="product-thumbanil">
                            <?php 
                            // Check if the 'label_hot_now_active' ACF field is true
                            $label_hot_now_active = get_field('label_hot_now_active'); 
                            if ($label_hot_now_active) : ?>
                                <div class="label-hotted">
                                    <label><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Fire.svg" alt="fireicon"/> Hot</label>
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
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>" class="d-block w-100" alt="Product Image"></a>
                                        </div>
                                        <?php
                                        $active_class = '';
                                    endforeach;
                                    ?>
                                    <div class="quick-view-btnn" style="display:none;">
                                        <a href="<?php the_permalink(); ?>">Quick View </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Show Brand Logo on Product Thumbnail -->
                            <?php 
                            // Check if the 'show_brand_label_on_product_thumbnail' ACF field is true
                            $label_ShowBrand_active = get_field('show_brand_label_on_product_thumbnail'); 
                            if (!empty($label_ShowBrand_active)) : ?>
                                <div class="show-brandlogo">
                                    <label><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/YellowWRKLogo-1.svg" alt="Brand Logo"/></label>
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
    <?php
    
    return ob_get_clean();
}
add_shortcode('pricecustomproducts', 'prices_products_shortcode');



add_action('woocommerce_single_product_summary', 'display_wishlist_button_on_single_product', 35);

function display_wishlist_button_on_single_product() {
    if (function_exists('webtoffee_add_to_wishlist_button')) {
        // Display the Add to Wishlist button
        echo '<div class="product-wishlist-button">';
        webtoffee_add_to_wishlist_button(); // Function to display the wishlist button
        echo '</div>';
    }
}




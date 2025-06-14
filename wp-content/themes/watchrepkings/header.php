<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/stylesheet.css" rel="stylesheet">
	<link
		href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@400..800&display=swap"
		rel="stylesheet">
	<?php wp_head(); ?>

</head>
<style>
	.dots {
		width: 56px;
		height: 13.4px;
		background: radial-gradient(circle closest-side at left 6.7px top 50%, #FFD200 90%, #0000),
			radial-gradient(circle closest-side, #FFD200 90%, #0000),
			radial-gradient(circle closest-side at right 6.7px top 50%, #FFD200 90%, #0000);
		background-size: 100% 100%;
		background-repeat: no-repeat;
		animation: dots-xm0185md 1s infinite alternate;

	}

	#loaderbar {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgb(11 11 11 / 89%);
		z-index: 9999;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	@keyframes dots-xm0185md {
		to {
			width: 22.4px;
			height: 26.9px;
		}
	}
</style>

<body <?php body_class(); ?>>

	<!--
<div id="loaderbar">
  <div class="dots"></div>
</div>
-->

	<header class="cont-header">
		<!-- desktop header  start from here-->
		<div class="prime-header">
			<div class="container">
				<div class="prime-headerrow">
					<div class="brandbar">
						<a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
							<?php
							if (has_custom_logo()) {
								the_custom_logo();
							}
							?>
						</a>
					</div>
					<div class="detailedheader">
						<div class="leftbarmenu">
							<?php
							wp_nav_menu(array(
								'menu' => 20, // Menu ID
								'container' => 'nav',
								'container_class' => 'brand-menubar submenubar',
								'menu_class' => 'menu',
								'fallback_cb' => false,
								'walker' => new Custom_Brand_Walker() // Use custom walker
							));
							?>
							<?php
							wp_nav_menu(array(
								'menu' => 68, // Menu ID
								'container' => 'nav',
								'container_class' => 'shop-menubar submenubar',
								'menu_class' => 'menu',
								'fallback_cb' => false,
								'walker' => new Custom_Shop_Menu_Walker(), // Custom Walker
							));
							?>
							<?php
							wp_nav_menu(array(
								'menu' => 71, // Menu ID
								'container' => 'nav',
								'container_class' => 'simple-menus',
								'menu_class' => 'menu',
								'fallback_cb' => false,
							));
							?>
						</div>

						<?php
						// Custom Walker Class to Display Brands with Images and Sub-brands
						class Custom_Brand_Walker extends Walker_Nav_Menu
						{

							public function start_lvl(&$output, $depth = 0, $args = array())
							{
								if ($depth === 0) {
									$output .= '<div class="sub-menu">';
									$output .= '<ul class="sub-menu-ul">';
								} else {
									$output .= '<ul class="sub-menu">';
								}
							}

							public function end_lvl(&$output, $depth = 0, $args = array())
							{
								if ($depth === 0) {
									$output .= '</ul>'; // close sub-menu-ul
									$output .= '<div class="view-all-wrapper">';
									$output .= '<a href="' . esc_url(home_url('/shop')) . '" class="view-all-btn"> View All Timepieces</a>';
									$output .= '</div>';
									$output .= '</div>'; // close sub-menu
								} else {
									$output .= '</ul>'; // close nested sub-menu
								}
							}

							public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
							{
								$output .= '<li class="menu-item still-active">';

								// Display the main menu link
								$output .= '<a class="catname" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

								// If it's a product_brand taxonomy
								if ($item->object == 'product_brand') {
									$term_id = $item->object_id;

									// Brand image from term meta
									$image_id = get_term_meta($term_id, 'thumbnail_id', true);
									$image_url = $image_id ? wp_get_attachment_url($image_id) : '';

									if ($image_url) {
										$output .= '<a target="blank" class="brand-image" href="' . esc_url($item->url) . '">';
										$output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($item->title) . '" />';
										$output .= '</a>';
									}

									// Brand icon (ACF)
									$brand_icon = get_field('brandicon', 'product_brand_' . $term_id);
									$dummy_icon = 'https://via.placeholder.com/24';

									$output .= '<div class="brandicon">';
									$output .= '<a target="blank"  href="' . esc_url($item->url) . '">';
									$output .= '<img src="' . esc_url($brand_icon ?: $dummy_icon) . '" alt="' . esc_attr($item->title) . '" />';
									$output .= '</a>';
									$output .= '</div>';

									// Fetch sub-brands (children terms)
									$sub_brands = get_terms(array(
										'taxonomy' => 'product_brand',
										'hide_empty' => false,
										'parent' => $term_id,
									));

									if (!empty($sub_brands) && !is_wp_error($sub_brands)) {
										$output .= '<ul class="sub-brands-list">';
										foreach ($sub_brands as $sub_brand) {
											$output .= '<li>';
											$output .= '<a href="' . esc_url(get_term_link($sub_brand)) . '">';

											// Start badge + name
											$output .= '<div class="badge-icon-wrap">';
											$output .= esc_html($sub_brand->name);

											// Get ACF field value
											$badge = get_field('badge_bar', 'product_brand_' . $sub_brand->term_id);

											// Add span only if badge is not "Normal"
											if ($badge && $badge !== 'Normal') {
												$badge_class = '';
												if ($badge === 'Hot') {
													$badge_class = 'hot';
												} elseif ($badge === 'Populer') {
													$badge_class = 'populer';
												}

												$output .= '<span class="badge-label ' . esc_attr($badge_class) . '">' . esc_html($badge) . '</span>';
											}

											$output .= '</div>'; // Close .badge-icon-wrap
						
											// Always show icon outside badge wrap but inside <a>
											$output .= '<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/03/v.png" alt="Sub Brand Icon" />';

											$output .= '</a>';
											$output .= '</li>';
										}
										$output .= '</ul>';
									}



									// ✅ Add View All Button (only at top-level)
									if ($depth === 0) {
										$output .= '<div class="view-all-wrapper ff">';
										$output .= '<a href="' . esc_url(home_url('/shop')) . '" class="view-all-btn">View All Timepieces</a>';
										$output .= '</div>';
									}
								}

								$output .= '</li>';
							}

						}

						class Custom_Shop_Menu_Walker extends Walker_Nav_Menu
						{
							function start_lvl(&$output, $depth = 0, $args = null)
							{
								$output .= '<ul class="sub-menu">';
							}

							function end_lvl(&$output, $depth = 0, $args = null)
							{
								$output .= '</ul>';
							}

							function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
							{
								$thumbnail = '';

								// Check if this is a product category
								if ('product_cat' === $item->object) {
									$term_id = $item->object_id;
									$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
									if ($thumbnail_id) {
										$thumbnail = wp_get_attachment_image($thumbnail_id, 'full', false, array('class' => 'menu-thumb'));
									}
								}

								$output .= '<li class="menu-item">';
								$output .= '<a href="' . esc_url($item->url) . '">';

								if ($thumbnail) {
									$output .= '<div class="menu-thumbnail">' . $thumbnail . '</div>';
								}
								$output .= '<span class="menu-title">' . esc_html($item->title) . '</span>';
								$output .= '</a>';
								$output .= '</li>';
							}

							function end_el(&$output, $item, $depth = 0, $args = null)
							{
								$output .= '';
							}
						}

						?>

						<div class="woo-searchbar">
							<?php echo do_shortcode('[aws_search_form]'); ?>
						</div>
						<div class="rytbar-woo-menu">
							<!-- login user print  -->
							<div class="loginuserpart">
								<?php if (is_user_logged_in()): ?>
									<a
										href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
										<?php echo get_user_rank_icon_by_role_img(); ?> My Account
									</a>
								<?php else: ?>
									<a
										href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
										<img class="user-rank-icon"
											src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/04/User-Male.png"
											alt="Guest Icon" /> Sign In
									</a>
								<?php endif; ?>
							</div>

							<?php
							wp_nav_menu(array(
								'menu' => 19, // Menu ID
								'container' => 'nav',
								'container_class' => 'custom-menu-class',
								'menu_class' => 'menu',
								'fallback_cb' => false,
								'walker' => new Custom_Cart_Menu_Walker(), // Custom Walker
							));

							class Custom_Cart_Menu_Walker extends Walker_Nav_Menu
							{
								function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
								{
									// Retain the default menu classes
									$classes = implode(' ', $item->classes);

									// Check if the menu item is the cart page
									if ('cart' === strtolower($item->title)) {
										// Get cart count and cart items
										$cart_count = WC()->cart->get_cart_contents_count();
										$cart_items = WC()->cart->get_cart();

										// Start Cart Menu Item
										$output .= '<li class="' . esc_attr($classes) . '">';
										$output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . ' <span class="cart-count">' . $cart_count . '</span></a>';

										// Start Dropdown
										$output .= '<ul class="cart-dropdown">';
										if ($cart_count > 0) {
											foreach ($cart_items as $cart_item) {
												$product = $cart_item['data'];
												$product_name = $product->get_name();
												$product_price = wc_price($product->get_price());
												$product_img = wp_get_attachment_image($product->get_image_id(), 'thumbnail');

												$output .= '<li class="cart-item">';
												$output .= '<a href="' . esc_url(get_permalink($product->get_id())) . '">';
												$output .= '<div class="primg">' . $product_img . '</div>';
												$output .= '<div class="pr-detail">';
												$output .= '<span class="cart-item-name">' . esc_html($product_name) . '</span>';
												// $output .= '<span class="cart-item-summery">' . esc_html($product_name) . '</span>';
												$output .= '<span class="cart-item-price">' . $product_price . '</span>';
												$output .= '</div>';
												$output .= '</a>';
												$output .= '</li>';
											}
											$output .= '<div class="interestcontainermycss"><div class="you-may-be-interested-in">YOU MAY BE INTERESTED IN...</div><div class="product-cards-container"><div class="product-card"><div class="product-image"></div><div class="product-details"><div class="product-title">Rolex Ballpoint Pen</div><div class="product-rating"><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span></div><div class="product-price">$69.00</div></div><div class="add-button">+ADD</div></div><div class="product-card"><div class="product-image"></div><div class="product-details"><div class="product-title">Rolex Wallet</div><div class="product-rating"><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span></div><div class="product-price">$65.00</div></div><div class="add-button">+ADD</div></div><div class="product-card"><div class="product-image"></div><div class="product-details"><div class="product-title">Official Rolex Wooden Box</div><div class="product-rating"><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span></div><div class="product-price">$125.00</div></div><div class="add-button">+ADD</div></div></div><div class="subtotal-section"><div class="subtotal-label">Subtotal:</div><div class="subtotal-value">$899.00</div></div></div>';
											// Add the "View All" button at the end
											$output .= '<li class="view-all viewallmycss">';
											$output .= '<a href="' . esc_url(wc_get_cart_url()) . '" class="view-all-btn viewcartbtnmycss">View Cart</a>';
											$output .= '<a href="' . esc_url(home_url('/checkout')) . '" class="view-all-btn viewcheckoutbtnmycss">Checkout</a>';
											$output .= '</li>';
										} else {
											$output .= '<li class="cart-item">No products in the cart.</li>';
										}
										$output .= '</ul>';

										$output .= '</li>';
									} else {
										// Default menu item
										$output .= '<li class="' . esc_attr($classes) . '">';
										$output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
										$output .= '</li>';
									}
								}
							}
							?>


							<div class="multi_currency-layout">
								<?php echo do_shortcode('[woo_multi_currency_layout10]'); ?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- desktop header  ends here-->
		<!-- Mobile view header start here  -->
		<div class="mob-header">
			<div class="container">
				<div class="brandbar">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
						<?php
						if (has_custom_logo()) {
							the_custom_logo();
						}
						?>
					</a>
				</div>
				<div class="mobmenu">
					<div class="mobcart">
						<a href="<?php echo site_url() . '/cart/'; ?>">Cart </a>
					</div>

					<div class="humbergerbar">
						<button class="togglebtn" type="button"><i class="fa-solid fa-bars"></i></button>
					</div>
					<div class="sidebar-menu">

						<button class="togglebtn" type="button"><i class="fa-solid fa-circle-xmark"></i></button>
						<?php
						wp_nav_menu(array(
							'menu' => 41, // Menu ID
							'container' => 'nav',
							'container_class' => 'custom-menu-class',
							'menu_class' => 'menu',
							'fallback_cb' => false
						));
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile view header start here  -->
	</header>

	<script>
		jQuery(document).ready(function ($) {
			$(".togglebtn").click(function () {
				$(".sidebar-menu").toggleClass("active");
				$("body").toggleClass("active");
			});
			// Show loader immediately when the page starts loading
			$('#loaderbar').show();

			// Hide loader after all resources (images, fonts, etc.) have fully loaded
			$(window).on('load', function () {
				$('#loaderbar').fadeOut('slow'); // Fades out with a smooth effect
			});
		});
	</script>
	<script>
		jQuery(document).ready(function ($) {
			// Add toggle buttons to menu items with submenus
			$('.custom-menu-class li.menu-item-has-children').each(function () {
				$(this).find('> a').after('<button class="submenu-toggle" aria-label="Toggle Submenu"></button>');
			});

			// Toggle submenu
			$('.submenu-toggle').on('click', function (e) {
				e.preventDefault();
				let $submenu = $(this).siblings('.sub-menu');
				let $button = $(this);

				// Close others if needed (accordion behavior)
				$('.custom-menu-class .sub-menu').not($submenu).slideUp();
				$('.submenu-toggle').not($button).removeClass('open');

				// Toggle current
				$submenu.slideToggle();
				$button.toggleClass('open');
			});
		});
	</script>

	<!-- Body wrapper start here  -->
	<div class="wrapper">
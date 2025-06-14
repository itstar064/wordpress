<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
	<div class="profile-header">
		<div class="avatar-container">
			<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/avatar.png"
				alt="" class="avatar">
			<span class="edit-icon">&#9998;</span>
		</div>
		<h2>KENDRICK</h2>
		<a href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/my-account/edit-address/billing/"
			class="edit-profile">Edit Profile</a>
	</div>
	<ul class="myaccountnav">
		<?php
		$index = 0; // Initialize counter
		foreach (wc_get_account_menu_items() as $endpoint => $label):
			?>
			<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
				<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" <?php echo wc_is_current_account_menu_item($endpoint) ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html($label); ?>
				</a>
			</li>

			<?php if ($index === 3): // Insert after the 4th item ?>
				<div class="container best-seller-top-spacer">
					<div class="devidecirclediv"></div>
				</div>
			<?php endif; ?>

			<?php $index++; // Increment counter ?>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
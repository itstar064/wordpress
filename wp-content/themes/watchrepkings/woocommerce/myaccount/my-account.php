<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_navigation'); ?>

<div class="woocommerce-MyAccount-content">
	<div class="right-panel">
		<div class="welcome-section">
			<h1>Hello, KENDRICK</h1>
			<div class="collector-status">
				<span class="rank-label">COLLECTOR</span>
				<span class="points">2,000/3,000 Points</span>
			</div>
			<p class="progress-message">Almost there! Just <strong>$1,000</strong> away from unlocking free express
				shipping and your next tier.</p>
		</div>

		<div class="guidelines-section">
			<h3>GUIDELINES <small>Check your loyalty privilege</small></h3>
			<div class="current-rank-details">
				<p>Current Rank: <strong>Collector</strong></p>
				<p>Diamonds Earned: <strong>2,000</strong></p>
				<p>Spend So Far: <strong>$2,000</strong></p>
				<p>Progress to Next Tier: <strong>1,000 Diamonds to Timekeeper Diamond</strong></p>
			</div>
			<p class="earn-message">Earn 1 Diamond for every $1 spent</p>
		</div>

		<div class="loyalty-table">
			<table>
				<thead>
					<tr>
						<th>Points</th>
						<th>Spend Threshold</th>
						<th>Discount</th>
						<th>Perks</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="pointstd pintsgradienttd1"><img
								src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/VIP21.svg"
								alt="Collector Icon"> <span>COLLECTOR</span></td>
						<td>$0</td>
						<td>0% OFF</td>
						<td>Earn points with every order</td>
					</tr>
					<tr>
						<td class="pointstd pintsgradienttd2"><img
								src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/VIP31.svg"
								alt="Timekeeper Icon"> <span>TIMEKEEPER</span></td>
						<td>$3,000</td>
						<td>3% OFF</td>
						<td>1x Free Express Shipping</td>
					</tr>
					<tr>
						<td class="pointstd pintsgradienttd3"><img
								src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/VIP41.svg"
								alt="Horologist Icon"> <span>HOROLOGIST</span></td>
						<td>$10,000</td>
						<td>5% OFF</td>
						<td>WRK Merch (Cap or Tee)</td>
					</tr>
					<tr>
						<td class="pointstd pintsgradienttd4"><img
								src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/VIP51.svg"
								alt="Master Watchmaker Icon"> <span>MASTER WATCHMAKER</span></td>
						<td>$20,000</td>
						<td>10% OFF</td>
						<td>WRK Watch Roll Priority Packing</td>
					</tr>
					<tr>
						<td class="pointstd pintsgradienttd5"><img
								src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Reseller1.svg"
								alt="King of Time Icon"> <span>KING OF TIME</span></td>
						<td>$40,000</td>
						<td>14% OFF</td>
						<td>Reseller Status Unlimited Express Shipping Drops</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="boost-rank-section">
			<h3>BOOST YOUR RANK</h3>
			<button class="trustpilot-button">LEAVE REVIEW ON TRUSTPILOT</button> &rarr; Earn a secret WRK Gifts
			<br>
			<button class="refer-friend-button">REFER A FRIEND</button> &rarr; Earn bonus Diamonds
			<p class="help-message">**Need help or proof of your review? DM us on <span>Telegram</span> or
				<span>Instagram</span> @watchrepkings
			</p>
		</div>

		<div class="contact-info">
			<div class="contact-header">
				<h4>Kendrick</h4>
				<span class="edit-icon">&#128393;</span>
			</div>
			<p>+634567829019</p>
			<p>Indonesia, Indonesia</p>
			<p>kendricklamar@gmail.com</p>
			<p class="billing-address">Billing Address</p>
		</div>
	</div>
</div>
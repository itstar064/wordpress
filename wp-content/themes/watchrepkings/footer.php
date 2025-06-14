<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<footer>
	<div class="footer-container">
		<div class="footer-column footerleftpart">
			<div class="locationstext">
				<h3>OUR LOCATION:</h3>
				<p>Lam Tsuen, Hongkong</p>
			</div>
			<div class="footerphonediv">
				<div class="contact-phone">
					<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/logo1.svg" alt="Phone Icon" class="phone-icon">
				</div>
				<div>
					<h3>GOT QUESTIONS?</h3>
					<span>+1 (123) 456 789</span>

					<h3>WHATSAPP 24/7</h3>
					<p class="italicfontstyle">Our customer support will gladly assist you with any concerns.</p>

					<button class="request-refund-btn">REQUEST A REFUND</button>
				</div>
			</div>
		</div>
		<div class="footerrightpartmain">
			<div class="footerrightpart">
				<div class="footer-column">
					<h3>Customer Support</h3>
					<ul>
						<li><a href="#">Member Login</a></li>
						<li><a href="#">Order Help Page</a></li>
						<li><a href="#">Refunds & Return Policy</a></li>
						<li><a href="#">Chat with Us on Telegram</a></li>
					</ul>
				</div>

				<div class="footer-column">
					<h3>Trust & Transparency</h3>
					<ul>
						<li><a href="#">WRK Guarantee</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">FAQs</a></li>
						<li><a href="#">Reviews</a></li>
					</ul>
				</div>

				<div class="footer-column">
					<h3>Connect</h3>
					<ul>
						<li><a href="#">Why Us?</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<div class="payment-icons">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Visa.svg"
					alt="Visa">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/MasterCard.svg"
					alt="Mastercard">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/PayPal.svg"
					alt="PayPal">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Stripe.svg"
					alt="Stripe">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/ApplePay.svg"
					alt="Apple Pay">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Bitcoin.svg"
					alt="Bitcoin">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Tether.svg"
					alt="Tether">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/WesternUnion.svg"
					alt="Western Union">
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="footer-disclaimer-copyright">
			<div class="footerbottom_left">
				<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Logo12.svg"
					alt="Watch Rep Kings Logo" class="footer-logo">
				<div class="footer-social-disclaimer-wrapper">
					<div class="social-icons-wrapper">
						<div class="social-icons">
							<a href="#"><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Facebook.svg" alt="Facebook"></a>
							<a href="#"><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Instagram.svg" alt="Instagram"></a>
							<a href="#"><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Twitter.svg" alt="YouTube"></a>
							<a href="#"><img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Tiktok.svg" alt="TikTok"></a>
						</div>
					</div>
					<p>Disclaimer: Our timepieces are crafted for discerning collectors who value exceptional
						quality.
						While visually identical to originals, they are intended for personal use – not for
						misrepresentation. Their excellence on its own.</p>
				</div>
			</div>
			<div class="footerbottom_right">
				<div class="security-badges">
					<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/SSL.svg"
						alt="SSL Secure">
					<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/Norton.svg"
						alt="Norton Secure">
					<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/rockit.svg"
						alt="Reddit Approved">
				</div>
				<div class="phone-icon1">
					<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/WhatsApp.svg" alt="whatsapp">
					<p class="copyright">&copy; 2025, WATCH REP KINGS.</p>
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- Fix widget bar  -->

<a href="<?php echo get_field('whatsapp-field', 'option'); ?>" class="fixcontbtn" target="_blank">
	<img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/WhatsApp.svg"
		alt=" whatsapp">
</a>

<div id="mini-cart-sidebar" class="mini-cart-hidden">
	<div class="mini-cart-overlay"></div>
	<div class="mini-cart-inner">
		<div class="cart-titlte">
			<span class="close-mini-cart">&times;</span>
			<h3>Your Cart</h3>
		</div>
		<div class="widget_shopping_cart_content">
			<?php woocommerce_mini_cart(); ?>
		</div>
	</div>
</div>


<?php wp_footer(); ?>

</div>
<!-- Body wrapper ends here  -->
</body>

</html>
<?php
/*
Template Name: Home page
*/

get_header(); ?>

<!-- product slider start form here  -->
<section class="product-slider">
    <div class="push-notificationbar">
        <div class="container">
            <?php
            $notification_label = get_field('notification_label');

            if (!empty($notification_label)): ?>
                <p><?php echo esc_html($notification_label); ?></p>
            <?php endif;
            ?>
        </div>
    </div>
    <?php echo do_shortcode('[acf_product_slider]'); ?>
</section>
<!-- product slider ends form here  -->


<!-- accordion start form here  -->
<section class="accordion-sec reasons-why-pic-uss">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion-wrap-sec">
                    <div class="titlebar">
                        <h1>3 REASONS WHY PICK US?</h1>
                        <div>
                            <img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/05/30e89be41924c56dd8429e39e9675de3190e551e.png"
                                alt="logo">
                        </div>
                    </div>
                    <?php if (have_rows('accordion_section')): ?>
                        <div class="accordion" id="accordionExample12">
                            <?php $i = 0;
                            while (have_rows('accordion_section')):
                                the_row();
                                $unique_id = 'collapse' . $i;
                                $heading_id = 'heading' . $i; ?>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="<?php echo $heading_id; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#<?php echo $unique_id; ?>" aria-expanded="false"
                                            aria-controls="<?php echo $unique_id; ?>">
                                            <?php echo esc_html(get_sub_field('accordion-tilte')); ?>
                                        </button>
                                    </h2>
                                    <div id="<?php echo $unique_id; ?>" class="accordion-collapse collapse"
                                        aria-labelledby="<?php echo $heading_id; ?>" data-bs-parent="#accordionExample12">
                                        <div class="accordion-body">
                                            <?php echo wp_kses_post(get_sub_field('accordion-content')); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $i++; endwhile; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- accordion ends form here  -->

<div class="container best-seller-top-spacer">
    <div class="divider circle-shaped"></div>
</div>


<!-- BEST SELLERS section start from here  -->
<section class="Newest bestseller pt-0 pb-0 ">
    <div class="container">
        <div class="titleinlinebar">
            <h3>BEST SELLERS</h3>
            <div class="seemorebtn"><a class="seemre"
                    href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/best-seller/">See More <i
                        class="fa-solid fa-caret-right" style="color: #ffffff;"></i></a></div>
        </div>
    </div>
    <div class="container slidercontainer">
        <div class="allnewest-products">
            <?php echo do_shortcode('[customproductsslider categoryshow="best-seller" order="DESC" itemtoshow="10"]'); ?>
        </div>
    </div>
</section>
<!-- BEST SELLERS section ends from here  -->

<!-- Get real deals section start here  -->
<section class="realdeals">
    <div class="container">
        <div class="titlebar">
            <?php
            $sec_title = get_field('main_title');
            $sec_subtitle = get_field('sub_title');

            if (!empty($sec_title)): ?>
                <h2><?php echo esc_html($sec_title); ?></h2>
            <?php endif; ?>
            <p>
                We don’t touch every brand, we master the BESTS.<br>
                WRK specializes in perfecting three legendary houses: Rolex, Audemars Piguet, and Patek Philippe.<br>
                Our builds replicate every detail, down to the dial depth, screw weight, and rehaut alignment.<br>
                If it’s not flawless, it doesn’t leave our tray.
            </p>
        </div>
        <div class="allcategoryblock f">
            <!-- <div class="seemorebtn">
                <a class="seemre" href="<?php echo site_url(); ?>/collection/">See All 
                    <i class="fa-solid fa-caret-right" style="color: #ffffff;"></i>
                </a>
            </div> -->
            <?php if (have_rows('cat_gallery')): ?>
                <div class="product-categories-list">
                    <?php $i = 0;
                    $test = ["ROLEX", "AUDEMARS PIGUET", "PATEK PHILIPPE"]; ?>

                    <?php while (have_rows('cat_gallery') && $i < 3):
                        the_row(); ?>
                        <?php
                        $catlink = get_sub_field('catlink'); // Link URL (string)
                        $brand_img = get_sub_field('brand_img'); // Image URL
                        ?>
                        <div class="product-category-item">
                            <a href="<?php echo esc_url($catlink); ?>">
                                <img src="<?php echo esc_url($brand_img); ?>" alt="Brand Image">
                                <div class="productaddme1">
                                    <p><?php echo $test[$i]; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php $i++; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>

<section>
    <div class="myaddcss_header">
        <p>WATCH REP KINGS</p>
        <h1>PREMIUM REPLICAS</h1>
    </div>
    <div class="myaddcss_container">
        <div class="myaddcss_logosection">
            <img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/2ee69939a7883ddceae7976f006720319f38b5b5.png"
                alt="Play Button Icon">
            <div class="myaddcss_btnplay">
                <img
                    src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/02/Group 22.png">
            </div>
        </div>
        <div class="myaddcss_textsection">
            <h2>WHO ARE WE?</h2>
            <p>
                At WatchRepKings (WRK), we’re more than just the #1 replica watch destination in the world. We’re a
                global movement powered by passion, craftsmanship, and trust. For over 8 years, we’ve been serving a
                global base of watch lovers who just want one thing: a replica that feels real, lasts long, and looks
                incredible. No promises, just top-tier quality and a watch that actually gives a damn.
            </p>
            <p>
                We carefully handpick only the best-finished models from trusted factories, inspect every detail, and
                make sure your watch gets to you fast, safe, anywhere in the world.
            </p>
            <button class="myaddcss_readmore">READ MORE</button>
        </div>
    </div>
</section>
<!-- Get real deals section ends here  -->



<div class="container who-we-are-spacer top">
    <div class="divider circle-shaped"></div>
</div>

<!-- Get real deals section start here  -->
<section class="realdeals customer-review bgblack">
    <div class="container">
        <div class="titlebar">
            <h1>SHOP WHAT YOU LIKE</h1>
        </div>
    </div>
    <div class="ratingbar slider">
        <?php
        $i = 0;
        $urls = ['https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/7127bce359b83a135714133b3d0ea5cf3109c59d.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/1c544557130d11d0b0a60322962bc74c8ae11630.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/6656156dfe69cac31ab1584a625034760633455e.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/93b25c27acde41ce72b476474604d6bfc2916249.png'];
        $test = ["FOR MEN", "FOR WOMEN", "SPECIAL REDUCTIONS", "BEST SELLERS"];
        if (get_field('customers_gallery_images_row')): ?>
            <?php while (has_sub_field('customers_gallery_images_row') && $i < 4): ?>
                <div class="ratingbox">
                    <img src=<?php echo $urls[$i] ?> alt="review img" />
                    <div class="productaddme1 <?php echo ($i == 2) ? ' focusdiv' : ''; ?>">
                        <p><?php echo $test[$i]; ?></p>
                    </div>
                </div>
                <?php $i++; endwhile; ?>
        <?php endif; ?>
    </div>
</section>
<!-- Get real deals section ends here  -->




<!-- who we are section start from here  -->
<section class="whoweare" style="display: none !important;">
    <div class="max-w-1020">
        <div class="row ">
            <div class="col-md-5 whoweare-left">
                <div class="videobar">
                    <?php
                    $thumbnail = get_field('video_thumbnail');
                    $video = get_field('who_we_are_media');
                    ?>

                    <?php if ($thumbnail): ?>
                        <img src="<?php echo esc_url($thumbnail['url']); ?>"
                            alt="<?php echo esc_attr($thumbnail['alt']); ?>" class="img-fluid" />
                    <?php endif; ?>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal">
                        <i class="fa-solid fa-play" style="color: #ffffff;"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if ($video) {
                                        echo wp_oembed_get($video); // Fetch embedded video
                                    } else {
                                        echo '<p>No video available</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 whoweare-right">
                <h4><?php echo esc_html(get_field("whowe_title")); ?></h4>
                <p><?php echo wp_kses_post(get_field("whowe_content")); ?></p>

                <div class="btnbar">
                    <?php
                    $button = get_field('button_learnmore');
                    if ($button) {
                        ?>
                        <a href="<?php echo esc_url($button['url']); ?>" class="stillbtn-wrap btnlearnmre"
                            target="<?php echo esc_attr($button['target']); ?>">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- who we are section ends from here  -->

<!-- BEST SELLERS section start from here  -->
<section class="Newest special-reduction realdeals">
    <div class="container">
        <div class="container">
            <div class="titleinlinebar">
                <h3>Newest</h3>
                <div class="seemorebtn">
                    <a class="seemre" href="https://dev.webchefz.in/devsites/WBC213/watchrepkings/best-seller/">See More
                        <i class="fa-solid fa-caret-right" style="color: #ffffff;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="slidercontainer">
        <div class="allreduction-products">
            <?php echo do_shortcode('[customproductsslider categoryshow="special-reductions" order="DESC" itemtoshow="10"]'); ?>
        </div>
    </div>
</section>
<!-- BEST SELLERS section ends from here  -->

<div class="container who-we-are-spacer top">
    <div class="divider circle-shaped"></div>
</div>

<section>
    <div class="earn-section">
        <h1 class="earn-title">EARN AS YOU SPEND WITH US</h1>
        
        <p class="earn-subheading">Earn Diamonds. Rise in Rank. Rule Your Collection.</p>
        <p class="earn-text">
            At WatchRepKings, every timepiece brings you closer to greatness. With each order, you collect Diamonds
            unlocking VIP t iers, elite perks, and rare collector rewards built for those who don’t just wear time...
            they own it.
        </p>
    </div>
    <div class="mycss_imagesection">
        <img src="https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/9202b54474ac754eab59e075000e6fa03de92b54.png"
            alt="chart">
    </div>
    <div class="rewards-section">
        <div>
            <div class="rewards-header">How Diamond Rewards Work</div>
            <ul class="rewards-list">
                <li>• Earn 1 Diamond for every $1 spent</li>
                <li>• Your total Diamonds = your Rank</li>
                <li>• Each tier unlocks luxury discounts, exclusive gifts & faster shipping</li>
                <li>• erks activate automatically on your next order after leveling up</li>
            </ul>
        </div>
        <button class="earn-button">Earn Rewards</button>
    </div>
</section>


<section class="qualitycontrol">
    <div class="earn-section">
        <h1 class="earn-title">QUALITY CONTROL</h1>
        <p class="earn-text">
            We don’t deal in <span class="mycss_specialletter">“good enough.”</span><br>
            Every WRK piece is a faithful recreation of a classic, hand-inspected for
            precision, balance, and finish.<br>
            <span class="mycss_specialletter1">Your wrist deserves the best and nothing less.</span>
        </p>
    </div>
    <div class="allcategoryblock f">
        <?php if (have_rows('cat_gallery')): ?>
            <div class="product-categories-list">
                <?php $i = 0;
                $urls = ['https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/551037b5fb460839e974ebcc12076f972c20bbe8.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/4479eb327851ea9b3f9991e5aa2d21b24f23c394.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/e426fce591f876a03f772a9e920e22ef7d6075ba.png'];
                $test = ["Covered by a 3-month warranty", " Faults in movement or manufacturing? We replace or refund", "We stand behind every detail"]; ?>

                <?php while (have_rows('cat_gallery') && $i < 3):
                    the_row(); ?>
                    <?php
                    $catlink = get_sub_field('catlink'); // Link URL (string)
                    $brand_img = get_sub_field('brand_img'); // Image URL
                    ?>
                    <div class="product-category-item">
                        <a href="<?php echo esc_url($catlink); ?>">
                            <img src="<?php echo $urls[$i]; ?>" alt="Brand Image">
                            <div class="productaddme2">
                                <p><?php echo $test[$i]; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="container who-we-are-spacer top">
    <div class="divider circle-shaped"></div>
</div>

<section class="hearitfromourcustomers">
    <div class="earn-section">
        <h1 class="earn-title">HEAR IT FROM OUR CUSTOMERS</h1>
        <p class="earn-text">
            Lately, word’s been spreading and not just from us.<br>
            Leaks from China have shown that many luxury brands share suppliers with high-end replica makers. The<br>
            difference? You pay 10x more for the same guts and packaging.<br>
            Our watches? Same factories. Same feel. Less flexing, more value.
        </p>
    </div>
   
</section>



<section class="blogsection">
    <div class="earn-section">
        <h1 class="earn-title">BLOG</h1>
    </div>
    <div class="allcategoryblock f">
        <?php if (have_rows('cat_gallery')): ?>
            <div class="product-categories-list">
                <?php $i = 0;
                $text = ["TITLE 1", "TITLE 2", "TITLE 3"];
                $urls = ['https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/d2f43895a5b2d13643334198f448316510172599.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/9009f89cd1338f1e7ad756604306bfd820f04f4d.png', 'https://dev.webchefz.in/devsites/WBC213/watchrepkings/wp-content/uploads/2025/06/88b3a406f1e9aac6264ad9f7461f0d44f6118d72.png'];
                $test = [
                    "Lorem ipsum dolor sit amet. Ab galisum inventore eum dolores nostrum sit minima repellat est iste ipsum aut doloribus incidunt et architecto beatae eos repudiandae quisquam.",
                    "Lorem ipsum dolor sit amet. Ab galisum inventore eum dolores nostrum sit minima repellat est iste ipsum aut doloribus incidunt et architecto beatae eos repudiandae quisquam.",
                    "Lorem ipsum dolor sit amet. Ab galisum inventore eum dolores nostrum sit minima repellat est iste ipsum aut doloribus incidunt et architecto beatae eos repudiandae quisquam."
                ]; ?>

                <?php while (have_rows('cat_gallery') && $i < 3):
                    the_row(); ?>
                    <?php
                    $catlink = get_sub_field('catlink'); // Link URL (string)
                    $brand_img = get_sub_field('brand_img'); // Image URL
                    ?>
                    <div class="product-category-item">
                        <a class="mycss_link" href="<?php echo esc_url($catlink); ?>">
                            <img class="mycss_blogimage" src="<?php echo $urls[$i]; ?>" alt="Brand Image">
                            <div class="productaddme3">
                                <h1><?php echo $text[$i]; ?></h1>
                                <p><?php echo $test[$i]; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>



<section class="mycsscontactus">
    <div class="tabs-container">
        <div class="tabs-nav">
            <button class="tab-link active" data-tab="tab1">CONTACT US</button>
            <button class="tab-link" data-tab="tab2">TRACK YOUR PACKAGE</button>
        </div>
        <div class="tab-content active" id="tab1">
            <label>Got any questions? Reply to your inquiries:</label>
            <input type="email" placeholder="Enter your email...">
            <textarea placeholder="Type your inquiry here..."></textarea>
            <button>SUBMIT</button>
        </div>
        <div class="tab-content" id="tab2">
            <label>Want to track your package?</label>
            <input type="text" placeholder="Enter your tracking code...">
            <button>TRACK</button>
        </div>
    </div>
</section>
<!-- 
<footer class="footer">
    <div class="footer-section">
        <h3>OUR LOCATION:</h3>
        <p>Lam Tsuen, Hongkong</p>
        <div class="location">
            <img src="https://via.placeholder.com/24/ffffff/000000?text=📍" alt="Location Icon">
            <p>GOT QUESTIONS?<br><span class="whatsapp">+1 (123) 456 789</span> 24/7<br>WHATSAPP<br>Our customer support
                will gladly assist you with any concerns.</p>
        </div>
        <button class="refund-button">REQUEST A REFUND</button>
    </div>
    <div class="footer-section">
        <h3>Customer Support</h3>
        <ul>
            <li><a href="#">Member Login</a></li>
            <li><a href="#">Order Help Page</a></li>
            <li><a href="#">Refunds & Return Policy</a></li>
            <li><a href="#">Chat with Us on Telegram</a></li>
        </ul>
    </div>
    <div class="footer-section">
        <h3>Trust & Transparency</h3>
        <ul>
            <li><a href="#">WRK Guarantee</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Why Us?</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Reviews</a></li>
        </ul>
    </div>
    <div class="footer-section">
        <h3>Connect</h3>
        <div class="payment-icons">
            <img src="https://via.placeholder.com/30x20/0000FF/ffffff?text=V" alt="Visa">
            <img src="https://via.placeholder.com/30x20/FFD700/000000?text=M" alt="Mastercard">
            <img src="https://via.placeholder.com/30x20/007FFF/ffffff?text=PP" alt="PayPal">
            <img src="https://via.placeholder.com/30x20/FF4500/ffffff?text=S" alt="Stripe">
            <img src="https://via.placeholder.com/30x20/FFD700/000000?text=dP" alt="dPay">
            <img src="https://via.placeholder.com/30x20/FFA500/000000?text=B" alt="Bitcoin">
            <img src="https://via.placeholder.com/30x20/00FF00/000000?text=T" alt="Tether">
            <img src="https://via.placeholder.com/30x20/FF00FF/000000?text=W" alt="Wise">
        </div>
        <div class="security-icons">
            <img src="https://via.placeholder.com/30x20/FFD700/000000?text=SSL" alt="SSL">
            <img src="https://via.placeholder.com/30x20/000000/ffffff?text=N" alt="Norton">
            <img src="https://via.placeholder.com/30x20/FF4500/ffffff?text=McA" alt="McAfee">
            <img src="https://via.placeholder.com/30x20/00FF00/000000?text=R" alt="Reddit">
            <img src="https://via.placeholder.com/30x20/FF00FF/000000?text=WA" alt="WhatsApp">
        </div>
        <div class="social-icons">
            <a href="#"><img src="https://via.placeholder.com/24/ffffff/000000?text=f" alt="Facebook"></a>
            <a href="#"><img src="https://via.placeholder.com/24/ffffff/000000?text=t" alt="Twitter"></a>
            <a href="#"><img src="https://via.placeholder.com/24/ffffff/000000?text=i" alt="Instagram"></a>
        </div>
    </div>
</footer>
<div class="disclaimer">
    Disclaimer: Our timepieces are crafted for discerning collectors who value exceptional quality. While visually
    identical to originals, they are intended for personal use - not for misrepresentation. Their excellence stands on
    its own.<br>2025, WATCHREP KINGS
</div> -->



<!-- 
.footer {
  background-color: #1a2a44;
  color: #fff;
  padding: 20px;
  font-family: Arial, sans-serif;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 20px;
}
.footer-section {
  flex: 1;
  min-width: 200px;
  margin-bottom: 20px;
}
.footer-section h3 {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #d4af37;
}
.footer-section ul {
  list-style: none;
  padding: 0;
}
.footer-section ul li {
  margin-bottom: 8px;
  font-size: 14px;
}
.footer-section ul li a {
  color: #fff;
  text-decoration: none;
}
.footer-section ul li a:hover {
  color: #d4af37;
}
.location {
  display: flex;
  align-items: center;
}
.location img {
  width: 24px;
  height: 24px;
  margin-right: 10px;
}
.whatsapp {
  color: #25d366;
  font-weight: bold;
}
.refund-button {
  background-color: #d4af37;
  color: #1a2a44;
  padding: 10px 20px;
  border: none;
  font-weight: bold;
  cursor: pointer;
  border-radius: 5px;
  text-transform: uppercase;
  margin-top: 10px;
}
.refund-button:hover {
  background-color: #b8972f;
}
.payment-icons,
.security-icons {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}
.payment-icons img,
.security-icons img {
  width: 30px;
  height: 20px;
}
.social-icons {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}
.social-icons img {
  width: 24px;
  height: 24px;
  filter: brightness(0) invert(1);
}
.social-icons img:hover {
  filter: brightness(0) invert(0.5);
}
.disclaimer {
  font-size: 12px;
  color: #ccc;
  text-align: center;
  margin-top: 20px;
  padding-top: 10px;
  border-top: 1px solid #d4af37;
}

/* Responsive Design */
@media (max-width: 768px) {
  .footer {
    flex-direction: column;
    align-items: center;
  }
  .footer-section {
    text-align: center;
  }
  .payment-icons,
  .security-icons,
  .social-icons {
    justify-content: center;
  }
}
@media (max-width: 480px) {
  .footer-section h3 {
    font-size: 16px;
  }
  .footer-section ul li {
    font-size: 12px;
  }
  .payment-icons img,
  .security-icons img {
    width: 25px;
    height: 15px;
  }
  .social-icons img {
    width: 20px;
    height: 20px;
  }
} -->


<script>
    jQuery(document).ready(function ($) {
        $('.ratingbar').slick({
            slidesToShow: 5,  // Show 3 slides at a time
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            dots: false,
            prevArrow: '<button class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
            nextArrow: '<button class="slick-next"><i class="fa fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1540,
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
        $('.tab-link').click(function () {
            $('.tab-link').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').removeClass('active');
            $('#' + $(this).data('tab')).addClass('active');
        });
    });

</script>
<?php get_footer(); ?>
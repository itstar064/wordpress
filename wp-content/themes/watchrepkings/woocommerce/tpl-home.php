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

                if( !empty($notification_label) ): ?>
                    <p><?php echo esc_html($notification_label); ?></p>
                <?php endif; 
            ?>
        </div>
    </div>
    <?php echo do_shortcode('[acf_product_slider]'); ?>
</section>
<!-- product slider ends form here  -->

<!-- Get real deals section start here  -->
<section class="realdeals">
    <div class="container">
        <div class="titlebar">
            <?php 
                $sec_title = get_field('main_title');
                $sec_subtitle = get_field('sub_title');

                if (!empty($sec_title)): ?>
                    <h1><?php echo esc_html($sec_title); ?></h1>
                <?php endif; 

                if (!empty($sec_subtitle)): ?>
                    <p><?php echo esc_html($sec_subtitle); ?></p>
                <?php endif; 
            ?>
        </div>
        <div class="allcategoryblock">
            <div class="seemorebtn"><a class="seemre" href="#">See All <i class="fa-solid fa-caret-right" style="color: #ffffff;"></i></a></div>
            <?php 
                echo do_shortcode('[product_categories_with_thumbnails order="DESC" itemshow="3"]');
            ?>
        </div>
    </div>
</section>
<!-- Get real deals section ends here  -->


<?php get_footer(); ?> 
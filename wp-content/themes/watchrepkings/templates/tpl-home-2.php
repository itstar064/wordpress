<?php
/*
Template Name: Home page Two
*/

get_header(); ?>

<!-- Discover Collection slider start form here  -->


<section class="discover-collection-slider">
    <div id="carouseldiscovercollection" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
                <?php $i = 0; while( have_rows('discover_collection_slider') ) : the_row(); ?>
                    <button type="button" data-bs-target="#carouseldiscovercollection" data-bs-slide-to="<?php echo $i; ?>" 
                        class="<?php echo $i == 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>">
                    </button>
                <?php $i++; endwhile; ?>
        </div>
        <div class="carousel-inner">
                <?php $i = 0; while( have_rows('discover_collection_slider') ) : the_row();
                    $product_image = get_sub_field('slider_image');?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($product_image); ?>" class="d-block w-100" alt="Slide Image">
                        <div class="banner-btn">
                            <a href="#" type="button" class="stillbtn-wrap">
                                DISCOVER THE COLLECTION
                            </a>
                        </div>
                    </div>
                <?php $i++; endwhile; ?>
        </div>
    </div>
</section>
<!-- Discover Collection slider ends form here  -->

<!-- accordion start form here  -->
<section class="accordion-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion-wrap-sec">
                    <?php if( have_rows('accordion_section') ): ?>
                        <div class="accordion" id="accordionExample">
                            <?php $i = 0; while (have_rows('accordion_section')): the_row(); 
                                $unique_id = 'collapse' . $i; 
                                $heading_id = 'heading' . $i; ?>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="<?php echo $heading_id; ?>">
                                        <button class="accordion-button <?php echo $i == 0 ? '' : 'collapsed'; ?>" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#<?php echo $unique_id; ?>" 
                                                aria-expanded="<?php echo $i == 0 ? 'true' : 'false'; ?>" 
                                                aria-controls="<?php echo $unique_id; ?>">
                                            <?php echo esc_html(get_sub_field('title')); ?>
                                        </button>
                                    </h2>
                                    <div id="<?php echo $unique_id; ?>" 
                                         class="accordion-collapse collapse <?php echo $i == 0 ? 'show' : ''; ?>" 
                                         aria-labelledby="<?php echo $heading_id; ?>" 
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <?php echo wp_kses_post(get_sub_field('content')); ?>
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










<section class="brands-logo-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="brands-logo">
                    <h2><?php echo the_field('brand_title')?></h2>
                    <?php if( have_rows('brands_logo') ): ?>
                        <ul>
                        <?php while (have_rows('brands_logo')): the_row(); ?>
                            <li><img src="<?php echo the_sub_field('image')?>" alt="logo"></li>
                        <?php endwhile; ?>    
                        </ul>
                    <?php endif; ?>    
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?> 
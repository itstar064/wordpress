<?php
get_header();
?>

<?php if ( have_posts() ) : ?>
<section class="padding-t-b-100 cont-archive-top">
    <div class="container">
        <div class="row">
            <div class="col-12 archive-head">
                
                <!-- ✅ Breadcrumb -->
                <div class="col-12 breadcrumb-wrap">
                    <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                    }
                    ?>
                </div>

                <!-- Archive Title -->
                <div class="col-12 archive-title-year">
                    <h2>Weekly Archive</h2>
                </div>
            </div>

            <!-- ✅ Posts Listing Without Filter -->
            <div class="col-12 archive-posts">
                <div class="col-12 blog-sec-grids display-flex allnewest-products">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-md-4 col-sm-12 col-12 blog-single-grid hide-blog-grid">
                            <div class="col-12 blog-single-img">
                                <?php 
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
                                } else {
                                    echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/assets/images/default-image.jpg' ) . '" alt="Default Image" class="img-fluid">';
                                }
                                ?>
                            </div>
                            <div class="col-12 blog-single-content">
                                <h3><?php the_title(); ?></h3>
                                <a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'moyal'); ?></a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <!-- Load More Button -->
                <div class="col-12 load-testimonial">
                    <a id="loadMore" href="javascript:;"><?php echo esc_html_e('Load More'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else : ?>
    <?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>

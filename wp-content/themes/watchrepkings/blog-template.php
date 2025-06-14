<?php
/*
Template Name: Blog page
*/
get_header();
?>

<?php
// Get ACF fields
$banner_img = get_field('banner_img');
$page_title = get_field('page_title');
$description = get_field('banner_description');
?>

<div class="postbanner" style="background-image: url('<?php echo esc_url($banner_img['url']); ?>'); background-size: cover; background-position: center;">
    <div class="container">
        <?php if ($page_title): ?>
            <h1><?php echo esc_html($page_title); ?></h1>
        <?php else: ?>
            <h1><?php the_title(); ?></h1>
        <?php endif; ?>

        <?php if ($description): ?>
            <p><?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="blog-posts container">
   <div class="bloglistingbar">
   <?php
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : ( get_query_var('page') ? get_query_var('page') : 1 );

    $blog_query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $paged
    ]);

    if ( $blog_query->have_posts() ) :
        while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
            <article <?php post_class('blog-post'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumb">
                        <div class="datebar">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a class="read-more-btn" href="<?php the_permalink(); ?>">Read More</a>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif;

    wp_reset_postdata();
    ?>
   </div>
    <!-- ✅ Pagination Outside Blog Posts Wrapper -->
<?php if ( isset($blog_query) && $blog_query->max_num_pages > 1 ) : ?>
    <div class="blog-pagination container">
        <?php
        echo paginate_links([
            'total' => $blog_query->max_num_pages,
            'current' => $paged,
            'mid_size' => 8,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
        ]);
        ?>
    </div>
<?php endif; ?>
</div>



<?php get_footer(); ?>

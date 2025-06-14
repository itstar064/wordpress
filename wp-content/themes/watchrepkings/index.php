<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<?php if ( is_home() ) { ?>

<section class="padding-t-b-100 cont-archive-top">
	<div class="container">
		<div class="row">
			<div class="col-12 display-flex archive-head">
				<div class="col-md-8 col-sm-8 col-8 archive-title">
					<h2 class="title title-46">Immigration Newsweek</h2>
				</div>
				<div class="col-md-4 col-sm-4 col-4 display-flex archive-title-year">
					<div class="archive-year-title">Weekly Articles:</div>
					<div class="archive-year">
						<form action="<?php echo site_url(); ?>" method="get">
							<select name="year" onchange="this.form.submit();">
								<!--option value="">Select Year</option-->
								<?php
								global $wpdb;
								$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
								
								$current_year = get_query_var('year'); // Get the current archive year

								foreach ($years as $year) {
									$selected = ($year == $current_year) ? 'selected' : '';
									echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
								}
								?>
							</select>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12 display-flex archive-posts">
				<div class="col-12 display-flex blog-sec-grids">
					<?php
						// Get the selected year from the dropdown
						$selected_year = get_query_var('year');

						// If no year is selected, use the latest available year
						if (!$selected_year) {
							global $wpdb;
							$selected_year = $wpdb->get_var("SELECT MAX(YEAR(post_date)) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'");
						}

						// WP_Query Arguments
						$args = array(
						'post_type'      => 'post',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'orderby'        => 'date',
						'order'          => 'ASC',
						'date_query'     => array(
							array(
								'year' => $selected_year, // Filter by selected or latest year
							),
						),
					);

					$loop = new WP_Query($args);
					?>
					<?php if ($loop->have_posts()) : ?>
						<?php while ($loop->have_posts()) : $loop->the_post(); ?>
						<div class="col-md-4 col-sm-12 col-12 blog-single-grid hide-blog-grid">
							<div class="col-12 blog-single-img">
								<?php 
								if (has_post_thumbnail()) {
									the_post_thumbnail('full', array('class' => 'img-fluid'));
								} else {
									echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/default-image.jpg') . '" alt="Default Image" class="img-fluid">';
								}
								?>
							</div>
							<div class="col-12 blog-single-content">
								<h3><?php the_title();?></h3>
								<a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'moyal'); ?></a>
							</div>
						</div>
						<?php endwhile; 
							wp_reset_postdata();
						?>
					<?php endif; ?>
				</div>
				<div class="col-12 load-testimonial">
					<a id="loadMore" href="javascript:;"><?php echo esc_html_e('Load More'); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php } else { ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
	}

	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

} ?>

<?php } ?>

<?php
get_footer();

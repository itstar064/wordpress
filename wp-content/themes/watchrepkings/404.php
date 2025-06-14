<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Creepster&display=swap');
.page-header404 {min-height: 70vh;display: flex;align-items: center;justify-content: center;}

.page-header404 .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.page-header404 .page-title {
    font-family: "Creepster", system-ui;
    font-size: 250px;
    line-height: 1;
    color: rgb(79 79 79 / 41%);
}

.page-header404 .container p {
    margin-bottom: 40px;
    font-size: 20px;
    line-height: 26px;
    font-family: 'Inter';
    color: #c9c9c9;
}

.page-header404 .container .btnbar {}

.page-header404 .container .btnbar a {
    padding: 26px 40px;
    display: inline-flex;
    border-radius: 10px;
    color: #1B1B1B;
    font-family: 'FONTSPRING DEMO - Procerus Extra';
    font-weight: bold !important;
    font-style: italic;
    align-items: center;
    justify-content: center;
    font-size: 28px !important;
    line-height: 1;
    letter-spacing: 2px;
    background-image: linear-gradient(45deg, #ffcc00, #FFF600);
    overflow: hidden;
    position: relative;
    border: 1px solid transparent;
    height: 36px;
}
@media (max-width: 767px){
	.page-header404 .page-title {
    font-size: 100px;
}
.page-header404 .container p {
    margin-bottom: 20px;
    font-size: 16px;
    line-height: 22px;
    font-family: 'Inter';
}
.page-header404 .container .btnbar a {
    font-size: 22px !important;
    padding: 18px 20px !important;
}
}
</style>
	<header class="page-header404 ">
		<div class="container">
			<h1 class="page-title">404</h1>
			<p>Sorry, this page was not found!</p>
			<div class="btnbar">
				<a href="<?php echo home_url(); ?>">Back to Home page.</a>
			</div>
		</div>
	</header>

<?php
get_footer();

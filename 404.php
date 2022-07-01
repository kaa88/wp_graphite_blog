<?php
/* Template Name: Home */
get_template_part('parts/header');
?>

<div class="main page404">

		<div class="container">
			<div class="page404__main">
				<h1>404</h1>
				<h2><?php echo __('Page Not Found') ?></h2>
				<p><?php echo __('Sorry, but the page you were trying to view does not exist.') ?></p>
				<p><?php echo __('Try to <a href="#">search</a> something.') ?></p>
				<a href="<?php echo home_url() ?>"><?php echo __('Go to Homepage') ?></a>
			</div>
		</div>

	</div>

<?php get_template_part('parts/footer');
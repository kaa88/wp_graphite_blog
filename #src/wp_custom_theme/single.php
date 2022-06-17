<?php
get_template_part('parts/header');


if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

	<section class="wp-post">
		<div class="wp-post__container container">
			<h2 class="wp-post__title"><?php the_title() ?></h2>
			<?php the_content() ?>
		</div>
	</section>

<?php endwhile; else : ?>
	<p>Записей нет.</p>
<?php endif;


get_template_part('parts/footer');
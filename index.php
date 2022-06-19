<?php
get_template_part('parts/header');

// index.php
// Здесь должны быть блоки: is_search, is_archive(рубрики, метки, автор)

// Search
if ( is_search() ) {
	global $wp_query;
	
	if ( $wp_query->found_posts ) {
		print_r('<br>Найдено: ' . $wp_query->found_posts . ' совпадений');
	}
}
?>

<div class="main__article-box article-box">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<a class="article-box__article-preview article-preview" href="<?php the_permalink() ?>">
			<span class="article-preview__img">
				<?php if (has_post_thumbnail()) {
						the_post_thumbnail();
				}; ?>
			</span>
			<span class="article-preview__content">
				<span class="article-preview__title"><?php the_title() ?></span>
				<span class="article-preview__text">
					<?php the_excerpt() ?>
				</span>
			</span>
		</a>

	<?php endwhile; else : ?>
		<p>Записей нет.</p>
	<?php endif; ?>

</div>

<?php
get_template_part('parts/footer');
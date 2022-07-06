<?php
/* Template Name: Home */
get_template_part('parts/header');
?>

<main class="main --page-home">
	<div class="main__container container">

		<div class="main__author author">
			<div class="author__img">
				<!-- <img src="<?php //the_field('author_photo') ?>" alt=""> -->
				<?php echo wp_get_attachment_image( carbon_get_the_post_meta('author_photo2')) ?>
				<!-- чтобы в ВП работала ретина, надо нарезать картинки для разных размеров, он сам выберет -->
				<!-- максимальная ширина 1920*2 = 3840 -->
				<!-- но придется всегда указывать нужный размер, т.к. по умолчанию будет выводиться thumbnail 150рх -->
				<!-- еще сделать выгрузку из gulp без @2x -->
				<!-- thumb 350 700 1024 1280 1920 3840 full -->
			</div>
			<div class="author__info">
				<h1 class="author__title"><?php the_field('author_title') ?></h1>
				<p class="author__text">
					<?php the_field('author_text') ?>
				</p>
			</div>
			<div class="author__contact-links contact-links">
				<?php 
					$list = get_field('socials_group');
					if ($list) {
						for ($i = 0; $i < count($list); $i++) {
							echo '<a class="contact-links__link" href="'.$list[$i]['socials_link'].'" title="'.$list[$i]['socials_select'].'">
								<i class="icon-'.$list[$i]['socials_select'].'"></i>
							</a>';
						}
					}
				?>
			</div>
		</div>

		<div class="main__controls controls">
			<a class="controls__button controls__button--download g-button" href="<?php the_field('author_cv') ?>" target="_blank">
				<i class="icon-download"></i>
				<span><?php the_field('author_button_text') ?></span>
			</a>
			<a class="controls__button controls__button--contact g-button modal-link" href="#modal-contact">
				<span><?php echo __('Contact', 'wp_graphite_blog') ?></span>
			</a>
			<div class="controls__theme" title="<?php echo __('Change color theme', 'wp_graphite_blog') ?>">
				<span></span>
			</div>


			<div class="controls__lang">
				<?php wp_nav_menu() ?>
				<!-- <a href="/">EN</a>
				<a class="_inactive" href="/ru.html">RU</a> -->
			</div>
		</div>

		<div class="main__dropdown">
			<div class="spoiler">
				<div class="spoiler__header">
					<div class="spoiler__header-inner">
						<p><?php the_field('spoiler_title') ?></p>
						<i class="icon-arrow"></i>
					</div>
				</div>
				<div class="spoiler__wrapper">
					<div class="spoiler__content">
						<p><?php the_field('spoiler_text') ?></p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="main__article-box article-box">
		
			<?php
				$myposts = get_posts([
					'numberposts' => 99,
					'category'    => 1,
				]);
				foreach( $myposts as $post ){
					setup_postdata( $post );
					?>
						<a class="article-box__article-preview article-preview" href="<?php the_permalink() ?>">
							<span class="article-preview__img">
								<?php if (has_post_thumbnail()) {
										the_post_thumbnail('thumbnail');
								}; ?>
							</span>
							<span class="article-preview__content">
								<span class="article-preview__title"><?php the_title() ?></span>
								<span class="article-preview__text">
									<?php the_excerpt() ?>
								</span>
							</span>
						</a>
				<?php }
				wp_reset_postdata();
			?>

		</div>

		<div class="main__card-box card-box">

			<?php
				$myposts = get_posts([
					'numberposts' => 99,
					'category'    => 3,
					'order'       => 'ASC',
				]);
				foreach( $myposts as $post ){
					setup_postdata( $post );
					?>
						<a class="card-box__card-preview card-preview" href="<?php the_permalink() ?>">
							<span class="card-preview__img">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail([365]);
								}; ?>
							</span>
							<span class="card-preview__title"><?php the_title() ?></span>
						</a>
				
				<?php }
				wp_reset_postdata();
			?>

		</div>

	</div>


</main>

<?php get_template_part('parts/popup'); ?>

<section class="modal">
	<?php get_template_part('parts/modal-contact'); ?>
</section>

<?php get_template_part('parts/footer');
<?php
/* Template Name: Post */
get_template_part('parts/header');
?>

<main class="main --page-post">

	<section class="main__post post">
		<div class="post__container container">

			<div class="post__title-image">
				<div class="post__header">
					<i class="icon-arrow"></i>
					<a href="/">Back</a>
				</div>
				<img src="media/img/card1@2x.jpg" alt="">
			</div>


			<div class="post__content">
				<h1 class="post__title">Heading</h1>
				<p class="post__text">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil reprehenderit eligendi iusto reiciendis vero quos amet animi voluptate dignissimos magnam sint, cupiditate repudiandae ea voluptatibus. A facilis quae sit quidem.
				</p>
	
				<div class="post__images">
					<div class="post__images-item">
						<img src="media/img/card2.jpg" srcset="media/img/card2@2x.jpg 2x" alt="" loading="lazy">
					</div>
					<div class="post__images-item">
						<img src="media/img/card1.jpg" srcset="media/img/card1@2x.jpg 2x" alt="" loading="lazy">
					</div>
				</div>
				
				<p class="post__text">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil reprehenderit eligendi iusto reiciendis vero quos amet animi voluptate dignissimos magnam sint, cupiditate repudiandae ea voluptatibus. A facilis quae sit quidem.
				</p>
			</div>

		</div>
	</section>

</main>

<?php get_template_part('parts/footer'); ?>

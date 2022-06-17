<?php
/* Template Name: Home */
get_template_part('parts/header');
?>

<main class="main --page-home">
	<div class="main__container container">

		<div class="main__author author">
			<div class="author__img">
				<img src="<?php echo get_template_directory_uri() . '/assets/media/img/profile-photo-s.jpg'; ?>" alt="">
			</div>
			<div class="author__info">
				<h1 class="author__title">Andrei K.</h1>
				<p class="author__text">
					Something about me. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
				</p>
			</div>
			<div class="author__contact-links contact-links">
				<a class="contact-links__link" href="#" title="Bitrix">
					<i class="icon-bitrix"></i>
				</a>
				<a class="contact-links__link" href="#" title="Wordpress">
					<i class="icon-wp"></i>
				</a>
				<a class="contact-links__link" href="#" title="Twitter">
					<i class="icon-twitter"></i>
				</a>
				<a class="contact-links__link" href="#" title="link">
					<i class="icon-link"></i>
				</a>
				<a class="contact-links__link" href="#" title="send">
					<i class="icon-send"></i>
				</a>
				<a class="contact-links__link" href="#" title="mail">
					<i class="icon-mail"></i>
				</a>
			</div>
		</div>

		<div class="main__controls controls">
			<a class="controls__button controls__button--download g-button" href="media/doc/docsample.pdf">
				<i class="icon-download"></i>
				<span>Download CV</span>
			</a>
			<a class="controls__button controls__button--contact g-button modal-link" href="#modal-contact">
				<span>Concact</span>
			</a>
			<div class="controls__theme" title="Change color theme">
				<span></span>
			</div>
			<div class="controls__lang">
				<a href="/">EN</a>
				<a class="_inactive" href="/ru.html">RU</a>
			</div>
		</div>

		<div class="main__dropdown">
			<div class="spoiler">
				<div class="spoiler__header">
					<div class="spoiler__header-inner">
						<p>Biography</p>
						<i class="icon-arrow"></i>
					</div>
				</div>
				<div class="spoiler__wrapper">
					<div class="spoiler__content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="main__article-box article-box">
			<a class="article-box__article-preview article-preview" href="single.html">
				<span class="article-preview__img">
					<img src="media/img/profile-photo-s.jpg" alt="">
				</span>
				<span class="article-preview__content">
					<span class="article-preview__title">Title</span>
					<span class="article-preview__text">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero minima quos eos excepturi rem inventore suscipit molestias fugit perferendis laboriosam.
					</span>
				</span>
			</a>
			<a class="article-box__article-preview article-preview" href="single.html">
				<span class="article-preview__img">
					<img src="media/img/1x1.png" alt="">
				</span>
				<span class="article-preview__content">
					<span class="article-preview__title">Title</span>
					<span class="article-preview__text">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero minima quos eos excepturi rem inventore suscipit molestias fugit perferendis laboriosam.
					</span>
				</span>
			</a>
			<a class="article-box__article-preview article-preview" href="single.html">
				<span class="article-preview__img">
					<img src="media/img/1x1.png" alt="">
				</span>
				<span class="article-preview__content">
					<span class="article-preview__title">Title</span>
					<span class="article-preview__text">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero minima quos eos excepturi rem inventore suscipit molestias fugit perferendis laboriosam.
					</span>
				</span>
			</a>
		</div>

		<div class="main__card-box card-box">
			<a class="card-box__card-preview card-preview" href="single.html">
				<span class="card-preview__img">
					<img src="media/img/card1.jpg" alt="">
				</span>
				<span class="card-preview__title">iOS applications</span>
			</a>
			<a class="card-box__card-preview card-preview" href="single.html">
				<span class="card-preview__img">
					<img src="media/img/card2.jpg" alt="">
				</span>
				<span class="card-preview__title">Design systems</span>
			</a>
			<a class="card-box__card-preview card-preview" href="single.html">
				<span class="card-preview__img">
					<img src="media/img/profile-photo-s.jpg" alt="">
				</span>
				<span class="card-preview__title">Profiling</span>
			</a>
			<a class="card-box__card-preview card-preview" href="single.html">
				<span class="card-preview__img">
					<img src="media/img/1x1.png" alt="">
				</span>
				<span class="card-preview__title">Testing</span>
			</a>
		</div>

	</div>


</main>



<!-- popup -->
<div class="popup scroll-lock-item-m">
	<div class="cookie-alert">
		<div class="popup__close-btn"><i class="icon-cross"></i></div>
		<p class="cookie-alert__title">Cookie alert</p>
		<p class="cookie-alert__text-closed">
			Lorem ipsum dolor sit amet, consectetur adipiscing ut labore et dolore magna aliqua. 
		</p>
		<p class="cookie-alert__text-opened">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
		</p>
		<div class="cookie-alert__link-container"><span class="cookie-alert__link">About cookies</span></div>
		<div class="cookie-alert__buttons">
			<div class="cookie-alert__accept g-button">Accept</div>
			<div class="cookie-alert__close g-button"><span>Close</span></div>
		</div>
	</div>
</div>

<section class="modal">
	<?php get_template_part('parts/modal-contact'); ?>
</section>

<?php get_template_part('parts/footer'); ?>

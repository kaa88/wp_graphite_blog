@@include('parts/head.html', {
	'title': 'Post | Graphite Blog',
	'descr': 'Description',
	'robots': 'noindex, nofollow',
})
<body>
@@include('parts/noscript.html')
@@include('parts/loadscreen.html')

<!-- @@include('parts/header.html') -->
<script id="header-menu-options">
	// список пунктов меню в header.html
	// наличие и порядок устанавливаются в массиве 'links'
	// 'activeLink' добавляет класс 'this-page'
	// тег 'script' можно удалить
	
	// let headerMenuOptions = {
	// 	links: ['home','products','about','contacts'],
	// 	activeLink: 'home'
	// }
</script>

<!-- <div id="wpadminbar">wpadminbar</div> -->

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



@@include('parts/footer.html')

<section class="modal">
	@@include('parts/modal-contact.html')
</section>

<!-- SVG test -->
<!-- <img style="width: 300px;" src="media/img/icon-twitter.svg"> -->

<!-- @@include('parts/svg.html') -->

<!-- <div class="template-test-block scroll-lock-item-p"><div class="container">@@include('../#templates.html')</div></div> -->

@@include('parts/script.html')
</body>
</html>
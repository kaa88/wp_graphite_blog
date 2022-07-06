<div class="modal__window" id="modal-contact">
	<div class="modal__wrapper">
		<div class="modal__content">
			<div class="modal__close-button"><i class="icon-cross"></i></div>

			<form class="contact-form" name="contact-form" action="#">
				<p class="contact-form__title">
					<?php
						if (get_locale() == 'ru_RU') echo carbon_get_theme_option('modal_header_ru');
						else echo carbon_get_theme_option('modal_header');
					?>
				</p>
				<div class="contact-form__links">

					<?php 
						$list = carbon_get_theme_option('modal_quick_contacts');
						if ($list) {
							for ($i = 0; $i < count($list); $i++) {
								echo '<a class="contact-form__link" href="'.$list[$i]['link'].'">
									<i class="icon-'.$list[$i]['icon'].'"></i>'.
									$list[$i]['text'].
								'</a>';
							}
						}
					?>
				</div>
				<input class="contact-form__name _req" type="text" name="name" placeholder="<?php
						if (get_locale() == 'ru_RU') echo carbon_get_theme_option('modal_name_placeholder_ru');
						else echo carbon_get_theme_option('modal_name_placeholder');
					?>">
				<input class="contact-form__email _req" type="text" name="email" placeholder="<?php echo carbon_get_theme_option('modal_email_placeholder') ?>">
				<div class="form-report"></div>
				<button class="contact-form__button g-button" type="submit">
					<i class="icon-arrow-2"></i>
					<!-- Sending progress bar inside the button -->
					<span class="progress">
						<span class="progress__box">
							<i></i><i></i><i></i>
						</span>
					</span>
				</button>
			</form>
						
		</div>
	</div>
</div>
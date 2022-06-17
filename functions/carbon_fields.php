<?php
/* ШПАРГАЛКА
get_field('field')
the_field('field')
the_field('button_link', 'link')
echo get_template_directory_uri()
echo carbon_get_theme_option('field')
echo home_url()
...
проверка:
<?php
	$fields = [
		get_field('footer_email_link', 'theme'),
		get_field('footer_email_text', 'theme'),
	];
	if (check_fields($fields)):
?>
	// html... <?php echo $fields[0] ?>
<?php endif; ?>
...
картинка:
	<?php 
		$image = get_field('clients_item1_img');
		if ($image) echo '<img src="' . $image . '" alt="" loading="lazy">';
	?>
...
цикл:
	$list = get_field('list');
	if ($list) {
		for ($i = 0; $i < count($list); $i++) {
			echo '<img src="' . $list[$i]['img'] .'">';
		}
	}
		// или:
		foreach ($list as $item) {
			echo '<img src="' . $item['img'] .'">';
		}
	// или:
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php endwhile; endif; ?>
*/

//////////////////////////////////////////////

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Functions "get_field" and "the_field" allow easy switch between Cabron Fields and ACF.
function get_field($name, $type = 'default') {
	if ($type == 'theme')
		return carbon_get_theme_option($name);
	if ($type == 'link')
		return get_permalink(carbon_get_the_post_meta($name)[0]['id']);
	else
		return carbon_get_the_post_meta($name);
}
function the_field($name, $type = 'default') {
	if ($type == 'theme')
		echo carbon_get_theme_option($name);
	if ($type == 'link')
		echo get_permalink(carbon_get_the_post_meta($name)[0]['id']);
	else
		echo carbon_get_the_post_meta($name);
}
function check_fields($arr = []) {
	if (count($arr) == 0) return false;
	foreach ($arr as $v) {
		if (!$v) return false;
	}
	return true;
}

//////////////////////////////////////////////

function add_custom_fields() {

	// Custom fields container
	Container::make('theme_options', 'Custom Fields')
		->set_page_menu_title('Кастомные поля')
		->set_icon('dashicons-align-right')

	// Header tab
		->add_tab('Шапка', [
			Field::make('image', 'header_logo_img', 'Иконка логотипа')->set_value_type('url'),
			Field::make('text', 'header_logo_text', 'Текст логотипа'),
		])

	// Footer tab
		->add_tab('Подвал', [
			Field::make('text', 'footer_address', 'Адрес'),
			Field::make('text', 'footer_phone_link', 'Телефон - ссылка')->set_width(50)
				->set_help_text('Формат телефона для ссылки: +79999999999'),
			Field::make('text', 'footer_phone_text', 'Телефон - отображаемый текст')->set_width(50),
			Field::make('text', 'footer_email_link', 'Email - ссылка')->set_width(50),
			Field::make('text', 'footer_email_text', 'Email - отображаемый текст')->set_width(50),

			Field::make('separator', 'separator_footer_socials', 'Соцсети:'),
			Field::make('complex', 'footer_socials', 'Соцсети')
				->add_fields([
					Field::make('select', 'name', 'Выберите')->set_width(50)
						->set_options([
							'twitter' => 'Twitter',
							'facebook' => 'Facebook',
							'pinterest' => 'Pinterest',
							'google-plus' => 'Google+'
						]),
					Field::make('text', 'link', 'Ссылка')->set_width(50)
						->set_help_text('Введите адрес полностью, начиная с https://'),
				]),

		])

	// Metrics tab
		->add_tab('Метрики', [
			Field::make('header_scripts', 'metrics', 'HTML-код метрик и счетчиков поисковых систем')
				->set_default_value('<!-- Здесь будут метрики поисковых систем -->')
				->set_rows(20)
		]);

//////////////////////////////////////////////
	// Editor fields:

	// Banner section
		Container::make('post_meta', 'Banner')
			->where('post_id', '=', 15)
			->set_priority('core')
			->add_fields([
				Field::make('text', 'banner_title', 'Заголовок'),
				Field::make('text', 'banner_text', 'Текст'),

				Field::make('text', 'banner_button_text', 'Кнопка - текст'),
				Field::make('association', 'banner_button_link', 'Кнопка - ссылка')
					->set_max(1)
					->set_types([[
						'type' => 'post',
						'post_type' => 'page'
					]]),

				Field::make('image', 'banner_bg_dt', 'Background desktop')
					->set_value_type('url')
					->set_width(50),
				Field::make('image', 'banner_bg_mob', 'Background mobile')
					->set_value_type('url')
					->set_width(50),
			]);

} // end add_custom_fields()
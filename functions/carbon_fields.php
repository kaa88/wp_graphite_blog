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
		// ->add_tab('Шапка', [
		// 	Field::make('image', 'header_logo_img', 'Иконка логотипа')->set_value_type('url'),
		// 	Field::make('text', 'header_logo_text', 'Текст логотипа'),
		// ])

	// Footer tab
		// ->add_tab('Подвал', [
		// 	Field::make('text', 'footer_address', 'Адрес'),
		// 	Field::make('text', 'footer_phone_link', 'Телефон - ссылка')->set_width(50)
		// 		->set_help_text('Формат телефона для ссылки: +79999999999'),
		// 	Field::make('text', 'footer_phone_text', 'Телефон - отображаемый текст')->set_width(50),
		// 	Field::make('text', 'footer_email_link', 'Email - ссылка')->set_width(50),
		// 	Field::make('text', 'footer_email_text', 'Email - отображаемый текст')->set_width(50),

		// 	Field::make('separator', 'separator_footer_socials', 'Соцсети:'),
		// 	Field::make('complex', 'footer_socials', 'Соцсети')
		// 		->add_fields([
		// 			Field::make('select', 'name', 'Выберите')->set_width(50)
		// 				->set_options([
		// 					'twitter' => 'Twitter',
		// 					'facebook' => 'Facebook',
		// 					'pinterest' => 'Pinterest',
		// 					'google-plus' => 'Google+'
		// 				]),
		// 			Field::make('text', 'link', 'Ссылка')->set_width(50)
		// 				->set_help_text('Введите адрес полностью, начиная с https://'),
		// 		]),

		// ])

		->add_tab('Модал - контакт', [
			Field::make('text', 'modal_header', 'Заголовок'),
			Field::make( 'complex', 'modal_quick_contacts', __( 'Быстрые контакты' ) )
			->add_fields([
				Field::make('text', 'link', 'Ссылка')->set_width(33),
				Field::make('text', 'text', 'Текст кнопки')->set_width(33),
				Field::make( 'select', 'icon', __( 'Иконка' ) )
				->set_options([
					'bitrix' => 'Bitrix',
					'wp' => 'Wordpress',
					'twitter' => 'Twitter',
					'link' => 'Link',
					'send' => 'Telegram',
					'mail' => 'Email',
				])
				->set_width(33)
			]),
			Field::make('text', 'modal_name_placeholder', 'Замещающий текст - имя')->set_width(50),
			Field::make('text', 'modal_email_placeholder', 'Замещающий текст - email')->set_width(50),
		])
		// Metrics tab
		->add_tab('Метрики', [
			Field::make('header_scripts', 'metrics', 'HTML-код метрик и счетчиков поисковых систем')
				->set_default_value('<!-- Здесь будут метрики поисковых систем -->')
				->set_rows(20)
		]);

//////////////////////////////////////////////
	// Editor fields:

	// Author section
		Container::make('post_meta', 'Автор')
			->where('post_id', '=', 32)
			->or_where('post_id', '=', 152)
			->set_priority('core')
			->add_fields([
				// Field::make('image', 'author_photo', 'Фото')
				// 	->set_value_type('url')
				// 	->set_width(50),
				Field::make('image', 'author_photo2', 'Фото id')
					->set_width(50),
				Field::make('text', 'author_title', 'Заголовок'),
				Field::make('text', 'author_text', 'Текст'),

				Field::make( 'file', 'author_cv', 'Кнопка - файл' )
				->set_value_type( 'url' )
				->set_width(50),
				Field::make('text', 'author_button_text', 'Кнопка - текст')
				->set_width(50),

				Field::make( 'complex', 'socials_group', __( 'Группа ссылок на соцсети' ) )
				->add_fields( array(
					Field::make( 'select', 'socials_select', __( 'Выбор' ) )
					->set_options( array(
						'bitrix' => 'Bitrix',
						'wp' => 'Wordpress',
						'twitter' => 'Twitter',
						'link' => 'Link',
						'send' => 'Telegram',
						'mail' => 'Email',
					) )
					->set_width(50),
					Field::make('text', 'socials_link', 'Ссылка')
					->set_width(50),
				) ),
				Field::make('text', 'spoiler_title', 'Заголовок спойлера'),
				Field::make('textarea', 'spoiler_text', 'Текст спойлера'),
			]);

} // end add_custom_fields()
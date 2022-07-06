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
	Container::make('theme_options', __('Custom Fields', 'wp_graphite_blog'))
		->set_page_menu_title( __('Custom Fields', 'wp_graphite_blog') )
		->set_icon('dashicons-align-right')

		->add_tab(__('Modal-contact', 'wp_graphite_blog'), [
			Field::make('text', 'modal_header', __('Header (EN)', 'wp_graphite_blog'))->set_width(50),
			Field::make('text', 'modal_header_ru', __('Header (RU)', 'wp_graphite_blog'))->set_width(50),
			Field::make( 'complex', 'modal_quick_contacts', __('Quick contacts', 'wp_graphite_blog') )
			->add_fields([
				Field::make('text', 'link', __('Link', 'wp_graphite_blog'))->set_width(33),
				Field::make('text', 'text', __('Button text', 'wp_graphite_blog'))->set_width(33),
				Field::make( 'select', 'icon', __('Icon', 'wp_graphite_blog') )
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
			Field::make('text', 'modal_name_placeholder', __('Placeholder - name (EN)', 'wp_graphite_blog'))->set_width(50),
			Field::make('text', 'modal_name_placeholder_ru', __('Placeholder - name (RU)', 'wp_graphite_blog'))->set_width(50),
			Field::make('text', 'modal_email_placeholder', __('Placeholder - email', 'wp_graphite_blog')),
		])
		// Metrics tab
		->add_tab(__('Metrics', 'wp_graphite_blog'), [
			Field::make('header_scripts', 'metrics', __('HTML-code for searchbots', 'wp_graphite_blog'))
				->set_default_value(__('<!-- Mertics will be here -->', 'wp_graphite_blog'))
				->set_rows(20)
		]);

//////////////////////////////////////////////
	// Editor fields:

	// Author section
		Container::make('post_meta', __('Author', 'wp_graphite_blog'))
			->where('post_id', '=', 32)
			->or_where('post_id', '=', 152)
			->set_priority('core')
			->add_fields([
				Field::make('image', 'author_photo2', __('Photo id', 'wp_graphite_blog'))
					->set_width(50),
				Field::make('text', 'author_title', __('Header', 'wp_graphite_blog')),
				Field::make('text', 'author_text', __('Text', 'wp_graphite_blog')),

				Field::make( 'file', 'author_cv', __('Button - file', 'wp_graphite_blog') )
				->set_value_type( 'url' )
				->set_width(50),
				Field::make('text', 'author_button_text', __('Button - text', 'wp_graphite_blog'))
				->set_width(50),

				Field::make( 'complex', 'socials_group', __( 'Socials group', 'wp_graphite_blog' ) )
				->add_fields( array(
					Field::make( 'select', 'socials_select', __( 'Select', 'wp_graphite_blog' ) )
					->set_options( array(
						'bitrix' => 'Bitrix',
						'wp' => 'Wordpress',
						'twitter' => 'Twitter',
						'link' => 'Link',
						'send' => 'Telegram',
						'mail' => 'Email',
					) )
					->set_width(50),
					Field::make('text', 'socials_link', __('Link', 'wp_graphite_blog'))
					->set_width(50),
				) ),
				Field::make('text', 'spoiler_title', __('Spoiler header', 'wp_graphite_blog')),
				Field::make('textarea', 'spoiler_text', __('Spoiler text', 'wp_graphite_blog')),
			]);

} // end add_custom_fields()
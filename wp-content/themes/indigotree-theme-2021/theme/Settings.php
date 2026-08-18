<?php

namespace Origin\Theme;

use Origin\Theme\Traits\UsesACF;

class Settings
{
	use UsesACF;

	/**
	 * Theme options key.
	 *
	 * @var string
	 */
	protected $key = 'theme-options';

	/**
	 * Collection of groups used for tabs.
	 *
	 * @var array
	 */
	protected $groups = [];

	/**
	 * Singleton Instance
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Get the ModuleManager instance
	 *
	 * @return ModuleManager
	 */
	public static function instance()
	{
		if (is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Create some new settings fields/sections.
	 *
	 * @return void
	 */
	protected function __construct()
	{
		add_action('init', [$this, 'register'], 15);
		add_action('admin_bar_menu', [$this, 'bar'], 99);
	}

	public function register()
	{
		if (!function_exists('acf_add_options_sub_page') || !function_exists('acf_add_local_field_group')) {
			return;
		}

		$this->menu();
		$this->settings();

		do_action('origin_register_settings');

		$this->wrapper("{$this->key}_wrapper", 'Settings', $this->groups);
	}

	/**
	 * Register various fields for the theme options screen.
	 *
	 * @return array
	 */
	protected function settings()
	{
		$this->group('emergency-number', 'Emergency 24 hour line', [
			[
				'name' => 'emergency-number',
				'label' => 'Emergency Number',
				'type' => 'link',
				'instructions' => 'URL must be in the following format: tel:+443335772999. Link Text will be displayed as the telephone number. Both fields are required.',
			]
		]);

		$this->group('banners', 'Banners', [
			[
				'name' => 'default_banner',
				'label' => 'Default Banner',
				'type' => 'image'
			]
		]);

		$this->group('insights', 'Insights', [
			[
				'name' => 'useful_insights',
				'label' => 'Useful Insights',
				'type' => 'repeater',
				'sub_fields' => [
					[
						'name' => 'useful_insight',
						'label' => 'Insight',
						'type' => 'post_object',
						'post_type' => [
							0 => 'post',
						]
					]
				]
			]
		]);

		$this->group('social', 'Social Media', [
			[
				'name' => 'social_media',
				'label' => 'Social Media',
				'type' => 'repeater',
				'sub_fields' => [
					[
						'name' => 'icon',
						'label' => 'Icon',
						'type' => 'select',
						'choices' => [
							'facebook' => 'Facebook',
							'twitter' => 'Twitter',
							'pinterest' => 'Pinterest',
							'linkedin' => 'Linkedin',
							'instagram' => 'Instagram',
							'youtube' => 'Youtube'
						]
					],
					[
						'name' => 'link',
						'label' => 'Link',
						'type' => 'link'
					]
				]
			]
		]);

		$this->group('footer', 'Footer', [
			[
				'name' => 'contact_address',
				'label' => 'Footer Contact Addresses',
				'type' => 'repeater',
				'sub_fields' => [
					[
						'name' => 'address',
						'label' => 'Address',
						'type' => 'wysiwyg'
					]
				]
			],
			[
				'name' => 'footer_logos',
				'label' => 'Footer Contact Addresses',
				'type' => 'repeater',
				'sub_fields' => [
					[
						'name' => 'logo',
						'label' => 'Logo',
						'type' => 'image',
						'return' => 'id'
					]
				]
			],
			[
				'key' => 'field_671hewofyg2364899',
				'label' => 'Cyber Essentials',
				'name' => 'footer_cyber_essentials',
				'aria-label' => '',
				'type' => 'textarea',
				'instructions' => 'Please add code snippet for cyber essentials logo',
			],
			[
				'key' => 'field_67167514325436',
				'label' => 'SRA snippet',
				'name' => 'footer_sra_snippet',
				'aria-label' => '',
				'type' => 'textarea',
				'instructions' => 'Please add code snippet for reverse mono logo from https://www.yoshki.com/sra/',
			],

			[
				'name' => 'opening_times',
				'label' => 'Opening Times',
				'type' => 'group',
				'sub_fields' => [
					[
						'key' => 'field_time_monday',
						'label' => 'Monday',
						'name' => 'monday',
						'default_value' => '9am–5:30pm',
					],
					[
						'key' => 'field_time_tuesday',
						'label' => 'Tuesday',
						'name' => 'tuesday',
						'default_value' => '9am–5:30pm',
					],
					[
						'key' => 'field_time_wednesday',
						'label' => 'Wednesday',
						'name' => 'wednesday',
						'default_value' => '9am–5:30pm',
					],
					[
						'key' => 'field_time_thursday',
						'label' => 'Thursday',
						'name' => 'thursday',
						'default_value' => '9am–5:30pm',
					],
					[
						'key' => 'field_time_friday',
						'label' => 'Friday',
						'name' => 'friday',
						'default_value' => '9am–5:30pm',
					],
					[
						'key' => 'field_time_saturday',
						'label' => 'Saturday',
						'name' => 'saturday',
						'default_value' => 'Closed',
					],
					[
						'key' => 'field_time_sunday',
						'label' => 'Sunday',
						'name' => 'sunday',
						'default_value' => 'Closed',
					],
				]
			],
			[
				'name' => 'copyright_text',
				'placeholder' => origin_theme_copyright_default(),
				'instructions' => '<code>%1$d</code> = Current Year, <code>%2$s</code> = Site Name'
			]
		]);

		$this->group('page-404', '404 Page', [
			[
				'name' => 'page_404_title',
				'label' => 'Title',
				'type' => 'text',
				'placeholder' => 'Page Not Found'
			],
			[
				'name' => 'page_404_content',
				'label' => 'Content',
				'type' => 'wysiwyg'
			]
		]);
	}

	public function group($key, $label, $fields)
	{
		$this->groups[] = [
			'key' => "settings_tab_${key}",
			'label' => $label,
			'type' => 'tab',
			'placement' => 'left'
		];

		foreach ($fields as $field) {
			$this->groups[] = $this->normalizeField($field);
		}
	}

	protected function wrapper($key, $label, $fields)
	{
		$return = [
			'key' => $key,
			'title' => $label,
			'fields' => $fields,
			'location' => [
				[
					[
						'param' => 'options_page',
						'operator' => '==',
						'value' => $this->key,
					]
				]
			]
		];

		acf_add_local_field_group($return);

		return $return;
	}

	protected function menu()
	{
		acf_add_options_sub_page([
			'page_title' => 'Theme Options',
			'menu_title' => 'Theme Options',
			'parent_slug' => 'themes.php',
			'capability' => 'edit_theme_options',
			'menu_slug' => $this->key
		]);
	}

	/**
	 * Register the WordPress admin bar menu item
	 * used for easy access to the settings
	 *
	 * @return void
	 */
	public function bar($bar)
	{
		$bar->add_node([
			'id' => 'theme-options',
			'title' => 'Theme Options',
			'href' => admin_url('themes.php?page=' . $this->key),
			'parent' => 'site-name'
		]);
	}
}

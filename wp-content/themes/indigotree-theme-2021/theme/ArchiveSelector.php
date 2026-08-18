<?php

namespace Origin\Theme;

if ( in_array( 'advanced-custom-fields-pro/acf.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	include_once(WP_PLUGIN_DIR.'/advanced-custom-fields-pro/acf.php');
}

class ArchiveSelector
{
	/**
	 * Prefix used for the settings
	 *
	 * @var string
	 */
	protected $prefix = 'archive_page_';

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
	 * Create a new Archive Selector
	 *
	 * @return void
	 */
	protected function __construct()
	{
		add_filter('display_post_states', [$this, 'addPostStates'], 10, 2);

		add_action('origin_register_settings', [$this, 'createSettingsTab']);

		add_action('admin_bar_menu', [$this, 'addMenuToAdminBar'], 80);
	}

	/**
	 * Create a tab in the theme-options
	 *
	 * @return void
	 */
	public function createSettingsTab()
	{
		$settings = \Origin\Theme\Settings::instance();
		$fields = [];

		foreach ($this->getPostTypes() as $type) {
			$fields[] = [
				'key' => 'field_' . md5(sprintf('archive_page_%s', $type->name)),
				'name' => "{$this->prefix}{$type->name}",
				'label' => $type->labels->singular_name,
				'type' => 'post_object',
				'post_type' => ['page'],
				'allow_null' => 1,
				'return_format' => 'object',
			];
		}

		if (sizeof($fields) > 0) {
			$settings->group('settings_tab_archive_pages', 'Archive Pages', $fields);
		}
	}

	/**
	 * Add "post states" next to the title in the admin area
	 *
	 * @param array $states
	 * @param $post
	 *
	 * @return array
	 */
	public function addPostStates(array $states, $post): array
	{
		foreach ($this->getPostTypes() as $type) {
			$value = get_field("{$this->prefix}{$type->name}", 'option');
			if ($value && $value->ID === $post->ID) {
				$states[] = sprintf('%s Archive', $type->labels->singular_name);
			}
		}

		return $states;
	}

	/**
	 * Return all post types that have archive pages
	 *
	 * @return array
	 */
	protected function getPostTypes(): array
	{
		$types = get_post_types(['public' => true, '_builtin' => false], 'objects');
		$return = [];

		foreach ($types as $type) {
			if ($type->has_archive) {
				$return[] = $type;
			}
		}

		return $return;
	}

	/**
	 * Return the page attached to the given post type archive
	 *
	 * @param $type
	 * @return object|null
	 */
	public function getPage($type = null)
	{
		if (is_null($type) && is_post_type_archive()) {
			$type = get_queried_object()->name;
		}

		if (is_object($type) && property_exists($type, 'name')) {
			$type = $type->name;
		}

		$return = get_field("{$this->prefix}{$type}", 'option');

		if (!is_a($return, 'WP_Post') && is_numeric($return)) {
			return get_page($return);
		}

		return $return;
	}

	/**
	 * Add an "edit page" link to the admin bar
	 *
	 * @param $wp_admin_bar
	 *
	 * @return void
	 */
	public function addMenuToAdminBar($wp_admin_bar): void
	{
		if (!is_post_type_archive()) {
			return;
		}

		$type = get_queried_object();

		if (!is_a($type, 'WP_Post_Type')) {
			return;
		}

		$archive = origin_get_archive_page($type->name);

		if (!$archive) {
			return;
		}

		if (!current_user_can('edit_post', $archive->ID)) {
			return;
		}

		$wp_admin_bar->add_menu([
			'id' => 'edit',
			'title' => get_post_type_object('page')->labels->edit_item,
			'href' => get_edit_post_link($archive->ID),
		]);
	}
}

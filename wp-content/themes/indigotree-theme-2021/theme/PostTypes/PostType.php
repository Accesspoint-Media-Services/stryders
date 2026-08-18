<?php

namespace Origin\Theme\PostTypes;

abstract class PostType
{
	/**
	 * The name of the post type
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The plural of $name
	 *
	 * @var string
	 */
	protected $plural;

	/**
	 * Setup the post type
	 *
	 * @return void
	 */
	public function init()
	{
		add_action('init', [$this, 'register']);

		if (method_exists($this, 'columns')) {
			add_filter('manage_edit-' . $this->type . '_columns', [$this, 'columns']);
		}

		if (method_exists($this, 'renderColumns')) {
			add_action('manage_' . $this->type . '_posts_custom_column', [$this, 'renderColumns'], 10, 2);
		}
	}

	/**
	 * Register the post type with WordPress
	 *
	 * @param array $args
	 *
	 * @return void
	 */
	protected function registerPostType(array $args = [])
	{
		$defaults = [
			'public' => true,
			'labels' => $this->generateLabels(),
			'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail'],
			'show_in_rest' => true,
			'rewrite' => [
				'slug' => $this->slug,
			],
		];

		$args = wp_parse_args($args, $defaults);

		if (isset($args['has_archive']) && $args['has_archive'] === true) {
			$args['has_archive'] = $this->getArchiveUrl();
		}

		register_post_type($this->type, $args);
	}

	/**
	 * Determine the Archive URL from the connected page
	 *
	 * @return string|boolean
	 */
	protected function getArchiveUrl()
	{
		$archive = origin_get_archive_page($this->type);

		return is_a($archive, 'WP_Post') ? get_page_uri($archive->ID) : true;
	}

	/**
	 * Automatically generate labels
	 *
	 * @return array
	 */
	protected function generateLabels(): array
	{
		if (empty($this->plural)) {
			$this->plural = $this->name;
		}

		return [
			'name' => $this->plural,
			'singular_name' => $this->name,
			'add_new' => 'Add New',
			'add_new_item' => sprintf('Add New %s', $this->name),
			'edit_item' => sprintf('Edit %s', $this->name),
			'new_item' => sprintf('New %s', $this->name),
			'all_items' => sprintf('All %s', $this->plural),
			'view_item' => sprintf('View %s', $this->name),
			'search_items' => sprintf('Search %s', $this->plural),
			'not_found' => sprintf('No %s found', strtolower($this->plural)),
			'not_found_in_trash' => sprintf('No %s found in trash', strtolower($this->plural)),
			'parent_item_colon'  => '',
			'menu_name' => $this->plural
		];
	}
}

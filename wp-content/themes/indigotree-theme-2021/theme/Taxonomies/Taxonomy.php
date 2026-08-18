<?php

namespace Origin\Theme\Taxonomies;

abstract class Taxonomy
{
	/**
	 * The slug used in the rewrite url
	 *
	 * @var string
	 */
	protected $postTypes = [];

	/**
	 * The name of the taxonomy
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
	}

	/**
	 * Register the taxonomy with WordPress
	 *
	 * @param array $args
	 *
	 * @return void
	 */
	protected function registerTaxonomy(array $args = [])
	{
		$defaults = [
			'public' => true,
			'labels' => $this->generateLabels(),
			'show_in_rest' => true,
			'rewrite' => [
				'slug' => $this->slug,
			],
		];

		register_taxonomy($this->taxonomy, $this->postTypes, wp_parse_args($args, $defaults));
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
			'search_items' => sprintf('Search %s', $this->plural),
			'all_items' => sprintf('All %s', $this->plural),
			'parent_item' => sprintf('Parent %s', $this->name),
			'parent_item_colon' => sprintf('Parent %s:', $this->name),
			'edit_item' => sprintf('Update %s', $this->name),
			'update_item' => sprintf('Update %s', $this->name),
			'add_new_item' => sprintf('Add New %s', $this->name),
			'new_item_name' => sprintf('New %s Name', $this->name),
			'menu_name' => $this->plural,
		];
	}
}

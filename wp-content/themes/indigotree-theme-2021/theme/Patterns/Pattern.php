<?php

namespace Origin\Theme\Patterns;

abstract class Pattern
{
	/**
	 * A unique key for this pattern
	 *
	 * @var string
	 */
	protected $unique;

	/**
	 * A human-readable title for the pattern
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * A visually hidden text used to describe the pattern in the inserter.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * An array of aliases or keywords that help users discover the pattern while searching.
	 *
	 * @var array
	 */
	protected $keywords = [];

	/**
	 * An array of pattern categories used to group block patterns.
	 *
	 * @var int
	 */
	protected $categories = [];

	/**
	 * An integer specifying the width of the pattern in the inserter.
	 *
	 * @var int
	 */
	protected $viewportWidth = 1920;

	/**
	 * Create a new Pattern
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('init', [$this, 'register']);
	}

	/**
	 * Return the pattern namespace
	 *
	 * @return string
	 */
	public static function namespace()
	{
		return 'indigotree';
	}

	/**
	 * Registers a new pattern with the block editor
	 *
	 * @return void
	 */
	public function register()
	{
		$namespace = static::namespace();
		$content = $this->content();

		if (empty($content)) {
			return;
		}

		register_block_pattern("{$namespace}/{$this->unique}", [
			'title' => $this->title,
			'description' => $this->description,
			'content' => $content,
			'categories' => [$namespace, ...$this->categories],
			'viewportWidth' => $this->viewportWidth,
		]);
	}
}

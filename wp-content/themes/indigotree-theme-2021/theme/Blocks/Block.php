<?php

namespace Origin\Theme\Blocks;

use Origin\Theme\Traits\UsesACF;

abstract class Block
{
	use UsesACF;

	/**
	 * Namespace for blocks
	 *
	 */
	protected $namespace = 'wp-block-origin';

	/**
	 * Create a new Block
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('acf/init', [$this, 'register']);
	}

	/**
	 * Register a new ACF field group & block with WordPress
	 *
	 * @return void
	 */
	public function register()
	{
		if (!function_exists('acf_register_block') || !function_exists('acf_add_local_field_group')) {
			return;
		}

		$defaults = [
			'name' => $this->unique,
			'title' => $this->title,
			'category' => 'indigotree',
		];

		$block = wp_parse_args($this->block(), $defaults);

		if (!isset($block['render_callback'])) {
			$block['render_callback'] = function ($block, $content = '', $is_preview = false, $post_id = 0) {
				// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->blockOpenCallback($block, $content, $is_preview, $post_id);
				echo $this->callback($block, $content, $is_preview, $post_id);
				echo $this->blockCloseCallback($block, $content, $is_preview, $post_id);
				// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
			};
		}

		acf_register_block($block);

		$settings = $this->normalizeLocalFieldGroup($this->settings());

		acf_add_local_field_group($settings);
	}

	/**
	 * The frontend HTML for the block
	 *
	 * @return void
	 */
	public function callback($block, $content, $is_preview, $post_id)
	{
		echo 'This block has no output';
	}

	/**
	 * Open tag for the block
	 *
	 * @param array $block
	 * @param string $content
	 * @param bool $is_preview
	 * @param int|string $post_id
	 *
	 * @return void
	 */
	protected function blockOpenCallback($block, $content = '', $is_preview = false, $post_id = 0)
	{
		$classes = ["{$this->namespace}-{$this->unique}"];

		if (!empty($block['align'])) {
			$classes[] = sprintf('align%s', $block['align']);
		}

		if (!empty($block['align_text'])) {
			$classes[] = sprintf('has-text-align-%s', $block['align_text']);
		}

		if (!empty($block['className'])) {
			$classes[] = $block['className'];
		}

		$classes = implode(' ', array_filter($classes));

?><div class="<?= esc_attr($classes); ?>"><?php
																								}

																								/**
																								 * Close tag for the block
																								 *
																								 * @param array $block
																								 * @param string $content
																								 * @param bool $is_preview
																								 * @param int|string $post_id
																								 *
																								 * @return void
																								 */
																								protected function blockCloseCallback($block, $content = '', $is_preview = false, $post_id = 0)
																								{
																									?></div><?php
																								}
																							}

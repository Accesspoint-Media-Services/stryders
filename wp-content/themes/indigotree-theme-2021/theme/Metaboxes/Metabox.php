<?php

namespace Origin\Theme\Metaboxes;

use Origin\Theme\Traits\UsesACF;

abstract class Metabox
{
	use UsesACF;

	/**
	 * Create a new Metabox
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('acf/init', [$this, 'register']);
	}

	/**
	 * Register a new ACF field group with WordPress
	 *
	 * @return void
	 */
	public function register()
	{
		if (!function_exists('acf_add_local_field_group')) {
			return;
		}

		$settings = $this->normalizeLocalFieldGroup($this->settings());

		acf_add_local_field_group($settings);
	}
}

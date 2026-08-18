<?php

namespace Origin\Theme\Layouts;

abstract class Layout
{
	/**
	 * Unique key for ACF
	 *
	 * @var string
	 */
	public $key = '';

	/**
	 * Programmer friendly name
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Human readable name
	 *
	 * @var string
	 */
	public $label = '';

	/**
	 * Settings to register a new flexible block
	 *
	 * @return array
	 */
	public function settings(): array
	{
		return [
			'key' => $this->key,
			'name' => $this->name,
			'label' => $this->label,
			'display' => 'block',
			'sub_fields' => $this->fields()
		];
	}
}

<?php

namespace Origin\Theme\Traits;

trait UsesACF
{

	/**
	 * Seed to generate UUID v5 ACF keys
	 *
	 * @var string
	 */
	protected $seed = '973513a3-0a0a-413f-9c75-3a2836a12df6';

	/**
	 * Relative path to the themes ACF config for fields/groups
	 *
	 * @var string
	 */
	protected $config = 'acf.config.json';

	/**
	 * Ensure an ACF local field group contains the correct attributes
	 *
	 * @param array $group
	 *
	 * @return array
	 */
	protected function normalizeLocalFieldGroup(array $group = []): array
	{
		$class = (new \ReflectionClass($this))->getShortName();

		$defaults = [
			'fields' => [],
			'location' => [],
		];

		$group = wp_parse_args($group, $defaults);

		if (isset($group['fields']) && is_array($group['fields'])) {
			$group['fields'] = $this->normalizeFields($group['fields']);
		}

		return $group;
	}

	/**
	 * Ensure all field arrays contains correct attributes
	 *
	 * @param array $fields
	 * @param null|string $parent
	 *
	 * @return array
	 */
	protected function normalizeFields(array $fields = [], ?string $parent = null): array
	{
		return array_map(fn ($field) => $this->normalizeField($field, $parent), $fields);
	}

	/**
	 * Ensure a field array contains correct attributes
	 *
	 * @param array $field
	 * @param null|string $parent
	 *
	 * @return array
	 */
	protected function normalizeField(array $field = [], ?string $parent = null): array
	{
		$chain = implode('.', array_filter([$parent, $field['name']]));

		$defaults = [
			'key' => $this->createUniqueKey($chain),
			'label' => $this->createLabelFromName($field['name']),
			'type' => 'text',
		];

		$attributes = wp_parse_args($field, $defaults);

		if (isset($attributes['sub_fields']) && is_array($attributes['sub_fields'])) {
			$attributes['sub_fields'] = $this->normalizeFields($attributes['sub_fields'], $chain);
		}

		return $attributes;
	}

	/**
	 * Generate a label from an ACF 'name' attribute
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected function createLabelFromName(string $name)
	{
		$name = str_replace(['_', '-'], ' ', $name);

		return ucwords($name);
	}

	/**
	 * Create a unique UUID v5 based key for ACF
	 *
	 * @param string $chain
	 * @param string $namespace
	 *
	 * @return string
	 */
	protected function createUniqueKey(string $chain): string
	{
		$namespace = !empty($this->unique) ? get_called_class() . ':' . $this->unique : get_called_class();

		return $this->uuidv5($chain, $this->uuidv5($namespace, $this->seed));
	}

	/**
	 * Generate a UUID v5
	 * Implementation taken from here: https://gist.github.com/dahnielson/508447#file-uuid-php
	 *
	 * @param string $string
	 * @param string $namespace
	 *
	 * @return string
	 */
	protected function uuidv5(string $string, string $namespace): string
	{
		if (preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $namespace) !== 1) {
			return false;
		}

		$nhex = str_replace(['-', '{', '}'], '', $namespace);
		$nstr = '';

		for ($i = 0; $i < strlen($nhex); $i += 2) {
			$nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
		}

		$hash = sha1($nstr . $string);

		return sprintf(
			'%08s-%04s-%04x-%04x-%12s',
			substr($hash, 0, 8),
			substr($hash, 8, 4),
			(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
			(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
			substr($hash, 20, 12)
		);
	}

	/**
	 * Convert fields from JSON to an array
	 *
	 * @param string $string
	 *
	 * @return array
	 */
	protected function fromJson(string $string)
	{
		if (!$this->isJson($string)) {
			if ('.json' === mb_substr($string, -5)) {
				return $this->fromJsonFile($string);
			}
			return $this->fromGlobalJsonFile($string);
		}

		$json = json_decode($string, true);

		if (!isset($json['fields'])) {
			$json = reset($json);
		}

		return $json;
	}

	/**
	 * Read fields from a JSON document
	 *
	 * @param string $path
	 *
	 * @return array|bool
	 */
	protected function fromJsonFile(string $path)
	{
		if (!file_exists($path)) {
			return false;
		}

		// phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$contents = file_get_contents($path);

		if (!$this->isJson($contents)) {
			return false;
		}

		$json = json_decode($contents, true);

		if (!isset($json['fields'])) {
			$json = reset($json);
		}

		return $json;
	}

	/**
	 * Read a group of fields from a JSON document
	 *
	 * @param string $path
	 *
	 * @return array|bool
	 */
	protected function fromGlobalJsonFile(string $string)
	{
		$config = get_theme_file_path($this->config);

		if (!file_exists($config)) {
			return false;
		}

		// phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$contents = file_get_contents($config);

		if (!$this->isJson($contents)) {
			return false;
		}

		$data = json_decode($contents, true);

		$group = array_filter($data, fn ($group) => $group['key'] === $string);

		return reset($group);
	}

	/**
	 * Check if the provided string is JSON
	 *
	 * @param string $string
	 *
	 * @return bool
	 */
	protected function isJson(string $string)
	{
		json_decode($string);

		return (json_last_error() == JSON_ERROR_NONE);
	}
}

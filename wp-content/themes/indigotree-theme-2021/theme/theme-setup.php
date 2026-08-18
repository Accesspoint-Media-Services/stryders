<?php

// Set the content width for oEmbeds.
//
if (!isset($content_width)) {
	$content_width = 870;
}

// Setup theme support etc.
//
add_action('after_setup_theme', function () {

	add_image_size('card-thumb', 722, 430, true);

	add_theme_support('align-wide');
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-logo');
	add_theme_support('custom-spacing');
	add_theme_support('disable-custom-colors');
	add_theme_support('disable-custom-gradients');
	add_theme_support('editor-styles');
	add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'script', 'style']);
	add_theme_support('origin-developer', ['version' => '2.6']);
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('title-tag');
	add_theme_support('yoast-seo-breadcrumbs');

	add_filter('should_load_remote_block_patterns', '__return_false');
	add_filter('should_load_separate_core_block_assets', '__return_true');
});

// Register new Theme Options
//
\Origin\Theme\Settings::instance();

// Register the "archive selector"
//
\Origin\Theme\ArchiveSelector::instance();

// Register WordPress navigation menus.
//
add_action('init', function () {

	register_nav_menus([
		'primary' => 'Primary',
		'footer-copyright' => 'Footer (Copyright)'
	]);
});

// Register WordPress sidebars
//
add_action('init', function () {

	register_sidebars(2, [
		'id'            => 'footer',
		'name'          => 'Footer %d',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	]);
});

// Register a default block pattern category
//
add_action('init', function () {
	$label = wp_get_theme()->Name ?? 'Indigo Tree';
	$namespace = \Origin\Theme\Patterns\Pattern::namespace();
	register_block_pattern_category($namespace, [
		'label' => $label
	]);
});

// Automatically register WordPress Meta boxes
//
foreach (glob(ORIGIN_PATH . '/theme/Metaboxes/*.php') as $metabox) {

	$name = substr(basename($metabox), 0, -4);

	if ($name === 'Metabox') {
		continue;
	}

	$class = "Origin\\Theme\\Metaboxes\\{$name}";

	new $class();
}

// Automatically register WordPress Blocks
//
foreach (glob(ORIGIN_PATH . '/theme/Blocks/*.php') as $block) {

	$name = substr(basename($block), 0, -4);

	if ($name === 'Block') {
		continue;
	}

	$class = "Origin\\Theme\\Blocks\\{$name}";

	new $class();
}

// Automatically register WordPress Shortcodes
//
foreach (glob(ORIGIN_PATH . '/theme/Shortcodes/*.php') as $shortcode) {

	$name = substr(basename($shortcode), 0, -4);

	if ($name === 'Shortcode') {
		continue;
	}

	$class = "Origin\\Theme\\Shortcodes\\{$name}";

	$_shortcode = new $class();

	add_shortcode($_shortcode->tag(), [$_shortcode, 'register']);
}

// Automatically register WordPress Block Patterns
//
foreach (glob(ORIGIN_PATH . '/theme/Patterns/*.php') as $pattern) {

	$name = substr(basename($pattern), 0, -4);

	if ($name === 'Pattern') {
		continue;
	}

	$class = "Origin\\Theme\\Patterns\\{$name}";

	new $class();
}

// Automatically register WordPress Widgets
//
add_action('widgets_init', function () {

	foreach (glob(ORIGIN_PATH . '/theme/Widgets/*.php') as $widget) {

		$name = substr(basename($widget), 0, -4);

		if ($name === 'Widget') {
			continue;
		}

		register_widget("Origin\\Theme\\Widgets\\{$name}");
	}
});

// Automatically register Taxonomies
//
foreach (glob(ORIGIN_PATH . '/theme/Taxonomies/*.php') as $types) {

	$name = substr(basename($types), 0, -4);

	if ($name === 'Taxonomy') {
		continue;
	}

	$class = "Origin\\Theme\\Taxonomies\\{$name}";

	(new $class())->init();
}

// Automatically register PostTypes
//
foreach (glob(ORIGIN_PATH . '/theme/PostTypes/*.php') as $types) {

	$name = substr(basename($types), 0, -4);

	if ($name === 'PostType') {
		continue;
	}

	$class = "Origin\\Theme\\PostTypes\\{$name}";

	(new $class())->init();
}

// Enqueue our scripts
//
add_action('wp_enqueue_scripts', function () {

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	$main = \IndigoTree\Platform\Core\enqueue_webpack_script('main', null, ['jquery']);

	wp_localize_script($main['handle'], 'origin', [
		'ajaxurl' => admin_url('admin-ajax.php')
	]);
});

// Enqueue scripts for the block editor
//
add_action('enqueue_block_editor_assets', function () {
	\IndigoTree\Platform\Core\enqueue_webpack_script('editor');
	\IndigoTree\Platform\Core\enqueue_webpack_style('editor');
});

// Enqueue our stylesheet(s)
//
add_action('wp_enqueue_scripts', function () {

	\IndigoTree\Platform\Core\enqueue_webpack_style('main');
}, 25);

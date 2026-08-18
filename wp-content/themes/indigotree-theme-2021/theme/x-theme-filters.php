<?php

/**
 * Turn off ACF settings screens for non-admins
 */
add_action('acf/settings/show_admin', function () {
	return current_user_can('manage_options');
});

/**
 * Force Yoast metabox to have lowest priority
 */
add_filter('wpseo_metabox_prio', function () {
	return 'low';
});

/**
 * Hook a "skip to link" into the footer somewhere
 *
 * @return void
 */
add_action('wp_body_open', function () {
?>
	<a href="#main" class="skip-link">Skip to content</a>
<?php
});

// Add Shortcode support for Widget Text/Title inputs
//
add_filter('widget_title', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

add_filter('acf/format_value/type=oembed', function ($value, $post_id, $field) {
	if (0 !== mb_strpos($value, '<iframe')) {
		return $value;
	}
	return '<div class="responsive-embed responsive-embed--16:9">' . trim($value) . '</div>';
}, 15, 3);

// Update archive title on "home" aka "blog" pages
//
add_filter('get_the_archive_title', function ($title) {
	if (is_home() && get_option('page_for_posts')) {
		return get_the_title(get_option('page_for_posts'));
	} elseif (is_search()) {
		return sprintf('Search: %s', get_search_query());
	} elseif (is_post_type_archive() && 0 === mb_strpos($title, 'Archives: ')) {
		return mb_substr($title, 10);
	} elseif (is_category() || is_tag()) {
		return single_cat_title('', false);
	} elseif (is_author()) {
		return '<span class="vcard">' . get_the_author() . '</span>';
	}
	return $title;
});

/**
 * Remove title="" attribute from nav menu if same as text
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
	if ($item->title == $atts['title']) {
		unset($atts['title']);
	}
	return $atts;
}, 10, 4);

// Stop figure having inline style width that break the design!!!
//
add_filter('img_caption_shortcode_width', '__return_false');


// Automatically highlight the post type archive menu item
//
add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {

	if (!is_post_type_archive() && !is_singular()) {
		return $classes;
	}

	$url = untrailingslashit($item->url);
	$o = get_queried_object();

	$archive = is_singular() ? $o->post_type : $o->name;

	if (untrailingslashit(get_post_type_archive_link($archive)) == $url) {
		$classes[] = 'active';
	}

	return $classes;
}, 10, 4);

// Remove /page/1 from pagination to prevent redirect
//
add_filter('paginate_links', function ($link) {
	return preg_replace('#page\/1[^\d]#', '', $link);
});

add_filter('block_categories_all', function ($categories) {
	return array_merge(
		$categories,
		[[
			'slug' => 'indigotree',
			'title' => 'Indigo Tree',
		]]
	);
});

add_filter('image_size_names_choose', function ($sizes) {
	global $_wp_additional_image_sizes;
	if (empty($_wp_additional_image_sizes)) {
		return $sizes;
	}
	foreach ($_wp_additional_image_sizes as $key => $data) {
		if (!isset($sizes[$key]))
			$sizes[$key] =  implode(' ', array_map('ucfirst', explode('-', $key)));
	}
	return $sizes;
});

/**
 * Eager load first image found with page content
 *
 * @param string $content
 * @return string
 */
add_filter('the_content', function ($content) {
	$check = strpos($content, '<img');

	if ($check !== false) {
		preg_match_all('/<img\s[^>]+>/', $content, $matches, PREG_SET_ORDER);
	} else {
		return $content;
	}

	$image = $matches[0] ?? null;

	if (empty($image)) {
		return $image;
	}

	$eager_image = str_replace('loading="lazy"', 'loading="eager"', $image);

	return str_replace($image, $eager_image, $content);
}, 12);

/**
 * Preload first image found within page content
 *
 * @return void
 */
add_action('wp_head', function () {
	if (!is_single() || !is_main_query()) {
		return;
	}

	$blocks = parse_blocks(get_the_content());
	$block = array_shift($blocks);

	if (is_null($block)) {
		return;
	}

	if (!($block['blockName'] === 'core/image' || $block['blockName'] === 'core/cover' || $block['blockName'] === 'core/gallery')) {
		return;
	}

	if ($block['blockName'] === 'core/gallery') {
		$id = $block['attrs']['ids'][0];
		$size = 'medium_large';
	} else {
		$id = $block['attrs']['id'];
		$size = $block['attrs']['sizeSlug'] ?? 'medium_large';
	}

	$srcset = wp_get_attachment_image_srcset($id, $size);
	$sizes = wp_get_attachment_image_sizes($id, $size);
	$image = wp_get_attachment_image_src($id, $size);

	printf(
		'<link rel="preload" as="image" href="%s" imagesrcset="%s" imagesizes="%s">',
		esc_url($image[0]),
		esc_attr($srcset),
		esc_attr($sizes)
	);
}, 0);

// replace excerpt ending [...] with an something else
add_filter('excerpt_more', function ($more) {
	$more = '...';
   return $more;
});

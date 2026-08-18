<?php

/**
 * Archive pagination
 *
 * @param WP_Query|null $query
 */
function origin_archive_pagination($query = null)
{
	global $wp_query;

	if (is_null($query)) {
		$query = $wp_query;
	}

	if ($query->max_num_pages < 2) {
		return;
	}

	$big = 999999999;

	$links = paginate_links([
		'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format'  => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total'   => $query->max_num_pages,
		'type'    => 'array',
	]);

	get_template_part('template-parts/pagination', null, compact('links'));
}

/**
 * Return the default message for the themes copyright
 *
 * @return string
 */
function origin_theme_copyright_default()
{
	return 'Copyright %1$d %2$s.';
}

/**
 * Output the themes "copyright"
 *
 * @return string
 */
function origin_theme_copyright()
{
	$format = get_field('copyright_text', 'option') ?: origin_theme_copyright_default();

	return esc_html('&copy; ' . sprintf($format, current_time('Y'), get_bloginfo('name')));
}

/**
 * Output the themes "credit" line, typically found in the footer
 *
 * @return string
 */
function origin_theme_credit()
{
	$website = apply_filters('origin_theme_author_credit_url','https://indigotree.co.uk/');
	$name = apply_filters('origin_theme_author_credit_name', 'Website by Indigo Tree');
	$clientdomain = get_site_url();
	$clientname= str_replace(array("https://","http://"), array("", ""),$clientdomain);
	$utm = array(
		"utm_campaign" 	=> 	"client+website",
		"utm_source" 	=> 	"{$clientname}+website",
		"utm_medium" 	=> 	"footer+link",
		"utm_content" 	=> 	"{$name}"
	);
	$utm = apply_filters('origin_theme_author_credit_utm', $utm);
	return ' <a href="' .esc_url($website ."?". http_build_query($utm)) . ' " target="_blank" rel="noopener">' . esc_html($name) . '</a>';

}

/**
 * Helper function to add the target attribute to an anchor tag
 *
 * @param array $link
 * @return string
 */
function origin_target_attr($link = [])
{
	if (empty($link)) {
		return '';
	}

	$rel = !empty($link['target']) && $link['target'] === '_blank' ? 'rel="noopenner noreferrer" ' : '';

	return !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '" ' . $rel : '';
}

/**
 * Return the page attached to the given post type archive
 *
 * @param $type mixed
 * @return object|null
 */
function origin_get_archive_page($type = null)
{
	return \Origin\Theme\ArchiveSelector::instance()->getPage($type);
}

/*
 * ACF escaping
 */
function ksTagList() {

    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href'  => array(),
            'rel'   => array(),
            'title' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'br' => array(),
        'blockquote' => array(
            'cite'  => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'sup' => array(),
        'sub' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(
            'style' => array(),
        ),
        'h2' => array(
            'style' => array(),
        ),
        'h3' => array(
            'style' => array(),
        ),
        'h4' => array(
            'style' => array(),
        ),
        'h5' => array(
            'style' => array(),
        ),
        'h6' => array(
            'style' => array(),
        ),
        'i' => array(),
        'img' => array(
            'alt'    => array(),
            'class'  => array(),
            'height' => array(),
            'src'    => array(),
            'width'  => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
            'style' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'mfn' => array(),
    );

    return $allowed_tags;
}

/*
 * return the excerpt with a customisable number of words
 */
function excerpt($limit, $id) {
    if (is_search()) {
        return wp_trim_words(wp_trim_excerpt('', $id), $limit);
    } else {
        return wp_trim_words(get_the_excerpt($id), $limit);
    }
}

/**
 * Removes the default block patterns from the theme.
 *
 * @since 0.8.0
 *
 * @return void
 */
function indigotree_remove_default_patterns()
{

	// Remove core block patterns.
	remove_theme_support('core-block-patterns');
}

add_action('after_setup_theme', 'indigotree_remove_default_patterns');

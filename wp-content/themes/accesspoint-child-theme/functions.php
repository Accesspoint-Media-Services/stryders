<?php

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );
    
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style'],
        wp_get_theme()->get('Version')
    );
});

add_action('wp_ajax_stryders_filter_insights', 'stryders_filter_insights');
add_action('wp_ajax_nopriv_stryders_filter_insights', 'stryders_filter_insights');

function stryders_filter_insights() {
    $search    = isset($_POST['search'])    ? sanitize_text_field($_POST['search'])    : '';
    $expertise = isset($_POST['expertise']) ? sanitize_text_field($_POST['expertise']) : '';
    $type      = isset($_POST['type'])      ? sanitize_text_field($_POST['type'])      : '';
    $sort      = isset($_POST['sort'])      ? sanitize_text_field($_POST['sort'])      : 'DESC';
    $paged     = isset($_POST['paged'])     ? intval($_POST['paged'])                  : 1;

    $args = [
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => get_option('posts_per_page'),
        'paged'               => $paged,
        'ignore_sticky_posts' => 1,
        'order'               => $sort,
        'orderby'             => 'date',
    ];

    if (!empty($search))    $args['s']             = $search;
    if (!empty($type))      $args['category_name'] = $type;
    if (!empty($expertise)) $args['tag']            = $expertise;

    $query = new WP_Query($args);

    ob_start();
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); ?>
        <div class="insight-ap-card">
            <a href="<?php the_permalink(); ?>" class="insight-image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('card-thumb'); ?>
                <?php else : ?>
                    <?php
                    $default = get_field('default_banner', 'options');
                    $banner_id = esc_html($default['ID']);
                    echo wp_get_attachment_image($banner_id, 'full');
                    ?>
                <?php endif; ?>
            </a>
            <a href="<?php the_permalink(); ?>" class="insight-title-link">
                <?php the_title('<h2 class="insight-title">', '</h2>'); ?>
            </a>
            <div class="insights-cat-date">
                <?php $cats = get_the_category();
                if ($cats) : 
                    $cat_slug = $cats[0]->slug; ?>
                    <div class="insight-cat insight-cat--<?php echo esc_attr($cat_slug); ?>">
                        <?php echo esc_html($cats[0]->name); ?>
                    </div>
                <?php endif; ?>
                <time datetime="<?php echo get_the_date('c'); ?>" class="insight-date">
                    <?php echo get_the_date(); ?>
                </time>
            </div>
        </div>
    <?php endwhile;
else : ?>
    <p>Sorry, no items matched your criteria.</p>
<?php endif;
$posts_html = ob_get_clean();

    $total    = $query->found_posts;
    $per_page = get_option('posts_per_page');
    $start    = $total > 0 ? (($paged - 1) * $per_page) + 1 : 0;
    $end      = min($paged * $per_page, $total);
    $count    = $total > 0 ? "Showing {$start}-{$end} of {$total} insights." : "No insights found.";

    wp_reset_postdata();

    wp_send_json_success([
        'posts'      => $posts_html,
        'pagination' => $pagination_html,
        'count'      => $count,
    ]);
}

add_action('init', function() {
    // Deregister the original
    unregister_post_type('your-problems');

    // Re-register with our-services slug
    register_post_type('your-problems', [
        'public' => true,
        'label' => 'Our Services',
        'labels' => [
            'name' => 'Our Services',
            'singular_name' => 'Our Service',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Our Service',
            'edit_item' => 'Edit Our Service',
            'new_item' => 'New Our Service',
            'all_items' => 'All Our Services',
            'view_item' => 'View Our Service',
            'search_items' => 'Search Our Services',
            'not_found' => 'No services found',
            'not_found_in_trash' => 'No services found in trash',
            'menu_name' => 'Our Services',
        ],
        'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail'],
        'show_in_rest' => true,
        'has_archive' => 'our-services', // matches your new page slug
        'rewrite' => [
            'slug' => 'our-services',
            'with_front' => false,
        ],
        'menu_icon' => 'dashicons-welcome-comments',
    ]);
}, 99);

add_action('template_redirect', function() {
    if (strpos($_SERVER['REQUEST_URI'], '/your-problems') !== false) {
        $new_url = str_replace('/your-problems', '/our-services', $_SERVER['REQUEST_URI']);
        wp_redirect($new_url, 301);
        exit;
    }
});

add_action('wp_ajax_stryders_filter_vacancies', 'stryders_filter_vacancies');
add_action('wp_ajax_nopriv_stryders_filter_vacancies', 'stryders_filter_vacancies');

function stryders_filter_vacancies() {
    $search   = sanitize_text_field($_POST['search'] ?? '');
    $location = sanitize_text_field($_POST['location'] ?? '');
    $sort     = $_POST['sort'] === 'ASC' ? 'ASC' : 'DESC';
    $paged    = max(1, intval($_POST['paged'] ?? 1));

    $args = [
        'post_type'      => 'vacancy',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => $sort,
    ];

    if ($search) {
        $args['s'] = $search;
    }

    if ($location) {
    $args['meta_query'] = [
        ['key' => 'location', 'value' => $location, 'compare' => '=']
    ];
}

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $location_val   = get_field('location');
            $employment_val = get_field('employment_type'); ?>
            <div class="vacancy-card">
                <div class="vacancy-items">
                    <a href="<?php the_permalink(); ?>" class="vacancy-title-link">
                        <?php the_title('<h3 class="vacancy-title">', '</h3>'); ?>
                    </a>
                    <div class="vacancy-fields">
                        <div>Location: <?php echo esc_html($location_val); ?></div>
                        <div>Employment: <?php echo esc_html($employment_val); ?></div>
                        <div class="vacancy-excerpt"><?php the_excerpt(); ?></div>
                    </div>
                </div>
                <a href="<?php the_permalink(); ?>" class="view-job">View job spec and apply</a>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else : ?>
        <p>Sorry, no vacancies matched your criteria.</p>
    <?php endif;
    $posts_html = ob_get_clean();

    ob_start();
    origin_archive_pagination();
    $pagination_html = ob_get_clean();

    wp_send_json_success([
        'posts'      => $posts_html,
        'pagination' => $pagination_html,
    ]);
}

add_filter('wpseo_breadcrumb_links', function($crumbs) {
    if (is_singular('vacancy')) {
        $careers_page  = get_page_by_path('careers');
        $vacancies_page = get_page_by_path('vacancies'); // update if slug is different

        $new_crumbs = [
            [
                'text' => 'Careers',
                'url'  => get_permalink($careers_page->ID),
            ],
            [
                'text' => 'Vacancies',
                'url'  => get_permalink($vacancies_page->ID),
            ],
        ];

        // Insert after Home (position 1)
        array_splice($crumbs, 1, 0, $new_crumbs);
    }
    return $crumbs;
});
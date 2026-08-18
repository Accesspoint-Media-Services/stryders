<?php
get_header();
$default = get_field('default_banner', 'options');
$banner_id = esc_html($default['ID']);

// Check for vacancies upfront
$vacancy_args = array(
    'post_type'      => 'vacancy',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu-order',
    'order'          => 'ASC'
);
$vacancy_query = new WP_Query($vacancy_args);
$has_vacancies = $vacancy_query->have_posts();
?>

<div class="banner">
    <div class="banner__content">
        <div class="banner__title">
            <?php the_title('<h1>', '</h1>'); ?>
        </div>
    </div>
    <?php if ($banner_id) : ?>
        <?php echo wp_get_attachment_image($banner_id, 'full'); ?>
    <?php endif; ?>
</div>

<div class="beige-backgrounds">
    <div class="container">
        <?php
        $post = get_post(29);
        $content = apply_filters('the_content', $post->post_content);
        echo $content;
        ?>
    </div>
</div>

<?php if ($has_vacancies) : ?>

    <div class="beige-background-insights">
        <div class="container">
            <h3 class="underline center-text outfit-font primary-color">Vacancies</h3>

            <div class="center-text vacancy-text">
                Every role makes an impact. Please see our current vacancies below.
            </div>

            <div class="insights-filters">
                <div class="insights-filters__search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="insights-search" placeholder="Search vacancies">
                </div>

                <select id="vacancy-location" class="insights-filters__select">
                    <option value="" disabled selected>Location</option>
                    <option value="">Show all</option>
                    <?php 
                    $locations = [];
                    $all_vacancies = get_posts(['post_type' => 'vacancy', 'posts_per_page' => -1]);
                    
                    $location_field = get_field_object('location', $all_vacancies[0]->ID);
                    $location_choices = $location_field['choices'] ?? [];

                    foreach ($all_vacancies as $v) {
                        $loc = get_post_meta($v->ID, 'location', true);
                        if ($loc && !in_array($loc, $locations)) $locations[] = $loc;
                    }

                    foreach ($locations as $loc) : ?>
                        <option value="<?php echo esc_attr($loc); ?>">
                            <?php echo esc_html($location_choices[$loc] ?? $loc); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select id="insights-sort" class="insights-filters__select insights-sort">
                    <option value="DESC">Sort by date</option>
                    <option value="ASC">Oldest first</option>
                </select>
            </div>
            </div>
</div>

        <?php else : ?>

            <h2 class="vacancy-sorry center-text">Sorry, there are currently no vacancies.</h2>

        <?php endif; ?>


<?php if ($has_vacancies) : ?>

<div class="container">
    <div id="insights-spinner" class="insights-spinner" style="display:none;">
        <div class="insights-spinner__inner"></div>
    </div>

    <div id="insights-grid" class="insights-grid">
        <?php
        while ($vacancy_query->have_posts()) : $vacancy_query->the_post(); ?>
            <div class="vacancy-card">
                <div class="vacancy-items">
                    <a href="<?php the_permalink(); ?>" class="vacancy-title-link">
                        <?php the_title('<h3 class="vacancy-title">', '</h3>'); ?>
                    </a>
                    <div class="vacancy-fields">
                        <?php 
                            $location = get_field('location'); 
                            $employment_type = get_field('employment_type'); 
                        ?>
                        <div>Location: <?php echo esc_html($location); ?></div>
                        <div>Employment: <?php echo esc_html($employment_type); ?></div>
                        <div class="vacancy-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
                <a href="<?php the_permalink(); ?>" class="view-job">
                    View job spec and apply
                </a>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>

    <div id="insights-pagination" class="insights-pagination">
        <?php origin_archive_pagination(); ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput    = document.getElementById('insights-search');
    const locationSelect = document.getElementById('vacancy-location');
    const sortSelect     = document.getElementById('insights-sort');
    const grid           = document.getElementById('insights-grid');
    const pagination     = document.getElementById('insights-pagination');
    const spinner        = document.getElementById('insights-spinner');

    let searchTimeout;
    let currentPage = 1;

    const fetchPosts = () => {
        spinner.style.display = 'flex';
        grid.style.opacity = '0.5';

        const formData = new FormData();
        formData.append('action', 'stryders_filter_vacancies');
        formData.append('search', searchInput.value.trim());
        formData.append('location', locationSelect.value);
        formData.append('sort', sortSelect.value);
        formData.append('paged', currentPage);

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                grid.innerHTML = data.data.posts;
                pagination.innerHTML = data.data.pagination;
            }
        })
        .finally(() => {
            spinner.style.display = 'none';
            grid.style.opacity = '1';
        });
    };

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => { currentPage = 1; fetchPosts(); }, 300);
    });

    locationSelect.addEventListener('change', () => { currentPage = 1; fetchPosts(); });
    sortSelect.addEventListener('change', () => { currentPage = 1; fetchPosts(); });

    pagination.addEventListener('click', (e) => {
        if (e.target.closest('a.page-numbers')) {
            e.preventDefault();
            const link = e.target.closest('a.page-numbers');
            if (link.classList.contains('prev')) {
                currentPage = Math.max(1, currentPage - 1);
            } else if (link.classList.contains('next')) {
                currentPage++;
            } else {
                currentPage = parseInt(link.textContent) || 1;
            }
            fetchPosts();
            grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

<?php endif; ?>

<?php get_footer(); ?>
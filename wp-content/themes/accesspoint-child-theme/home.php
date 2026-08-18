<?php
get_header();
$default = get_field('default_banner', 'options');
$banner_id = esc_html($default['ID']);
?>

<div class="banner">
    <div class="banner__content">
        <div class="banner__title">
            <?php the_archive_title('<h1>', '</h1>'); ?>
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

<div class="beige-background-insights">
    <div class="container">
        <h3 class="underline center-text outfit-font primary-color">Latest Insights</h3>

        <div class="insights-filters">
            <div class="insights-filters__search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="insights-search" placeholder="Search insight">
            </div>

            <select id="insights-expertise" class="insights-filters__select">
                <option value="" disabled selected>Expertise</option>
                <option value="">Show all</option>
                <?php foreach (get_tags(['hide_empty' => true]) as $tag) : ?>
                    <option value="<?php echo esc_attr($tag->slug); ?>"><?php echo esc_html($tag->name); ?></option>
                <?php endforeach; ?>
            </select>

            <select id="insights-type" class="insights-filters__select">
                <option value="" disabled selected>Insight Type</option>
                <option value="">Show all</option>
                <?php foreach (get_categories(['hide_empty' => true]) as $cat) : ?>
                    <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>

            <select id="insights-sort" class="insights-filters__select insights-sort">
                <option value="DESC">Sort by date</option>
                <option value="ASC">Oldest first</option>
            </select>
        </div>
    </div>
</div>

<div class="container">
    <div id="insights-spinner" class="insights-spinner" style="display:none;">
        <div class="insights-spinner__inner"></div>
    </div>

    <div id="insights-grid" class="insights-grid">
        <?php
        $the_query = new WP_Query(['ignore_sticky_posts' => 1]);
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="insight-ap-card">
                    <a href="<?php the_permalink(); ?>" class="insight-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('card-thumb'); ?>
                        <?php else : ?>
                            <?php echo wp_get_attachment_image($banner_id, 'full'); ?>
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
            wp_reset_postdata();
        else : ?>
            <p>Sorry, no items matched your criteria.</p>
        <?php endif; ?>
    </div>

    <div id="insights-pagination" class="insights-pagination">
        <?php origin_archive_pagination(); ?>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput     = document.getElementById('insights-search');
    const expertiseSelect = document.getElementById('insights-expertise');
    const typeSelect      = document.getElementById('insights-type');
    const sortSelect      = document.getElementById('insights-sort');
    const grid            = document.getElementById('insights-grid');
    const pagination      = document.getElementById('insights-pagination');
    const spinner         = document.getElementById('insights-spinner');

    let searchTimeout;
    let currentPage = 1;

    const fetchPosts = () => {
        spinner.style.display = 'flex';
        grid.style.opacity = '0.5';

        const formData = new FormData();
        formData.append('action', 'stryders_filter_insights');
        formData.append('search', searchInput.value.trim());
        formData.append('expertise', expertiseSelect.value);
        formData.append('type', typeSelect.value);
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

    expertiseSelect.addEventListener('change', () => { currentPage = 1; fetchPosts(); });
    typeSelect.addEventListener('change', () => { currentPage = 1; fetchPosts(); });
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

<?php get_footer(); ?>
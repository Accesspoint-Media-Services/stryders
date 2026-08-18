<?php

get_header();

$default = get_field('default_banner', 'options');
$banner_id = esc_html($default['ID']);

$types = get_terms(array(
    'taxonomy' => 'case-type',
));

?>

<div class="banner">
	<div class="banner__content">
		<div class="banner__title">
			<?php the_archive_title('<h1>', '</h1>'); ?>
		</div>
	</div>
	<?php
	if ($banner_id) :
		echo wp_get_attachment_image($banner_id, 'full');
	endif;
	?>
</div>

<div class="beige-background">
	<div class="container">
		<?php $page = origin_get_archive_page('notable-cases');
			$post = get_post($page->ID);
			$content = apply_filters('the_content', $post->post_content);
			echo $content;
		?>

		<div class="filter-tabs notable-cases">
			<ul>
				<li data-category="all" class="active">All Cases</li>
				<?php
				foreach ($types as $filter_type) :
				?>
					<li data-category="<?= esc_attr($filter_type->slug) ?>"><?= esc_html($filter_type->name) ?></li>
				<?php
				endforeach;
				?>

			</ul>
		</div>

		<h2 class="category underline">All Cases</h2>
	</div>
</div>

<div class="container">
	<?php

	if (have_posts()) : ?>

		<div class="row cards m--b-sm">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('template-parts/case-card'); ?>
			<?php endwhile; ?>
		</div>

		<?php origin_archive_pagination(); ?>

	<?php else : ?>

		<p>Sorry, no items matched your criteria.</p>

	<?php endif; ?>

</div>

<?php get_footer();

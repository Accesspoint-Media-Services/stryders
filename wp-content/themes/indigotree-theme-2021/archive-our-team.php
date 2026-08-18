<?php

get_header(); 

$titles = get_terms(array(
    'taxonomy' => 'team-title',
));

?>

<div class="banner">
	<div class="banner__content">
		<div class="banner__title">
			<?php the_archive_title('<h1>', '</h1>'); ?>
		</div>
	</div>
	<img src="<?= esc_url(get_theme_file_uri('/images/background-our-team.png')); ?>" alt="<?php the_title(); ?>">
</div>

<div class="beige-background">
	<div class="container">
		<h2 class="underline">Your trusted team of skilled legal professionals</h2>

		<div class=filter-tabs>
			<ul>
				<li class="active" data-category="all">All</li>
				<?php
				foreach ($titles as $job_title) :
				?>
					<li data-category="<?= esc_attr( $job_title->slug ) ?>"><?= esc_html( $job_title->name ) ?></li>
				<?php
				endforeach;
				?>
			</ul>
		</div>

		<h3 class="category underline">All Staff</h3>
	</div>
</div>

<div class="container white-section">
	<?php

	if (have_posts()) : ?>

		<div class="row cards m--b-sm">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('template-parts/team-card'); ?>
			<?php endwhile; ?>
		</div>

		<?php origin_archive_pagination(); ?>

	<?php else : ?>

		<p>Sorry, no items matched your criteria.</p>

	<?php endif; ?>

</div>

<?php get_footer();

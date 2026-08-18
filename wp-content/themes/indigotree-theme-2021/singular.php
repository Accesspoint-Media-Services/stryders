<?php get_header(); ?>

<?php get_template_part('template-parts/default-banner', null, ['class'=>'post', 'title' => get_the_title()]); ?>

<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class('entry'); ?> id="post-<?php the_ID(); ?>">
		<div class="gutenberg">
			<?php the_content(); ?>
		</div>
	</article>

<?php endwhile; ?>

<?php get_footer();

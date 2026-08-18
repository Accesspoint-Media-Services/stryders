<?php

$page_title = 'Page Not Found';

$page_content = 'Sorry, but the page you were looking for doesn\'t exist anymore or it may have been moved.';

get_header(); ?>

<?php get_template_part('template-parts/default-banner', null, ['class'=>'post', 'title' => apply_filters('the_title', get_field('page_404_title', 'option') ?: $page_title, null)]); ?>

<div class="beige-background">
	<div class="container">
<?php

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo apply_filters('the_content', get_field('page_404_content', 'option') ?: $page_content);

	?>
	</div>
</div>

<?php get_footer();

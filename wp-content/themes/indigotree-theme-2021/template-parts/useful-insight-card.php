<?php
$post_categories = wp_get_post_categories( get_the_ID() );
$catlist = '';
foreach($post_categories as $c) :
	$postcat = get_category( $c );
	$catlist .= $postcat->name . ' ';
endforeach;
?>
<div class="column column--sm-12 column--md-4">
	<a href="<?php the_permalink(); ?>" class="card useful-insight-card">
		<div class="card__media">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('large'); ?>
			<?php else :
				$default = get_field('default_banner', 'options');
				$banner_id = esc_html($default['ID']);

				echo wp_get_attachment_image($banner_id, 'full');
			endif; ?>
		</div>

		<div class="card__content">
			<p class="card__title underline underline-left"><?php the_title(); ?></p>

			<p class="card__meta"><?php
				echo get_the_author();
				echo ', ';
				echo esc_html($catlist);
			?></p>
		</div>
	</a>
</div>
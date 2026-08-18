<div class="column column--sm-12 column--md-6">
	<a href="<?php the_permalink(); ?>" class="card insight-card">
		<div class="card__media">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('card-thumb'); ?>
			<?php else :
				$default = get_field('default_banner', 'options');
				$banner_id = esc_html($default['ID']);
				echo wp_get_attachment_image($banner_id, 'full');
			endif; ?>
		</div>
		<div class="card__overlay">
			<div class="card__inner">
				<div class="card__header">
					<?php the_title('<h2 class="card__title">', '</h2>'); ?>
				</div>
			</div>
		</div>
	</a>
</div>

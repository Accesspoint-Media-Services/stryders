<?php

$useful_insights = get_field('useful_insights', 'options');

if ($useful_insights) :
?>
<div class="grey-background useful-insights">
	<div class="container">

		<h3 class="underline center-text outfit-font primary-color">Useful Insights</h3>

		<div class="row cards m--b-sm">
			<?php
			foreach( $useful_insights as $insight_post ):
				$insight_post = $insight_post['useful_insight'];
				setup_postdata( $insight_post );

				$post_categories = wp_get_post_categories($insight_post->ID);
				$catlist = '';
				foreach($post_categories as $c) :
					$postcat = get_category( $c );
					$catlist .= $postcat->name . ' ';
				endforeach;
				?>
				<div class="column column--sm-12 column--md-4">
					<a href="<?php the_permalink(); ?>" class="card useful-insight-card">
						<div class="card__media">
							<?php if (has_post_thumbnail($insight_post->ID)) : ?>
								<?php echo get_the_post_thumbnail($insight_post->ID, 'large'); ?>
							<?php else :
								$default = get_field('default_banner', 'options');
								$banner_id = $default['ID'];

								echo wp_get_attachment_image($banner_id, 'full');
							endif; ?>
						</div>

						<div class="card__content">
							<p class="card__title underline underline-left"><?php echo esc_html($insight_post->post_title); ?></p>

							<p class="card__meta"><?php
								echo get_the_author();
								echo ', ';
								echo esc_html($catlist);
							?></p>
						</div>
					</a>
				</div>
				<?php
			endforeach;
			?>
		</div>

	</div>
</div>
<?php
	wp_reset_postdata();
else :
?>
<div class="spacer"></div>
<?php
endif;
?>
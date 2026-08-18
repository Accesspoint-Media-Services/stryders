<?php
/*
 * Template Name: Home Page
 */

get_header();

$homepage_title = get_field('homepage_title');
$homepage_subtitle = get_field('homepage_subtitle');
$homepage_text = get_field('homepage_text');
$homepage_button_1 = get_field('homepage_button_1');
$homepage_button_2 = get_field('homepage_button_2');
$homepage_image = get_field('homepage_image');
$homepage_logos = get_field('homepage_logos');
$homepage_logos_text1 = get_field('homepage_logos_text1');
$homepage_logos_text2 = get_field('homepage_logos_text2');

$arr = ksTagList();

?>

	<div class="homepage-banner">
		<div class="homepage-banner__left-col"></div>
		<div class="homepage-banner__right-col">
			<img src="<?= esc_url(get_theme_file_uri('/images/blind-justice.png')); ?>" alt="<?= esc_attr(get_bloginfo('name')); ?> Logo">
		</div>
		<div class="homepage-banner__overlay">
			<div class="homepage-banner__overlay--content">
				<div class="homepage-banner__overlay--inner">
					<?php
					if ($homepage_title) :
					?>
					<h1><?= esc_html($homepage_title); ?></h1>
					<?php
					endif;

					if ($homepage_subtitle) :
					?>
					<h2><?= esc_html($homepage_subtitle); ?></h2>
					<?php
					endif;

					if ($homepage_text) :
						echo wp_kses($homepage_text, $arr);
					endif;

					if ($homepage_button_1 || $homepage_button_2) :
					?>
					<div class="button-row">
						<?php
						if ($homepage_button_1) :
						?>
						<a href="<?= esc_url($homepage_button_1['url']); ?>" class="button button--secondary"><?= esc_html($homepage_button_1['title']); ?></a>
						<?php
						endif;

						if ($homepage_button_2) :
						?>
						<a href="<?= esc_url($homepage_button_2['url']); ?>" class="button button--secondary-outline"><?= esc_html($homepage_button_2['title']); ?></a>
						<?php
						endif;
						?>
					</div>
					<?php
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="homepage-banner__logos">
		<div class="wrapper">
			<div class="inner">
				<div class="title">
					<h2><?= esc_html($homepage_logos_text1); ?></h2>
					<h3><?= esc_html($homepage_logos_text2); ?></h3>
				</div>
				<?php
				if ($homepage_logos) :
					?>
					<div class="logo-row">
					<?php
					foreach ($homepage_logos as $logo) :
					?>
						<div class="logo">
							<?php echo wp_get_attachment_image(esc_attr($logo['homepage_banner_logo']['id']), 'full'); ?>
						</div>
					<?php
					endforeach;
					?>
					</div>
					<?php
				endif;
				?>
				<div class="enquiry">
					<a href="/contact-us" class="button button--primary">Make an enquiry</a>
				</div>
			</div>
		</div>
	</div>

<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class('entry'); ?> id="post-<?php the_ID(); ?>">
		<div class="gutenberg">
			<?php the_content(); ?>
		</div>
	</article>

<?php endwhile; ?>

<?php get_footer();

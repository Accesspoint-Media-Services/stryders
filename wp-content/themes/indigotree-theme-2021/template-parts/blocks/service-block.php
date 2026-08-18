<?php

$service_link = get_field('service_link');
$service_icon = get_field('service_icon');

?>
<a class="service-block" href="<?= esc_url($service_link['url']) ?: '#'; ?>">
	<div class="service-block__icon">
		<?= file_get_contents(get_theme_file_path('/images/icon-'.$service_icon.'.svg')); // phpcs:ignore ?>
	</div>
	<div class="service-block__text">
		<p><?= esc_html($service_link['title']) ?: 'Service Box'; ?></p>
	</div>
</a>
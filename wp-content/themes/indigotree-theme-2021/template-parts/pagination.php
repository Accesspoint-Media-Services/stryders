<nav class="pagination" role="navigation">
	<ul class="pagination__menu">
		<?php foreach ($args['links'] as $hyperlink) : ?>
			<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<li><?= $hyperlink; ?></li>
		<?php endforeach;  ?>
	</ul>
</nav>

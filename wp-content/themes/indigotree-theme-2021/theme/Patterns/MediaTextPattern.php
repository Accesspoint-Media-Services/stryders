<?php

namespace Origin\Theme\Patterns;

class MediaTextPattern extends Pattern
{
    /**
     * A unique key for this pattern
     *
     * @var string
     */
    protected $unique = 'media-text';
    
    /**
     * A human-readable title for the pattern
     *
     * @var string
     */
    protected $title = 'Media Text';

    /**
     * The HTML of the pattern
     *
     * @return string
     */
    protected function content()
    {
        ob_start();

        $image_id = 116;
        $image = wp_get_attachment_image_src($image_id, 'full');
        $image_url = $image[0] ?? null;

        ?>

        <!-- wp:media-text {"align":"full","mediaId":<?= esc_attr($image_id); ?>,"mediaLink":"#","mediaType":"image"} -->
        <div class="wp-block-media-text alignfull is-stacked-on-mobile left-aligned-image"><figure class="wp-block-media-text__media"><img src="<?= esc_url($image_url); ?>" alt="" class="wp-image-<?= esc_attr($image_id); ?> size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:paragraph {"fontSize":"medium"} -->
        <p class="has-medium-font-size"><strong>Lorem ipsum dolor sit amet</strong></p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph -->
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mattis nunc sed blandit libero volutpat sed cras ornare. Etiam sit amet nisl purus in mollis. Aliquet eget sit amet tellus. Consequat id porta nibh venenatis cras sed. At tellus at urna condimentum mattis pellentesque id. Cursus sit amet dictum sit amet justo donec enim.</p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph -->
        <p>estibulum lorem sed risus ultricies tristique nulla. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus. Leo integer malesuada nunc vel risus commodo viverra maecenas.</p>
        <!-- /wp:paragraph --></div></div>
        <!-- /wp:media-text -->

        <?php

        $contents = ob_get_contents();

        ob_end_clean();
        
        return $contents;
    }
}

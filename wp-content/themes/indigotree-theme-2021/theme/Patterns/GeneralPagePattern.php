<?php

namespace Origin\Theme\Patterns;

class GeneralPagePattern extends Pattern
{
    /**
     * A unique key for this pattern
     *
     * @var string
     */
    protected $unique = 'general-page';

    /**
     * A human-readable title for the pattern
     *
     * @var string
     */
    protected $title = 'General Page';

    /**
     * The HTML of the pattern
     *
     * @return string
     */
    protected function content()
    {
        return '
            <!-- wp:cover {"overlayColor":"tertiary","minHeight":216,"isDark":false,"align":"full","className":"subheading"} -->
            <div class="wp-block-cover alignfull is-light subheading" style="min-height:216px"><span aria-hidden="true" class="wp-block-cover__background has-tertiary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","textColor":"primary","className":"is-style-underline","fontSize":"x-large"} -->
            <h2 class="has-text-align-center is-style-underline has-primary-color has-text-color has-x-large-font-size">Subheading</h2>
            <!-- /wp:heading --></div></div>
            <!-- /wp:cover -->
            <!-- wp:spacer {"height":"50px"} -->
            <div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
            <!-- wp:yoast-seo/breadcrumbs /-->
            <!-- wp:paragraph -->
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porta enim vitae lobortis elementum. Maecenas urna eros, maximus at mollis vel, congue placerat ligula. Integer id bibendum tellus. Vivamus arcu sem, pulvinar vitae felis sit amet, convallis interdum tortor. Donec vestibulum commodo sem eget consectetur. Nullam vulputate dolor quis tincidunt semper. Duis ac augue quis massa molestie facilisis ut vitae risus. Suspendisse posuere sagittis venenatis. Etiam consequat, felis vel lacinia dictum, urna massa rhoncus neque, vitae feugiat tortor leo sed dui. Cras quis nibh ullamcorper, commodo orci sed, bibendum risus. Etiam interdum ipsum et ex convallis venenatis. Nullam elementum sed metus sit amet lacinia. Maecenas sit amet elementum justo. Sed quis varius ex, non sagittis odio. Sed ac felis felis. Donec luctus dui non orci mollis cursus.</p>
            <!-- /wp:paragraph -->
            <!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
        ';
    }
}
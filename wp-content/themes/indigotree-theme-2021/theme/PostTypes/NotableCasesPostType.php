<?php

namespace Origin\Theme\PostTypes;

class NotableCasesPostType extends PostType
{
    /**
     * The unique key
     *
     * @var string
     */
    protected $type = 'notable-cases';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $slug = 'notable-cases';

    /**
     * The readable name
     *
     * @var string
     */
    protected $name = 'Notable Cases';

    /**
     * Register the post type
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostType([
            'menu_icon' => 'dashicons-book',
            'has_archive' => true,
            'show_in_rest' => true,
            'taxonomies'  => array( 'case-type' ),
            'rewrite' => array( 'with_front' => false ),
        ]);
    }
}
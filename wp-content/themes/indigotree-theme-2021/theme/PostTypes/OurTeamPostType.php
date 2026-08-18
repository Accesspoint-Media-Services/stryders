<?php

namespace Origin\Theme\PostTypes;

class OurTeamPostType extends PostType
{
    /**
     * The unique key
     *
     * @var string
     */
    protected $type = 'our-team';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $slug = 'our-team';

    /**
     * The readable name
     *
     * @var string
     */
    protected $name = 'Our Team';

    /**
     * Register the post type
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostType([
            'menu_icon' => 'dashicons-admin-users',
            'has_archive' => true,
            'show_in_rest' => true,
            'taxonomies'  => array( 'team-title' ),
            'rewrite' => array( 'with_front' => false ),
        ]);
    }
}
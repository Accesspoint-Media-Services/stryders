<?php

namespace Origin\Theme\PostTypes;

class YourProblemsPostType extends PostType
{
    /**
     * The unique key
     *
     * @var string
     */
    protected $type = 'your-problems';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $slug = 'your-problems';

    /**
     * The readable name
     *
     * @var string
     */
    protected $name = 'Problems';

    /**
     * Register the post type
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostType([
            'menu_icon' => 'dashicons-welcome-comments',
            'has_archive' => true,
        ]);
    }
}
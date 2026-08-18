<?php

namespace Origin\Theme\Taxonomies;

class TeamSpecialismsTaxonomy extends Taxonomy
{
    /**
     * The unique key
     * 
     * @var string
     */
    protected $taxonomy = 'team-specialism';

    /**
     * The slug used in the rewrite url
     * 
     * @var string
     */
    protected $slug = 'team-specialism';

    /**
     * The post type the taxonomy applies to
     * 
     * @var string
     */
    protected $postTypes = ['our-team'];

    /**
     * The readable name
     * 
     * @var string
     */
    protected $name = 'Team Specialism';

    /**
     * Register the post type
     * 
     * @return void
     */
    public function register()
    {
        $this->registerTaxonomy([
            'hierarchical' => true,
            'public' => false,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_in_menu' => true
        ]);
    }
}

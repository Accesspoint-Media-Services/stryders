<?php

namespace Origin\Theme\Taxonomies;

class CaseTypeTaxonomy extends Taxonomy
{
    /**
     * The unique key
     * 
     * @var string
     */
    protected $taxonomy = 'case-type';

    /**
     * The slug used in the rewrite url
     * 
     * @var string
     */
    protected $slug = 'case-type';

    /**
     * The post type the taxonomy applies to
     * 
     * @var string
     */
    protected $postTypes = ['notable-cases'];

    /**
     * The readable name
     * 
     * @var string
     */
    protected $name = 'Case Type';

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

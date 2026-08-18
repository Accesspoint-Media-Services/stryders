<?php

namespace Origin\Theme\Blocks;

class ServicesListBlock extends Block
{
    /**
     * A unique id/key for this Block.
     *
     * @var string
     */
    protected $unique = 'services-list-block';

    /**
     * The "name" or "title" of the Block.
     *
     * @var string
     */
    protected $title = 'Service List Block';

    /**
     * Register settings for this Block
     *
     * @return array
     */
    protected function block() : array
    {
        return [
            'name'     => $this->unique,
            'title'    => $this->title,
            'category' => 'formatting',
            'icon'     => 'screenoptions',
            'keywords' => []
        ];
    }

    /**
     * Render this Block
     *
     * @param array $acf
     * @return string
     */
    public function callback($block, $content = '', $is_preview = false, $post_id = 0)
    {
        get_template_part('template-parts/blocks/services-list-block');
    }

    /**
     * Register settings for this Blocks fields
     *
     * @return array
     */
    protected function settings() : array
    {
        return [
            'key'      => "{$this->unique}-group",
            'title'    => $this->title,
            'fields'   => [
                [
                    'key' => 'field_first_col_title',
                    'label' => 'First Column Title',
                    'name' => 'first_col_title',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_first_col_items',
                    'label' => 'First Column List',
                    'name' => 'first_col_items',
                    'type' => 'repeater',
                    'sub_fields' => [
                        [
                            'name' => 'first_col_item',
                            'label' => 'Item',
                            'type' => 'link',
                        ]
                    ]
                ],
                [
                    'key' => 'field_servicesblock_image',
                    'label' => 'Image',
                    'name' => 'servicesblock_image',
                    'type' => 'image',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => "acf/{$this->unique}"
                    ]
                ]
            ]
        ];
    }
}
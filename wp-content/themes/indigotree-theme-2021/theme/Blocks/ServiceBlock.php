<?php

namespace Origin\Theme\Blocks;

class ServiceBlock extends Block
{
    /**
     * A unique id/key for this Block.
     *
     * @var string
     */
    protected $unique = 'service-block';

    /**
     * The "name" or "title" of the Block.
     *
     * @var string
     */
    protected $title = 'Service Box';

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
        get_template_part('template-parts/blocks/service-block');
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
                    'key' => 'field_service_text',
                    'label' => 'Service Link',
                    'name' => 'service_link',
                    'type' => 'link',
                ],
                [
                    'key' => 'field_service_icon',
                    'label' => 'Service Icon',
                    'name' => 'service_icon',
                    'type' => 'select',
                    'choices' => [
                        'handcuffs' => 'Handcuffs',
                        'pillar' => 'Pillar',
                        'mail' => 'Mail',
                        'jury' => 'Jury',
                    ],
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
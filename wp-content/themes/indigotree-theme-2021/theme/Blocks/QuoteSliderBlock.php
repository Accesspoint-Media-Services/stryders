<?php

namespace Origin\Theme\Blocks;

class QuoteSliderBlock extends Block
{
    /**
     * A unique id/key for this Block.
     *
     * @var string
     */
    protected $unique = 'quote-slider-block';

    /**
     * The "name" or "title" of the Block.
     *
     * @var string
     */
    protected $title = 'Quote Slider';

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
        get_template_part('template-parts/blocks/quote-slider-block');
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
                    'key' => 'field_quote_slider',
                    'label' => 'Quote',
                    'name' => 'quote',
                    'type' => 'repeater',
                    'sub_fields' => [
                        [
                            'key' => 'field_slider_text',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'textarea',
                        ],
                        [
                            'key' => 'field_slider_citation',
                            'label' => 'Citation',
                            'name' => 'citation',
                            'type' => 'text',
                        ],
                    ]
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
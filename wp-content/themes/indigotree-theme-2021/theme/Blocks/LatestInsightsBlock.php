<?php

namespace Origin\Theme\Blocks;

class LatestInsightsBlock extends Block
{
    /**
     * A unique id/key for this Block.
     *
     * @var string
     */
    protected $unique = 'latest-insights-block';

    /**
     * The "name" or "title" of the Block.
     *
     * @var string
     */
    protected $title = 'Latest Insights';

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
        get_template_part('template-parts/blocks/latest-insights-block');
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
                    'key' => 'field_insights_title',
                    'label' => 'Title',
                    'name' => 'insights_title',
                    'type' => 'text',
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
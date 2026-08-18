<?php

namespace Origin\Theme\Metaboxes;

class HomepageBannerMetaBox extends Metabox
{

    /**
     * A unique id/key for this Metabox.
     *
     * @var string
     */
    protected $unique = 'homepage-banner-metabox';

    /**
     * The "name" or "title" of the Metabox.
     *
     * @var string
     */
    protected $title = 'Homepage Banner Elements';

    /**
     * Register settings for this Metabox
     *
     * @return array
     */
    protected function settings() : array
    {
        return [
            'key' => $this->unique,
            'title' => $this->title,
            'fields' => [
                [
                    'key' => 'field_homepage_title',
                    'label' => 'Banner Title',
                    'name' => 'homepage_title',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_homepage_subtitle',
                    'label' => 'Banner Subtitle',
                    'name' => 'homepage_subtitle',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_homepage_text',
                    'label' => 'Banner Text',
                    'name' => 'homepage_text',
                    'type' => 'wysiwyg',
                ],
                [
                    'key' => 'field_homepage_button_1',
                    'label' => 'Banner Button 1',
                    'name' => 'homepage_button_1',
                    'type' => 'link',
                ],
                [
                    'key' => 'field_homepage_button_2',
                    'label' => 'Banner Button 2',
                    'name' => 'homepage_button_2',
                    'type' => 'link',
                ],
                [
                    'key' => 'field_homepage_image',
                    'label' => 'Banner Image',
                    'name' => 'homepage_image',
                    'type' => 'image',
                ],
				[
                    'key' => 'field_homepage_logos_text1',
                    'label' => 'Text before logos, line 1.',
                    'name' => 'homepage_logos_text1',
                    'type' => 'text',
                ],
				[
                    'key' => 'field_homepage_logos_text2',
                    'label' => 'Text before logos, line 2.',
                    'name' => 'homepage_logos_text2',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_homepage_logos',
                    'label' => 'Banner Logos',
                    'name' => 'homepage_logos',
                    'type' => 'repeater',
                    'sub_fields' => [
                        [
                            'name' => 'homepage_banner_logo',
                            'label' => 'Logo',
                            'type' => 'image',
                        ]
                    ]
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'template-homepage.php'
                    ]
                ]
            ]
        ];
    }
}

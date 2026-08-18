<?php

namespace Origin\Theme\Metaboxes;

class TeamDetailsMetaBox extends Metabox
{

    /**
     * A unique id/key for this Metabox.
     *
     * @var string
     */
    protected $unique = 'team-details-metabox';

    /**
     * The "name" or "title" of the Metabox.
     *
     * @var string
     */
    protected $title = 'Team Member Details';

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
                    'key' => 'field_team_title',
                    'label' => 'Team Title',
                    'name' => 'field_team_title',
                    'type' => 'select',
                    'choices' => [
                        'Director' => 'Director',
                        'Solicitor' => 'Solicitor',
                        'Consultant' => 'Consultant',
                        'Paralegal' => 'Paralegal',
                        'Practice Manager' => 'Practice Manager',
                        'Court Administrator' => 'Court Administrator',
                    ],
                ],
                [
                    'key' => 'field_team_email',
                    'label' => 'Team Email',
                    'name' => 'field_team_email',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_team_mobile',
                    'label' => 'Telephone Number',
                    'name' => 'field_team_mobile',
                    'type' => 'link',
					'instructions' => 'URL must be in the following format: tel:+443335772999. Link Text will be displayed as the telephone number. Both fields are required.',
				],
				[
					'key' => 'field_team_image',
					'label' => 'Team Member Image',
					'name' => 'field_team_image',
					'type' => 'image',
					'return_format' => 'array',
				],
				[
					'key' => 'field_team_bio',
					'label' => 'Team Member Bio',
					'name' => 'field_team_bio',
					'type' => 'textarea',
                ],
                [
                    'key' => 'field_team_accordion',
                    'label' => 'Team Member Facts',
                    'name' => 'team_accordion',
                    'type' => 'repeater',
                    'sub_fields' => [
                        [
                            'name' => 'team_accordion_title',
                            'label' => 'Title',
                            'type' => 'text',
                        ],
                        [
                            'name' => 'team_accordion_text',
                            'label' => 'Content',
                            'type' => 'textarea',
                        ]
                    ]
                ],
                [
                    'key' => 'field_team_quotes',
                    'label' => 'Team Member Quotes',
                    'name' => 'team_quotes',
                    'type' => 'repeater',
                    'sub_fields' => [
                        [
                            'name' => 'quote_text',
                            'label' => 'Quote',
                            'type' => 'textarea',
                        ],
                        [
                            'name' => 'quote_citation',
                            'label' => 'Citation',
                            'type' => 'text',
                        ]
                    ]
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'our-team'
                    ]
                ]
            ]
        ];
    }
}

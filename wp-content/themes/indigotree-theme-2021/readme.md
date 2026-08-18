# Building with the Indigo Tree theme

## Metaboxes

Metaboxes can be created with WP CLI using the command:

```
wp origin metabox {name} --fields="{fields}"
```

You can also create Metaboxes manually by creating a class in the appropriate folder. For example, to create an `Event` Metabox for the `event` Post Type you must create a file within `/theme/Metaboxes` called `EventMetaBox.php` containing the following code:

```php
<?php

namespace Origin\Theme\Metaboxes;

class EventMetaBox extends Metabox
{

    /**
     * A unique id/key for this Metabox.
     *
     * @var string
     */
    protected $unique = 'event-metabox';

    /**
     * The "name" or "title" of the Metabox.
     *
     * @var string
     */
    protected $title = 'Event';

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
                    'key' => 'field_590062b9bcfb8',
                    'label' => 'Starts At',
                    'name' => 'event_starts_at',
                    'type' => 'date_time_picker',
                    'display_format' => 'd/m/Y g:i a',
                    'return_format' => 'Y-m-d H:i:s',
                ],
                [
                    'key' => 'field_590062f1bcfb9',
                    'label' => 'Ends At',
                    'name' => 'events_ends_at',
                    'type' => 'date_time_picker',
                    'display_format' => 'd/m/Y g:i a',
                    'return_format' => 'Y-m-d H:i:s',
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'event'
                    ]
                ]
            ]
        ];
    }
}
```

## Shortcodes

Shortcodes can be created with WP CLI using the command:

```
wp origin shortcode {name} --fields="{fields}"
```

You can also create Shortcodes manually by creating a class in the appropriate folder. For example, to create a `LeadShortcode` Shortcode with the tag `[lead]` you must create a file within `/theme/Shortcodes` called `LeadShortcode.php` containing the following code:

```php
<?php

namespace Origin\Theme\Shortcodes;

class LeadShortcode extends Shortcode
{
    /**
     * The unique shortcode tag used with add_shortcode();.
     *
     * @var string
     */
    protected $tag = 'lead';

    /**
     * Register field/attributes for this Shortcode.
     *
     * @return array
     */
    public function fields() : array
    {
        return [
            'xclass' => '',
        ];
    }

    /**
     * Create the class="" attribute.
     *
     * @param array $atts
     *
     * @return string
     */
    protected function attrClass(array $atts = []) : string
    {
        $classes = ['lead'];

        if (!empty($atts['xclass'])) {
            $classes[] = $atts['xclass'];
        }

        return sprintf(' class="%s"', esc_attr(implode(' ', $classes)));
    }

    /**
     * Shortcode callback. Renders the output for a Shortcode.
     *
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function callback(array $atts = [], string $content = '') : string
    {
        $classes = $this->attrClass($atts);

        return '<p'.$classes.'>'.do_shortcode($content).'</p>';
    }
}
```

### Widgets

Widgets can be created with WP CLI using the command:

```
wp origin widget {name} --fields="{fields}"
```

You can also create Widgets manually by creating a class in the appropriate folder. For example, to create a `ImageWidget` Widget you must create a file within `/theme/Widgets` containing the following code:

```php
<?php

namespace Origin\Theme\Widgets;

class ImageWidget extends Widget
{
    /**
     * A unique id/key for this Widget.
     *
     * @var string
     */
    protected $unique = 'image-widget';

    /**
     * The "name" or "title" of the widget.
     *
     * @var string
     */
    protected $title = '+ Image';

    /**
     * CSS class(es) added to the Widget
     *
     * @var string
     */
    protected $css_class = 'image-widget';

    /**
     * Register fields for this Widget.
     *
     * @return array
     */
    protected function settings() : array
    {
        return [
            'key'      => $this->unique,
            'title'    => $this->title,
            'fields'   => [
                [
                    'key'   => 'title',
                    'name'  => 'title',
                    'type'  => 'text',
                    'label' => 'Title'
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'widget',
                        'operator' => '==',
                        'value'    => $this->unique
                    ]
                ]
            ]
        ];
    }

    /**
     * Widget callback. Render the Widget content.
     *
     * @param $args
     * @param $instance
     * @return void
     */
    protected function callback(array $args, array $instance) : void
    {
        $title = apply_filters('widget_title', $instance['acf']['title'], $instance, $this->id_base);

        echo $args['before_widget'];

        echo $title ? $args['before_title'] . $title . $args['after_title'] : '';

        // ..

        echo $args['after_widget'];
    }
}
```

### Blocks

Blocks can be created with WP CLI using the command:

```
wp origin block {name} --fields="{fields}"
```

You can also create Blocks manually by creating a class in the appropriate folder. For example, to create a `ImageBlock` Block you must create a file within `/theme/Blocks` containing the following code:

```php
<?php

namespace Origin\Theme\Blocks;

class ImageBlock extends Block
{
    /**
     * A unique id/key for this Block.
     *
     * @var string
     */
    protected $unique = 'image-block';

    /**
     * The "name" or "title" of the Block.
     *
     * @var string
     */
    protected $title = 'Image';

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
    public function callback(array $acf) : string
    {
        return print_r($acf, true);
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
```

### Patterns

Block Patterns can be created with WP CLI using the command:

```
wp origin pattern {name}
```

These are automatically grouped into a theme specific pattern category using the same name as your theme (as defined in style.css).

You can also create Patterns manually by creating a class in the appropriate folder. For example, to create a `ColumnsPattern` Pattern you must create a file within `/theme/Patterns` containing the following code:

```php
<?php

namespace Origin\Theme\Patterns;

class ColumnsPattern extends Pattern
{
    /**
     * A unique key for this pattern
     *
     * @var string
     */
    protected $unique = 'columns';

    /**
     * A human-readable title for the pattern
     *
     * @var string
     */
    protected $title = 'Columns';

    /**
     * The HTML of the pattern
     *
     * @return string
     */
    protected function content()
    {
        return '
            <!-- wp:columns -->
            <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"></div>
            <!-- /wp:column -->
            <!-- wp:column -->
            <div class="wp-block-column"></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->
        ';
    }
}
```

If you need to add additional categories, this can be done within `/theme/theme-setup.php`

### Post Types

Post Types can be created with WP CLI using the command:

```
wp origin posttype {name}
```

You can also create Post Types manually by creating a class in the appropriate folder. For example, to create an `Event` Post Type you must create a file within `/theme/PostTypes` called `Event.php` containing the following code:

```php
<?php

namespace Origin\Theme\PostTypes;

class Event extends PostType
{
    /**
     * The unique key
     *
     * @var string
     */
    protected $type = 'event';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $slug = 'events';

    /**
     * The readable name
     *
     * @var string
     */
    protected $name = 'Event';

    /**
     * Register the post type
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostType([
            'menu_icon' => 'dashicons-calendar',
            'has_archive' => true,
        ]);
    }
}
```

### Taxonomies

Taxonomies can be created with WP CLI using the command:

```
wp origin taxonomy {name}
```

You can also create Taxonomies manually by creating a class in the appropriate folder. For example, to create a `Type` Taxonomy for an `Event` PostType you must create a file within `/theme/Taxonomies` called `Type.php` containing the following code:

```php
<?php

namespace Origin\Theme\Taxonomies;

class Type extends Taxonomy
{
    /**
     * The unique key
     *
     * @var string
     */
    protected $taxonomy = 'type';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $slug = 'type';

    /**
     * The slug used in the rewrite url
     *
     * @var string
     */
    protected $postTypes = ['event'];

    /**
     * The readable name
     *
     * @var string
     */
    protected $name = 'Event Type';

    /**
     * Register the post type
     *
     * @return void
     */
    public function register()
    {
        $this->registerTaxonomy([
            'hierarchical' => true,
        ]);
    }
}
```

---

## Theme Options

Theme options are stored within `/theme/Settings.php` and must be registered within the `settings()` method. An example grouping can be seen below. This will create 2 fields (Phone Number & Email Address) which will exist within it's own "page".

```php
$this->group('contact', 'Contact Information', [
    [
        'key' => 'contact_phone',
        'name' => 'contact_phone',
        'label' => 'Phone Number',
        'type' => 'text',
    ],
    [
        'key' => 'contact_email',
        'name' => 'contact_email',
        'label' => 'E-Mail Address',
        'type' => 'text',
    ]
]);
```

## Archive Selector

WordPress has the concept of "Post Type Archive" pages, which are not real pages, but they're used to act as the archive for a set of posts. Often you need to add custom text to these pages, and there is no "nice" way to do it.

The archive selector will try to handle this for you. Anytime you create a public post type with `has_archive` set to true, Origin will create a setting in the Theme Options that you can use to assign a real page to the archive.

You can get this page from the archive page by calling `origin_get_archive_page()` which will return a `WP_Post` for the attached page. You can then access the content for the archive like any other page.

```php
// archive-event.php
$page = origin_get_archive_page('event');

echo get_the_title($page->ID);
echo get_field('banner_image', $page->ID);
```

## theme-\*.php Files

There are 3 main files where the majority of functions & filters can be found.

### theme-setup.php

The `theme-setup.php` file should be used to register or setup data. Think of it is a bootstrapping file. You can see we use this file to register menus, widgets, post types etc.

### theme-filters.php

Anytime you need to hook into WordPress or a plugin using `add_action` or `add_filter`, it should be done within the `theme-filters.php` file.

### theme-functions.php

Any functions that you'd like to re-use in your code should go here. Not those used for actions/filters.

## Misc Functions

### origin_cache()

The `origin_cache()` function is a wrapper around the Transient API. You can use this to easily cache data from third party API's.

```php
// origin_cache($key, $time, $callback);

$tweets = origin_cache('tweets_indigotreesays', 15, function () {
    return get_tweets_from_twitter('indigotreesays');
});
```

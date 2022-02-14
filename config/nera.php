<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Input directory
    |--------------------------------------------------------------------------
    |
    | This value is the directory where your Markdown files live in the
    | Laravel resources folder.
    |
    */

    'input_path' => 'nera/pages',

    /*
    |--------------------------------------------------------------------------
    | Output directory
    |--------------------------------------------------------------------------
    |
    | This value is the directory where the generated Html files should be
    | stored in the Laravel storage folder.
    |
    */

    'output_path' => 'app/public/nera',

    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    |
    | This value will be used as the default in the meta tag named description
    | to show search engines a short description of your website.
    | However for better SEO you should set this property for every page .
    | separatly.
    |
    */

    'description' => 'Nera is an easy to use and light weight static site generator',


    /*
    |--------------------------------------------------------------------------
    | Keywords
    |--------------------------------------------------------------------------
    |
    | This value will be used as the default in the meta tag named keywords
    | to show search engines the main keywords of your website.
    | However for better SEO you should set this property for every page .
    | separatly.
    |
    */

    'keywords' => 'nera, static site generator, easy, light weight',

    /*
    |--------------------------------------------------------------------------
    | Robots
    |--------------------------------------------------------------------------
    |
    | This value will be used in the meta tag named robots to show search
    | engines how to crawl your website.
    |
    */

    'robots' => 'index,follow',

    /*
    |--------------------------------------------------------------------------
    | Meta tags
    |--------------------------------------------------------------------------
    |
    | Here you can define which meta tags should be used on your pages.
    |
    */

    'meta_tags' => [
        'description',
        'keywords',
        'robots',
    ],

    /*
    |--------------------------------------------------------------------------
    | Addons
    |--------------------------------------------------------------------------
    |
    | This includes all the addons Nera will use.
    |
    */

    'addons' => [],

];

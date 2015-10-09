# Pico GitHub Activity Plugin

## Requirements
- jQuery (included via CDN)
- moment.js (included via CDN)

## Install
- Copy `PicoGitHubActivity.php` to your `plugins` directory
- Copy & Paste the configuration array below in `config/config.php`
- Insert `{{ PicoGitHubActivity.rendered }}` in your template.

## Settings
```php
/**
 * Pico GitHib Activity Plugin Configuration
 */
$config['PicoGitHubActivity'] = array (
    'enabled' => true,           // Enable this plugin?
    'require' => array(          // Do you require:
        'jQuery' => true,        // jQuery?
        'momentJs' => true       // moment.js?
    ),
    'options' => array(
        'username' => 'theshka', // GitHub username
        'posts' => 10,           // How many posts?
        'maxLength' => 100       // Max length of descriptions
    )
);
```

## Twig Variables
This variable inserts the whole plugin in one tag,
```
{{ PicoGitHubActivity.rendered }} // The rendered plugin
```

OR you can place these in the appropriate areas of your template:

```
{{ PicoGitHubActivity.style }}    // Just the CSS
{{ PicoGitHubActivity.body }}     // Just the HTML
{{ PicoGitHubActivity.script }}   // Just the JS
```

## License
The MIT License (MIT)

Copyright (c) 2015 theshka

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

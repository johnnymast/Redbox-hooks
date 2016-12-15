<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Filters;

require 'autoload.php';

/**
 * This is the first registered filter. It's going to prepend
 * '@@' in front of the text.
 */
Filters::addFilter('prepend_at', function ($text = '') {
    return '@@' . $text;
});

/**
 * This is the second registered filter. It's going to append
 * '@@' to the text.
 */
Filters::addFilter('append_at', function ($text = '') {
    return $text . '@@';
});

/**
 * The result should be
 *
 * Result: @@This is a text@@
 *
 */
$out = Filters::applyFilter(['prepend_at', 'append_at'], 'This is a text');
echo "Result: " . $out . "\n";

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Filters::removeAllFilters('prepend_at');
Filters::removeAllFilters('append_at');

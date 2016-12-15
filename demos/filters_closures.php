<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Filters;

require 'autoload.php';

Filters::addFilter('prepend_at', function ($text = '') {
    return '@@' . $text;
});

$out = Filters::applyFilter('prepend_at', 'This is a text');

/**
 * The result should be
 *
 * Result: @@This is a text
 */
echo "Result: " . $out . "\n";

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Filters::removeAllFilters('prepend_at');

<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Filters;

require 'autoload.php';

/**
 * This function will return '@@This is a text';
 *
 * @param string $text
 * @return string
 */
function prependAt($text = '')
{
    return '@@' . $text;
}

/**
 * If you are using your own custom namespace it is highly important
 * to prefix your functions with a the correct namespace.
 */
Filters::addFilter('prepend_at', 'Sandbox\Demos\prependAt');
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
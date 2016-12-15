<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Filters;

require 'autoload.php';

function secondFunction($text = '')
{
    return '@@' . $text;
}
Filters::addFilter('prepend_at', 'Sandbox\Demos\secondFunction', 1);

function firstFunction($text = '')
{
    return '!!' . $text;
}
Filters::addFilter('prepend_at', 'Sandbox\Demos\firstFunction', 0);

$out = Filters::applyFilter('prepend_at', 'This is a text');

/**
 * The result should be:
 *
 * Result: @@!!This is a text
 */
echo "Result: " . $out . "\n";

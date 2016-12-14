<?php
namespace Redbox\Hooks\Tests\Filters\Assets;

use Redbox\Hooks\Filters;

/**
 * @param string $text
 * @return string
 */
function filterPrepend($text = '')
{
    return '@@' . $text;
}

/**
 * @param string $text
 * @return string
 */
function filterAppend($text = '')
{
    return $text . '@@';
}

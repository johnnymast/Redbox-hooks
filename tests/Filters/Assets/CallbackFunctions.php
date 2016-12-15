<?php
namespace Redbox\Hooks\Tests\Filters\Assets;

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

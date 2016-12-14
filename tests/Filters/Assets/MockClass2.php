<?php
namespace Redbox\Hooks\Tests\Filters\Assets;

use Redbox\Hooks\Filters;

class MockClass2
{
    /**
     * @param string $text
     * @return string
     */
    public function prependChars($text = '')
    {
        return '@@' . $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function appendChars($text = '')
    {
        return $text . '@@';
    }
}

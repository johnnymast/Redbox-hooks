<?php
namespace Redbox\Hooks\Tests\Filters\Assets;

use Redbox\Hooks\Filters;

class MockClass1
{

    /**
     * myMockClass1 constructor.
     */
    public function __construct()
    {
        Filters::addFilter('manipulate_string', [$this, 'prependChars']);
        Filters::addFilter('manipulate_string', [$this, 'appendChars']);
    }

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

    /**
     * @return string
     */
    public function execute()
    {
        return Filters::addFilter('manipulate_string', 'This is a text');
    }
}

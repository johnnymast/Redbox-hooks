<?php
namespace Redbox\Hooks\Tests\Filters\Assets;

/**
 * This use statement is actually required.
 * Phpstorm does freak out about it.
 */
use Redbox\Hooks\Annotations\Filter;
use Redbox\Hooks\Filters;

class FilterObject
{

    /**
     * @Filter("prepend_at", priority=1)
     * @param string $text
     * @return string
     */
    public function prependAt($text = '')
    {
        return '@' . $text;
    }

    /**
     * @Filter("prepend_at", priority=0)
     * @param string $text
     * @return string
     */
    public function prependAtSecond($text = '')
    {
        return '!!' . $text;
    }

    /**
     * @Filter("remove_filter_test", priority=0)
     * @param string $text
     * @return string
     */
    public function removeFilterTest($text)
    {
        Filters::removeFilter('prepend_at', [$this, 'prependAtSecond']);
        return $text;
    }
}

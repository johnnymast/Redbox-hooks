<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Filters;
use Redbox\Hooks\Tests\Filters\Assets\FilterObject;

/**
 * @since version 1.0
 * @covers Filters
 */
class FilterObjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that Filter Object Loads the Objects correctly.
     *
     * @covers Filters::registerFilterObject
     */
    public function testRegisterFilterObjectLoadsClasses()
    {
        $testObject = new FilterObject();
        Filters::registerFilterObject($testObject);
        Filters::removeAllFilters('prepend_at');
    }

    /**
     * Test that Sandbox\Filters::applyFilter triggers a filter
     * inside the filter Object.
     *
     * @covers Filters::applyFilter
     */
    public function testApplyFilterWorksOnFilterObject()
    {
        $testObject = new FilterObject();
        Filters::registerFilterObject($testObject);

        $string = 'Hello World';
        $expected = '@!!'.$string;
        $actual = Filters::applyFilter('prepend_at', $string);
        $this->assertEquals($expected, $actual);
        Filters::removeAllFilters('prepend_at');
    }

    /**
     * Test that filters can be removed using Sandbox\Filters::removeFilter
     * from inside a filter Object.
     *
     * @covers Filters::removeFilter
     */
    public function testFiltersCanBeRemovedFromInsideFilterObject()
    {
        $testObject = new FilterObject();
        Filters::registerFilterObject($testObject);

        $string = 'Hello World';
        $expected = '@!!'.$string;
        $actual = Filters::applyFilter('prepend_at', $string);
        $this->assertEquals($expected, $actual);

        /**
         * Trigger removal of one instance of the prepend_at filter.
         */
        Filters::applyFilter('remove_filter_test', $string);

        $string = 'Hello World';
        $expected = '@'.$string;
        $actual = Filters::applyFilter('prepend_at', $string);

        $this->assertEquals($expected, $actual);
        Filters::removeAllFilters('prepend_at');
    }
}

<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Filters;

/**
 * @since version 1.0
 * @covers Filters
 */
class FiltersClosuresTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneClosure()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('prepend_chars', function ($text) {
            return '@@' . $text;
        });
        $output = Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoClosures()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('apply_chars', function ($text) {
            return '@@' . $text;
        });

        Filters::addFilter('apply_chars', function ($text) {
            return $text . "@@";
        });

        $output = Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}

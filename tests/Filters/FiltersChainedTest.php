<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Filters;

/**
 * @since version 1.0
 * @covers Redbox\Hooks\Filters
 */
class FiltersChainedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Redbox\Hooks\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneClassMethod()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('prepend_chars', function ($text) {
            return '@@' . $text;
        });
        $output = Filters::applyFilter(['prepend_chars'], $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Redbox\Hooks\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoClassMethods()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('apply_chars', function ($text) {
            return '@@' . $text;
        });

        Filters::addFilter('prepend_chars', function ($text) {
            return $text . "@@";
        });

        $output = Filters::applyFilter(['apply_chars', 'prepend_chars'], $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}

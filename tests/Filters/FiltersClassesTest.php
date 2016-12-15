<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Tests\Filters\Assets\MockClass2;
use Redbox\Hooks\Filters;

/**
 * @since version 1.0
 * @covers Redbox\Hooks\Filters
 */
class FiltersClassesTest extends \PHPUnit_Framework_TestCase
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
        $instance = new MockClass2;

        Filters::addFilter('prepend_chars', [$instance, 'prependChars']);
        $output = Filters::applyFilter('prepend_chars', $string);

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
        $instance = new MockClass2;

        Filters::addFilter('apply_chars', [$instance, 'prependChars']);
        Filters::addFilter('apply_chars', [$instance, 'appendChars']);

        $output = Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}

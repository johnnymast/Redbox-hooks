<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Filters;

/**
 * @since version 1.0
 * @covers Filters
 */
class FiltersClassesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneClassMethod()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\MockClass2;

        Filters::addFilter('prepend_chars', [$instance, 'prependChars']);
        $output = Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoClassMethods()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\MockClass2;

        Filters::addFilter('apply_chars', [$instance, 'prependChars']);
        Filters::addFilter('apply_chars', [$instance, 'appendChars']);

        $output = Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}

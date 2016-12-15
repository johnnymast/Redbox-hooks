<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Filters;

/**
 * @since version 1.0
 * @covers Redbox\Hooks\Filters
 */
class FiltersFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Redbox\Hooks\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneFunction()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('prepend_chars', 'Redbox\Hooks\Tests\Filters\Assets\filterPrepend');

        $output = Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Redbox\Hooks\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoFunctions()
    {

        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Filters::addFilter('apply_chars', 'Redbox\Hooks\Tests\Filters\Assets\filterPrepend');
        Filters::addFilter('apply_chars', 'Redbox\Hooks\Tests\Filters\Assets\filterAppend');
        $output = Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}

<?php
namespace Redbox\Hooks\Tests\Filters;

use Redbox\Hooks\Tests\Filters\Assets\MockClass1;
use Redbox\Hooks\Filters;
use Redbox\Hooks\Hook;

/**
 * @since version 1.0
 * @covers Redbox\Hooks\Filters
 */
class FiltersStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Filters::addFilter('', 'some_callback')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterReturnsFalseOnEmptyCallback()
    {
        $this->assertFalse(
            Filters::addFilter('some_tag', '')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        $this->assertTrue(
            Filters::addFilter('some_tag', $callback)
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterAddsFilterCorrectly()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {
            /* void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback);

        Filters::addFilter($tag, $callback);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterAddsMultipleFiltersCorrectly()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback1);
        $hook->addHook($priority, $callback2);

        Filters::addFilter($tag, $callback1);
        Filters::addFilter($tag, $callback2);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterSortsPriorityCorrect()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        $tag = 'test_add_filter_arranges_priority_correct';

        $hook = new Hook($tag);
        $hook->addHook(1, $callback1);
        $hook->addHook(0, $callback2);

        Filters::addFilter($tag, $callback1, 1);
        Filters::addFilter($tag, $callback2, 0);

        /** @var Hook $hooks */
        /** @var \ReflectionProperty $property */

        $hooks = $property->getValue()[$tag];
        $actual = $hooks->getHooks()[0][0];
        $expected = $hook->getHooks()[0][0];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers Redbox\Hooks\Filters::addFilter
     */
    public function testAddFilterInClassMethodHasTheCorrectCallback()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new MockClass1;

        $tag = 'manipulate_string';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, [$instance, 'prependChars']);
        $hook->addHook($priority, [$instance, 'appendChars']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Filters::removeFilter('', 'some_callback')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseOnEmptyCallback()
    {
        $this->assertFalse(
            Filters::removeFilter('some_tag', '')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Filters::addFilter('some_filter', $callback);

        $this->assertTrue(
            Filters::removeFilter('some_filter', $callback)
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterActuallyRemovesTheFilter()
    {
        $tag = 'shiny_new_filter';
        $priority = 10;

        $callback = function ($string) {
            return $string . '@';
        };

        Filters::addFilter($tag, $callback, $priority);

        $expected = '';
        Filters::removeFilter($tag, $callback);

        $actual = Filters::applyFilter($tag, '');


        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterRemovesTheFilterCorrectly()
    {
        $filters = new \ReflectionClass('Redbox\Hooks\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);

        $reset_filter = function () use ($property) {
            $property->setValue([]);
        };
        $reset_filter();

        $tag = 'some_filter';

        /**
         * Test callback is a string
         */
        Filters::addFilter($tag, 'callback1', 1);
        Filters::addFilter($tag, 'callback2', 2);
        Filters::removeFilter($tag, 'callback1');

        $hook = new Hook($tag);
        $hook->addHook(2, 'callback2');

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_filter();

        /**
         * Test callback is a closure
         */
        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        Filters::addFilter('some_filter', $callback1, 1);
        Filters::addFilter('some_filter', $callback2, 2);
        Filters::removeFilter('some_filter', $callback1);

        $hook = new Hook($tag);
        $hook->addHook(2, $callback2);


        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_filter();

        /**
         * Test callback is inside a class
         */
        $instance = new MockClass1();
        Filters::removeFilter('manipulate_string', [$instance, 'prependChars']);

        $hook = new Hook('manipulate_string');
        $hook->addHook(10, [$instance, 'appendChars']);

        $expected = $hook;
        $actual = $property->getValue()['manipulate_string'];

        $this->assertEquals($expected, $actual);
        $reset_filter();
    }

    /**
     * @covers Redbox\Hooks\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseIfFilterCouldNotBeFound()
    {
        $this->assertFalse(Filters::removeFilter('i_do_not_exist', 'no_callback_here'));
    }

    /**
     * @covers Redbox\Hooks\Filters::removeAllFilters
     */
    public function testRemoveAllFiltersReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Filters::removeAllFilters('')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::removeAllFilters
     */
    public function testRemoveAllFiltersReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Filters::addFilter('some_filter', $callback, 1);

        $this->assertTrue(
            Filters::removeAllFilters('some_filter')
        );
    }

    /**
     * @covers Redbox\Hooks\Filters::applyFilter
     */
    public function testApplyFilterReturnsValueIfActionIsNotFound()
    {
        $this->assertEquals(Filters::applyFilter('some_filter', 'value'), 'value');
    }
}

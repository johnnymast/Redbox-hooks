<?php
namespace Redbox\Hooks\Tests\Actions;

use Redbox\Hooks\Actions;

/**
 * @since version 1.0
 * @covers Actions
 */
class ActionsStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Actions::addAction
     */
    public function testAddActionReturnsFalseOnEmptyTag()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $this->assertFalse(
            Actions::addAction('', 'some_callback')
        );
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionReturnsFalseOnEmptyCallback()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $this->assertFalse(
            Actions::addAction('some_action', '')
        );
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionReturnsTrueOnSuccess()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {
            /* void */
        };

        $this->assertTrue(
            Actions::addAction('some_action', $callback)
        );
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionAddsActionCorrectly()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);


        $callback = function () {
            /* void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback);

        Actions::addAction($tag, $callback);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionAddsMultipleActions()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'new_action';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback1);
        $hook->addHook($priority, $callback2);

        Actions::addAction($tag, $callback1);
        Actions::addAction($tag, $callback2);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionOrdersPriorityCorrect()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'test_add_action_arranges_priority_correct';

        $hook = new Hook($tag);
        $hook->addHook(1, $callback1);
        $hook->addHook(0, $callback2);

        Actions::addAction($tag, $callback1, 1);
        Actions::addAction($tag, $callback2, 0);

        /** @var Hook $hooks */
        /** @var \ReflectionProperty $property */

        $hooks = $property->getValue()[$tag];
        $actual = $hooks->getHooks()[0][0];
        $expected = $hook->getHooks()[0][0];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers Actions::addAction
     */
    public function testAddActionInClassMethodHasTheCorrectCallback()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\MockClass1;

        $tag = 'do_some_things';
        $priority = 10;

        $hook = new Hook($tag);
        $hook->addHook($priority, [$instance, 'firstAction']);
        $hook->addHook($priority, [$instance, 'secondAction']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Actions::removeAction
     */
    public function testRemoveActionReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Actions::removeAction('', 'some_callback')
        );
    }

    /**
     * @covers Actions::removeAction
     */
    public function testRemoveActionReturnsFalseOnEmptyCallback()
    {
        $this->assertFalse(
            Actions::removeAction('some_action', '')
        );
    }

    /**
     * @covers Actions::removeAction
     */
    public function testRemoveActionReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Actions::addAction('some_action', $callback);

        $this->assertTrue(
            Actions::removeAction('some_action', $callback)
        );
    }

    /**
     * @covers Actions::removeAction
     */
    public function testRemoveActionReturnsFalseOnFailing()
    {
        $this->assertFalse(
            Actions::removeAction('something', 'something')
        );
    }

    /**
     * @covers Actions::removeAction
     */
    public function testRemoveActionRemovesTheActionCorrectly()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);

        $reset_actions = function () use ($property) {
            $property->setValue([]);
        };
        $reset_actions();

        $tag = 'some_action';

        /**
         * Test callback is a string
         */
        Actions::addAction($tag, 'callback1', 1);
        Actions::addAction($tag, 'callback2', 2);
        Actions::removeAction($tag, 'callback1');

        $hook = new Hook($tag);
        $hook->addHook(2, 'callback2');

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();

        /**
         * Test callback is a closure
         */

        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        Actions::addAction($tag, $callback1, 1);
        Actions::addAction($tag, $callback2, 2);
        Actions::removeAction($tag, $callback1);

        $hook = new Hook($tag);
        $hook->addHook(2, $callback2);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();

        /**
         * Test callback is inside a class
         */
        $tag = 'do_some_things';
        $instance = new Sandbox\Tests\Actions\Assets\MockClass1;
        Actions::removeAction($tag, [$instance, 'firstAction']);

        $hook = new Hook($tag);
        $hook->addHook(10, [$instance, 'secondAction']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();
    }

    /**
     * @covers Actions::removeAllActions
     */
    public function testRemoveAllActionsReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Actions::removeAllActions('')
        );
    }

    /**
     * Test that Actions::removeAllActions will return false if the tag was not
     * found/
     *
     * @covers Actions::removeAllActions
     */
    public function testRemoveAllActionsReturnsFalseIfTagIsNotFound()
    {
        $this->assertFalse(Actions::removeAllActions('i_do_not_exist'));
    }

    /**
     * @covers Actions::removeAllActions
     */
    public function testRemoveAllActionsReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Actions::addAction('some_action', $callback, 1);

        $this->assertTrue(
            Actions::removeAllActions('some_action')
        );
    }
}

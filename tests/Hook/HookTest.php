<?php
namespace Sandbox\Tests\Hook;

use Redbox\Hooks\Hook;

/**
 * @since version 1.0
 * @covers Redbox\Hooks\Hook
 */
class HookTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that Redbox\Hooks\Hook::addHook adds new hooks correctly.
     *
     * @covers Redbox\Hooks\Hook::addHook
     */
    public function testAddHookAddsNewHooksCorrectly()
    {

        $callback = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $expected = [
            $priority => [
                [
                    'callback' => $callback,
                    'priority' => $priority,
                ]
            ]
        ];

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback);
        $actual = $hook->getHooks();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that Redbox\Hooks\Hook::getHooks returns an array of hooks.
     *
     * @covers Redbox\Hooks\Hook::getHooks
     */
    public function testGetHooksReturnsAnArrayOfHooks()
    {
        $callback = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $hook = new Hook($tag);

        $this->assertEmpty($hook->getHooks());
        $hook->addHook($priority, $callback);
        $actual = $hook->getHooks();

        $this->assertNotEmpty($actual);
    }

    /**
     * Test that Redbox\Hooks\Hook::removeCallbackWithPriority removed one hook
     * correctly.
     *
     * @covers Redbox\Hooks\Hook::removeCallbackWithPriority
     */
    public function testRemoveCallbackWithPriorityRemovesTheHookCorrectly()
    {
        $callback = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback);

        $hook->removeCallbackWithPriority($priority, $callback);
        $this->assertEmpty($hook->getHooks());
    }

    /**
     * Test that Redbox\Hooks\Hook::removeCallbackWithPriority removes
     * multiple hooks correctly.
     *
     * @covers Redbox\Hooks\Hook::removeCallbackWithPriority
     */
    public function testRemoveCallbackWithPriorityRemovesMultipleHooksCorrectly()
    {
        $callback = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $expected = [
            $priority => [
                [
                    'callback' => $callback2,
                    'priority' => $priority,
                ]
            ]
        ];

        $hook = new Hook($tag);
        $hook->addHook($priority, $callback);
        $hook->addHook($priority, $callback2);

        $hook->removeCallbackWithPriority($priority, $callback);

        $actual = $hook->getHooks();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that Redbox\Hooks\Hook::removeAllHooks reset the hooks array.
     *
     * @covers Redbox\Hooks\Hook::removeAllHooks
     */
    public function testRemoveAllHooksResetsTheActiveHooksToEmptyArray()
    {
        $hook = new Hook('tag');
        $hook->addHook(10, function () {
           /* void */
        });
        $hook->removeAllHooks();
        $this->assertEmpty($hook->getHooks());
    }
}

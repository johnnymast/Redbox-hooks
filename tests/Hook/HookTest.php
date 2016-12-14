<?php
namespace Sandbox\Tests\Hook;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Hook
 */
class HookTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that Sandbox\Hook::addHook adds new hooks correctly.
     *
     * @covers Sandbox\Hook::addHook
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

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);
        $actual = $hook->getHooks();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that Sandbox\Hook::getHooks returns an array of hooks.
     *
     * @covers Sandbox\Hook::getHooks
     */
    public function testGetHooksReturnsAnArrayOfHooks()
    {
        $callback = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $hook = new Sandbox\Hook($tag);

        $this->assertEmpty($hook->getHooks());
        $hook->addHook($priority, $callback);
        $actual = $hook->getHooks();

        $this->assertNotEmpty($actual);
    }

    /**
     * Test that Sandbox\Hook::removeCallbackWithPriority removed one hook
     * correctly.
     *
     * @covers Sandbox\Hook::removeCallbackWithPriority
     */
    public function testRemoveCallbackWithPriorityRemovesTheHookCorrectly()
    {
        $callback = function () {
            /* void */
        };

        $tag = 'hook_tag';
        $priority = 2;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);

        $hook->removeCallbackWithPriority($priority, $callback);
        $this->assertEmpty($hook->getHooks());
    }

    /**
     * Test that Sandbox\Hook::removeCallbackWithPriority removes
     * multiple hooks correctly.
     *
     * @covers Sandbox\Hook::removeCallbackWithPriority
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

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);
        $hook->addHook($priority, $callback2);

        $hook->removeCallbackWithPriority($priority, $callback);

        $actual = $hook->getHooks();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that Sandbox\Hook::removeAllHooks reset the hooks array.
     *
     * @covers Sandbox\Hook::removeAllHooks
     */
    public function testRemoveAllHooksResetsTheActiveHooksToEmptyArray()
    {
        $hook = new Sandbox\Hook('tag');
        $hook->addHook(10, function () {
           /* void */
        });
        $hook->removeAllHooks();
        $this->assertEmpty($hook->getHooks());
    }
}

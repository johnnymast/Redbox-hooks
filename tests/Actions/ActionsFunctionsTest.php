<?php
namespace Redbox\Hooks\Tests\Actions;

use Redbox\Hooks\Actions;

/**
 * @since version 1.0
 * @covers Actions
 */
class ActionsFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param callable $callback
     * @return mixed
     */
    private function captureTestOutput($callback)
    {
        ob_start();
        call_user_func($callback);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * @covers Actions::doAction
     */
    public function testAddActionWorksCorrectWithOneAction()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Actions::addAction('echo_astrix', 'Sandbox\Tests\Actions\Assets\outputAstrixSymbol');

        $expected = '*';
        $output = $this->captureTestOutput(
            function () {
                Actions::doAction('echo_astrix');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Actions::doAction
     */
    public function testAddActionWorksCorrectWithTwoActions()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Actions::addAction('echo_astrix', 'Sandbox\Tests\Actions\Assets\outputAstrixSymbol');

        Actions::addAction('echo_at', 'Sandbox\Tests\Actions\Assets\outputAtSymbol');

        $expected = '*@';
        $output = $this->captureTestOutput(
            function () {
                Actions::doAction('echo_astrix');
                Actions::doAction('echo_at');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Actions::doAction
     */
    public function testDoActionReturnsValueIfActionIsNotFound()
    {
        $this->assertEquals(Actions::doAction('some_action', 'value'), 'value');
    }
}

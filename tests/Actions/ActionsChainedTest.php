<?php
namespace Redbox\Hooks\Tests\Actions;

use Redbox\Hooks\Actions;

/**
 * @since version 1.0
 * @covers Actions
 */
class FiltersChainedTest extends \PHPUnit_Framework_TestCase
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
    public function testDoActionWorksCorrectWithOneClassMethod()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Actions::addAction('echo_astrix', function () {
            echo '*';
        });

        $expected = '*';
        $output = $this->captureTestOutput(
            function () {
                Actions::doAction(['echo_astrix']);
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Actions::doAction
     */
    public function testDoActionWorksCorrectWithTwoClassMethods()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Actions::addAction('echo_astrix', function () {
            echo '*';
        });

        Actions::addAction('echo_at', function () {
            echo '@';
        });

        $expected = '*@';
        $output = $this->captureTestOutput(
            function () {
                Actions::doAction(['echo_astrix', 'echo_at']);
            }
        );
        $this->assertEquals($expected, $output);
    }
}

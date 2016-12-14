<?php
namespace Sandbox\Tests\Demos;

use Sandbox;

class DemosTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Capture the output of a demo using ob_start().
     *
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
     * I might not needed this test but i did it anyways. If i ever
     * update the core i still know all my demo's will work just how
     * they should.
     *
     * @dataProvider expectedResults
     * @param string $demo
     * @param string $expected
     */
    public function testDemos($demo = '', $expected = '')
    {
        $actual = $this->captureTestOutput(
            function () use ($demo) {
                include DEMO_DIR . '/' . $demo;
            }
        );
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that all demo's have been covered. If i ever add new demo's
     * this test will fail.
     */
    public function testClassCoversAllDemos()
    {
        $expected = count(glob(DEMO_DIR . '/*.php')) - 1;
        $actual = count(array_keys($this->expectedResults()));

        $this->assertEquals($expected, $actual, "Not all demo's where covered in " . __CLASS__);
    }

    /**
     * This function returns all the demo's and their output's.
     *
     * @return array
     */
    public function expectedResults()
    {
        return [
            ['actions_functions.php', 'Hello World' . "\n"],
            ['actions_chaining.php', "Hi: GitHub\nBye: GitHub\n"],
            ['actions_classes.php', "Called first\nCalled second\n"],
            ['actions_closures.php', "The callback is called\n"],
            ['actions_priority.php', "Called first\nCalled second\n"],
            ['filters_annotation.php', "Result: @!!Hello world"],
            ['filters_chaining.php', "Result: @@This is a text@@\n"],
            ['filters_classes.php', "Result: @@This is a text@@\n"],
            ['filters_closures.php', "Result: @@This is a text\n"],
            ['filters_functions.php', "Result: @@This is a text\n"],
            ['filters_priority.php', "Result: @@!!This is a text\n"],
        ];
    }
}

<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Filters;

require 'autoload.php';


class Worker
{

    public function prependChars($text = '')
    {
        return '@@' . $text;
    }

    public function appendChars($text = '')
    {
        return $text . '@@';
    }

    public function execute()
    {

        Filters::addFilter('manipulate_string', [$this, 'prependChars']);
        Filters::addFilter('manipulate_string', [$this, 'appendChars']);

        return Filters::applyFilter('manipulate_string', 'This is a text');
    }
}

$worker = new Worker;
$out = $worker->execute();

/**
 * The result should be:
 *
 * Result: @@This is a text@@
 */
echo "Result: " . $out . "\n";

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Filters::removeAllFilters('manipulate_string');

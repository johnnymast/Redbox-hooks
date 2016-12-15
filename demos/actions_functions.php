<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Redbox\Hooks\Actions;

function helloWorld($text)
{
    echo $text . "\n";
}

/**
 * If you are using your own custom namespace it is highly important
 * to prefix your functions with a the correct namespace.
 */
Actions::AddAction('hello_world', 'Sandbox\Demos\helloWorld');
Actions::doAction('hello_world', 'Hello World');

/**
 * The result should be:
 *
 * Result: Hello World
 *
 */

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('hello_world');
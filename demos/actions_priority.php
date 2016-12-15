<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Actions;

require 'autoload.php';

/**
 * This function is going to be called second.
 */
function otherFunction()
{
    echo "Called second\n";
}

/**
 * This function is going to be called first.
 */
function oneFunction()
{
    echo "Called first\n";
}

Actions::addAction('say_hello', 'Sandbox\Demos\oneFunction', 0);
Actions::addAction('say_hello', 'Sandbox\Demos\otherFunction', 1);
Actions::doAction('say_hello');

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('say_hello');
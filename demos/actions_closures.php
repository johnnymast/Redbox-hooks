<?php
namespace Sandbox\Demos;

use Redbox\Hooks\Actions;

require 'autoload.php';

Actions::addAction('hello_world', function () {
    echo "The callback is called\n";
});

/**
 * Result should be:
 *
 * The callback is called
 *
 */
Actions::doAction('hello_world');

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('hello_world');
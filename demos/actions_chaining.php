<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Redbox\Hooks\Actions;

Actions::addAction('say_hi', function ($name = '') {
    echo "Hi: " . $name . "\n";
    return $name;
});

Actions::addAction('say_bye', function ($name = '') {
    echo "Bye: " . $name . "\n";
    return $name;
});

/**
 * Result should be:
 *
 * Hi: GitHub
 * Bye: GitHub
 *
 */
Actions::doAction(['say_hi', 'say_bye'], 'GitHub');

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('say_hi');
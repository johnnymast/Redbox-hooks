<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Redbox\Hooks\Actions;

class Action
{


    /**
     */
    public function firstFunc()
    {
        echo "Called first\n";
    }

    /**
     */
    public function secondFunc()
    {
        echo "Called second\n";
    }

    /**
     * Register and call the actions.
     *
     * @return string
     */
    public function execute()
    {
        Actions::addAction('say_hello', [$this, 'firstFunc'], 0);
        Actions::addAction('say_hello', [$this, 'secondFunc'], 1);
        return Actions::doAction('say_hello');
    }
}

$instance = new Action;
/**
 * Result should be:
 *
 * Called first
 * Called second
 *
 */
$instance->execute();

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('say_hello');

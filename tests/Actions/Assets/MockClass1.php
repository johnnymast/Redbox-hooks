<?php
namespace Redbox\Hooks\Tests\Actions\Assets;

use Redbox\Hooks\Actions;

class MockClass1
{

    public function __construct()
    {
        Actions::addAction('do_some_things', [$this, 'firstAction']);
        Actions::addAction('do_some_things', [$this, 'secondAction']);
    }

    /**
     * @param array $args
     */
    public function firstAction($args = [])
    {
        /* void */
    }

    /**
     * @param array $args
     */
    public function secondAction($args = [])
    {
        /* void */
    }
}

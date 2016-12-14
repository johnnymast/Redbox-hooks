<?php
namespace Redbox\Hooks;

class Actions
{

    /**
     * @var array
     */
    private static $actions = [];

    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     * @return bool
     */
    public static function addAction($tag = '', $callback = '', $priority = 10)
    {

        if (empty($tag) || empty($callback)) {
            return false;
        }

        if (isset(self::$actions[$tag]) === false) {
            self::$actions[$tag] = new Hook($tag);
        }

        self::$actions[$tag]->addHook($priority, $callback);

        return true;
    }

    /**
     * @param string $action
     * @param string $value
     * @return string
     */
    public static function doAction($action = '', $value = '')
    {
        if (is_array($action)) {
            foreach ($action as $single) {
                $value = self::execute($single, $value);
            }
        } else {
            $value = self::execute($action, $value);
        }
        return $value;
    }

    /**
     * @param $tag
     * @param string $value
     * @return string
     */
    private static function execute($tag, $value = '')
    {
        if (isset(self::$actions[$tag]) === false) {
            return $value;
        }

        $hooks = self::$actions[$tag]->getHooks();

        foreach ($hooks as $priority => $callbacks) {
            do {
                $entry = current($callbacks);
                if (is_callable($entry['callback'])) {
                    $value = call_user_func($entry['callback'], $value);
                }
            } while (next($callbacks));
        }
        return $value;
    }

    /**
     * @param string $tag
     * @param string $callback
     * @return bool
     */
    public static function removeAction($tag, $callback)
    {
        if (empty($tag) || empty($callback)) {
            return false;
        }

        if (isset(self::$actions[$tag]) === true) {
            $found = false;
            $hooks = self::$actions[$tag]->getHooks();

            foreach ($hooks as $priority => $callbacks) {
                foreach ($callbacks as $entry) {
                    if ($entry['callback'] == $callback) {
                        self::$actions[$tag]->removeCallbackWithPriority($priority, $callback);
                        $found = true;
                    }
                }
            }
            return $found;
        }
        return false;
    }

    /**
     * @param string $tag
     * @return bool
     */
    public static function removeAllActions($tag)
    {
        if (empty($tag)) {
            return false;
        }

        if (isset(self::$actions[$tag])) {
            self::$actions[$tag]->removeAllHooks();
            unset(self::$actions[$tag]);
            return true;
        }
        return false;
    }
}

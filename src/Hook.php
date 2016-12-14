<?php
namespace Redbox\Hooks;

class Hook
{

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var array
     */
    protected $hooks = [];


    /**
     * Hook constructor.
     * @param string $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param int $priority
     * @param string $callback
     */
    public function addHook($priority = 10, $callback = '')
    {
        $this->hooks[$priority][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];
        ksort($this->hooks);
    }

    /**
     * Return all hooks
     *
     * @return array
     */
    public function getHooks()
    {
        return $this->hooks;
    }

    /**
     * Remove a given hook with a callback and priority.
     *
     * @param int $priority
     * @param string $callback
     */
    public function removeCallbackWithPriority($priority = 10, $callback = '')
    {
        $hooks = $this->getHooks();
        if (isset($hooks[$priority]) == true) {
            $callbacks = $hooks[$priority];
            foreach ($callbacks as $index => $entry) {
                if ($entry['callback'] == $callback) {
                    unset($this->hooks[$priority][$index]);

                    if (count($this->hooks[$priority]) > 0) {
                        $new = [];
                        foreach ($this->hooks[$priority] as $hook) {
                            $new[] = $hook;
                        }
                        $this->hooks[$priority] = $new;
                    } elseif (count($this->hooks[$priority]) == 0) {
                        unset($this->hooks[$priority]);
                    }
                }
            }
        }
    }

    /**
     * Remove all known hooks.
     */
    public function removeAllHooks()
    {
        $this->hooks = [];
    }
}

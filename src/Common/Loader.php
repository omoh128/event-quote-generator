<?php
/**
 * Hook and filter loader
 *
 * @package EventQuoteGenerator
 */
namespace EventQuoteGenerator\Common;

/**
 * Class Loader
 */
class Loader {
    /**
     * Array of action hooks to register
     *
     * @var array
     */
    protected $actions = array();

    /**
     * Array of filter hooks to register
     *
     * @var array
     */
    protected $filters = array();

    /**
     * Add a new action to the collection to be registered
     *
     * @param string $hook          Hook name.
     * @param object $component     Component object.
     * @param string $callback      Callback method.
     * @param int    $priority      Priority.
     * @param int    $accepted_args Number of accepted arguments.
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Add a new filter to the collection to be registered
     *
     * @param string $hook          Hook name.
     * @param object $component     Component object.
     * @param string $callback      Callback method.
     * @param int    $priority      Priority.
     * @param int    $accepted_args Number of accepted arguments.
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Register all actions and filters
     */
    public function run() {
        foreach ( $this->filters as $hook ) {
            add_filter(
                $hook['hook'],
                array( $hook['component'], $hook['callback'] ),
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ( $this->actions as $hook ) {
            add_action(
                $hook['hook'],
                array( $hook['component'], $hook['callback'] ),
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }

    /**
     * Add hook to collection
     *
     * @param array  $hooks         Existing hooks.
     * @param string $hook          Hook name.
     * @param object $component     Component object.
     * @param string $callback      Callback method.
     * @param int    $priority      Priority.
     * @param int    $accepted_args Number of accepted arguments.
     * @return array
     */
    private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {
        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
        );

        return $hooks;
    }
}
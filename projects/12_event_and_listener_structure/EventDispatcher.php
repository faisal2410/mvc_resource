<?php
// Step 3: Define a Simple Dispatcher
class EventDispatcher
{
    private $listeners = [];

    public function listen($eventName, $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener->handle($event);
            }
        }
    }
}

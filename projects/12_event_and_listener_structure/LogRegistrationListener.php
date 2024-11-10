<?php
class LogRegistrationListener
{
    public function handle(UserRegisteredEvent $event)
    {
        echo "Logging registration for " . $event->user->email . PHP_EOL;
    }
}
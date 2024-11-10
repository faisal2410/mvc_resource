<?php
// Step 2: Define a Listener
class SendWelcomeEmailListener
{
    public function handle(UserRegisteredEvent $event)
    {
        // Access user details from the event
        echo "Sending welcome email to " . $event->user->email;
    }
}
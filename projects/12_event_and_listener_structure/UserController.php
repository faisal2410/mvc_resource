<?php
// Step 4: Simulate MVC Controller Registering a User
class UserController
{
    protected $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function register($userData)
    {
        // Assume we saved the user to a database
        echo "User registered: " . $userData['email'] . PHP_EOL;

        // Dispatch an event
        $event = new UserRegisteredEvent((object) $userData);
        $this->eventDispatcher->dispatch($event);
    }
}

// Step 5: Putting it All Together
$eventDispatcher = new EventDispatcher();
$eventDispatcher->listen(UserRegisteredEvent::class, new SendWelcomeEmailListener());
$eventDispatcher->listen(UserRegisteredEvent::class, new LogRegistrationListener());

$userController = new UserController($eventDispatcher);
$userController->register(['email' => 'test@example.com']);

/*
In this example:

When UserController registers a user, it dispatches a UserRegisteredEvent.
The EventDispatcher handles this event, notifying the listeners: SendWelcomeEmailListener and LogRegistrationListener.

*/ 
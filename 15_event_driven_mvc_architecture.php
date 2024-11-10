<?php
/*
Script for Screencast Video: "Building an Event-Driven MVC Architecture in PHP"
Title: Building an Event-Driven MVC Architecture in PHP
Agenda:
Introduction to Event-Driven Design in MVC
Why Event-Driven Architecture?
Implementing Events and Listeners to Decouple MVC Components
Practical Example: Implementing Event-Driven Architecture in PHP
Script
Introduction
Hello everyone! Welcome to today’s session on “Building an Event-Driven MVC Architecture in PHP.”
In this screencast, we’ll dive into how we can utilize events to make our MVC applications more flexible, modular, and scalable.
With your understanding of PHP OOP, SOLID principles, design patterns, and SPL, we’re ready to explore the advantages of event-driven architecture.

1. Understanding Event-Driven Design in MVC
To start, let’s discuss the basics of event-driven design in an MVC context.
In a traditional MVC (Model-View-Controller) architecture, we often encounter situations where various components need to respond to certain actions or state changes—like when a user registers, or a record is updated.

With an event-driven approach, we can decouple these components by defining “events” that our system can listen to. This means instead of controllers handling every action directly, they can trigger events, and various parts of the system will respond without tightly coupling to the main process.

Code Example 1: Event and Listener Structure
php
Copy code
<?php

// Step 1: Define the Event
class UserRegisteredEvent {
    public $user;

    public function __construct($user) {
        $this->user = $user;
    }
}

// Step 2: Define a Listener
class SendWelcomeEmailListener {
    public function handle(UserRegisteredEvent $event) {
        // Access user details from the event
        echo "Sending welcome email to " . $event->user->email;
    }
}

// Step 3: Define a Simple Dispatcher
class EventDispatcher {
    private $listeners = [];

    public function listen($eventName, $listener) {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event) {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener->handle($event);
            }
        }
    }
}
?>
2. Why Event-Driven Architecture?
The main benefit of using events is decoupling. With an event-driven approach, our MVC components don’t need to directly know about each other’s implementations.
This aligns perfectly with the Open-Closed Principle in SOLID, allowing our system to be open for extension but closed for modification.
It also enables better testability and scalability because components can be added or removed without impacting existing code.

3. Implementing Events and Listeners for Decoupling MVC Components
Now, let’s look into implementing events and listeners within an MVC structure. We’ll simulate an example where we trigger an event when a new user registers, and listeners will handle actions like sending a welcome email or logging the registration event.

Let’s extend our previous code to make it more realistic within an MVC setting.

Code Example 2: Event-Driven MVC Simulation
php
Copy code
<?php

// Step 1: Define the Event (UserRegisteredEvent)
class UserRegisteredEvent {
    public $user;

    public function __construct($user) {
        $this->user = $user;
    }
}

// Step 2: Define Listeners
class SendWelcomeEmailListener {
    public function handle(UserRegisteredEvent $event) {
        echo "Sending welcome email to " . $event->user->email . PHP_EOL;
    }
}

class LogRegistrationListener {
    public function handle(UserRegisteredEvent $event) {
        echo "Logging registration for " . $event->user->email . PHP_EOL;
    }
}

// Step 3: Event Dispatcher
class EventDispatcher {
    private $listeners = [];

    public function listen($eventName, $listener) {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event) {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener->handle($event);
            }
        }
    }
}

// Step 4: Simulate MVC Controller Registering a User
class UserController {
    protected $eventDispatcher;

    public function __construct($eventDispatcher) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function register($userData) {
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
?>
In this example:

When UserController registers a user, it dispatches a UserRegisteredEvent.
The EventDispatcher handles this event, notifying the listeners: SendWelcomeEmailListener and LogRegistrationListener.
4. Practical Example: Implementing Event-Driven Architecture in PHP
Now, let’s put this into action with a practical walkthrough!

We’ll start with our MVC Controller—the UserController registers a user, triggering the UserRegisteredEvent. This event is then picked up by our EventDispatcher, which sends notifications to each listener.

This design provides flexibility to add or remove listeners as needed, without modifying existing code.

Testing Our Event-Driven Code
When we run this code, we should see output indicating that:

The user has been registered.
A welcome email is sent.
The registration is logged.
This allows us to clearly see how decoupling through events benefits our MVC architecture.

Conclusion
Today, we explored event-driven design within an MVC architecture, focusing on decoupling components to create a more modular and testable structure. This approach, combined with your knowledge of PHP OOP and SOLID principles, provides a powerful way to manage complex systems with multiple components.

Thanks for joining! Remember to experiment with events in your projects and see how they can improve flexibility and maintainability. Don’t forget to subscribe for more insights into advanced PHP development topics.


*/ 
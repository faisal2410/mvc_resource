<?php


// Step 1: Define the Event
class UserRegisteredEvent {
    public $user;

    public function __construct($user) {
        $this->user = $user;
    }
}





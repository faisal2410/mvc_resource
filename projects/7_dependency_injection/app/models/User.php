<?php
// app/models/User.php

class User
{
    private $db;
    private $logger;

    public function __construct($db, $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function findAll()
    {
        $this->logger->log("Fetching all users from the database.");
        return $this->db->query("SELECT * FROM users");
        // return $this->db->query("SELECT * FROM users")->fetchAll();
    }
}

<?php
// app/models/User.php

class User
{
    private Database $db;
    private Logger $logger;

    public function __construct(Database $db, Logger $logger)
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

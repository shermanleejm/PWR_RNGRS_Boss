<?php

class User {

    private $username;
    private $passwordHash;

    public function __construct($username, $passwordHash) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPasswordHash() {
        return $this->passwordHash;
    }

}

?>
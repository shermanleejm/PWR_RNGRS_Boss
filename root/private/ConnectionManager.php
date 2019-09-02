<?php

// DO NOT MODIFY THIS FILE
// UNLESS YOU ARE USING MAMP (then you may need to specify a Port)

class ConnectionManager {

    public function getConnection() {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'boss';
        $port = 3306;
        
        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);     
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // if fail, exception will be thrown

        // Return connection object
        return $conn;
    }

}
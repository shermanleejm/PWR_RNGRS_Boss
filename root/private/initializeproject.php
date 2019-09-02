<?php
session_start();
require_once "./ConncetionManager.php";

#MAC connection
$conn = new PDO( "mysql:host=localhost;dbname=boss", "root", "root");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#windows connection
// $conn = new ConnectionManager();

$username = "admin";
$password = "admin";
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "
    DROP TABLE IF EXISTS users ;
    CREATE TABLE users (
        username varchar(255) not null,
        password varchar(255) not null
    );
    INSERT INTO users VALUES (:username, :password);
    ";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":username", $username);
$stmt->bindParam(":password", $hash);
$stmt->execute();

echo "created successfully";

$stmt->close();
$conn->close();
?>
<?php

## Note: I adjusted the primary key for Bid table and also column name for course code -Sue (4/9/2019)

session_start();
// require_once "../ConnectionManager.php";

#MAC connection
$pdo = new PDO( "mysql:host=localhost;dbname=boss;port=3306", "root", "root");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#windows connection
// $conn = new ConnectionManager();

$username = "admin";
$password = "admin";
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "
    DROP TABLE IF EXISTS users ;
    CREATE TABLE users (
        username varchar(255) not null PRIMARY KEY,
        password varchar(255) not null
    );

    INSERT INTO users VALUES (:username, :password);

    DROP TABLE IF EXISTS bid ;
    CREATE TABLE bid (
        userid varchar(255) not null,
        amount int not null,
        coursecode varchar(10) not null,
        section varchar(3) not null,
        primary key (userid, coursecode)
    );

    DROP TABLE IF EXISTS courseCompleted ;
    CREATE TABLE courseCompleted (
        userid varchar(255) not null PRIMARY KEY,
        code varchar(10) not null
    );

    DROP TABLE IF EXISTS course ;
    CREATE TABLE course (
        course varchar(10) not null,
        school varchar(4) not null,
        title varchar(255) not null,
        description varchar(1000) not null,
        examdate date not null,
        examstart time not null,
        examend time not null
    );

    DROP TABLE IF EXISTS prerequisite ;
    CREATE TABLE prerequisite (
        course varchar(10) not null PRIMARY KEY,
        prerequisite varchar(10) not null
    );

    DROP TABLE IF EXISTS section ;
    CREATE TABLE section (
        course varchar(10) not null PRIMARY KEY,
        section varchar(3) not null,
        day int not null,
        start time not null,
        end time not null,
        instructor varchar(255) not null,
        venue varchar(255) not null,
        size int not null
    );

    DROP TABLE IF EXISTS student ;
    CREATE TABLE student (
        userid varchar(255) not null PRIMARY KEY,
        password varchar(10) not null,
        name varchar(255) not null,
        school varchar(4) not null,
        edollar int not null
    );

    ";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":username", $username, PDO::PARAM_STR);
$stmt->bindParam(":password", $hash, PDO::PARAM_STR);
$stmt->execute();

echo "created successfully";

$stmt->close();
$pdo->close();
?>
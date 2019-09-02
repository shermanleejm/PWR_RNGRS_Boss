<?php
session_start();
$conn = mysqli_connect( "localhost", "root", "root", "boss");
$sql = "
    DROP TABLE IF EXISTS 'username'
    CREATE TABLE username
    "


?>
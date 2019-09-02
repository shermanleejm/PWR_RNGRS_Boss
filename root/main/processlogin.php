<?php
session_start();
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
if (!empty($_POST["submit"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $hash;
    if ($_POST["username"] === "admin") {
        header('Location:admin.html');
    };
};
?>
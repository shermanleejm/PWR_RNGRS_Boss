<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // ...
// }
// $folder = date("Ymd");mkdir ($folder, 0755);

session_start();

if (isset($_FILES["data"])) {
    $errors = array();
    $file_name = $_FILES['data']['name'];
    $file_size = $_FILES['data']['size'];
    $file_tmp = $_FILES['data']['tmp_name'];
    $file_type = $_FILES['data']['type'];
    $file_ext = strtolower(explode('.', $file_name)[1]);

    if ($file_ext != "csv") {
        $errors[]= "Please upload a csv file only";
    }

    if (empty($errors)) {
        echo "Successful Upload!";
        $file = "../csvfiles/" + $file_name;
        move_uploaded_file($file_tmp, $file);
    }
    else {
        $_SESSION["errors"] = $errors;
        header("Location:admin.html");
    }   
}


?>
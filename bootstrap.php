<?php
require_once "connectionManager.php";


function doBootstrap() {
    $linkmanager = new ConnectionManager();  
    $conn = $linkmanager->getConnection();
    //session_start();
    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK );
    
            foreach( $files as $file ){
                delete_files( $file );      
            }
    
            rmdir( $target );
        } 
        elseif(is_file($target)) {
            unlink( $target );  
        }
    }

    if (!file_exists('../resources/temp')) {
        mkdir('../resources/temp', 0777, true);
    }
    else if (file_exists('../resources/temp')) {
        var_dump(file_exists('../resources/temp'));
        delete_files('../resources/temp');
        mkdir('../resources/temp', 0777, true);
    }

    $errors = array();
    $zip_file = $_FILES["data"]["tmp_name"];
    // $temp_dir = sys_get_temp_dir();
    $temp_dir = '../resources/temp';

    $zip = new ZipArchive;
    if ($zip->open($zip_file)) {
        $zip->extractTo($temp_dir);
        $zip->close();
    }

    $acceptablefilenames = ["student", "course", "section", "prerequisite", "course_completed", "bid"];
    $foldername = explode(".", $_FILES["data"]["name"]);
    $temp_dir = '../resources/temp/' . $foldername[0];
    $count = 0;
    foreach ($acceptablefilenames as $name) {
        ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
        ${"$name" . "_file"} = fopen(${"$name" . "_path"}, "r");
        if (empty(${"$name" . "_file"})) {
            $error = "$name" . ".csv not found";
            $_SESSION["bootstraperrors"][]= $error;
            fclose(${"$name"});
            unlink(${"$name" . "_path"});
            $error = "";
        }
        else{
            $count ++;
        }      
    }

    if ($count != count($acceptablefilenames)) {
        return FALSE;
        exit;
    }
   
    $sql = "create database if not exists boss;
    use boss;

create table if not exists student (
    userid varchar(64) not null primary key,
    studentpassword varchar(64) not null,
    studentname varchar(64) not null,
    school varchar(8) not null,
    edollar int not null
);
    TRUNCATE table student;

create table if not exists course (
    course varchar(64) not null,
    school varchar(8) not null,
    title varchar(64) not null,
    descr varchar(1000) not null,
    examdate date not null,
    examstart time not null,
    examend time not null,
    primary key (course, school, examdate, examstart, examend)
);
    TRUNCATE table course;

create table if not exists section (
    course varchar(64) not null,
    section varchar(64) not null,
    dayoftheweek int not null,
    starttime time not null,
    endtime time not null,
    instructor varchar(64) not null,
    venue varchar(64) not null,
    size int not null,
    primary key(course, section)
);
    TRUNCATE table section;

create table if not exists prerequisite (
    course varchar(64) not null,
    prerequisite varchar(64) not null,
    primary key (course, prerequisite)
);
    TRUNCATE table prerequisite;

create table if not exists course_completed (
    userid varchar(64) not null,
    code varchar(64) not null,
    primary key (userid, code)
);
    TRUNCATE table course_completed;

create table if not exists bid (
    userid varchar(64) not null,
    amount int not null,
    code varchar(64) not null,
    section varchar(8) not null,
    primary key (userid, code)
);
    TRUNCATE table bid;
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // mysqli_execute($stmt);

    // ERRROR CHECKING
    $_SESSION["bootstraperrors"] = array();

    // STUDENT
    $name = "student";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;
    $templistofuserid = [];
    $existinguserid = array();
    while ( ($line = fgetcsv($name)) == TRUE ) {
        $lineerrormessage = array();
        if (strpos(".", $line[4]) !== FALSE) {
            $decimalplaces = explode(".", $line[4])[1];
            if (strlen($decimalplaces) > 2) {
                $lineerrormessage[]="invalid e-dollar";
            }
        }
        if ( !in_array($line[0], $templistofuserid) ) {
            $templistofuserid[]=$line[0];
        }
        else {
            $lineerrormessage[]="duplicate userid";
        }
        if ( strlen($line[0]) > 128 ) {
            $lineerrormessage[]="invalid userid";
        }
        if ( strlen($line[1]) > 128 ) {
            $lineerrormessage[]="invalid password";
        }
        if ( strlen($line[2]) > 100 ) {
            $lineerrormessage[]="invalid password";
        }
        if ( ($line[4] < 0) ) {
            $lineerrormessage[]="invalid e-dollar";
        }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= array(
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            );
        }
        else {
            $properlines++;
            $existinguserid[]=$line[0];
            $stmt = $conn->prepare("use boss;
            INSERT INTO student 
            VALUES (:userid, :password, :name, :school, :edollar);
            ");
            $stmt->bindParam(":userid", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":password", $line[1], PDO::PARAM_STR);
            $stmt->bindParam(":name", $line[2], PDO::PARAM_STR);
            $stmt->bindParam(":school", $line[3], PDO::PARAM_STR);
            $stmt->bindParam(":edollar", $line[4], PDO::PARAM_INT);
            $stmt->execute();
            
        }
        $linecount++;
    }
    
    // COURSE
    $name = "course";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;
    $courses = [];
    $schoolandcourses = [];
    while ( ($line = fgetcsv($name)) == TRUE ) {
        $lineerrormessage = array();
        $starttime = explode(":", $line[5]);
        $endtime = explode(":", $line[6]);
        if ( (substr($line[4], 4, 2) > 12) || (substr($line[4], 6, 2) > 31) || strlen($line[4]) != 8) {
            $lineerrormessage[]= "invalid exam date";
        }
        if ( ($starttime[0] > 23) || ($starttime[1] > 59) ) {
            $lineerrormessage[]= "invalid exam start";
        }
        if ( ($endtime[0] > 23) || ($endtime[1] > 59) ) {
            $lineerrormessage[]= "invalid exam end";
        }
        if ( strlen($line[2]) > 100 ) {
            $lineerrormessage[]= "invalid title";
        }
        if ( strlen($line[3] > 1000) ) {
            $lineerrormessage[]= "invalid description";
        }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= [
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            ];
        }
        else {
            if (!in_array($line[0], $courses)) {
                $courses[]=$line[0]; 
            }
            if ( !array_key_exists($line[1], $schoolandcourses) ) {
                $schoolandcourses[$line[1]] = array( $line[0] );
            }
            else {
                $schoolandcourses[$line[1]][]= $line[0];
            }
            $properlines++;
            $stmt = $conn->prepare("use boss;
            INSERT INTO course 
            VALUES (:course, :section, :title, :descr, :day, :start, :end);
            ");
            $stmt->bindParam(":course", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":section", $line[1], PDO::PARAM_STR);
            $stmt->bindParam(":title", $line[2], PDO::PARAM_STR);
            $stmt->bindParam(":descr", $line[3], PDO::PARAM_STR);
            $stmt->bindParam(":day", $line[4], PDO::PARAM_STR);
            $stmt->bindParam(":start", $line[5], PDO::PARAM_STR);
            $stmt->bindParam(":end", $line[6], PDO::PARAM_STR);
            $stmt->execute();
        }
        $linecount++;
    }

    // SECTION
    $name = "section";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;
    $coursesection = [];
    while ( ($line = fgetcsv($name)) == TRUE ) {
        $lineerrormessage = array();
        if ( !in_array($line[0], $courses) ) {
            $lineerrormessage[]= "invalid course";
        }
        if ( (strtolower($line[1][0]) != "s") || (explode( "s", strtolower( $line[1] ) )[1] > 99) || (explode( "s", strtolower( $line[1] ) )[1] < 1) ) {
            $lineerrormessage[]= "invalid section";
        }
        if ( $line[2] > 7 || $line[2] < 1 ) {
            $lineerrormessage[]= "invalid day";
        }
        if ( explode(":", $line[3])[0] > 23 || explode(":", $line[3])[0] < 0 || explode(":", $line[3])[1] < 0 || explode(":", $line[3])[1] > 60 ) {
            $lineerrormessage[]= "invalid start";
        }
        if ( explode(":", $line[4])[0] > 23 || explode(":", $line[4])[0] < 0 || explode(":", $line[4])[1] < 0 || explode(":", $line[4])[1] > 60 ) {
            $lineerrormessage[]= "invalid end";
        }
        if (strlen($line[5]) > 100) {
            $lineerrormessage[]= "invalid instructor";
        }
        if ( strlen($line[6]) > 100 ) {
            $lineerrormessage[]= "invalid venue";
        }
        if ( $line[7] < 0 ) {
            $lineerrormessage[]= "invalid size";
        }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= array(
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            );
        }
        else {
            $properlines++;
            if ( !in_array($line[0], $coursesection) ) {
                $coursesection[$line[0]] = [ $line[1] ];
            }
            else {
                $coursesection[$line[0]][]= [ $line[1] ];
            }
            $stmt = $conn->prepare("use boss;
            INSERT INTO section 
            VALUES (:course, :section, :day, :start, :end, :instructor, :venue, :size);
            ");
            $stmt->bindParam(":course", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":section", $line[1], PDO::PARAM_STR);
            $stmt->bindParam(":day", $line[2], PDO::PARAM_INT);
            $stmt->bindParam(":start", $line[3], PDO::PARAM_STR);
            $stmt->bindParam(":end", $line[4], PDO::PARAM_STR);
            $stmt->bindParam(":instructor", $line[5], PDO::PARAM_STR);
            $stmt->bindParam(":venue", $line[6], PDO::PARAM_STR);
            $stmt->bindParam(":size", $line[7], PDO::PARAM_INT);
            $stmt->execute();
            
        }
        $linecount++;
    }

    // PREREQUISITE
    $name = "prerequisite";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;
    $prereqdict = [];
    while ( ($line = fgetcsv($name)) == TRUE ) {
        $lineerrormessage = array();
        if ( !in_array($line[0], $courses) ) {
            $lineerrormessage[]="invalid course";
        }
        if ( !in_array($line[1], $courses) ) {
            $lineerrormessage[]="invalid prerequisite";
        }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= array(
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            );
        }
        else {
            $properlines++;
            if ( !key_exists($line[0], $prereqdict) ) {
                $prereqdict[$line[0]] = [ $line[1] ];
            }
            else {
                $prereqdict[$line[0]][]= [ $line[1] ];
            }
            $stmt = $conn->prepare("use boss;
            INSERT INTO prerequisite 
            VALUES (:course, :prerequisite);
            ");
            $stmt->bindParam(":course", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":prerequisite", $line[1], PDO::PARAM_STR);
            $stmt->execute();
        }
        $linecount++;
    }

    // course_completed
    $name = "course_completed";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;
    while ( ($line = fgetcsv($name)) == TRUE ) {
        $lineerrormessage = array();
        if ( !in_array($line[0], $existinguserid) ) {
            $lineerrormessage[]="invalid userid";
        }
        if ( !in_array($line[1], $courses) ) {
            $lineerrormessage[]="invalid course";
        }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= array(
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            );
        }
        else {
            $properlines++;
            $stmt = $conn->prepare("use boss;
            INSERT INTO course_completed 
            VALUES (:userid, :code);
            ");
            $stmt->bindParam(":userid", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":code", $line[1], PDO::PARAM_STR);
            $stmt->execute();
        }
        $linecount++;
    }

    // bid
    $name = "bid";
    $filename = $name . ".csv";
    ${"$name" . "_path"} = "$temp_dir/$name" . ".csv";
    $name = fopen(${"$name" . "_path"}, "r");
    // print_r (fgetcsv(${"$name" . "_file"}));
    $line = fgetcsv($name);
    $linecount = 1;
    $properlines = 0;

    $stmt->closeCursor();
    $sql = "select * from roundstatus;";
    foreach ($q = $conn->query($sql) as $row) {
        $currentround = ($row["round"]);
    }
    $q->closeCursor();

    $bids = array();
    while ( ($line = fgetcsv($name)) == TRUE ) {
        var_dump($line[4]);
        $lineerrormessage = [];
        if ( !in_array($line[0], $existinguserid) ) {
            $lineerrormessage[]= "invalid userid";
        }
        if (strpos(".", $line[1]) !== FALSE) {
            $decimalplaces = explode(".", $line[1])[1];
            if (strlen($decimalplaces) > 2) {
                $lineerrormessage[]="invalid amount";
            }
        }
        if ( $line[1] < 10 ) {
            $lineerrormessage[]= "invalid amount";
        }
        if ( !in_array($line[2], $courses) ) {
            $lineerrormessage[]= "invalid code";
        }
        // else if ( !in_array($line[3], $coursesection[$line[2]]) ) {
        //     $lineerrormessage[]= "invalid section";
        // }

        if (!empty($lineerrormessage)) {
            $_SESSION["bootstraperrors"][]= array(
                "file"=>$filename , 
                "line"=>$linecount ,
                "message"=>$lineerrormessage
            );
        }
        else {
            $properlines++;
            $stmt = $conn->prepare("use boss;
            INSERT INTO bid 
            VALUES (:userid, :amount, :code, :section);
            ");
            $stmt->bindParam(":userid", $line[0], PDO::PARAM_STR);
            $stmt->bindParam(":amount", $line[1], PDO::PARAM_STR);
            $stmt->bindParam(":code", $line[2], PDO::PARAM_STR);
            $stmt->bindParam(":section", $line[3], PDO::PARAM_STR);
            $stmt->execute();
        }
        $linecount++;
    }

    
    return TRUE;    
}
?>
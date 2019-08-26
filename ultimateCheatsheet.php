
<? # this is a cheatsheet for php & html ?>

<? 
# JUST CTRL-F what you need
    # Eg. classes, html, checkboxes, foreach loop, debugging, login, authentication and stuff


# PHP CODE
# -----------------------------------------------------------------------
# DEBUGGING / ERRORS

# print_r and var_dump is better for displaying arrays and stuff
    print_r('whatever it is you wanna see');
    exit;

    var_dump('whatever it is you wanna see');
    exit;

# echo is usually for variables
    echo "whatever it is you wanna see";
    exit;

# -----------------------------------------------------------------------

# Index Arrays

    # Initialize
        $cities = []; 
        # or 
        $cities = ["London", "Paris", "Washington"]; 
    # Update
        $cities[1] = "Amsterdam"; 
    # Append
        $cities[] = "Bangkok"; 

# Associative Arrays

    # Initialize
        $capitals = array( "USA" => "Washington", 
                        "France" => "Paris"); 
    # Update
        $capitals["USA"] = "Washington, D.C.";
    # Append
        $capitals["Singapore"] = "Singapore"; 

# Multi-dimensional Arrays

    $capitals = array(
        array("Manchester","London"), 
        array("France", "Nice"), 
        array("San Francisco")
    );
    echo $capitals[2][0]; // prints "San Francisco"

# Array Methods

    # gives you the length of key-value pairs or items inside
        count($cities);

    # merges arrays 
    # if there are keys that are the same, the later one will replace the earlier one
    # if it is an index array, the later value will be appended to the back
        array_merge();


# -----------------------------------------------------------------------

# for each loop

    # Index Array
        $array = array(1, 2, 3, 4, 5);
        foreach ($arr as $arr_entry){
            echo $arr_entry;
        }

    # Associative Array
        $array = array("a"=>1, "b"=>2);
        foreach ($array as $key=>$value){
            echo $key . "maps to" . $value;
        }

# -----------------------------------------------------------------------

# CLASSES

    # Writing a class
        class Human{
            public $name;
            public $age;

            function __construct($name, $age){
                $this->name = $name;
                $this->age = $age;
            }

            function greet(){
                echo "Hi " . $this->name . "! You look great today! :-)";
            }
        }
    
    # Instantiating a new object from the class

        $human = new Human("name", 21);

    # Calling attributes from object

        $name = $human->name;
        $age = $human->age;

    # Calling methods 
    
        $human->greet();

    # Defining constants

        class Tax{
            const GST_RATE = 0.07;    
        }

    # Using the constant

        #inside the class itself 
            $gstRate = self::GST_RATE;
        
        #outside the class
            $gstRate = Tax::GST_RATE; //write the class name in front

# -----------------------------------------------------------------------
# Importing files

    # single file
        require_once "include/login.php";

    # if many files

        spl_autoload_register(function($class) {
    
            // we are assuming that it is in the same directory as common.php
            // otherwise we have to do
            // $path = '<path>/' . $class . ".php"    
            $path =  $class . ".php";
            require $path; 
        
        });

        # or 

    // Autoloading

        spl_autoload_register(
            function ($class_name) {
                include "{$class_name}.php";
                include "module/{$class_name}.php"; // to include files inside module folder as well
            }
        );
# General Stuff
    
    // Creates an array of lowercase alphabets
    $alphabets = range( 'a', 'z' );

    // Changing all capital to lower
    $ch = strtolower("ABC"); // strtoupper('abc') to upper

    // Check if Form that POST TO this file "text" is set?
    if(isset($_POST['text'])){} //check whether it is null 
    
    // For loop to loop through each character of a string
    for($i = 0; $i < strlen($str); $i++){ }


    // Do While Loop (Means will do once first before while)
    $i = 0;
	do{
		$i++;
		echo $i;
    }while ($i < 5);            // output 12345

    // While Loop
    $j = 0;
    $max = 10;
    while ($j < $max){
        $j++;
    } 

    // Constant Variables
    define("CONSTANT1","PHP"); // constant name always uppercase
    echo CONSTANT1; // Will echo PHP
    // const cannot be used under condition but define can 
    //define the constant name can be concatenated 

    // TimeZone
    date_default_timezone_set("Asia/Singapore");

    // Counts the number of times 'whattofind' in string
    substr_count(varaible,'whattofind');

    // Random Number
    $rand = rand(1,100); //  inclusive  ;  rand(100) the min by default is 0

    // Reverse a String
    strrev("Hello World!");

    // Removing spaces
    $string = str_replace(' ', '', $string);

    // Array Search for key
    if (($key = array_search($student, $student_free[$course->weekOfDay][$course->startTime])) !== false){}

    /* Returns no of words */
    str_word_count($str);

# -----------------------------------------------------------------------

# HTML TABLES ?>

    <table>
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
        
<? 

# colspan='2' is for spanning across the columns
# rowspan='2' is for spanning across the rows
// <td colspan = '2'> </td>
// <td rowspan = '2'> </td>


# HTML ?>
<html>
<head></head>
<body>

    <!-- Form -->
    <form method="post" >

        <!-- TextBox -->
        TextBox: <input type="text" name="firstname"><br> 
        TextBox Password: <input type="password" name="password"><br> 

        <!-- Radio Button -->
        Radio Button: <input type="radio" name="gender" id='male' value="male" checked><label for='male'> Male</label> 
        <input type="radio" name="gender" id='female' value="female"><label for='female'> Female</label><br>

        <!-- Check Box -->
        CheckBox:
        <input type="checkbox" value="apple" name="fruit[]" id='apple'><label for="apple">Apple</label><br/>

        <!-- Dropdownlist -->
        DropDownList: <select name='size'>
            <option disabled selected value="">Select your option</option> <!-- For Non select -->
            <option value='1' selected>1</option>
            <option value='2'>2</option>
        </select><br/>

        <!-- Multi Select Dropdownlist -->
        DropDownList: <select name='size' multiple>
            <option disabled selected value="">Select your option</option> <!-- For Non select -->
            <option value='1' selected>1</option>
            <option value='2'>2</option>
        </select><br/>

        <!-- Text Area -->
        <textarea name="comment" rows="2" cols="10">
            No comments!
        </textarea>
        
        <!-- Hidden FIeld -->
        <input type="hidden" name="language" value="english" />

        <!-- Reset Button -->
        <input type="reset" />

        <!-- Submit Button -->
        <input type="submit" value="Submit"><br/>
    </form>

    <!-- Image -->
    <img src='image.jpg'/><br/>

    <!-- Link -->
    <a href='./abc/123.html'>Google</a> <!-- the dot refers to current directory -->
    <a href='../abc/123.html'>Google</a> <!-- the dot refers to parent directory -->
    <a href='/abc/123.html'>Google</a> <!-- a slash at start means from the root (www) -->
    
    <!-- Anchor Tag -->
    <a href='#bottom-section'>Jump to Bottom</a>
    <a id='bottom-section'>Bottom Section</a>

    <!-- List -->
    <!--unordered list -->
    <ul>
        <li>List1</li>
        <li>List2</li>
    </ul><br/>

     <!--Ordered list -->
    <ol>
        <li>Coffee</li>
        <li>Tea</li>
        <li>Milk</li>
    </ol><br/>

</body>


</html>

<?

# PASSING CONTROL ACROSS PAGES
    # -----------------------------------------------------------------------
    # 1. Through submitting a form, through 'action'
        echo "
        <html>
        <body>
            <form action='another.php'>
                <input type='submit'/>
            </form>
        </body>
        </html>";

    # -----------------------------------------------------------------------
    # 2. Through Hyperlinks
        echo "
        <html>
            <body>
                <a href='another.php'>Go to another page</a>
            </body>
        </html>";

    # -----------------------------------------------------------------------
    # 3. Automatic Page Redirection 

        header("Location:index.php>"); // ne space before ':'
        exit;

# -----------------------------------------------------------------------

# PASSING CONTROL ACROSS PAGES
    # -----------------------------------------------------------------------
    # 1. Hidden fields

        echo " <input type='hidden' name='name' value='" . $_POST['name'] . "'/>";

    # -----------------------------------------------------------------------
    # 2. Through URL // GET

    # you need to append it to the back of the url
    # "&" is used to separate values

        # 2.1 for normal variables like username that perhaps you have received from the previous page

            header("Location:index.php?username='" . $_POST['username'] . "'");
            exit;


        # 2.2 for arrays **

            # Eg. $cakes = array( 0=>"strawberry", 1=>"chocolate", 2=>"mango")  
            $string = "";
            foreach ($cakes as $cake){
                $string .= 'cakes[if its a index array, this box is empty; else put the key for assoc array]=' . $cake . '&' ;
            }

            # rtrim is used to trim the extra & from the right side; there is ltrim also i think trim from the beginning
            # this is so you do not have to use the fencepost method when appending stuff

            $string = rtrim($string, '&');
            header("Location:index.php?$string");
            exit;

    # -----------------------------------------------------------------------
    # 3 Using Session **

        # You gotta start or resume the session before calling the session superglobal using session_start()
            session_start(); 


        # Clearing contents of a session

            # useful for errors like after you echo the errors inside, you unset it.
            unset($_SESSION['errors']);
            session_destroy; //clear all the cookies

            # if you have some problems, use CTRL-SHIFT-I to clear your cookies


# -----------------------------------------------------------------------

# PASSWORD HASHING
    
    $username = $_POST["username"];
    $password = $_POST['password'];
    
    # password_hash is a method to hash your passwords
    # PASSWORD_DEFAULT is a default way to hash your passwords

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    # using the DAO you will then register the user into the database
    # usually with his username and hashedpwd

    $dao = new UserDAO();
    $status = $dao->add($username,$hashed);
    if($status){
        echo "Registered successfully";
    }
    else{
        echo "Failed to register";
    }

# -----------------------------------------------------------------------

# CHECKING FOR USER AUTHENTICATON

    $username = $_POST["username"];
    $password = $_POST["password"];
    $dao = new UserDAO();
    $hashed = $dao->getHashedPassword($username); # this depends on the method in the DAO to get the hashedpwd; may not be the same

    # password_verify is a method to verify a given password and the hashedpwd
    $status = password_verify($password,$hashed);
    if($status){
        echo "Successful Login";
    }
    else{

        # Initialize a session or resume an existing one 
        session_start();

        # Put the error message to $_SESSION
        
        $_SESSION['error'] = "Failed Login";

        # Redirect to login page and append the user name to the URL

        header("Location:login.php/?username=$username");
        exit;
    
}
# -----------------------------------------------------------------------

# USING SESSION TO PROTECT YOUR PAGES

    # THIS CODE SHOULD BE IN THE PROCESSING OF THE LOGIN PAGE
    $username = $_POST["username"];
    $password = $_POST["password"];
    $dao = new UserDAO();
    $hashed = $dao->getHashedPassword($username);
    $status = password_verify($password,$hashed);

    # ONCE USER AUTHENTICATED 
    if($status){
        session_start();
        
        # YOU PUT A USER INTO SESSION FOR CHECKING LATER IN OTHER PAGES
        $_SESSION["user"] = $username; 
        echo "Successful Login";
    }
    else{
        echo "Failed Login";
    }

    # -----------------------------------------------------------------------
    # FOR EVERY PAGE THAT NEEDS PROTECTION; PUT THIS CODE 

    session_start();

    // No session variable "user" => no login
    if ( !isset($_SESSION["user"]) ) {
        
        // redirect to login page
        header("Location: login.php"); 
        
        // stop all further execution 
        // (if there are statements below)
        exit;
    }

    # -----------------------------------------------------------------------
    # TO AVOID REPEATING CODE, PUT THE ABOVE ^ CODE IN A protect.php
    # in the pages that need protecting

    require_once "protect.php";

# -----------------------------------------------------------------------

# Login page with repopulated username through GET if login fails ?>

<!DOCTYPE html>
<html>
    <body>  
        <form action='process_login.php' method='POST'>

             Username 
            <?php
                # If login fails, repopulate the username text field 
                # with the user name that was entered before
                $value = "";
                if (isset($_GET['username'])){
                    $value = "value='" . $_GET["username"] . "'";
                }
            
            echo "<input type=\"text\" name=\"username\" $value/><br/>";
            ?>
            Password <input type="password" name="password"/><br/>
            <input type="submit" value="Login"/>
        </form>
    </body>
</html>

<?
# -----------------------------------------------------------------------
# INTERACTING WITH A DATABASE

# Different bindParam 

/*  PDO::PARAM_BOOL -> Boolean type
    PDO::PARAM_STR  -> SQL char, varchar or other string data type 
    PDO::PARAM_INT  -> SQL integer 
    PDO::PARAM_NULL -> SQL null
    PDO::PARAM_LOB  ->  SQL large object data type */

class BookDAO {

    # Retrieve all books as an array of Book objects
    function retrieveAll() {
        $connMgr = new ConnectionManager();      
        $pdo = $connMgr->getConnection();
        
        $sql = 'SELECT * FROM book';
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new Book($row['title'], $row['isbn13'], $row['price']);
        }
            
        $stmt->closeCursor();
        $pdo = null;
        return $result;
    }
    
    # Retrieve a book with a specific isbn13 number
    function retrieve($isbn13) {
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        $sql = 'select title, isbn13, price from book where isbn13=:isbn13';
        
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':isbn13', $isbn13, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = null;
        if($row = $stmt->fetch()) {
            $result = new Book($row['title'], $row['isbn13'], $row['price']);
        }
        
        $stmt->closeCursor();
        $pdo = null;
        return $result;
    }
  
    # Add a book into the database
    # Return TRUE if the operation is successful, or
    # FALSE otherwise
    public function add($book) {
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        $sql = 'insert into book (title, isbn13, price) values (:title, :isbn13, :price)';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $book->title, PDO::PARAM_STR);
        $stmt->bindParam(':isbn13', $book->isbn13, PDO::PARAM_STR);
        $stmt->bindParam(':price', $book->price, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        
        
        $stmt->closeCursor();
        $pdo = null;
        
        return $isSuccess;
    }

    // $hobbies is array of Hobby objects
        // Given username & an array of Hobby objects
        // Insert all his/her hobbies into USER_HOBBY table
        // Return TRUE if insertion is successful
        // Return FALSE if insertion is unsuccessful
        function addAll($username, $hobbies) {
 
             $conn = new ConnectionManager();
             $pdo = $conn->getConnection();
 
             foreach ($hobbies as $hobby){
                 $hobbyObject = $this->get($hobby);
                 $hobby_id = $hobbyObject->id;
                 $sql = "insert into user_hobby (username, hobby_id) values (:username, :hobby_id)";
                 $stmt = $pdo->prepare($sql);
                 $stmt->setFetchMode(PDO::FETCH_ASSOC);
                 $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                 $stmt->bindParam(':hobby_id', $hobby_id, PDO::PARAM_INT);
                 if (!$stmt->execute()){
                     return false;
                 }
             }
             $stmt->closeCursor();
             $pdo = null;
 
             return true;
         }
    
    # Modify a book record in the database
    public function modify($book) {
        $connMgr = new ConnectionManager();           
        $pdo = $connMgr->getConnection();
        
        $sql = 'update book set title=:title, price=:price where isbn13=:isbn13';      
        
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $book->title, PDO::PARAM_STR);
        $stmt->bindParam(':isbn13', $book->isbn13, PDO::PARAM_STR);
        $stmt->bindParam(':price', $book->price, PDO::PARAM_INT);
        
        $stmt->execute();
        $stmt->closeCursor();
        $pdo = null;
    }
    
    # Delete a book with a given isbn13 number
    public function remove($isbn13) {
        $connMgr = new ConnectionManager();           
        $pdo = $connMgr->getConnection();
        $sql = 'delete from book where isbn13=:isbn13';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':isbn13', $book->isbn13, PDO::PARAM_STR);

        $stmt->execute();
        $stmt->closeCursor();
        $pdo = null;
    }
}


# INI FILE

class ConnectionManager {

    public function getConnection() {
      // store the ini file outside of www folder
      $conf = parse_ini_file($_SERVER["DOCUMENT_ROOT"] ."/../private/database.ini"); 
      $dsn="mysql:host={$conf['host']};" . "dbname={$conf['dbname']}";    
      return new PDO($dsn,$conf['username'],$conf['password']);  
    }
   
  }

# Read the ini file and store it in an associative array
# Get the individual value out

    $conf = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/../private/database.ini");
    $dsn = "mysql:host=" . $conf['host'] . ";"."dbname = {$conf['dbname']}";
    $pdo = new PDO($dsn,$conf['username'],$conf['password']);  

# -----------------------------------------------------------------------------------------------
# Goal: Avoid repetition of database connection setup code in many DAOs accessing the same DB

class ConnectionManager {
    public function getConnection() {
      // store the ini file outside of www folder
      $conf = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . 					"/../private/database.ini"); 
      $dsn="mysql:host={$conf['host']};" . 			                 "dbname={$conf['dbname']}";    
      return new PDO($dsn,$conf['username'],$conf['password']);  
    }
  }
  


?>

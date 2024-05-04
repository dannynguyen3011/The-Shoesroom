<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Login">
    <meta name="keywords" content="HTML, PHP">
    <meta name="author" content="The shoesroom">
    <title> Login </title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
    <div id="background">
    <?php
    include_once("includes/bg.inc");
    ?>
    <div id="page">
   <?php
    include_once("includes/navbar.inc");
   ?>
    <?php
    require_once("settings.php");
    require_once("process_function.php");
    session_start();

        echo "<form method='post' action='login.php'>"
            . "<div id='form_comb'>"
            . "<h2>Login</h2>"
            . "<label>Username</label>"
            . "<input type='text' name='username' placeholder='Username'> "  
            . "<label>Password</label>"
            . "<input type='password' name='password' placeholder='Password'>"
            . "<br>" 
            . "<input class='button_1' type='submit' name='submit' value='Login'>" 
            . "<p> Don't have an account yet? <a href='./signup.php' class='button_2'> Register now! </a> </p>"
            . "</div>"
            . "</form>";
            
    //The user has successfully logged in //
    if (isset($_SESSION["username"])) {
	header('location: manage.php');

    }
    //An attempt to log in.//
    if (isset($_POST["username"])) {

        $username = cleanseInput($_POST["username"]);
        $password = cleanseInput($_POST["password"]);

        //Create connection to database//
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) {
            echo "<p> Unable to connect to the database. Please try again later. </p>";
        } else {
            $account_table = "account";

            //Create account table if doesn't exist//
            $create_table_query = "CREATE TABLE IF NOT EXISTS $account_table (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL
                    );";
            $create_table_result = mysqli_query($conn, $create_table_query);
            if (!$create_table_result) {
                echo "<p> Failed to access to table. Please try again later. </p>";
            } else {
                //Check if the username and password pair exists in the table//
                $query = "SELECT * FROM $account_table WHERE username='$username' AND password='$password'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    //Fail to connect//
                    echo "<p> Failed to login. Please try again later. </p>";
                } else {
                    if (mysqli_connect_errno()) {
                        echo "<p> Failed to connect to MySQL </p>" . mysqli_connect_error();
                    }
                    $number_of_rows = mysqli_num_rows($result);

                    if ($number_of_rows > 0) {
                        //Logging in successful//
                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = mysqli_fetch_assoc($result)["email"];
			            header('location: manage.php');
                    } else {
                        //Username doesn't exist//
                        echo "<h2> Incorect username or password. $username </h2>
                              <p> Please try again <a href='./login.php' class='button_2'> here </a>. </p>
                            <p> Or create a new account <a href='./signup.php' class='button_2'> here </a>. </p>";
                    }
                }
            }
            mysqli_close($conn);
        }
    }
    include_once("includes/footer.inc");
    ?>
    </div>
</div>
</body>

</html>
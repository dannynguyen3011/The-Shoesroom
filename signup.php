<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Signup">
    <meta name="keywords" content="HTML, PHP">
    <meta name="author" content="The Shoesroom">
    <title> Sign Up </title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
<div id="background">
    <?php
    include_once("includes/bg.inc")
    ?>
    <div id="page">
    <?php
    include_once("includes/navbar.inc");
    require_once("settings.php");
    require_once("process_function.php");
    ?>
    <div id="form_comb">
        <form novalidate method="post" action="./signup.php">
            <h1 class="form_comb"> Sign Up </h1>
            <p class="form_comb"> <strong> Email </strong> </p>
            <p> <input type="text" class="form_comb" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email address"> </p>
            <p class="form_comb"> <strong> Username </strong> <em> (4-24 lowercase characters) </em> </p>
            <p> <input type="text" class="form_comb" name="username" pattern="[a-z].{4,24}" placeholder="Username"> </p>
            <p class="form_comb"> <strong> Password </strong> <em> (6-18 characters, must have at least one lowercase letter) </em> </p>
            <p> <input type="password" class="form_comb" name="password" pattern="(?=.*[a-z]).{4,18}" placeholder="Password"> </p>
            <p> <input type="submit" class="button_1" name="submit" value="Register"> </p>
        </form>
        <p> Already have an Account? Login <a href="./login.php" class="button_2"> here </a> </p>
    </div>
    <?php
    if (isset($_POST["username"])) {
        $email = cleanseInput($_POST["email"]);
        $username = cleanseInput($_POST["username"]);
        $password = cleanseInput($_POST["password"]);
        $error_Msg = "";
        if (!preg_match("/\S+@\S+\.\S+/", $email)) {
            $error_Msg .= "<p>Your email must be in the format of username@email_service.com</p>\n";
        }
        if (!preg_match("/^[a-zA-Z0-9]{4,24}$/", $username)) {
            $error_Msg .= "<p>Your username must contains only alphabetical characters and in between 4-24 characters length.</p>\n";
        }
        if (!preg_match("/^[a-zA-Z0-9]{6,18}$/", $password)) {
            $error_Msg .= "<p>Your password must contains only alphabetical characters, number and in between 6-18 characters length.</p>\n";
        }
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) {
            echo "<p> Unable to connect to the database. Please retry !. </p>";
        } else {
            //Create table if needed
            $account_table = "account";
            $create_table_query = "CREATE TABLE IF NOT EXISTS $account_table (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL
                    );";
            //Execute query
            $create_table_result = mysqli_query($conn, $create_table_query);
            if (!$create_table_result) {
                echo "<p> Failed to create the new table. Please retry !. </p>";
            } else {
                //Add username and password to account table
                if ($error_Msg == "") {
                    $query = "INSERT into $account_table (username, password, email) VALUES ('$username', '$password', '$email');";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_connect_errno()) {
                        echo "<p> Failed to connect to MySQL </p>" . mysqli_connect_error();
                    }
                    if ($result) {
                        //Successfully signed up
                        echo "<div>
                                <h2> You are registered successfully. </h2> <br>
                                <p> Click here to <a href='./login.php'> Login </a> </p>
                              </div>";
                    } else {
                        //Errors occurred
                        echo "<div>
                                <h2> Something is wrong with your registration!! </h2> <br>
                                <p> Click here to <a href='./signup.php'> Signup </a> again. </p>
                              </div>";
                    }
                }
                else
                {
                    echo $error_Msg;
                }
                mysqli_close($conn);
            }
        }
    }
    include_once("includes/footer.inc");
    ?>
    </div>
</div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The Shoesroom" />
    <meta name="topic" content="Process order page" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <meta name="description" content="This is the process order page" />
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <title>Enquiry</title>
</head>

<body>
    <?php
    require_once("settings.php");
    require_once("process_function.php");
if(!isset($_SERVER['HTTP_REFERER'])){
	header('location:enquire.php');
	exit;
}
    $error_Msg = "";

    //Data cleansing
    $first_name = cleanseInput($_POST["first_name"]);
    $last_name = cleanseInput($_POST["last_name"]);
    $email = cleanseInput($_POST["email"]);
    $address = cleanseInput($_POST["address"]);
    $postcode = cleanseInput($_POST["postcode"]);
    $phone = cleanseInput($_POST["phone"]);
    $preferred_contact = cleanseInput($_POST["contact"]);
    $product = cleanseInput($_POST["product"]);
    $quantity = cleanseInput($_POST["quantity"]);
    $feature_1 = cleanseInput($_POST["feat_1"]);
    $feature_2 = cleanseInput($_POST["feat_2"]);
    $feature_3 = cleanseInput($_POST["feat_3"]);
    $feature_4 = cleanseInput($_POST["feat_4"]);
    $feature_5 = cleanseInput($_POST["feat_5"]);
    $feature_6 = cleanseInput($_POST["feat_6"]);
    $suburb = cleanseInput($_POST["suburb"]);
    $state = cleanseInput($_POST["state"]);
    $comments = cleanseInput($_POST["comments"]);
    $card_type = cleanseInput($_POST["card_type"]);
    $card_name = cleanseInput($_POST["card_name"]);
    $card_number = cleanseInput($_POST["card_number"]);
    $card_expiry = cleanseInput($_POST["card_expiry"]);
    $card_cvv = cleanseInput($_POST["card_cvv"]);

    //Data validating
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $first_name)) {
        $error_Msg .= "<p class='message-unknown'>
        First name must be from 1-25 characteristic length and only include alphabetical symbols.</p>\n";
    }
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $last_name)) {
        $error_Msg .= "<p class='message-unknown'>
        Last name must be from 1-25 characteristic length and only include alphabetical symbols.</p>\n";
    }
    if (!preg_match("/\S+@\S+\.\S+/", $email)) {
        $error_Msg .= "<p class='message-unknown'> you can only enter the email with the formal email_name@service.com </p>\n";
}
    if (!preg_match("/^[a-zA-Z0-9 ]{1,40}$/", $address)) {
        $error_Msg .= "<p class='message-unknown'>Address must be from 1-40 characteristic length and include alphabetical symbols, numbers and spaces</p>\n";
    }
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $suburb)) {
        $error_Msg .= "<p class='message-unknown'>
        Your suburb must contains only alphabetical characters and in between 1-20 characters length.</p>\n";
    }
    if ($state == "none") {
        $error_Msg .= "<p class='message-unknown'>Please select your state.</p>\n";
    }
    if (!preg_match("/^\d{4}$/", $postcode)) {
        $error_Msg .= "<p class='message-unknown'>postcode must be a 4-digit number.</p>\n";
    }
    if (!preg_match("/^\d{8,12}$/", $phone)) {
        $error_Msg .= "<p class='message-unknown'> </p>\n";
        // Your phone number must contains only numbers and in between 8-12 digits length .
    }
    if ($product == "0") {
        $error_Msg .= "<p class='message-unknown'>Your must choose a product .</p>\n";
    } else {
            if ($product == "Tracker") {
                $cost = 1090*$quantity;
	    }
            if ($product == "Utility") {
                $cost = 1490*$quantity;
	    }
            if ($product == "Vintas") {
                $cost = 720*$quantity;
	    }
            if ($product == "Basas") {
                $cost = 580*$quantity;
	    }
            if ($product == "Urbas") {
                $cost = 580*$quantity;
	    }
            if ($product == "Mule") {
                $cost = 650*$quantity;
	    }
            if ($product == "Blue") {
                $cost = 420*$quantity;
	    }
            if ($product == "Dusty") {
                $cost = 610*$quantity;
	    }
    }
    if (!preg_match("/^\d{1}$/", $quantity)) {
        $error_Msg .= "<p class='message-unknown'>Your quantity must be a 1-digit number.</p>\n";
    }
    $features = "";
    if ($feature_1 != "") {
	$features .= "Size  ";
    }
    if ($feature_2 != "") {
	$features .= "Color ";
    }

    if ($feature_3 != "") {
	$features .= "Origin ";
    }

    if ($feature_4 != "") {
	$features .= "Style ";
    }

    if ($feature_5 != "") {
	$features .= "Combo ";
    }

    if ($feature_6 != "") {
	$features .= "Discount ";
    }
    if ($features == "") {
	$error_Msg .= "<p class='message-unknown'>You must select enquiry features.</p>\n";
    }
    if ($comments == "") {
        $error_Msg .= "<p class='message-unknown'>You must comment something.</p>\n";
    }
    if ($card_type == "none") {                                //if state has not been selected
        $error_Msg .= "<p class='message-unknown'>You must select your card type.</p>\n";
    }
    if ($card_name == "") {
        $error_Msg .= "<p class='message-unknown'>You must enter your name on card.</p>\n";
    } else if (!preg_match("/^[a-zA-Z ]{1,40}$/", $card_name)) {
        $error_Msg .= "<p class='message-unknown'>Card name must contains only alphabetical characters and spaces and cannot exceed 40 characters length.</p>\n";
    }
    if ($card_number == "") {
        $error_Msg .= "<p class='message-unknown'>You must enter your card number.</p>\n";
    } else {
        switch ($card_type) {
            case "visa":
                if ($card_number[0] != "4") {                                                                            //Check if first number is 4
                    $error_Msg .= "<p class='message-unknown'>Visa card number must start with 4.</p>\n";
                } else if (!preg_match("/^\d{16}$/", $card_number)) {                                                    //Check if length is 16 and only contains numbers
                    $error_Msg .= "<p class='message-unknown'>Visa card number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
            case "mastercard":
                if (!($card_number[0] == "5" && ($card_number[1] >= 1 && $card_number[1] <= 5))) {                        //Check if first 2 numbers are 51->55
                    $error_Msg .= "<p class='message-unknown'>MasterCard must start with digits \"51\" through to \"55\".</p>\n";
                } else if (!preg_match("/^\d{16}$/", $card_number)) {                                                    //Check if length is 16 and only contains numbers
                    $error_Msg .= "<p class='message-unknown'>MasterCard number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
            case "amex":
                if (!($card_number[0] == "3" && ($card_number[1] == "4" || $card_number[1] == "7"))) {                    //Check if first 2 numbers are 34 or 37
                    $errMsg .= "<p class='align-center'>American Express must start with \"34\" or \"37\".</p>\n";
                } else if (!preg_match("/^\d{15}$/", $card_number)) {                                                            //Check if length is 15 and only contains numbers
                    $errMsg .= "<p class='align-center'>MasterCard number must be 15 digits and contains numbers only.</p>\n";
                }
                break;
        }
    }
    if ($card_expiry == "") {
        $error_Msg .= "<p class='message-unknown'>Card expiry date cannot be left blank.</p>\n";
    } else if (!preg_match("/^\d{2}\/\d{2}$/", $card_expiry)) {        //Check if expiry date is in the right format
        $error_Msg .= "<p class='message-unknown'>Expiry should be in the format of mm/yy.</p>\n";
    } else {
        $date = explode("/", $card_expiry);
        $month = $date[0];
        $year = $date[1];

        //Check if card is expired or not
        $expires = \DateTime::createFromFormat('my', $month . $year);
        $now = new \DateTime();
        if ($expires < $now) {
            $error_Msg .= "<p class='message-unknown'>Card is expired.</p>\n";
        }
    }
    if ($card_cvv == "") {
        $error_Msg .= "<p class='message-unknown'>Card CVV cannot be left blank.</p>\n";        //Check if CVV is left empty
    } else if (!preg_match("/^\d{3}$/", $card_cvv)) {
        $error_Msg .= "<p class='message-unknown'>CVV must be a 3-digit number.</p>\n";        //check if CVV is a 3-digit number
    }

    //Invalid data case
    if ($error_Msg != "") {
        session_start();
        $_SESSION["error_Msg"] = $error_Msg;
        //Pass message and data to fix order page
        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["email"] = $email;
        $_SESSION["address"] = $address;
        $_SESSION["suburb"] = $suburb;
        $_SESSION["state"] = $state;
        $_SESSION["postcode"] = $postcode;
        $_SESSION["phone"] = $phone;
        $_SESSION["product"] = $product;
        $_SESSION["quantity"] = $quantity;
        $_SESSION["preferred_contact"] = $preferred_contact;
        $_SESSION["features"] = $features;
        $_SESSION["comments"] = $comments;
        $_SESSION["card_type"] = $card_type;
        $_SESSION["card_name"] = $card_name;
        $_SESSION["card_number"] = $card_number;
        $_SESSION["card_expiry"] = $card_expiry;
        $_SESSION["card_cvv"] = $card_cvv;
        header("location:fix_order.php");
        exit();
    }

    //Valid data case
    $confirm_Msg = "";
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($conn) {
        $sql_table = "orders";
        //Create table if it doesn't initialized
        $create_table = "CREATE TABLE IF NOT EXISTS $sql_table (
	                            order_id INT AUTO_INCREMENT PRIMARY KEY,
	                            first_name VARCHAR(25) NOT NULL,
	                            last_name VARCHAR(25) NOT NULL,
	                            email VARCHAR(50) NOT NULL,
	                            street VARCHAR(40) NOT NULL,
	                            suburb VARCHAR(20) NOT NULL,
	                            state VARCHAR(3) NOT NULL,
	                            postcode VARCHAR(4) NOT NULL,
	                            phone VARCHAR(15) NOT NULL,
	                            contact VARCHAR(10) NOT NULL,
	                            enquiry VARCHAR(20) NOT NULL,
	                            features VARCHAR(40),
	                            comment VARCHAR(200),
	                            card_type VARCHAR(20) NOT NULL,
	                            card_name VARCHAR(20) NOT NULL,
	                            card_number VARCHAR(20) NOT NULL,
	                            card_expiry VARCHAR(20) NOT NULL,
	                            card_CVV INT NOT NULL,
                                order_cost INT NOT NULL,
	                            order_date DATETIME NOT NULL,
                                order_status VARCHAR(10) NOT NULL
	                            );";
        $result = mysqli_query($conn, $create_table);
        //Execute the query
        if ($result) {
            $order_date = date('Y-m-d H:i:s');
            $add_order = "INSERT INTO orders
	        	(first_name, last_name, email, street, suburb, state, postcode, phone, contact, enquiry, features, comment,
                card_type, card_name, card_number, card_expiry, card_CVV, order_cost, order_date, order_status)
	        	VALUES ('$first_name', '$last_name', '$email', '$address', '$suburb', '$state', '$postcode', '$phone', '$preferred_contact', '$product',
	        	'$features', '$comments', '$card_type', '$card_name', '$card_number', '$card_expiry', '$cardCVV', '$cost', '$order_date', 'PENDING');";
            $execute = mysqli_query($conn, $add_order);

            if ($execute) {
                session_start();
                //Pass information to receipt page
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
                $_SESSION["email"] = $email;
                $_SESSION["address"] = $address;
                $_SESSION["suburb"] = $suburb;
                $_SESSION["state"] = $state;
                $_SESSION["postcode"] = $postcode;
                $_SESSION["phone"] = $phone;
                $_SESSION["product"] = $product;
                $_SESSION["quantity"] = $quantity;
                $_SESSION["preferred_contact"] = $preferred_contact;
                $_SESSION["features"] = $features;
		        $_SESSION["order_cost"] = $cost;
                $_SESSION["card_type"] = $card_type;
                $_SESSION["card_name"] = $card_name;
                $_SESSION["card_number"] = $card_number;
                $_SESSION["card_expiry"] = $card_expiry;
                $_SESSION["card_cvv"] = $card_cvv;
                header("location:receipt.php?message=$confirm_Msg");
                exit();
            } else {
                $confirm_Msg = "<p>Failed to add order. Please try again later.</p>";
            }
        } else {
            $confirm_Msg = "<p>Failed to create table. Please try again later.</p>";
        }
        mysqli_close($conn);
    } else {
        $confirm_Msg = "<p>Unable to connect to the database. Please try again later.</p>";
    }
    //Navigate to receipt page
    header("location:receipt.php?message=$confirm_Msg");

    ?>
</body>

</html>
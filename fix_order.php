<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The shoesroom" />
    <meta name="topic" content="Process order page" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <meta name="description" content="This is the process order page" />
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <title>Fix order</title>
</head>

<body>
<div id="background">
    <?php
    include_once("includes/bg.inc")
    ?>
    <div id="page">
    <?php
    include_once("includes/navbar.inc");
    ?>
    <section >
        <h1 >Customer Enquiry Form</h1>
        <p id="require"><em><strong>You must enter all the required question </strong></em></p>  //*Please fill in all the answer in the form
        <?php
        if(!isset($_SERVER['HTTP_REFERER'])){
            header('location:enquire.php');
            exit;
        }
            session_start();
            //Print error message
        	$error_Msg = $_SESSION["error_Msg"];
            echo $error_Msg;
        ?>
        <form id="form" method="post" novalidate action="process_order.php">
            <fieldset id="form_comb">
                <legend><label for="fname_box">Name</label></legend>
                <div >
                    <input value = "<?php echo $_SESSION["first_name"];?>" type='text' name='first_name' id='fname_box' required='required' maxlength='25' pattern='[A-Za-z]+'>
                    <br>
                    <label  for='fname_box'>First</label>
                </div>
                <div >
                    <input value = "<?php echo $_SESSION["last_name"];?>" type="text" name="last_name" id="lname_box" required="required" maxlength="25" pattern="[A-Za-z]+">
                    <br>
                    <label  for="lname_box">Last</label>
                </div>
                <legend>
                    <label for="email">Email</label>
                </legend>
                <input value = "<?php echo $_SESSION["email"];?>" type="email" name="email" id="email" required="required">
            <br>
            <div>
                    <legend>Address</legend>
                    <label for="address-1">Street Address</label>
                    <input value = "<?php echo $_SESSION["address"];?>" type="text" name="address" id="address-1" required="required" maxlength="40">
                    <br />
                    <label for="suburb">Suburb/Town</label>
                    <input value = "<?php echo $_SESSION["suburb"];?>" type="text" name="suburb" id="suburb" required="required" maxlength="20">
                    <br />
                    <label for="state">State</label>
                    <select name="state" id="state">
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                    <label for="postcode">Postcode</label>
                    <input value = "<?php echo $_SESSION["postcode"];?>" type="text" name="postcode" id="postcode" maxlength="4" size="10" required="required" pattern="[0-9]+">
                    <legend><label for="Phone">Phone number</label></legend>
                    <input value="<?php echo $_SESSION["phone"] ?>" name="phone" id="Phone" type="text" maxlength="10" required="required" pattern="[0-9]+" placeholder="e.g 0123456789">
                    <legend id="pref_contact_legend">Preferred contact</legend>
                    <label class="contact_method">Email
                        <input <?php if ($_SESSION["preferred_contact"] == "Email") {echo "checked";}?> required="required" type="radio" name="contact" value="Email">
                        <span class="checkmark"></span>
                    </label>
                    <label class="contact_method">Post
                        <input <?php if ($_SESSION["preferred_contact"] == "Post") {echo "checked";}?> required="required" type="radio" name="contact" value="Post">
                        <span class="checkmark"></span>
                    </label>
                    <label class="contact_method">Phone
                        <input <?php if ($_SESSION["preferred_contact"] == "Phone") {echo "checked";}?> required="required" type="radio" name="contact" value="Phone">
                        <span class="checkmark"></span>
                    </label>
            </div>
            <br>
                <legend><label for="product">Product</label></legend>
                <select name="product" id="product">
                    <option value="0">Choose an option</option>
                    <option <?php if ($_SESSION["product"] == "Tracker") {echo "selected";}?> value="Tracker">Tracker</option>
                    <option <?php if ($_SESSION["product"] == "Utility") {echo "selected";}?> value="Utility">Utility</option>
                    <option <?php if ($_SESSION["product"] == "Vintas") {echo "selected";}?> value="Vintas">Vintas</option>
                    <option <?php if ($_SESSION["product"] == "Basas") {echo "selected";}?> value="Basas">Basas</option>
                    <option <?php if ($_SESSION["product"] == "Urbas") {echo "selected";}?> value="Urbas">Urbas</option>
                    <option <?php if ($_SESSION["product"] == "Mule") {echo "selected";}?> value="Mule">Mule</option>
                    <option <?php if ($_SESSION["product"] == "Blue") {echo "selected";}?> value="Blue">Blue</option>
                    <option <?php if ($_SESSION["product"] == "Dusty") {echo "selected";}?> value="Dusty">Dusty</option>
                </select>
                <label>Quantity:</label>
                <input  value = "<?php echo $_SESSION["quantity"];?>" type="text" name="quantity" maxlength="2"  required="required" pattern="[0-9]+">
                <legend>Product feature:</legend>
                <label class="choose_feature">Size:
                    <input <?php if (strpos($_SESSION["features"], "Size") !== false) {echo "checked";} ?> type="checkbox" name="feat_1" value="Size">
                    <span class="checksquare"></span>
                </label>
                <label class="choose_feature">Color:
                    <input <?php if (strpos($_SESSION["features"], "Color") !== false) {echo "checked";} ?> type="checkbox" name="feat_2" value="Color">
                    <span class="checksquare"></span>
                </label>
                <label class="choose_feature">Origin:
                    <input <?php if (strpos($_SESSION["features"], "Origin") !== false) {echo "checked";} ?> type="checkbox" name="feat_3" value="Origin">
                    <span class="checksquare"></span>
                </label>
                <label class="choose_feature">Style:
                    <input <?php if (strpos($_SESSION["features"], "Style") !== false) {echo "checked";} ?> type="checkbox" name="feat_4" value="Style">
                    <span class="checksquare"></span>
                </label>
                <label class="choose_feature">Combo:
                    <input <?php if (strpos($_SESSION["features"], "Combo") !== false) {echo "checked";} ?> type="checkbox" name="feat_5" value="Combo">
                    <span class="checksquare"></span>
                </label>
                <label class="choose_feature">Discount:
                    <input <?php if (strpos($_SESSION["features"], "Discount") !== false) {echo "checked";} ?> type="checkbox" name="feat_6" value="Discount">
                    <span class="checksquare"></span>
                </label>
                <legend><label for="comments">Comments:</label></legend>
                <textarea id="comments" name="comments" placeholder="Enter your comments here"><?php echo $_SESSION["comments"];?></textarea>
                <legend><label for="card-type">Payment details:</label></legend>
                <div id="cardtype">
                    <label class="choose_feat" for="card-name-box">Card type:</label>
                <select name="card_type" id="cardtype">
                    <option value="0">Choose an option</option>
                    <option <?php if ($_SESSION["card_type"] == "visa") {echo "selected";}?> value="visa">Visa</option>
                    <option <?php if ($_SESSION["card_type"] == "mastercard") {echo "selected";}?> value="mastercard">Mastercard</option>
                    <option <?php if ($_SESSION["card_type"] == "amex") {echo "selected";}?>value="amex">American Express</option>
                </select>
                </div>
                <div id="cardname">
                    <label class="choose_feat" for="card-name-box">Card owner's name:</label>
                    <input value = "<?php echo $_SESSION["card_name"];?>" type="text" name="card_name" id="card-name-box">
                    <br>
                </div>
                <div id="cardnumber">
                    <label class="choose_feat" for="card-number-box">Card number:</label>
                    <input value = "<?php echo $_SESSION["card_number"];?>" type="text" name="card_number" id="card-number-box">
                    <br>
                </div>
                <div id="cardexpiry">
                    <label class="choose_feat" for="card-expiry-box">Expiry date:</label>
                    <input value = "<?php echo $_SESSION["card_expiry"];?>" type="text" name="card_expiry" id="card-expiry-box">
                    <br>
                </div>
                <div id="cardcvv">
                    <label class="choose_feat" for="card-cvv-box">Card CVV:</label>
                    <input value = "<?php echo $_SESSION["card_cvv"];?>" type="text" name="card_cvv" id="card-cvv-box">
                    <br>
                </div>
                <input class="button_1" type="submit" value="Submit">
                <input class="button_1" type="reset" value="Reset">
            </fieldset>
            <br>
        </form>
    </section>
    <?php
    include_once("includes/footer.inc")
    ?>
    </div>
</div>
</body>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="The shoesroom" />
    <meta name="topic" content="Enquiry page" />
    <meta name="keywords" content="HTML, CSS" />
    <meta name="description" content="This is the enquiry page" />
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <title>Enquiry</title>
</head>

<body>
    <div id="background">
    <?php
    include_once("includes/bg.inc")
    ?>
    <div id="page">
    <?php
    include_once("includes/navbar.inc")
    ?>
    <section id="section1">
        <h1 id="form-heading">Customer Enquire Form</h1>

        <p id="require"><em><strong>All fields are required</strong></em></p>

        <form id="form_comb" method="post" novalidate action="process_order.php">
            <fieldset id="name">
                <legend><label for="fname_box">Name</label></legend>
                <div id="first">
                    <input type="text" name="first_name" id="fname_box" required="required" maxlength="25" pattern="[A-Za-z]+">
                    <br>
                    <label class="name_label" for="fname_box">First</label>
                </div>
                <div id="last">
                    <input type="text" name="last_name" id="lname_box" required="required" maxlength="25" pattern="[A-Za-z]+">
                    <br>
                    <label class="name_label" for="lname_box">Last</label>
                </div>
            </fieldset>


            <fieldset id="email_box">
                <legend>
                    <label for="email">Email</label>
                </legend>
                <input type="email" name="email" id="email" required="required">
            </fieldset>

            <br>

            <div>
                <fieldset id="address">
                    <legend>Address</legend>
                    <label for="address-1">Address</label>
                    <input type="text" name="address" id="address-1" required="required" maxlength="40">
                    <br />
                    <label for="suburb">Suburb/Town</label>
                    <input type="text" name="suburb" id="suburb" required="required" maxlength="20">
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
                    <input type="text" name="postcode" id="postcode" maxlength="4" size="10" required="required" pattern="[0-9]+">
                </fieldset>

                <fieldset id="phone_field">
                    <legend><label for="Phone">Phone number</label></legend>
                    <input name="phone" id="Phone" type="text" maxlength="10" required="required" pattern="[0-9]+" placeholder="Enter your number here:">
                </fieldset>

                <fieldset id="pref_contact">
                    <legend>Preferred contact</legend>

                    <label class="contact_method">Email
                        <input required="required" type="radio" name="contact" value="Email">
                        <span class="checkmark"></span>
                    </label>
                    <label class="contact_method">Post
                        <input required="required" type="radio" name="contact" value="Post">
                        <span class="checkmark"></span>
                    </label>
                    <label class="contact_method">Phone
                        <input required="required" type="radio" name="contact" value="Phone">
                        <span class="checkmark"></span>
                    </label>
                </fieldset>
            </div>

            <br>

            <fieldset id="products">
                <legend><label for="product">Product</label></legend>
                <select name="product" id="product">
                    <option value="">Please choose an option</option>
                    <option value="Tracker">Tracker</option>
                    <option value="Utility">Utility</option>
                    <option value="Vintas">Vintas</option>
                    <option value="Basas">Basas</option>
                    <option value="Urbas">Urbas</option>
                    <option value="Mule">Mule</option>
                    <option value="Blue">Blue</option>
                    <option value="Dusty">Dusty</option>
                </select>
                <label>Quantity:</label>
                <input type="text" name ="quantity" maxlength="2" required="required" pattern="[0-9]+">
            </fieldset> 
            
            <fieldset id="feature_field">
                <legend>Product feature:</legend>

                <label class="choose_feature">Size
                    <input type="checkbox" name="feat_1" value="Size">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Color
                    <input type="checkbox" name="feat_2" value="Color">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Origin
                    <input type="checkbox" name="feat_3" value="Origin">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">Style
                    <input type="checkbox" name="feat_4" value="Style">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">Combo
                    <input type="checkbox" name="feat_5" value="Combo">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">Discount
                    <input type="checkbox" name="feat_6" value="Discount">
                    <span class="checksquare"></span>
                </label>
            </fieldset>

            <fieldset id="comments_field">
                <legend><label for="comments">Comments:</label></legend>
                <textarea id="comments" name="comments" placeholder="Enter your comments here"></textarea>

            </fieldset>

            <fieldset id="card-details">
                <legend><label for="card-type">Payment details:</label></legend>
                <div id="cardtype">
                    <label class="choose_feat" for="card-type">Card type:</label>
                <select name="card_type" id="cardtype">
                    <option value="none">Choose an option</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="amex">American Express</option>
                </select>
                </div>
                <div id="cardname">
                    <label class="choose_feat" for="card-name-box">Card owner name:</label>

                    <input type="text" name="card_name" id="card-name-box">
                    <br>
                </div>
                <div id="cardnumber">
                    <label class="choose_feat" for="card-number-box">Card number:</label>

                    <input type="text" name="card_number" id="card-number-box">
                    <br>
                </div>
                <div id="cardexpiry">
                    <label class="choose_feat" for="card-expiry-box">Expiry date:</label>
                    <input type="text" name="card_expiry" id="card-expiry-box">
                    <br>

                </div>
                <div id="cardcvv">
                    <label class="choose_feat" for="card-cvv-box">Card CVV:</label>
                    <input type="text" name="card_cvv" id="card-cvv-box">
                    <br>
                </div>
            </fieldset>

            <fieldset id="submit">
                <input class="button_1" type="submit" value="Submit">
                <input class ="button_1" type="reset" value="Reset">
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
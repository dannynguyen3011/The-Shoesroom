<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="The Shoesroom">
	<meta name="description" content="manager.php">
	<meta name="keywords" content="manager.php">	
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<title>Manager</title>
</head>

<body>
<div id="background">
    <?php
    include_once("includes/bg.inc")
    ?>
    <div id="page">
	<?php
	$page = "managePage";
	include_once("includes/navbar.inc");
	session_start();
	if (isset($_SESSION["username"])) {
		echo "<a class='button_2' href='logout.php'> Logout </a>";
	}
	else {
		header('location: login.php');
	}
	?>
	<h1 class="query-message">Manage Page</h1>
	<br><br>
	<!-- Sort options -->
	<h2 class="query-message">Search</h2>
	<form method="post" class="manage-form" action="manage.php">
		<fieldset>
			<legend>Search for orders ( you can see all the orders by not entering ) </legend>  
			<!-- //Query for a particular order (leave all blank to display all orders) -->
			<p>
				<label for="firstname">Customer's first name:</label>
				<input type="text" name="firstname" id="firstname">
			</p>
			<p>
				<label for="lastname">Customer's last name:</label>
				<input type="text" name="lastname" id="lastname">
			</p>
			<p>
				<label>Search for particular product:</label>
			</p>
			<p>
				<label for="shoe1">Tracker</label>
				<input type="checkbox" id="shoe1" name="product[]" class="manage_check" value="Tracker">
			</p>
			<p>
				<label for="shoe2">Utility</label>
				<input type="checkbox" id="shoe2" name="product[]" class="manage_check" value="Utility">	
			</p>
			<p>
				<label for="shoe3">Vintas</label>
				<input type="checkbox" id="shoe3" name="product[]" class="manage_check" value="Vintas">
			</p>
			<p>
				<label for="shoe4">Basas</label>
				<input type="checkbox" id="shoe4" name="product[]" class="manage_check" value="Basas">
			</p>
			<p>
				<label for="shoe5">Urbas</label>
				<input type="checkbox" id="shoe5" name="product[]" class="manage_check" value="Urbas">
			</p>
			<p>
				<label for="shoe6">Mule</label>
				<input type="checkbox" id="shoe6" name="product[]" class="manage_check" value="Mule">	
			</p>
			<p>
				<label for="shoe7">Blue</label>
				<input type="checkbox" id="shoe7" name="product[]" class="manage_check" value="Blue">
			</p>
			<p>
				<label for="shoe8">Dusty</label>
				<input type="checkbox" id="shoe8" name="product[]" class="manage_check" value="Dusty">
			</p>
			<p>
				<label> Search for pending orders: </label>  <!-- Query orders that are pending: -->
				<span>
					<label for="pending">Yes</label>
					<input type="radio" id="pending" name="pending" value="yes">
				</span>
				<span>
					<label for="nonepending">No</label>
					<input type="radio" id="nonepending" name="pending" value="no" checked>	
				</span>
			</p>
			<p>
				<label>Search by total cost:</label>
				<!-- Query orders sorted by total cost: -->
				<span>
					<label for="sort">Yes</label>
					<input type="radio" id="sort" name="Arrange" value="yes">
				</span>
				<span>
					<label for="unsort">No</label>
					<input type="radio" id="unsort" name="Arrange" value="no" checked>
				</span> 
			</p>
			<p>
				<label for="sortProcess">Sorting outcomes based on other criterias (choose again to show reverse):</label>
				<select name="sortProcess" id="sort">
					<option value="">Select ...</option>
					<option value="order_id">ID</option>
					<option value="order_date">Date</option>
					<option value="order_status">Status</option>
					<option value="first_name">First Name</option>
					<option value="last_name">Last Name</option>
				</select>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Find" name="Finding">
	</form>

	<?php
	require_once("process_function.php");
	//if Search form was submitted
	if (isset($_POST["Finding"])) {
		$sort = "";
		$condition = "";
		// Sort by cost
		if ($_POST["Arrange"] == "yes")
			$sort = " ORDER BY order_cost";
		// Sort by others criteria
		if (isset($_POST["sortProcess"])) {
			$tag = "";
			//Tag is to recognise sorting order (descending or ascending)
			if (!isset($_SESSION["sortTag"])) {		//tag="ASC" by default
				$tag = "ASC";
				$_SESSION["sortTag"] = $tag;
			} else {
				//Altered sortTag to each other
				if ($_SESSION["sortTag"] == "ASC") {
					$tag = "DESC";
					$_SESSION["sortTag"] = $tag;
				} else {
					$tag = "ASC";
					$_SESSION["sortTag"] = $tag;
				}
			}
			//Different criterias to sort
			if ($_POST["sortProcess"] == "ID") {
				if ($sort != "")
					$sort .= ", id $tag";
				else
					$sort = " ORDER BY order_id $tag";
			}
			if ($_POST["sortProcess"] == "Date") {
				if ($sort != "")
					$sort .= ", date $tag";
				else
					$sort = " ORDER BY order_date $tag";
			}
			if ($_POST["sortProcess"] == "Status") {
				if ($sort != "")
					$sort .= ", status $tag";
				else
					$sort = " ORDER BY order_status $tag";
			}
			if ($_POST["sortProcess"] == "Name") {
				if ($sort != "")
					$sort .= ", firstName $tag";
				else
					$sort = " ORDER BY first_name $tag";
			}
			if ($_POST["sortProcess"] == "Name") {
				if ($sort != "")
					$sort .= ", lastName $tag";
				else
					$sort = " ORDER BY last_name $tag";
			}
		}

		// Searching criteria
		if (isset($_POST["firstname"]) || isset($_POST["lastname"]) || $_POST["pending"] == "yes" || isset($_POST['product'])) {
			$firstname = cleanseInput($_POST["firstname"]);
			$lastname = cleanseInput($_POST["lastname"]);
			$pending = $_POST["pending"];
			require_once('settings.php');		//Create connection to database
			$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//Attempt to connect to database
			if (!$conn) {
				echo "<h2 class='query-message'>Unable to connect to the database.</h2>";
			} else {
				if ($firstname != "") {
					if ($condition != "")
						$condition .= " AND ";
					$condition .= "first_name LIKE '%$firstname%'";
				}
				if ($lastname != "") {
					if ($condition != "")
						$condition .= " AND ";
					$condition .= "last_name LIKE '%$lastname%'";
				}
				if ($pending == "yes") {
					if ($condition != "")
						$condition .= " AND ";
					$condition .= "order_status LIKE 'PENDING'";
				}
				if (isset($_POST['product'])) {
					$productstatus = $_POST["product"];
					$product_index = "";
					if ($condition != "")
						$condition .= " AND (";
					else
						$condition .= " (";
					if (in_array('Tracker', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Tracker%'";
						$product_index .= "Tracker";
					}
					if (in_array('Utility', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Utility%'";
						$product_index .= "Utility";
					}
					if (in_array('Vintas', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Vintas%'";
						$product_index .= "Vintas";
					}
					if (in_array('Basas', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Basas%'";
						$product_index .= "Basas";
					}
					if (in_array('Urbas', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Urbas%'";
						$product_index .= "Urbas";
					}
					if (in_array('Mule', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Mule%'";
						$product_index .= "Mule";
					}
					if (in_array('Blue', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Blue%'";
						$product_index .= "Blue";
					}
					if (in_array('Dusty', $productstatus)) {
						if ($product_index != "")
							$condition .= " OR ";
						$condition .= "enquiry LIKE '%Dusty%'";
						$product_index .= "Dusty";
					}
					$condition .= ")";
				}
			}
		}

		if ($condition != "") {
			$condition = " WHERE " . $condition;
		}
		//Initialize query
		$query = "SELECT * FROM orders" . $condition . $sort . ";";
		$query_result = mysqli_query($conn, $query);			
		if (!$query_result) {
			echo "<h2 class='query-message'>Failed to execute query: ", $query, ".</h2>";
		} else {
			if (mysqli_num_rows($query_result) > 0) {
				echo "<h2 class='query-message'>Search result</h2>";
				echo "<table id='searchResult' class='table-2'>
							<tr>
								<th>Order ID</th>
								<th>Total cost ($)</th>
								<th>Order date</th>
								<th>Order status</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Product</th>  
							</tr>";
				while ($saving = mysqli_fetch_assoc($query_result)) {
					echo "<tr>
								<td>{$saving['order_id']}</td>
								<td>{$saving['order_cost']}</td>
								<td>{$saving['order_date']}</td>
								<td>{$saving['order_status']}</td>
								<td>{$saving['first_name']}</td>
								<td>{$saving['last_name']}</td>
								<td>{$saving['enquiry']}</td>
							  </tr>";
				}
				echo "</table>";
				mysqli_free_result($query_result);
			} else {
				echo "<h2 class='query-message'>No result matches your search criteria</h2>";
				echo "<p class='query-message'>Your query: $query</p>";
			}
		}
		mysqli_close($conn);
	}
	?>
	<br><br><br>
	<!-- Enable manage to modify orders' status -->
	<h2 class="query-message">Update order's status</h2>
	<form method="post" class="manage-form" action="manage.php">
		<fieldset>
			<legend>Update status of an order:</legend>
			<p>
				<label for="ID_update">Order ID:</label>
				<input type="number" name="ID_update" id="ID_update" required="required">
			</p>
			<p>
				<label for="Status">Order status:</label>
				<select name="Status" id="Status" required>
					<option value="">Select Status...</option>
					<option value="PENDING">PENDING</option>
					<option value="FULFILLED">FULFILLED</option>
					<option value="PAID">PAID</option>
					<option value="ARCHIVED">ARCHIVED</option>
				</select>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Update" name="Update">
	</form>

	<?php
	require_once("process_function.php");
	//Update form was submitted
	if (isset($_POST["Update"])) {
		require_once('settings.php');
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//Attempt to connect to database
		if (!$conn) {
			echo "<h2 class='query-message'>Unable to connect to the database.</h2>";  //Unable to connect to the database.
		} else {
			$ID = cleanseInput($_POST["ID_update"]);
			$status = $_POST["Status"];
			$query = "SELECT * from orders WHERE order_id='$ID'";
			$query_result = mysqli_query($conn, $query);
			if ($query_result) {
				if (mysqli_num_rows($query_result) > 0) {
					$query = "UPDATE orders SET order_status='$status' WHERE order_id='$ID'";
					$query_result = mysqli_query($conn, $query);		//Execute the query and store the result
					if (!$query_result) {
						echo "<h2 class='query-message'>Failed to execute query: ", $query, ".</h2>";
					} else {
						echo "<h2 class='query-message'>Order status has been updated.</h2>";
					}
				}
				else {
					//No order with given ID
					echo "<h2 class='query-message'>Can't find order with ID $ID.</h2>";
				}
				mysqli_close($conn);
			}
			else {
				//Query failed
				echo "<h2 class='query-message'>Failed to execute query: ", $query, ".</h2>";
			}
		}
	}
	?>
	<br><br><br>
	<!-- Enable manage to delete pending orders -->
	<h2 class="query-message">Delete PENDING order</h2>
	<form method="post" class="manage-form" action="manage.php">
		<fieldset>
			<legend>Delete PENDING orders :</legend>
			<p>
				<label for="ID_delete">Order ID:</label>
				<input type="number" name="ID_delete" id="ID_delete" required="required">
			</p>
		</fieldset>
		<input class="button" type="submit" value="Delete" name="Delete">
	</form>

	<?php
	require_once("process_function.php");
	//if delete form was submitted
	if (isset($_POST["Delete"])) {
		require_once('settings.php');
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//Attempt to connect to database
		if (!$conn) {
			echo "<h2 class='query-message'>Unable to connect to the database.</h2>";
		} else {
			$ID = cleanseInput($_POST["ID_delete"]);
			$query = "SELECT order_status FROM orders WHERE order_id='$ID'";
			$query_result = mysqli_query($conn, $query);		//Execute the query and store the result into result pointer
			if (!$query_result) {
				echo "<h2 class='query-message'>Failed to execute query: ", $query, ".</h2>";
			} else {
				//No order with the given ID
				$saving = mysqli_fetch_assoc($query_result);
				if (mysqli_num_rows($query_result) == 0 ) {
					echo "<h2 class='query-message'>Can't find order with ID $ID</h2>";
				}
				//Order status not Pending
				else if ($saving["order_status"] != "PENDING") {
					echo "<h2 class='query-message'>Sorry you cannot delete this order, only existed orders or PENDING orders can be deleted.</h2>";
				} else {
					//Successfully deleted
					$delete = "DELETE FROM orders WHERE order_id='$ID'";
					$process = mysqli_query($conn, $delete);
					if (!$process) {
						echo "<h2 class='query-message'>Failed to execute query: ", $delete, ".</h2>";
					} else {
						echo "<h2 class='query-message'>The order has been deleted.</h2>";
					}
				}
			}
			mysqli_close($conn);
		}
	}
	?>
	<br><br><br>
	<!-- Enhancement -->
	<h2 class="query-message" id="enhancement-1">Advance Report</h2>
	<form method="post" class="manage-form" action="manage.php">
		<fieldset>
			<legend>Extended function</legend>
			<!-- More advanced manage report: -->
			<p>
				<label>Display the favorite products.</label>
				<!-- Show best selling product:  -->
				<span>
					<label for="showBest">Yes</label>
					<input type="radio" id="showBest" name="best" value="yes">
				</span>
				<span>
					<label for="noShowBest">No</label>
					<input type="radio" id="noShowBest" name="best" value="no" checked>
				</span>
			</p>

			<p>
			<label>Display the client with the most luxurious bill: </label>
				<!-- Show customer has the highest bill:  -->
				<span>
					<label for="showPerson">Yes</label>
					<input type="radio" id="showPerson" name="purchase" value="yes">
				</span>
				<span>
					<label for="noShowPerson">No</label>
					<input type="radio" id="noShowPerson" name="purchase" value="no" checked>
				</span>
			</p>

			<p>
				<label>Display the standard revenue per receipt: </label>
				<!-- Show average profit per transaction: -->
				 <span>
					<label for="showAvgProfit">Yes</label>
					<input type="radio" id="showAvgProfit" name="average_profit" value="yes">
				</span>
				<span>
					<label for="noShowAvgProfit">No</label>
					<input type="radio" id="noShowAvgProfit" name="average_profit" value="no" checked>
				</span>
			</p>

			<p>
				<label>Show number of PENDING | FULFILLED | PAID | ARCHIVED orders: </label>
				<span>
					<label for="showStatusNumber">Yes</label>
					<input type="radio" id="showStatusNumber" name="order_status_number" value="yes">
				</span>
				<span>
					<label for="noShowStatusNumber">No</label>
					<input type="radio" id="noShowStatusNumber" name="order_status_number" value="no" checked>
				</span>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Check" name="Advance">
	</form>

	<?php
	//Advance (enhancement form) was submitted
	if (isset($_POST["Advance"])) {
		require_once('settings.php');		//Acquire connection to database
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//connect to database

		if (!$conn) {
			echo "<h2 class='query-message'>Unable to connect to the database.</h2>";
		} else {
			if ($_POST["best"] == "yes" || $_POST["purchase"] == "yes" || $_POST["average_profit"] == "yes" || $_POST["order_status_number"] == "yes") {
				$query = "SELECT * FROM orders";
				$result = mysqli_query($conn, $query);				//execute the query and store the result into result pointer
				if (!$result) {
					echo "<h2 class='query-message'>Failed to execute query: ", $query, ".</h2>";
				} else {
					//Product count
					$TrackerCount = 0;
					$UtilityCount = 0;
					$VintasCount = 0;
					$BasasCount = 0;
					$UrbasCount = 0;
					$MuleCount = 0;
					$BlueCount = 0;
					$DustyCount = 0;

					//Customer with the highest bill
					$customers = array();
					$customerBills = array_fill(0, 100, 0);

					//Average profit variables
					$sum = 0;
					$numberOfOrders = 0;

					//Order status count
					$pendingCount = 0;
					$fulfilledCount = 0;
					$paidCount = 0;
					$archivedCount = 0;

					while ($record = mysqli_fetch_assoc($result)) {					//fetch all the records
						// Best selling product
						if ($_POST["best"] == "yes") {
							if (strpos($record["enquiry"], "Tracker shoe") !== false)		//if Tracker is selected
								$TrackerCount++;
							if (strpos($record["enquiry"], "Utility shoe") !== false)			//if Utility is selected
								$UtilityCount++;
							if (strpos($record["enquiry"], "Vintas shoe") !== false)			//if Vintas is selected
								$VintasCount++;
							if (strpos($record["enquiry"], "Basas shoe") !== false)		//if Basas is selected
								$BasasCount++;
							if (strpos($record["enquiry"], "Urbas shoe") !== false)		//if Urbas is selected
								$UrbasCount++;
							if (strpos($record["enquiry"], "Mule shoe") !== false)		//if Mule is selected
								$MuleCount++;
							if (strpos($record["enquiry"], "Blue shoe") !== false)		//if Blue is selected
								$BlueCount++;
							if (strpos($record["enquiry"], "Dusty shoe") !== false)		//if Dusty is selected
								$DustyCount++;
						}
						// Customer with the highest bill
						if ($_POST["purchase"] == "yes") {
							if (!in_array($record["last_name"], $customers)) {
								$customers[] = $record["last_name"];		//add customer name into array
							}
							$index = array_search($record["last_name"], $customers);
							$customerBills[$index] += $record["order_cost"];
						}
						// Average profit per transaction
						if ($_POST["average_profit"] == "yes") {
							$numberOfOrders++;
							$sum += $record["order_cost"];
						}
						// Order status number
						if ($_POST["order_status_number"] == "yes") {
							if ($record["order_status"] == "PENDING")
								$pendingCount++;
							if ($record["order_status"] == "FULFILLED")
								$fulfilledCount++;
							if ($record["order_status"] == "PAID")
								$paidCount++;
							if ($record["order_status"] == "ARCHIVED")
								$archivedCount++;
						}
					}
					//Display best selling result
					echo "<h2 class='query-message'>Advance report result</h2>";
					if ($_POST["best"] == "yes") {
						$max = $TrackerCount;
						$name = "Tracker";
						if ($UtilityCount > $max) {
							$max = $UtilityCount;
							$name = "Utility";
						}
						if ($VintasCount > $max) {
							$max = $VintasCount;
							$name = "Vintas";
						}
						if ($BasasCount > $max) {
							$max = $BasasCount;
							$name = "Basas";
						}
						if ($UrbasCount > $max) {
							$max = $UrbasCount;
							$name = "Urbas";
						}
						if ($MuleCount > $max) {
							$max = $MuleCount;
							$name = "Mule";
						}
						if ($BlueCount > $max) {
							$max = $BlueCount;
							$name = "Blue";
						}
						if ($DustyCount > $max) {
							$max = $DustyCount;
							$name = "Dusty";
						}
						echo "<p class='query-message'>Best selling product is: $name, purchased by $max customer(s).</p>";
					}

					//Display customer with the highest bill
					if ($_POST["purchase"] == "yes") {
						$max = $customerBills[0];
						$index = 0;
						for ($i = 1; $i < count($customers); $i++) {
							if ($customerBills[$i] > $max) {
								$max = $customerBills[$i];
								$index = $i;
							}
						}
						echo "<p class='query-message'>Customer with the highest bill is: $customers[$index], total amount spent is $max$.</p>";
					}

					//Display average profit
					if ($_POST["average_profit"] == "yes") {
						$avg = $sum / (float)$numberOfOrders;
						echo "<p class='query-message'>The average profit per transaction is: ", number_format((float) $avg, 3, '.', ''), "$.</p>";
					}

					//Display order status number
					if ($_POST["order_status_number"] == "yes") {
						echo "<p class='query-message'>The number of each order status:</p>";
						echo "<p class='query-message'>PENDING: $pendingCount order(s)</p>";
						echo "<p class='query-message'>FULFILLED: $fulfilledCount order(s)</p>";
						echo "<p class='query-message'>PAID: $paidCount order(s)</p>";
						echo "<p class='query-message'>ARCHIVED: $archivedCount order(s)</p>";
					}
				}
			}
			mysqli_close($conn);
		}
	}

	?>

	<?php
	include_once("includes/footer.inc");
	?>
	</div>
</div>
</body>

</html>
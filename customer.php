<!--Project File for UBC CPSC 304
  David (Yu Feng) Guo, Yixue Xu, Brandon Yip, Niloofar Gharavi -->

<!DOCTYPE html>
<html>
  <head>
    <link href="style.php" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,700" rel="stylesheet">
  </head>


<form method="POST" action="customer.php">
<div class="center"><p class="title">ANONYMOUS CUSTOMER</p>
<table id="customerEmail" class="center">
	<tr>
    <td><font size="2">Please Enter Your Email:</font></td>
  </tr>
  <tr>
		<td><input type="text" name="myEmail" size="30"></td>
  </tr>
	<tr>
		<td>
		<input type="submit" value="Show All Purchases" name="showPurchases">
		<input type="submit" value="My Cart" name="showCart">
		<input type="submit" value="Show Customer Info" name="showCustomerInfo">
		</td>
	</tr>
</table>
<table id="customerEmail" class="center">
	<tr>
		<td>
		<input type="submit" value="Show All Tables" name="showAll">
		</td>
	</tr>
</table>
</div>
</form>

<div id="searchQuery">
<p><font size="2">Deliverable 8: a simple query</font></p>
<p> Search for games in the library:</p>
<form method="POST" action="customer.php">
<p>
<input name="newThread" type="button" value="Open Search Engine" 
onclick="window.open('search.php')"/>
</p>
</form>
</div>

<div id="customerCartQuery">
<h3>Shopping Cart Queries</h3>
<p><font size="2">Deliverable 9: a simple query</font></p>
<p> Add a game to shopping cart: </p>
<form method="POST" action="customer.php">
<table>
  <tr>
		<td><font size="2">Customer Email</font></td>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
    <td><input type="text" name="addGameToCartEmail" size="20"></td>
		<td><input type="text" name="addGameToCartGID" size="20"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Add to Cart" name="addGameToCartSubmit"></td>
  </tr>
</table>
</form>

<p> Remove a game from the shopping cart: </p>
<form method="POST" action="customer.php">
<!--refresh page when submit-->

<table>
  <tr>
		<td><font size="2">Customer Email</font></td>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
		<td><input type="text" name="removeGameFromCartEmail" size="20"></td>
    <td><input type="text" name="removeGameFromCartGID" size="20"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Remove From Cart" name="removeGameFromCartSubmit"></td>
  </tr>
</table>
</form>

<p> Clear the shopping cart: </p>
<form method="POST" action="customer.php">
<table>
	<tr>
    <td><font size="2">Customer Email</font></td>
  </tr>
  <tr>
		<td><input type="text" name="clearCartEmail" size="20"></td>
  </tr>
	<tr>
    <td><input type="submit" value="Clear Shopping Cart" name="clearCartSubmit"></td>
  </tr>
</table>
</form>
</div>

<div id="customerPurchaseQuery">
<h3>Purchase Queries</h3>
<p> Purchase a game on the Shopping Cart: </p>
<form method="POST" action="customer.php">
<table>
	<tr>
		<td><font size="2">Customer Email</font></td>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
		<td><input type="text" name="purchaseEmail" size="20"></td>
		<td><input type="text" name="purchaseGID" size="20"></td>
  </tr>
	<tr>
    <td><input type="submit" value="$$$ PURCHASE $$$" name="purchaseSubmit"></td>
  </tr>
</table>
</form>

<p> Delete a game from my purchases: </p>
<form method="POST" action="customer.php">
<table>
	<tr>
		<td><font size="2">Customer Email</font></td>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
		<td><input type="text" name="deletePurchaseEmail" size="20"></td>
		<td><input type="text" name="deletePurchaseGID" size="20"></td>
  </tr>
	<tr>
    <td><input type="submit" value="Delete" name="deleteSubmit"></td>
		<td><font size="2">This cannot be undone!</font></td>
  </tr>
</table>
</form>
</div>

<div id="customerInfoQuery">
<h3>Customer Information Queries</h3>
<p> Update Customer Personal Information: </p>
<form method="POST" action="customer.php">
<table>
	<tr>
    <td><font size="2">Customer Email</font></td>
  </tr>
  <tr>
    <td><input type="text" name="originalEmail" size="20"></td>
  </tr>
	<tr>
    <td><font size="2">New Bank Account Information</font></td>
  </tr>
  <tr>
		<td><input type="text" name="updateBank" size="20"></td>
  </tr>
	<tr>
    <td><input type="submit" value="Update" name="updateCustomerSubmit"></td>
  </tr>
</table>
</form>


</div>

<a href="steam.php">Back to home</a>
</html>

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_n9y0b", "a57734162", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}

function executeBoundSQL($cmdstr, $list) {
	/* Sometimes the same statement will be executed for several times ... only
	 the value of variables need to be changed.
	 In this case, you don't need to create the statement several times; 
	 using bind variables can make the statement be shared and just parsed once.
	 This is also very useful in protecting against SQL injection.  
      See the sample code below for how this functions is used */

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}

}

function printCartResult($result) { //prints results from a select statement
	echo "<center><h2>Shopping Carts</h2></center>";
	echo "<table id=\"cart\">";
	echo "<tr><td>Game ID</td><td>Shopping Cart ID</td></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printPurchasesResult($result) { //prints results from a select statement
	echo "<center><h2>Purchases</h2></center>";
	echo "<table id=\"purchases\">";
	echo "<tr><td>Email</td><td>Game ID</td></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printCustomersResult($result) { //prints results from a select statement
	echo "<center><h2>Customers</h2></center>";
	echo "<table id=\"customers\">";
	echo "<tr><td>Email</td><td>Bank Account</td><td>Shopping Cart ID</td></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table tab1");

		// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table tab1 (nid number, name varchar2(30), gender varchar2(20), primary key (nid))");
		OCICommit($db_conn);

	} else
	if (array_key_exists('showCart', $_POST)) {
	
	//Hardcoded query
	$email = $_POST['myEmail'];
	$result = executePlainSQL("SELECT * FROM ShoppingCarts WHERE Email='".$email."'");
	$sid;
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$sid = $row[0]; // gets the SID
	}
	
	// if ($_POST && $success) {
	// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
	// 	header("location: customer.php");
	// }
		// Select data...
		$result = executePlainSQL("select * from AddRemoveFromCart WHERE SID=".$sid);
		printCartResult($result);


} else if (array_key_exists('showCustomerInfo', $_POST)) {

		$result = executePlainSQL("SELECT * FROM Customers WHERE Email='".$_POST['myEmail']."'");
		printCustomersResult($result);

	}  else if (array_key_exists('showPurchases', $_POST)) {

		$result = executePlainSQL("SELECT * FROM Purchases WHERE Email='".$_POST['myEmail']."'");
		printPurchasesResult($result);

	} else if (array_key_exists('showAll', $_POST)) {

		$result = executePlainSQL("select * from AddRemoveFromCart");
		printCartResult($result);
		$result = executePlainSQL("SELECT * FROM Customers");
		printCustomersResult($result);
		$result = executePlainSQL("SELECT * FROM Purchases");
		printPurchasesResult($result);

	} else if (array_key_exists('addGameToCartSubmit', $_POST)) {
		
		//Hardcoded query
		$email = $_POST['addGameToCartEmail'];
		$result = executePlainSQL("SELECT * FROM ShoppingCarts WHERE Email='".$email."'");
		$sid;
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			$sid = $row[0]; // gets the SID
		}
		
		$tuple = array (
			":bind1" => $_POST['addGameToCartGID'],
			":bind2" => $sid
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("INSERT INTO AddRemoveFromCart
			VALUES (:bind1, :bind2)", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("select * from AddRemoveFromCart WHERE SID=".$sid);
			printCartResult($result);

	} else if (array_key_exists('removeGameFromCartSubmit', $_POST)) {
		
		//Hardcoded query
		$email = $_POST['removeGameFromCartEmail'];
		$result = executePlainSQL("SELECT * FROM ShoppingCarts WHERE Email='".$email."'");
		$sid;
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			$sid = $row[0]; // gets the SID
		}
		
		$tuple = array (
			":bind1" => $_POST['removeGameFromCartGID'],
			":bind2" => $sid
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("DELETE FROM AddRemoveFromCart
			WHERE CGID=:bind1 and SID=:bind2", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("select * from AddRemoveFromCart WHERE SID=".$sid);
			printCartResult($result);

	} else if (array_key_exists('clearCartSubmit', $_POST)) {
		
		//Hardcoded query
		$email = $_POST['clearCartEmail'];
		$result = executePlainSQL("SELECT * FROM ShoppingCarts WHERE Email='".$email."'");
		$sid;
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			$sid = $row[0]; // gets the SID
		}
		
		$tuple = array (
			":bind1" => $sid
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("DELETE FROM AddRemoveFromCart
			WHERE SID=:bind1", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("select * from AddRemoveFromCart WHERE SID=".$sid);
			printCartResult($result);

	} else if (array_key_exists('purchaseSubmit', $_POST)) {
		$email = $_POST['purchaseEmail'];
		$tuple = array (
			":bind1" => $email,
			":bind2" => $_POST['purchaseGID']
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("INSERT INTO Purchases
		VALUES (:bind1, :bind2)", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("SELECT * FROM Purchases WHERE Email='".$email."'");
			printPurchasesResult($result);

	} else if (array_key_exists('deleteSubmit', $_POST)) {
		$email = $_POST['deletePurchaseEmail'];
		$tuple = array (
			":bind1" => $email,
			":bind2" => $_POST['deletePurchaseGID']
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("DELETE FROM Purchases
		WHERE Email=:bind1 and GID=:bind2", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("SELECT * FROM Purchases WHERE Email='".$email."'");
			printPurchasesResult($result);

	} else if (array_key_exists('updateCustomerSubmit', $_POST)) {
		$email = $_POST['originalEmail'];
		$tuple = array (
			":bind1" => $email,
			":bind2" => $_POST['updateBank']
		);
		$alltuples = array (
			$tuple
		);
		executeBoundSQL("UPDATE Customers SET BankAccount=:bind2
			WHERE Email=:bind1", $alltuples);
		OCICommit($db_conn);
		// if ($_POST && $success) {
		// 	//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		// 	header("location: customer.php");
		// }
			// Select data...
			$result = executePlainSQL("SELECT * FROM Customers WHERE Email='".$email."'");
			printCustomersResult($result);

	}
	else
			if (array_key_exists('updatesubmit', $_POST)) {
				// Update tuple using data from user
				$tuple = array (
					":bind1" => $_POST['oldName'],
					":bind2" => $_POST['newName'],
          ":bind3" => $_POST['gender']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("update tab1 set name=:bind2 where name=:bind1 and gender=:bind3", $alltuples);
				OCICommit($db_conn);

			} else
      if (array_key_exists('deletesubmit', $_POST)) {
        // Update tuple using data from user
        $tuple = array (
          ":bind2" => $_POST['deleteName'],
          ":bind3" => $_POST['deleteGender']
        );
        $alltuples = array (
          $tuple
        );
        executeBoundSQL("delete from tab1 where name=:bind2 and gender=:bind3", $alltuples);
        OCICommit($db_conn);

      } else
				if (array_key_exists('dostuff', $_POST)) {
					// Insert data into table...
					executePlainSQL("insert into tab1 values (10, 'Frank', 'Male')");
					// Inserting data into table using bound variables
					$list1 = array (
						":bind1" => 6,
						":bind2" => "All",
            ":bind3" => "Male"
					);
					$list2 = array (
						":bind1" => 7,
						":bind2" => "John",
            ":bind3" => "Male"
					);
					$allrows = array (
						$list1,
						$list2
					);
					executeBoundSQL("insert into tab1 values (:bind1, :bind2, :bind3)", $allrows); //the function takes a list of lists
					// Update data...
					//executePlainSQL("update tab1 set nid=10 where nid=2");
					// Delete data...
					//executePlainSQL("delete from tab1 where nid=1");
					OCICommit($db_conn);
				}


	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}


/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database.
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */
/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode. */
/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>
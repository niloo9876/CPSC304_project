<!--Project File for UBC CPSC 304
  David (Yu Feng) Guo, Yixue Xu, Brandon Yip, Niloofar Gharavi -->

<!DOCTYPE html>
<html>
  <head>
    <link href="style.php" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>

<form method="POST" action="search.php">
<div class="center"><p class="title">SEARCH ENGINE</p>
<p><input type="submit" value="Show all the available games" name="showGames"></p>
</div>
</form>


<!----> 
<div id="searchQuery">
<p>Search for games within a certain genre </p>
<form method="POST" action="search.php">
<p><table>
  <tr>
    <td><font size="2"> Genre</font></td>
  </tr>
  <tr>
   <td>
      <select name="gameGenre">
        <option value="Action-Adventure">Action-Adventure</option>
        <option value="Action">Action</option>
        <option value="Survival Horror">Survival Horror</option>
        <option value="Simulation">Simulation</option>
        <option value="Strategy">Strategy</option>
        <option value="Role-Playing">Role-Playing</option>
        <option value="Sports">Sports</option>
        <option value="Adventure">Adventure</option>
      </select>
    </td>
  </tr>
  <tr>
    <td><input type="submit" value="Search" name="genreSearch"></td>
  </tr>
</table></p>
</form>

<!----> 
<p>Search for games released by certain developers</p>
<form method="POST" action="search.php">
<p><table>
  <tr>
    <td><font size="2"> Developer's name</font></td>
  </tr>
  <tr>
    <td><input type="text" name="devName" size="10"></td>
  </tr>
  <tr>
      <td><input type="submit" value="Search" name="devSearch"><td>
  </tr>  
  </table></p>
</form>

<!----> 
<p>Search for games released between a given date range</p>
<form method="POST" action="search.php">
<p><table>
  <tr>
    <td><font size="2"> From date</font></td>
    <td><font size="2"> To date</font></td>
  </tr>
  <tr>
    <td><input type="date" name="fromD" size="10"></td>
    <td><input type="date" name="toD" size="10"></td>
  </tr>
  <tr>
      <td><input type="submit" value="Search" name="dateSearch"></td>
  </tr>
  </table></p>
</form>

<p>Search for games released between a given price range</p>
<form method="POST" action="search.php">
<p><table>
  <tr>
    <td><font size="2"> From price</font></td>
    <td><font size="2"> To price</font></td>
  </tr>
  <tr>
    <td><input type="input" name="fromP" size="10"></td>
    <td><input type="input" name="toP" size="10"></td>
  </tr>
  <tr>
      <td><input type="submit" value="Search" name="priceSearch"></td>
  </tr>
  </table></p>
</form>

<p>Search for games on sale</p>
<form method="POST" action="search.php">
<p><table>
  <tr>
      <td><input type="submit" value="On Sale Search" name="saleSearch"></td>
  </tr>
  </table></p>
</form>

<p>Apply All Filters</p>
<form method="POST" action="search.php">
<p><table>
<tr>
    <td><font size="2"> Genre</font></td>
  </tr>
  <tr>
   <td>
      <select name="dgameGenre">
        <option value="Action-Adventure">Action-Adventure</option>
        <option value="Action">Action</option>
        <option value="Survival Horror">Survival Horror</option>
        <option value="Simulation">Simulation</option>
        <option value="Strategy">Strategy</option>
        <option value="Role-Playing">Role-Playing</option>
        <option value="Sports">Sports</option>
        <option value="Adventure">Adventure</option>
      </select>
    </td>
  </tr>
  <tr>
    <td><font size="2"> Developer's name</font></td>
  </tr>
  <tr>
    <td><input type="text" name="ddevName" size="10"></td>
  </tr>
  <tr>
    <td><font size="2"> From date</font></td>
    <td><font size="2"> To date</font></td>
  </tr>
  <tr>
    <td><input type="date" name="dfromD" size="10"></td>
    <td><input type="date" name="dtoD" size="10"></td>
  </tr>
  <tr>
    <td><font size="2"> From price</font></td>
    <td><font size="2"> To price</font></td>
  </tr>
  <tr>
    <td><input type="input" name="dfromP" size="10"></td>
    <td><input type="input" name="dtoP" size="10"></td>
  </tr>
  <tr>
      <td><input type="submit" value="Search" name="detailedSearch"></td>
  </tr>
  </table></p>
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
  return $statement;
}

function printResult($result) { //prints results from a select statement
	echo "<center><h2>Found games that match your search</h2></center>";
	echo "<table class=\"results\">";
	echo "<tr><td>Game ID</td><td>Name</td><td>Genre</td><td>Price</td><td>ReleaseDate</td><td>DevName</td></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[2] . "</td><td>" . $row[1] . "</td><td>" . $row[0] . "</td><td>" . "$" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td></tr>"; 
	}
	echo "</table>";

}


// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('genreSearch', $_POST)) {
		// Search the game table for specific genre 
    $result = executePlainSQL("select * from Games where genre='".$_POST['gameGenre']."'");
    printResult($result);
    OCICommit($db_conn);
    
	} else if (array_key_exists('devSearch', $_POST)) {
		// Search the game table for games that are published by the given developer
    $result = executePlainSQL("select * from Games where devName='".$_POST['devName']."'");
    printResult($result);
    OCICommit($db_conn);
    
  } else if (array_key_exists('dateSearch', $_POST)) {
    $result = executePlainSQL("select * from Games where releasedate between '".
                              $_POST['fromD']."' and '".$_POST['toD']."'");
    printResult($result);
    OCICommit($db_conn);
  } else if (array_key_exists('priceSearch', $_POST)) {
    $result = executePlainSQL("select * from Games where price between ".
                              $_POST['fromP']." and ".$_POST['toP']);
    printResult($result);
    OCICommit($db_conn);
  } else if (array_key_exists('saleSearch', $_POST)) {
    $result = executePlainSQL("select * from Games , OnSaleList where Games.GID = OnSaleList.OGID");
    printResult($result);
    OCICommit($db_conn);
  } else if (array_key_exists('detailedSearch', $_POST)) {
    // Search the game table for games that are on sale
    $result = executePlainSQL("select * from Games where genre='".$_POST['dgameGenre']."' and devName='"
                              .$_POST['ddevName']."' and releasedate between '".
                              $_POST['dfromD']."' and '".$_POST['dtoD']."' and price between ".
                              $_POST['dfromP']." and ".$_POST['dtoP']);
    printResult($result);
    OCICommit($db_conn);
  
  } else if(array_key_exists('showGames', $_POST)) {
    $result = executePlainSQL("select * from Games");
    printResult($result);

    //Commit to save changes...
	  OCILogoff($db_conn);
  }
/*
	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: search.php");
	} else {
		// Select data...
		$result = executePlainSQL("select * from Games");
		printResult($result);
	}

	//Commit to save changes...
  OCILogoff($db_conn);
  */
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

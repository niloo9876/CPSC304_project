<!--Project File for UBC CPSC 304
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->



<p>If you wish to reset the table, press the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="developer.php">
   
<p><input type="submit" value="Reset" name="reset"></p>
<p><input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>

<p>(Deliverable 2: INSERT) Add a game into the library:</p>
<form method="POST" action="developer.php">
<p><table>
  <tr>
    <td><font size="2">Game Genre</font></td>
    <td><font size="2">Game Name</font></td>
    <td><font size="2">Game ID</font></td>
    <td><font size="2">Price</font></td>
    <td><font size="2">Release Date</font></td>
    <td><font size="2">Developer Name</font></td>
    <td><font size="2">On-Sale Price</font></td>
    </tr>
  <tr>
    <td>
      <select name="gameGenre">
      <option value="">Action</option>
      <option value="">Survival Horror</option>
      <option value="">Simulation</option>
      <option value="">Strategy</option>
      <option value="">Role-Playing</option>
      <option value="">Sports</option>
      <option value="">Adventure</option>
      </select>
    </td>
    <td><input type="text" name="gameName" size="20"></td>
    <td><input type="text" name="gameID" size="10"></td>
    <td><input type="text" name="gamePrice" size="8"></td>
    <td><input type="text" name="gameReleaseDate" size="15"></td>
    <td><input type="text" name="gameDevName" size="20"></td>
    <td><input type="text" name="gameSalePrice" size="16"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Add Game" name="insertGameSubmit"></td>
  </tr>
</table></p>
</form>

<p> (Deliverable 4: UPDATE) Update an existing game in the library, please provide the existing game ID: </p>
<form method="POST" action="developer.php">
<p><table>
  <tr>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
    <td><input type="text" name="updateGameID" size="12"></td>
  </tr>
  <tr>
    <td><font size="2">Game Genre</font></td>
    <td><font size="2">Game Name</font></td>
    <td><font size="2">Price</font></td>
    <td><font size="2">Developer Name</font></td>
    <td><font size="2">On-Sale Price</font></td>
  </tr>
  <tr>
    <td>
      <select name="updateGameGenre">
      <option value="">Action</option>
      <option value="">Survival Horror</option>
      <option value="">Simulation</option>
      <option value="">Strategy</option>
      <option value="">Role-Playing</option>
      <option value="">Sports</option>
      <option value="">Adventure</option>
      </select>
    </td>
    <td><input type="text" name="updateGameName" size="20"></td>
    <td><input type="text" name="updateGamePrice" size="8"></td>
    <td><input type="text" name="updateGameDevName" size="20"></td>
    <td><input type="text" name="updateGameSalePrice" size="16"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Update Game" name="updateGameSubmit"></td>
  </tr>
</table></p>

</form>

<p> (Deliverable 3: DELETE) Delete a game from the library: </p>
<form method="POST" action="developer.php">
<!--refresh page when submit-->

<p><table>
  <tr>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
    <td><input type="text" name="deleteGameID" size="12"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Delete Game" name="deleteGameSubmit"></td>
  </tr>
</table></p>
</form>

<p> (Deliverable 10: a simple query) Add a game to the OnSaleList: </p>
<form method="POST" action="developer.php">

<p><table>
  <tr>
    <td><font size="2">Game ID</font></td>
    <td><font size="2">Event Index</font></td>
    <td><font size="2">Sale Price</font></td>
    <td><font size="2">Start Date</font></td>
    <td><font size="2">End Date</font></td>
  </tr>
  <tr>
    <td><input type="text" name="addSaleGameID" size="12"></td>
    <td><input type="text" name="addSaleEventIndex" size="12"></td>
    <td><input type="text" name="addSalePrice" size="12"></td>
    <td><input type="text" name="addSaleStart" size="12"></td>
    <td><input type="text" name="addSaleEnd" size="12"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Start Sale" name="addSaleSubmit"></td>
  </tr>
</table></p>
</form>

<p> Update existing games in the OnSaleList: </p>
<form method="POST" action="developer.php">

<p><table>
  <tr>
    <td><font size="2">Event Index</font></td>
  </tr>
  <tr>
    <td><input type="text" name="updateEventIndex" size="12"></td>
  </tr>
  <tr>
    <td><font size="2">Updated Sale Price</font></td>
    <td><font size="2">Updated Sale End Date</font></td>
  </tr>
  <tr>
    <td><input type="text" name="updateSalePrice" size="15"></td>
    <td><input type="text" name="updateSaleEnd" size="15"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Update Sale" name="updateSaleSubmit"></td>
  </tr>
</table></p>
</form>

<p> Delete a game from the OnSaleList: </p>
<form method="POST" action="developer.php">
<!--refresh page when submit-->

<p><table>
<tr>
    <td><font size="2">Event Index</font></td>
  </tr>
  <tr>
    <td><input type="text" name="deleteEventIndex" size="12"></td>
  </tr>
  <tr>
    <td><input type="submit" value="End Sale" name="deleteSaleSubmit"></td>
  </tr>
</table></p>
</form>

<p> Update developer information: </p>
<form method="POST" action="developer.php">

<p><table>
  <tr>
    <td><font size="2">Current Developer Name</font></td>
  </tr>
  <tr>
    <td><input type="text" name="oldDevName" size="30"></td>
  </tr>
  <tr>
    <td><font size="2">New Name</font></td>
    <td><font size="2">New Bank Account Information</font></td>
  </tr>
  <tr>
    <td><input type="text" name="updateDevName" size="30"></td>
    <td><input type="text" name="updateDevBank" size="30"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Update Developer Information" name="updateDevSubmit"></td>
  </tr>
</table></p>
</form>

<a href="steam.php">Back to home</a>

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

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Name</th><th>Gender</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) { // TODO
		// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table tab1");

		// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table tab1 (nid number, name varchar2(30), gender varchar2(20), primary key (nid))");
		OCICommit($db_conn);

	} else
		if (array_key_exists('insertGameSubmit', $_POST)) {
			//Getting the values from user and insert game into the table
			if(isset($_POST['gameGenre']) ) {
				$varGenre = $_POST['gameGenre'];
			}
			$tuple = array (
				":bind1" => $varGenre,
				":bind2" => $_POST['gameName'],
        ":bind3" => $_POST['gameID'],
        ":bind4" => $_POST['gamePrice'],
				":bind5" => $_POST['gameReleaseDate'],
        ":bind6" => $_POST['gameDevName'],
        ":bind7" => $_POST['gameSalePrice']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("INSERT INTO Games
      VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
			OCICommit($db_conn);
		} else
			if (array_key_exists('updateGameSubmit', $_POST)) {
        // Update existing game using data from user
        if(isset($_POST['updateGameGenre']) ) {
          $varUpdateGenre = $_POST['updateGameGenre'];
        }
				$tuple = array (
					":bind1" => $varUpdateGenre,
					":bind2" => $_POST['updateGameName'],
          ":bind3" => $_POST['updateGamePrice'],
          ":bind4" => $_POST['updateDevName'],
					":bind5" => $_POST['updateSalePrice'],
          ":bind6" => $_POST['updateGameID']
				);
				$alltuples = array (
					$tuple
        );
        executeBoundSQL("UPDATE Games 
          SET Genre=:bind1, Name=:bind2, Price=:bind3, DName=:bind4, salePrice=:bind5 
          WHERE GID=:bind6", $alltuples);
				OCICommit($db_conn);
			} else
        if (array_key_exists('deleteGameSubmit', $_POST)) {
        // Delete existing game using data from user
        $tuple = array (
          ":bind1" => $_POST['deleteGameID']
        );
        $alltuples = array (
          $tuple
        );
        executeBoundSQL("DELETE FROM Games WHERE GID=:bind1", $alltuples);
        OCICommit($db_conn);
      } else
        if (array_key_exists('addSaleSubmit', $_POST)) {
          // Getting the values from user and insert game into the onSaleList
        $tuple = array (
          ":bind1" => $_POST['addSaleGameID'],
          ":bind2" => $_POST['addSaleEventIndex'],
          ":bind3" => $_POST['addSalePrice'],
          ":bind4" => $_POST['addSaleStart'],
          ":bind5" => $_POST['addSaleEnd']
        );
        $alltuples = array (
          $tuple
        );
        executeBoundSQL("INSERT INTO OnSaleList
        VALUES (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
        OCICommit($db_conn);
      } else
			  if (array_key_exists('updateSaleSubmit', $_POST)) {
        // Update existing entry in OnSaleList using data from user
				$tuple = array (
					":bind1" => $_POST['updateSalePrice'],
					":bind2" => $_POST['updateSaleEnd'],
          ":bind3" => $_POST['updateEventIndex']
				);
				$alltuples = array (
					$tuple
        );
        executeBoundSQL("UPDATE OnSaleList 
          SET SalePrice=:bind1, EndDate=:bind2 
          WHERE EventIndex=:bind3", $alltuples);
				OCICommit($db_conn);
			} else
        if (array_key_exists('deleteSaleSubmit', $_POST)) {
        // Delete entry in OnSaleList using data from user
        $tuple = array (
          ":bind1" => $_POST['deleteEventIndex']
        );
        $alltuples = array (
          $tuple
        );
        executeBoundSQL("DELETE FROM OnSaleList WHERE EventIndex=:bind1", $alltuples);
        OCICommit($db_conn);
      } else
        if (array_key_exists('updateDevSubmit', $_POST)) {
        // Update existing entry in OnSaleList using data from user
        $tuple = array (
          ":bind1" => $_POST['updateDevName'],
          ":bind2" => $_POST['updateDevBank'],
          ":bind3" => $_POST['oldDevName']
        );
        $alltuples = array (
          $tuple
        );
        executeBoundSQL("UPDATE Developers 
          SET Name=:bind1, BankAccount=:bind2 
          WHERE Name=:bind3", $alltuples);
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

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: developer.php");
	} else {
		// Select data...
		$result = executePlainSQL("select * from tab1");
		printResult($result);
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
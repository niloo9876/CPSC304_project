<!--Project File for UBC CPSC 304
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<!DOCTYPE html>
<html>
<head>
    <link href="style.php" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,700" rel="stylesheet">
</head>

<form method="POST" action="member.php">
    <div class="center"><p class="title">REGISTERED MEMBER</p>
        <p><input type="submit" value="Show All Tables" name="dostuff"></p>
    </div>
</form>

<div id="allMemberDivs">
<p>Add another member as friend:</p>

<form method="POST" action="member.php">
<table>
  <tr>
    <td><font size="2">My Email:</font></td>
    <td><font size="2">My friend's Email:</font></td>
    </tr>
  <tr>
    <td><input type="text" name="addFriendMyEmail" size="20"></td>
    <td><input type="text" name="addFriendOtherEmail" size="20"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Add Friend" name="AddFriend"></td>
  </tr>
</table>
</form>
</div>

<div id="allMemberDivs">
<p> Update My Username and Password: </p>
<form method="POST" action="member.php">

    <table>
        <tr>
            <td><font size="2">My Email</font></td>
        </tr>
        <tr>
            <td><input type="text" name="MyEmail" size="30"></td>
        </tr>
        <tr>
            <td><font size="2">New Username</font></td>
            <td><font size="2">New Password</font></td>
        </tr>
        <tr>
            <td><input type="text" name="updateUsername" size="30"></td>
            <td><input type="text" name="updatePassword" size="30"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Update My Information" name="updateMyInformation"></td>
    </tr>
    </table>
</form>
</div>

<div id="allMemberDivs">
<p> Add a game to wishlist by ID: </p>
<form method="POST" action="member.php">
<table>
  <tr>
    <td><font size="2">Game ID</font></td>
  </tr>
  <tr>
    <td><input type="text" name="toWishlistGID" size="12"></td>
  </tr>
  <tr>
    <td><font size="2">Wishlist ID</font></td>
    </tr>
  <tr>
    <td><input type="text" name="toWishListWID" size="20"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Add Game To Wishlist" name="addGameToWishlist"></td>
  </tr>
</table>

</form>

<p> (Deliverable 5: 3 table join query) Search For Currently On Sale Games In My Wishlist: </p>
<form method="POST" action="member.php">
<!--refresh page when submit-->

<table>
  <tr>
    <td><font size="2">My WIshlist ID</font></td>
  </tr>
  <tr>
    <td><input type="text" name="WID" size="12"></td>
  </tr>
  <tr>
    <td><input type="submit" value="Search Games" name="searchOnSaleGamesByWID"></td>
  </tr>
</table>
</form>

<p> (Deliverable 6: 2 table join query) Search For Certain Developer's Game In My Wishlist: </p>
<form method="POST" action="member.php">
    <!--refresh page when submit-->

    <table>
        <tr>
            <td><font size="2">Developer's Name</font></td>
            <td><font size="2">Wishlist ID</font></td>
        </tr>
        <tr>
            <td><input type="text" name="searchDev" size="12"></td>
            <td><input type="text" name="searchWID" size="12"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Search Games" name="searchDevGame"></td>
    </tr>
    </table>
</form>
</div>

<div id="allMemberDivs">
<p><font size="2">Deliverable 11: CREATE VIEW</font></p>
<p> See a list of all developers on the platform: </p>
<form method="POST" action="member.php">
    <!--refresh page when submit-->
    <table>
        <tr>
            <td><input type="submit" value="Search Games" name="devViewSubmit"></td>
        </tr>
    </table>
</form>
</div>


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

function printfriendsresult($result) { //prints results from a select statement
    echo "<center><h2>Friends List</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>MyEmail</td><td>FriendEmail</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";

}

function printmembersresult($result) {
    echo "<center><h2>Members</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>Email</td><td>Username</td><td>Password</td><td>Wid</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function printwishlistsresult($result) { //prints results from a select statement
    echo "<center><h2>Wishlists</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>Game ID</td><td>WIshlist ID</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";

}

function printsearchsalesresult($result) { //prints results from a select statement
    echo "<center><h2>These games in your wishlist is currently onsale</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>Game Name</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";

}

function printsearchdevresult($result, $WID, $devName) { //prints results from a select statement
    echo "<center><h2>These games in your wishlist with ID: ".$WID." are made by ".$devName."</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>Game Name</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";

}

function printDevViewResult($result) {
    echo "<center><h2>A view of all developers</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><th>Developer Name</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td></tr>" ; //or just use "echo $row[0]"
    }
    echo "</table>";
}

function printviewsresult($result) {
    echo "<center><h2>Deliverable 11: A view of All Games by Capcom</h2></center>";
    echo "<table class=\"results\">";
    echo "<tr><td>Game Name</td><td>Developer Name</td></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>" ; //or just use "echo $row[0]"
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
        if (array_key_exists('AddFriend', $_POST)) {
            //Getting the values from user and insert game into the table
            // if(isset($_POST[gameGenre]) ) {
            // 	$varGenre = $_POST[gameGenre];
            // }
            $myEmail = $_POST['addFriendMyEmail'];
            $tuple = array (
                ":bind1" => $_POST['addFriendMyEmail'],
                ":bind2" => $_POST['addFriendOtherEmail']
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("INSERT INTO Friends
                VALUES (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);

            // Select data...
            $result = executePlainSQL("select * from Friends where MyEmail='".$myEmail."'");
            printfriendsresult($result);

            //Commit to save changes...
            OCILogoff($db_conn);
        }

        else
            if (array_key_exists('updateMyInformation', $_POST)) {
                // Update existing game using data from user
                $tuple = array (
                    ":bind1" => $_POST['updateUsername'],
                    ":bind2" => $_POST['updatePassword'],
                    ":bind3" => $_POST['MyEmail']
                );
                $alltuples = array (
                    $tuple
                );
                executeBoundSQL("UPDATE Members 
             SET Username=:bind1, Password=:bind2
             WHERE Email=:bind3", $alltuples);
                OCICommit($db_conn);

                // Select data...
                $result = executePlainSQL("select * from Members where Email='".$_POST['MyEmail']."'");
                printmembersresult($result);
                //Commit to save changes...
                OCILogoff($db_conn);
            }
            else
            if (array_key_exists('addGameToWishlist', $_POST)) {
                // Update existing game using data from user
                $tuple = array (
                    ":bind1" => $_POST['toWishlistGID'],
                    ":bind2" => $_POST['toWishListWID'],
                );
                $alltuples = array (
                    $tuple
                );
                executeBoundSQL("INSERT INTO AddRemoveFromWishlist
         VALUES (:bind1, :bind2)", $alltuples);
                OCICommit($db_conn);


                $result = executePlainSQL("select * from AddRemoveFromWishlist where WID=".$_POST['toWishListWID']);
                printwishlistsresult($result);

                //Commit to save changes...
                OCILogoff($db_conn);
            } else
                if (array_key_exists('searchOnSaleGamesByWID', $_POST)) {
                    //Getting the values from user and insert data into the table
                    $tuple = array(
                        ":bind1" => $_POST['WID']
                    );
                    $alltuples = array(
                        $tuple
                    );
                    $result = executePlainSQL("select name from Games join Addremovefromwishlist
                                  on wgid = gid
                                  join Onsalelist on ogid = wgid
                                  where wid = 1", $alltuples );
                    printsearchsalesresult($result);
                }

                else
                    if (array_key_exists('searchDevGame', $_POST)) {
                        //Getting the values from user and insert data into the table
                        $dev = $_POST['searchDev'];
                        $wid = $_POST['searchWID'];
                        $result = executePlainSQL("select name from Games join Addremovefromwishlist
                                                          on wgid = gid
                                                          where wid = ".$wid." and devname = '".$dev."'");
                        printsearchdevresult($result, $wid, $dev);
                    }
                    else
                    if (array_key_exists('devViewSubmit', $_POST)) {
                        //Getting the values from user and insert data into the table
                        $result = executePlainSQL("select * from devNameOnly");
                        printDevViewResult($result);
                    }

                else
                    if (array_key_exists('dostuff', $_POST)) {

                                        $result = executePlainSQL("select * from Friends");
                                        printfriendsresult($result);
                                        $result = executePlainSQL("select * from Members");
                                        printmembersresult($result);
                                        $result = executePlainSQL("select * from AddRemoveFromWishlist");
                                        printwishlistsresult($result);
                                        $result = executePlainSQL("select * from capcomgame");
                                        printviewsresult($result);

                                        //Commit to save changes...
                                        OCILogoff($db_conn);
                                    }
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
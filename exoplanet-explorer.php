<!-- Test Oracle file for UBC CPSC304
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  Modified by Jason Hall (23-09-20)
  This file shows the very basics of how to execute PHP commands on Oracle.
  Specifically, it will drop a table, create a table, insert values update
  values, and then query for values
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up All OCI commands are
  commands to the Oracle libraries. To get the file to work, you must place it
  somewhere where your Apache server can run it, and you must rename it to have
  a ".php" extension. You must also change the username and password on the
  oci_connect below to be your ORACLE username and password
-->

<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters


// Database access configuration
$config["dbuser"] = "ora_jt3135";		// change "cwl" to your own CWL
$config["dbpassword"] = "a54932769";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
?>

<html>

<head>
	<title>Exoplanet Explorer</title>
</head>

<body>
	<h2>Reset</h2>
	<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

	<form method="POST" action="exoplanet-explorer.php">
		<!-- "action" specifies the file or page that will receive the form data for processing. As with this example, it can be this same file. -->
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
	</form>

	<hr />

	<h2>Insert Values for Exoplanets</h2>
	<form method="POST" action="exoplanet-explorer.php">
		<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
		Name: <input type="text" name="insName"> <br /><br />
		Type: <input type="text" name="insType"> <br /><br />
		Mass: <input type="number" name="insMass"> <br /><br />
		Radius: <input type="number" name="insRadius"> <br /><br />
		Discovery Year: <input type="text" name="insYear" step="1"> <br /><br />
		Light Years from Earth: <input type="number" name="insLight"> <br /><br />
		Orbital Period: <input type="number" name="insOrb"> <br /><br />
		Eccentricity: <input type="number" name="insEcc"> <br /><br />
		Space Agency Name: <input type="text" name="insSpace"> <br /><br />
		Discovery Method: <input type="text" name="insDisc"> <br /><br />

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>

	<hr />

	<h2>Insert Space Agency to delete</h2>
	<form method="POST" action="exoplanet-explorer.php">
		<input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
		Name: <input type="text" name="insName"> <br /><br />

		<input type="submit" value="Submit" name="deleteSubmit"></p>
	</form>

	<hr />

	<h2>Update Researcher Information</h2>
	<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.
		Leave blank if you want to keep the original value. 
	</p>

	<form method="POST" action="exoplanet-explorer.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
		ID: <input type="text" name="ID"> <br /><br />
		Change Name to: <input type="text" name="newName"> <br /><br />
		Change Affiliation to: <input type="text" name="newAffiliation"> <br /><br />
		Change EmailAddress to: <input type="text" name="newEmailAddress"> <br /><br />
		Change SpaceAgencyName to: <input type="text" name="newSpaceAgencyName"> <br /><br />

		<input type="submit" value="Update" name="updateSubmit"></p>
	</form>

	<hr />

	<h2>Select from Exoplanet_DiscoveredAt</h2>
	</p>

	<form method="GET" action="exoplanet-explorer.php">
		<input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
        WHERE: <input type="text" name="Where"> <br><br>

		<input type="submit" value="Submit" name="selectQuerySubmit"></p>
	</form>

	<hr />

	<h2>Join Star_BelongsTo and StellarClass</h2>
	<form method="GET" action="exoplanet-explorer.php">
		<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
		StellarClass for FILTERING: <input type="text" name="StellarClassClass"><br><br>

		<input type="submit" value="Join" name="joinSubmit"></p>
	</form>

	<hr />

	<h2>Display a Table</h2>
	<form method="GET" action="exoplanet-explorer.php">
		<input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
		TableName: <input type="text" name="tableNameForDisplay"> <br><br>
		<input type="submit" value="Submit" name="displayTuples"></p>
	</form>

	<hr />

	<h2>Projection Query</h2>
	<form method="GET" action="exoplanet-explorer.php">
		<input type="hidden" id="projectionRequest" name="projectionRequest">
		TableName: <input type="text" name="tableNameForDisplay" required> <br><br>
		Attributes (comma-separated): <input type="text" name="attributes" required> <br><br>
		<input type="submit" value="Project" name="projectionSubmit"></p>
	</form>

	<!-- <h2>Projection Query</h2>
	<form method="GET" action="exoplanet-explorer.php">
    	Table Name: <input type="text" name="tableName" required>
    	Attributes (comma-separated): <input type="text" name="attributes" required>
    	<input type="submit" value="Project" name="projectionSubmit"></p>
	</form> -->

	<hr />

	</form>
    <h2>Number of Missions for each Space Program (GROUP BY)</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="groupTuplesRequest" name="groupTuplesRequest">
        <input type="submit" name="groupTuples" id="button"></p>
    </form>

	<hr />

	</form>
    <h2>Number of Stellar Classes having more than 2 stars (HAVING)</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="havingTuplesRequest" name="havingTuplesRequest">
        <input type="submit" name="havingTuples" id="button"></p>
    </form>

	<hr />
	
	</form>
	<h2>Division Query</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="divisionTuplesRequest" name="divisionTuplesRequest">
        <input type="submit" name="divisionTuples" id="button"></p>
    </form>

	<hr />

	<?php
	// The following code will be parsed as PHP

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function executePlainSQL($cmdstr)
	{ //takes a plain (no bound variables) SQL command and executes it
		//echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;

		$statement = oci_parse($db_conn, $cmdstr);
		//There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = oci_execute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For oci_execute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		}

		return $statement;
	}

	function executeBoundSQL($cmdstr, $list)
	{
		/* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

		global $db_conn, $success;
		$statement = oci_parse($db_conn, $cmdstr);

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
				oci_bind_by_name($statement, $bind, $val);
				unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
			}

			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

	// function printResult($result)
	// { //prints results from a select statement
	// 	echo "<br>Retrieved data from table demoTable:<br>";
	// 	echo "<table>";
	// 	echo "<tr><th>ID</th><th>Name</th></tr>";

	// 	while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
	// 		echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
	// 	}

	// 	echo "</table>";
	// }

	function printResult($result) {
		// Check if there are rows to display
		if (!oci_fetch($result)) {
			echo "<p>No data found.</p>";
			return;
		}
	
		// Move back to the first row of the result set
		oci_execute($result, OCI_DEFAULT);
	
		// Start table and add header row for column names
		echo "<table border='1'>";
<<<<<<< HEAD
    $ncols = oci_num_fields($result);
    echo "<tr>";
    for ($i = 1; $i <= $ncols; $i++) {
        $colName = oci_field_name($result, $i);
        echo "<th>" . htmlspecialchars($colName ?? '', ENT_QUOTES, 'UTF-8') . "</th>";
    }
    echo "</tr>";

    while ($row = oci_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $item) {
            echo "<td>" . htmlspecialchars($item ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
=======
		$ncols = oci_num_fields($result);
		echo "<tr>";
		for ($i = 1; $i <= $ncols; $i++) {
			$colName = oci_field_name($result, $i);
			echo "<th>" . htmlspecialchars($colName) . "</th>";
		}
		echo "</tr>";
	
		// Add data rows
		while ($row = oci_fetch_assoc($result)) {
			echo "<tr>";
			foreach ($row as $item) {
				echo "<td>" . htmlspecialchars($item) . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";

		print("Success!");
>>>>>>> 30182feed50e609a504137d452250b2237cb64c5
	}
	

	function connectToDB()
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		$db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

		if ($db_conn) {
			debugAlertMessage("Database is Connected");
			return true;
		} else {
			debugAlertMessage("Cannot connect to Database");
			$e = OCI_Error(); // For oci_connect errors pass no handle
			echo htmlentities($e['message']);
			return false;
		}
	}

	function disconnectFromDB()
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}

	function handleUpdateRequest()
	{
		global $db_conn;

		$ID = $_POST['ID'];
        $newName = $_POST['newName'];
        $newAffiliation = $_POST['newAffiliation'];
        $newEmailAddress = $_POST['newEmailAddress'];
        $newSpaceAgencyName = $_POST['newSpaceAgencyName'];

		if(!is_string($ID) || !is_string($newName) || !is_string($newAffiliation) || !is_string($newEmailAddress) || !is_string($newSpaceAgencyName)) {
            echo "Error: All fields must be of type string.";
            return;
        }

		executePlainSQL("UPDATE Researcher_WorksAt SET 
		Name = COALESCE('$newName', Name), 
		Affiliation = COALESCE('$newAffiliation', Affiliation), 
		EmailAddress = COALESCE('$newEmailAddress', EmailAddress), 
		SpaceAgencyName = COALESCE('$newSpaceAgencyName', SpaceAgencyName)
		WHERE ID = '$ID'");

		oci_commit($db_conn);
	}

	function executeFromFile($filename) {
		global $success;
		$success = True; // Assume success unless an error occurs
	
		// Check if the file exists
		if (!file_exists($filename)) {
			echo "File not found: $filename<br>";
			return false;
		}
	
		// Read the SQL file
		$sql = file_get_contents($filename);
		if ($sql === false) {
			echo "Unable to read the file: $filename<br>";
			return false;
		}

		// Split the SQL file into individual SQL statements
		$statements = explode(';', $sql);
		foreach ($statements as $statement) {
			$statement = trim($statement);
			// Skip empty statements (which could appear due to the explode if there's a trailing semicolon)
			if (!empty($statement)) {
				executePlainSQL($statement);
				// Check the global success flag to see if the execution was successful
				if (!$success) {
					echo "An error occurred executing the statement: $statement<br>";
					// If one statement fails, you might decide to stop execution or continue; this example stops
					return false;
				}
			}
		}
		return true;
	}

	function handleResetRequest()
	{
		global $db_conn;
		// // Drop old table
		// executePlainSQL("DROP TABLE demoTable");

		// // Create new table
		// echo "<br> creating new table <br>";
		// executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");

		
		$filename = 'sql_ddl.sql';
		executeFromFile($filename);

		oci_commit($db_conn);

	}

	function handleInsertRequest() {
		global $db_conn;
	
		// Extract POST data
		$name = $_POST['insName'];
		$type = $_POST['insType'];
		$mass = $_POST['insMass'];
		$radius = $_POST['insRadius'];
		$discoveryYear = $_POST['insYear'];
		$lightYears = $_POST['insLight'];
		$orbitalPeriod = $_POST['insOrb'];
		$eccentricity = $_POST['insEcc'];
		$spaceAgencyName = $_POST['insSpace'];
		$discoveryMethod = $_POST['insDisc'];
	
		// Check if the Exoplanet name already exists
		$queryExoplanet = "SELECT Name FROM Exoplanet_DiscoveredAt WHERE Name = :name";
		$stmtCheckExoplanet = oci_parse($db_conn, $queryExoplanet);
		oci_bind_by_name($stmtCheckExoplanet, ':name', $name);
		oci_execute($stmtCheckExoplanet);
	
		if (oci_fetch($stmtCheckExoplanet)) {
			echo "<p>Error: An exoplanet with the name '{$name}' already exists.</p>";
			return; // Stop the function execution if the exoplanet name exists
		}
	
		// Ensure the SpaceAgency exists or insert it
		$querySpaceAgency = "SELECT Name FROM SpaceAgency WHERE Name = :spaceAgencyName";
		$stmt = oci_parse($db_conn, $querySpaceAgency);
		oci_bind_by_name($stmt, ':spaceAgencyName', $spaceAgencyName);
		oci_execute($stmt);
	
		if (!oci_fetch($stmt)) { // If SpaceAgency does not exist, insert it
			$insertSpaceAgency = "INSERT INTO SpaceAgency(Name) VALUES (:spaceAgencyName)";
			$stmtInsertAgency = oci_parse($db_conn, $insertSpaceAgency);
			oci_bind_by_name($stmtInsertAgency, ':spaceAgencyName', $spaceAgencyName);
			oci_execute($stmtInsertAgency);
		}
	
		// Ensure the ExoplanetDimensions exists or insert it
		$queryDimensions = "SELECT * FROM ExoplanetDimensions WHERE Mass = :mass AND Radius = :radius";
		$stmtDimensions = oci_parse($db_conn, $queryDimensions);
		oci_bind_by_name($stmtDimensions, ':mass', $mass);
		oci_bind_by_name($stmtDimensions, ':radius', $radius);
		oci_execute($stmtDimensions);
	
		if (!oci_fetch($stmtDimensions)) { // If ExoplanetDimensions does not exist, insert it
			$insertDimensions = "INSERT INTO ExoplanetDimensions(Mass, Radius) VALUES (:mass, :radius)";
			$stmtInsertDimensions = oci_parse($db_conn, $insertDimensions);
			oci_bind_by_name($stmtInsertDimensions, ':mass', $mass);
			oci_bind_by_name($stmtInsertDimensions, ':radius', $radius);
			oci_execute($stmtInsertDimensions);
		}
	
		// Insert the Exoplanet
		$insertExoplanet = "INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, \"Discovery Year\", \"Light Years from Earth\", \"Orbital Period\", Eccentricity, SpaceAgencyName, \"Discovery Method\") 
							 VALUES (:name, :type, :mass, :radius, :discoveryYear, :lightYears, :orbitalPeriod, :eccentricity, :spaceAgencyName, :discoveryMethod)";
		$stmtExoplanet = oci_parse($db_conn, $insertExoplanet);
		oci_bind_by_name($stmtExoplanet, ':name', $name);
		oci_bind_by_name($stmtExoplanet, ':type', $type);
		oci_bind_by_name($stmtExoplanet, ':mass', $mass);
		oci_bind_by_name($stmtExoplanet, ':radius', $radius);
		oci_bind_by_name($stmtExoplanet, ':discoveryYear', $discoveryYear);
		oci_bind_by_name($stmtExoplanet, ':lightYears', $lightYears);
		oci_bind_by_name($stmtExoplanet, ':orbitalPeriod', $orbitalPeriod);
		oci_bind_by_name($stmtExoplanet, ':eccentricity', $eccentricity);
		oci_bind_by_name($stmtExoplanet, ':spaceAgencyName', $spaceAgencyName);
		oci_bind_by_name($stmtExoplanet, ':discoveryMethod', $discoveryMethod);
		oci_execute($stmtExoplanet);
	
		oci_commit($db_conn);
		echo "<p>Exoplanet '{$name}' successfully inserted.</p>";
	}

	function handleDeleteRequest()
	{
		global $db_conn;

		$SpaceAgencyName = $_POST['insName'];

		$result = executePlainSQL("DELETE FROM SPACEAGENCY WHERE Name ='" . $SpaceAgencyName . "'");
		oci_commit($db_conn);
		displayTable("SpaceAgency");
		displayTable("Exoplanet_DiscoveredAt");
	}

	function handleSelectRequest()
	{
		global $db_conn;

		$whereClause = $_GET['Where'];
		$SelectRequest = "SELECT * FROM Exoplanet_DiscoveredAt";

		if (!empty($whereClause)) {
			$SelectRequest .= " WHERE " . $whereClause;
		}

		$result = executePlainSQL($SelectRequest);
		oci_commit($db_conn);
		printResult($result);
	}

	function handleJoinRequest()
	{
		global $db_conn;

		$stellarClass = $_GET['StellarClassClass'];

		if (!empty($stellarClass)) {
            $whereClause = "WHERE Star_BelongsTo.StellarClassClass = StellarClass.Class AND Star_BelongsTo.StellarClassClass = '" . $stellarClass . "'";
        } else {
            $whereClause = "";
        }

		$result = executePlainSQL("SELECT * FROM Star_BelongsTo, StellarClass " . $whereClause);
		printResult($result);
		// print("hello");
		oci_commit($db_conn);
	}

	function handleCountRequest()
	{
		global $db_conn;

		$result = executePlainSQL("SELECT Count(*) FROM demoTable");

		if (($row = oci_fetch_row($result)) != false) {
			echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
		}
	}

	function handleDisplayRequest()
	{
		// global $db_conn;
		// $result = executePlainSQL("SELECT * FROM demoTable");
		// printResult($result);
		displayTable($_GET["tableNameForDisplay"]);
	}

	function handleProjectionRequest()
	{
		// global $db_conn;
		$attributes = $_GET['attributes'];
		$tableName = $_GET['tableNameForDisplay'];

		$query = "SELECT DISTINCT " . $attributes . " FROM " . $tableName;

		$result = executePlainSQL($query);

		printResult($result);


	}

	function handleGroupRequest()
	{
		global $db_conn;
        $result = executePlainSQL("SELECT SpaceProgramName, COUNT(*) AS NumMissions
		FROM Mission
		GROUP BY SpaceProgramName");
        //print result
	}

	function handleHavingRequest()
	{
		global $db_conn;
        $result = executePlainSQL("SELECT sc.Class, COUNT(*) AS NumStars
		FROM StellarClass sc
		JOIN Star_BelongsTo sb ON sc.Class = sb.StellarClassClass
		GROUP BY sc.Class
		HAVING COUNT(*) > 2");
        printGroupResult($result);
	}

	function handleDivisionRequest()
	{
		global $db_conn;
        $result = executePlainSQL("SELECT sc.Class, COUNT(*) AS NumStars
		FROM StellarClass sc
		JOIN Star_BelongsTo sb ON sc.Class = sb.StellarClassClass
		GROUP BY sc.Class
		HAVING COUNT(*) > 2");
        printGroupResult($result);
	}
	

	function displayTable($tableName)
	{
		// global $db_conn;
		$result = executePlainSQL("SELECT * FROM " . $tableName);
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('resetTablesRequest', $_POST)) {
				handleResetRequest();
			} else if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			} else if (array_key_exists('deleteQueryRequest', $_POST)) {
				handleDeleteRequest();
<<<<<<< HEAD
			} else if (array_key_exists('joinQueryRequest', $_POST)) {
				handleJoinRequest();
			} 
=======
			} else if (array_key_exists('selectQueryRequest', $_POST)) {
				handleSelectRequest();
			}
>>>>>>> 30182feed50e609a504137d452250b2237cb64c5
			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) {
				handleCountRequest();
			} elseif (array_key_exists('displayTuples', $_GET)) {
				handleDisplayRequest();
			} elseif (array_key_exists('projectionSubmit', $_GET)){
				handleProjectionRequest();
			} elseif (array_key_exists('groupTuples', $_GET)){
				handleGroupRequest();
			} elseif (array_key_exists('havingTuples', $_GET)){
				handleHavingRequest();
			} elseif (array_key_exists('divisonTuples', $_GET)){
				handleDivisionRequest();
<<<<<<< HEAD
			} else if (array_key_exists('selectQueryRequest', $_GET)) {
				handleSelectRequest();
=======
			}  else if (array_key_exists('joinQueryRequest', $_GET)) {
				handleJoinRequest();
>>>>>>> 30182feed50e609a504137d452250b2237cb64c5
			} 

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) ) {
		handlePOSTRequest();
<<<<<<< HEAD
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || 
	isset($_GET['selectQuerySubmit'])) {
=======
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || isset($_GET['joinSubmit']) ) {
>>>>>>> 30182feed50e609a504137d452250b2237cb64c5
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
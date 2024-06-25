
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
		Mass: <input type="any" name="insMass"> <br /><br />
		Radius: <input type="any" name="insRadius"> <br /><br />
		Discovery Year: <input type="text" name="insYear" step="1"> <br /><br />
		Light Years from Earth: <input type="any" name="insLight"> <br /><br />
		Orbital Period: <input type="any" name="insOrb"> <br /><br />
		Eccentricity: <input type="any" name="insEcc"> <br /><br />
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

	<hr />

	</form>
    <h2>Number of Missions for each Space Program (GROUP BY)</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="groupTuplesRequest" name="groupTuplesRequest">
        <input type="submit" value = "Submit" name="groupSubmit"></p>
	</form>

	<hr />

	</form>
    <h2>Number of Stellar Classes having more than 2 stars (HAVING)</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="havingTuplesRequest" name="havingTuplesRequest">
        <input type="submit" value = "Submit" name="havingSubmit"></p>
        <input type="submit" value = "Submit" name="havingSubmit"></p>
    </form>

	<hr />


	</form>
    <h2>DIVISION: Find galaxy names of those galaxies that contain all the stars in the dataset</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="divisionRequest" name="divisionRequest">
        <input type="submit" value = "Submit" name="divisionSubmit"></p>
	</form>

	<hr />

	</form>
	<h2>NESTED AGGREGATION: AVERAGE NUMBER OF EXOPLANETS DISCOVERED PER YEAR</h2>
    <h2>DIVISION: Find galaxy names of those galaxies that contain all the stars in the dataset</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="divisionRequest" name="divisionRequest">
        <input type="submit" value = "Submit" name="divisionSubmit"></p>
	</form>

	<hr />

	</form>
	<h2>NESTED AGGREGATION: AVERAGE NUMBER OF EXOPLANETS DISCOVERED PER YEAR</h2>
    <form method="GET" action="exoplanet-explorer.php">
        <input type="hidden" id="nestedRequest" name="nestedRequest">
        <input type="submit" value = "Submit" name="nestedSubmit"></p>
	</form>
        <input type="hidden" id="nestedRequest" name="nestedRequest">
        <input type="submit" value = "Submit" name="nestedSubmit"></p>
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
    	$ncols = oci_num_fields($result);
    	echo "<tr>";
    	for ($i = 1; $i <= $ncols; $i++) {
        	$colName = oci_field_name($result, $i);
        	echo "<th>" . htmlspecialchars($colName ?? '', ENT_QUOTES, 'UTF-8') . "</th>";
    	}
    	echo "</tr>";
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
   		while ($row = oci_fetch_assoc($result)) {
        	echo "<tr>";
        	foreach ($row as $item) {
            	echo "<td>" . htmlspecialchars($item ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
       		}
        	echo "</tr>";
    	}
    	echo "</table>";
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

		displayTable("Researcher_WorksAt");

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

		echo "All tables successfully reset";

		echo "All tables successfully reset";

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

		// Identify the first error condition
    $errorCondition = null;
    if (!isset($name) || trim($name) === '') {
        $errorCondition = 'name';
    } elseif (!isset($mass) || trim($mass) === '') {
        $errorCondition = 'mass';
    } elseif (!isset($radius) || trim($radius) === '') {
        $errorCondition = 'radius';
    } elseif (!isset($spaceAgencyName) || trim($spaceAgencyName) === '') {
        $errorCondition = 'spaceAgencyName';
    }

    // Handle the error condition with a switch statement
    switch ($errorCondition) {
        case 'name':
            echo "<p>Error: Name is required and cannot be null or empty.</p>";
            return; // Stop if name is null or empty
        case 'mass':
            echo "<p>Error: Mass is required and cannot be null or empty.</p>";
            return; // Stop if mass is null or empty
        case 'radius':
            echo "<p>Error: Radius is required and cannot be null or empty.</p>";
            return; // Stop if radius is null or empty
        case 'spaceAgencyName':
            echo "<p>Error: Space Agency Name is required and cannot be null or empty.</p>";
            return; // Stop if space agency name is null or empty
    }

		// Validate input types
    if (!is_string($name) || !is_string($type) || !is_numeric($mass) || !is_numeric($radius) || !is_numeric($discoveryYear) || !is_numeric($lightYears) || !is_numeric($orbitalPeriod) || !is_numeric($eccentricity) || !is_string($spaceAgencyName) || !is_string($discoveryMethod)) {
			echo "<p>Error: Incorrect input types.</p>";
			return; // Stop the function execution if any input type is incorrect
		}

		// Identify the first error condition
    $errorCondition = null;
    if (!isset($name) || trim($name) === '') {
        $errorCondition = 'name';
    } elseif (!isset($mass) || trim($mass) === '') {
        $errorCondition = 'mass';
    } elseif (!isset($radius) || trim($radius) === '') {
        $errorCondition = 'radius';
    } elseif (!isset($spaceAgencyName) || trim($spaceAgencyName) === '') {
        $errorCondition = 'spaceAgencyName';
    }

    // Handle the error condition with a switch statement
    switch ($errorCondition) {
        case 'name':
            echo "<p>Error: Name is required and cannot be null or empty.</p>";
            return; // Stop if name is null or empty
        case 'mass':
            echo "<p>Error: Mass is required and cannot be null or empty.</p>";
            return; // Stop if mass is null or empty
        case 'radius':
            echo "<p>Error: Radius is required and cannot be null or empty.</p>";
            return; // Stop if radius is null or empty
        case 'spaceAgencyName':
            echo "<p>Error: Space Agency Name is required and cannot be null or empty.</p>";
            return; // Stop if space agency name is null or empty
    }

		// Validate input types
    if (!is_string($name) || !is_string($type) || !is_numeric($mass) || !is_numeric($radius) || !is_numeric($discoveryYear) || !is_numeric($lightYears) || !is_numeric($orbitalPeriod) || !is_numeric($eccentricity) || !is_string($spaceAgencyName) || !is_string($discoveryMethod)) {
			echo "<p>Error: Incorrect input types.</p>";
			return; // Stop the function execution if any input type is incorrect
		}
	
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

		displayTable("Exoplanet_DiscoveredAt");

		displayTable("Exoplanet_DiscoveredAt");
	
		oci_commit($db_conn);
		echo "<p>Exoplanet '{$name}' successfully inserted.</p>";
	}

	function handleDeleteRequest()
	{
		global $db_conn;

		$SpaceAgencyName = $_POST['insName'];

		// Ensure input is not empty
		if (!isset($SpaceAgencyName) || trim($SpaceAgencyName) === '') {
			echo "<p>Error: Space Agency Name is required and cannot be null or empty.</p>";
      return; // Stop if space agency name is null or empty
		}

		// Ensure the SpaceAgency exists 
		$querySpaceAgency = "SELECT Name FROM SpaceAgency WHERE Name = :SpaceAgencyName";
		$stmt = oci_parse($db_conn, $querySpaceAgency);
		oci_bind_by_name($stmt, ':SpaceAgencyName', $SpaceAgencyName);
		oci_execute($stmt);

		if (!oci_fetch($stmt)) { // If SpaceAgency does not exist, print error
			echo "<p>Error: There is no space agency to delete with the given name.</p>";
			return;
		}

		// Ensure input is not empty
		if (!isset($SpaceAgencyName) || trim($SpaceAgencyName) === '') {
			echo "<p>Error: Space Agency Name is required and cannot be null or empty.</p>";
      return; // Stop if space agency name is null or empty
		}

		// Ensure the SpaceAgency exists 
		$querySpaceAgency = "SELECT Name FROM SpaceAgency WHERE Name = :SpaceAgencyName";
		$stmt = oci_parse($db_conn, $querySpaceAgency);
		oci_bind_by_name($stmt, ':SpaceAgencyName', $SpaceAgencyName);
		oci_execute($stmt);

		if (!oci_fetch($stmt)) { // If SpaceAgency does not exist, print error
			echo "<p>Error: There is no space agency to delete with the given name.</p>";
			return;
		}

		$result = executePlainSQL("DELETE FROM SPACEAGENCY WHERE Name ='" . $SpaceAgencyName . "'");
		oci_commit($db_conn);
		echo " The space agency '" . $SpaceAgencyName . "' has been removed";
		echo " The space agency '" . $SpaceAgencyName . "' has been removed";
		displayTable("SpaceAgency");
		echo "\n";
		echo "\n";
		displayTable("Exoplanet_DiscoveredAt");
	}

	function handleSelectRequest() {
    global $db_conn;
	function handleSelectRequest() {
    global $db_conn;

    // Retrieve the user input
    $whereClause = $_GET['Where'];

    // Construct the query with the user-provided WHERE clause
    $query = "SELECT * FROM Exoplanet_DiscoveredAt";
    if (!empty($whereClause)) {
        $query .= " WHERE " . $whereClause;
    }

    $stmt = oci_parse($db_conn, $query);

    // Check for parsing errors
    if (!$stmt) {
        echo "<p>Error: Your request could not be executed. Please check your input.</p>";
        return;
    }

    // Attempt to execute the query
    $result = @oci_execute($stmt); // Suppressing error reporting with @

    if (!$result) {
        // If execution fails, print a generic error message
        echo "<p>Error: Your request could not be executed. Please check your input.</p>";
        // Optionally, log the detailed error message for internal review
        $e = oci_error($stmt);
        // error_log("Query execution error: " . $e['message']);
        return; // Early return to stop further execution
    }



    // If execution is successful, proceed to fetch and display the results
    // echo "<table border='1'>";
    // echo "<tr><th>Name</th><th>Type</th><th>Mass</th><th>Radius</th></tr>";
    // while ($row = oci_fetch_assoc($stmt)) {
    //     echo "<tr><td>" . htmlspecialchars($row['NAME']) . "</td>"
    //          . "<td>" . htmlspecialchars($row['TYPE']) . "</td>"
    //          . "<td>" . htmlspecialchars($row['MASS']) . "</td>"
    //          . "<td>" . htmlspecialchars($row['RADIUS']) . "</td></tr>";
    // }
    // echo "</table>";
		echo "Here are the selected observations: ";
		printResult($stmt);
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
		echo "Join successful. Here are the results: ";
		echo "Join successful. Here are the results: ";
		printResult($result);
		// print("hello");
		oci_commit($db_conn);
	}


	function handleDisplayRequest()
	{
		displayTable($_GET["tableNameForDisplay"]);
	}

	function handleProjectionRequest()
{
    global $db_conn;

    $attributes = $_GET['attributes'];
    $tableName = $_GET['tableNameForDisplay'];

		// Check if the table exists before attempting to display its content
    if (!checkTableExists($tableName)) {
			echo "<p>Error: The table '{$tableName}' does not exist.</p>";
			return;
	}

    // Construct the query without regex validation
    $query = "SELECT DISTINCT " . $attributes . " FROM " . $tableName;
    $stmt = oci_parse($db_conn, $query);

    if (!$stmt) {
        echo "<p>Error: Invalid input. Check your attribute names and table name.</p>";
        return;
    }

    // Attempt to execute the query
    if (!@oci_execute($stmt)) {
        $e = oci_error($stmt);
        echo "<p>Error: Invalid input. Check your attribute names and table name.</p>";
        return;
    }

    // If the query executes successfully, print the results
		echo "Projection successful. Here are your results: ";
    printResult($stmt);
}



	function handleGroupRequest()
    {
        $result = executePlainSQL("SELECT SpaceProgramName, COUNT(*) AS NumMissions FROM Mission GROUP BY SpaceProgramName");
		printResult($result);
    }

	function handleHavingRequest()
	{
		$result = executePlainSQL("SELECT sc.Class, COUNT(*) AS NumStars FROM StellarClass sc JOIN Star_BelongsTo sb ON sc.Class = sb.StellarClassClass GROUP BY sc.Class HAVING COUNT(*) >= 2");
        printResult($result);
	}

	function handleDivisionRequest()
	{
		$result = executePlainSQL("SELECT g.Name AS GalaxyName FROM Galaxy g WHERE NOT EXISTS (SELECT s.Name FROM Star_BelongsTo s WHERE NOT EXISTS (SELECT * FROM Star_BelongsTo sb WHERE sb.GalaxyName = g.Name AND sb.Name = s.Name))");
        printResult($result);
	}

	function handleNestedRequest()

	function handleNestedRequest()
	{
        $result = executePlainSQL('SELECT AVG(Exoplanet_discovery_count) FROM (SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year")');
        // $result = executePlainSQL('SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year"'); // intermediate query
        $result = executePlainSQL('SELECT AVG(Exoplanet_discovery_count) FROM (SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year")');
        // $result = executePlainSQL('SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year"'); // intermediate query
		printResult($result);
	}
	

	function displayTable($tableName) {
    global $db_conn;

    // Check if the table exists before attempting to display its content
    if (!checkTableExists($tableName)) {
        echo "<p>Error: The table '{$tableName}' does not exist.</p>";
        return;
    }

    // Proceed with the original logic to display the table
    $query = "SELECT * FROM " . $tableName;
    $stmt = oci_parse($db_conn, $query);
    $r = oci_execute($stmt);

    // Assuming successful execution, proceed to fetch and display the results
		printResult($stmt);
}

function checkTableExists($tableName) {
	global $db_conn;

	// Attempt a query that will fail if the table doesn't exist
	$query = "SELECT 1 FROM " . $tableName . " WHERE ROWNUM = 1";
	$stmt = oci_parse($db_conn, $query);

	if (!$stmt) {
			// If oci_parse fails, it's a bad sign but doesn't necessarily mean the table doesn't exist
			return false;
	}

	// Suppress PHP warnings and attempt to execute the query
	$r = @oci_execute($stmt);

	if (!$r) {
			// If execution fails, check the error code for ORA-00942
			$e = oci_error($stmt);
			if (strpos($e['message'], 'ORA-00942') !== false) {
					// Table does not exist
					return false;
			}
	}

	// If we reach this point, the table exists
	return true;
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
			}
			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('displayTuples', $_GET)) {
			if (array_key_exists('displayTuples', $_GET)) {
				handleDisplayRequest();
			} elseif (array_key_exists('projectionSubmit', $_GET)){
				handleProjectionRequest();
			} elseif (array_key_exists('groupTuplesRequest', $_GET)){
				handleGroupRequest();
			} elseif (array_key_exists('havingTuplesRequest', $_GET)){
				handleHavingRequest();
			} elseif (array_key_exists('divisionRequest', $_GET)){ //divisionSubmit
			} elseif (array_key_exists('divisionRequest', $_GET)){ //divisionSubmit
				handleDivisionRequest();
			} elseif (array_key_exists('nestedRequest', $_GET)){
				handleNestedRequest();
			} elseif (array_key_exists('nestedRequest', $_GET)){
				handleNestedRequest();
			} else if (array_key_exists('selectQueryRequest', $_GET)) {
				handleSelectRequest();
			} else if (array_key_exists('joinQueryRequest', $_GET)) {
			} else if (array_key_exists('joinQueryRequest', $_GET)) {
				handleJoinRequest();
			} 

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) ) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || isset($_GET['groupSubmit']) || isset($_GET['havingSubmit']) || isset($_GET['joinSubmit']) || isset($_GET['selectQuerySubmit']) || isset($_GET['divisionSubmit']) || isset($_GET['nestedSubmit'])) {
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || isset($_GET['groupSubmit']) || isset($_GET['havingSubmit']) || isset($_GET['joinSubmit']) || isset($_GET['selectQuerySubmit']) || isset($_GET['divisionSubmit']) || isset($_GET['nestedSubmit'])) {
        handleGETRequest();
    }

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

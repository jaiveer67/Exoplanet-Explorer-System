
<?php
try {
    $db_conn = new PDO('sqlite:db/exoplanet.db');
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}

// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <form method="GET" action="exoplanet-explorer.php">
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
		$db_conn = new PDO("sqlite:db/exoplanet.db");
		$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
		$db_conn = null; // Close the connection
		debugAlertMessage("Disconnect from Database");
	}

	function executePlainSQL($cmdstr) {
    global $db_conn;
    try {
        return $db_conn->query($cmdstr);
    } catch (PDOException $e) {
        echo "<p>Error executing query: " . htmlspecialchars($e->getMessage()) . "</p>";
        return false;
    }
}

	function executeBoundSQL($cmdstr, $list) {
		global $db_conn;
		try {
			$stmt = $db_conn->prepare($cmdstr);
			foreach ($list as $tuple) {
				$stmt->execute($tuple);
			}
			return true;
		} catch (PDOException $e) {
			echo "<p>Error executing bound SQL: " . htmlspecialchars($e->getMessage()) . "</p>";
			return false;
		}
	}

	function printResult($stmt) {
		if (!$stmt) {
			echo "<p>No results.</p>";
			return;
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (!$rows) {
			echo "<p>No data found.</p>";
			return;
		}
		echo "<table border='1'><tr>";
		foreach (array_keys($rows[0]) as $colName) {
			echo "<th>" . htmlspecialchars($colName, ENT_QUOTES, 'UTF-8') . "</th>";
		}
		echo "</tr>";
		foreach ($rows as $row) {
			echo "<tr>";
			foreach ($row as $item) {
				echo "<td>" . htmlspecialchars($item ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
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
		printResult($result);
	}

	function handleUpdateRequest()
	{
		global $db_conn;

		$id = $_POST['ID'];
		$newName = $_POST['newName'];
		$newAffiliation = $_POST['newAffiliation'];
		$newEmailAddress = $_POST['newEmailAddress'];
		$newSpaceAgencyName = $_POST['newSpaceAgencyName'];

		if (empty($id)) {
			echo "<p>Error: ID cannot be empty.</p>";
			return;
		}

		$setClause = [];
		if (!empty($newName)) {
			$setClause[] = "Name = '" . $newName . "'";
		}
		if (!empty($newAffiliation)) {
			$setClause[] = "Affiliation = '" . $newAffiliation . "'";
		}
		if (!empty($newEmailAddress)) {
			$setClause[] = "EmailAddress = '" . $newEmailAddress . "'";
		}
		if (!empty($newSpaceAgencyName)) {
			$setClause[] = "SpaceAgencyName = '" . $newSpaceAgencyName . "'";
		}

		if (empty($setClause)) {
			echo "<p>Error: No fields to update.</p>";
			return;
		}

		$query = "UPDATE Researcher_WorksAt SET " . implode(", ", $setClause) . " WHERE ID = :id";
		$stmt = $db_conn->prepare($query);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		if (!$stmt->execute()) {
			echo "<p>Error: Invalid input. Check your values.</p>";
			return;
		}
		if (function_exists('displayTable')) {
            displayTable("Researcher_WorksAt");
        }
		echo "<p>Update successful.</p>";
	}

	function handleDeleteRequest()
	{
		global $db_conn;

		$name = $_POST['insName'];

		if (empty($name)) {
			echo "<p>Error: Name cannot be empty.</p>";
			return;
		}

		$query = "DELETE FROM SpaceAgency WHERE Name = :name";
		$stmt = $db_conn->prepare($query);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);

		if (!$stmt->execute()) {
			echo "<p>Error: Invalid input. Check your values.</p>";
			return;
		}

		if (function_exists('displayTable')) {
            displayTable("SpaceAgency");
        }
		echo "<p>Deletion successful.</p>";
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
    $stmt = $db_conn->prepare($query);

    if (!$stmt) {
        echo "<p>Error: Invalid input. Check your attribute names and table name.</p>";
        return;
    }

    // Attempt to execute the query
    if (!@$stmt->execute()) {
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
	{
        $result = executePlainSQL('SELECT AVG(Exoplanet_discovery_count) FROM (SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year")');
        // $result = executePlainSQL('SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year"'); // intermediate query
        $result = executePlainSQL('SELECT AVG(Exoplanet_discovery_count) FROM (SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year")');
        // $result = executePlainSQL('SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count FROM Exoplanet_DiscoveredAt GROUP BY "Discovery Year"'); // intermediate query
		printResult($result);
	}
	

	function displayTable($tableName) {
    global $db_conn;
    if (!checkTableExists($tableName)) {
        echo "<p>Error: The table '{$tableName}' does not exist.</p>";
        return;
    }
    $query = "SELECT * FROM " . $tableName;
    $stmt = $db_conn->prepare($query);
    $stmt->execute();
    printResult($stmt);
}

	function handleSelectRequest() {
		global $db_conn;

		$whereClause = $_GET['Where'];
		if (empty($whereClause)) {
			echo "<p>Error: WHERE clause cannot be empty.</p>";
			return;
		}

		$query = "SELECT * FROM Exoplanet_DiscoveredAt WHERE " . $whereClause;
		$stmt = $db_conn->prepare($query);

		if (!$stmt) {
			echo "<p>Error: Invalid input. Check your WHERE clause.</p>";
			return;
		}

		if (!@$stmt->execute()) {
			$e = oci_error($stmt);
			echo "<p>Error: Invalid input. Check your WHERE clause.</p>";
			return;
		}

		printResult($stmt);
	}

function checkTableExists($tableName) {
	global $db_conn;

	// Attempt a query that will fail if the table doesn't exist
	$query = "SELECT 1 FROM " . $tableName . " LIMIT 1";
try {
    $stmt = $db_conn->prepare($query);
    $stmt->execute();
    return true;
} catch (PDOException $e) {
    return false;
}

	if (!$stmt) {
			// If oci_parse fails, it's a bad sign but doesn't necessarily mean the table doesn't exist
			return false;
	}

	// Suppress PHP warnings and attempt to execute the query
	$r = @$stmt->execute();

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

function handleResetRequest() {
    global $db_conn;
    $filename = 'sql/sql_ddl.sql';

    if (!file_exists($filename)) {
        echo "<p>Schema file not found at $filename.</p>";
        return;
    }

    $sql = file_get_contents($filename);
    try {
        $db_conn->exec($sql);
        echo "<p>Tables reset successfully.</p>";
    } catch (PDOException $e) {
        echo "<p>Error resetting tables: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

function handleInsertRequest()
{
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
            return;
        case 'mass':
            echo "<p>Error: Mass is required and cannot be null or empty.</p>";
            return;
        case 'radius':
            echo "<p>Error: Radius is required and cannot be null or empty.</p>";
            return;
        case 'spaceAgencyName':
            echo "<p>Error: Space Agency Name is required and cannot be null or empty.</p>";
            return;
    }

    // Validate input types
    if (!is_string($name) || !is_string($type) || !is_numeric($mass) || !is_numeric($radius) || !is_numeric($discoveryYear) || !is_numeric($lightYears) || !is_numeric($orbitalPeriod) || !is_numeric($eccentricity) || !is_string($spaceAgencyName) || !is_string($discoveryMethod)) {
        echo "<p>Error: Incorrect input types.</p>";
        return;
    }

    try {
        $db_conn->beginTransaction();

        // Check if the Exoplanet name already exists
        $queryExoplanet = "SELECT Name FROM Exoplanet_DiscoveredAt WHERE Name = :name";
        $stmtCheckExoplanet = $db_conn->prepare($queryExoplanet);
        $stmtCheckExoplanet->execute([':name' => $name]);
        if ($stmtCheckExoplanet->fetch()) {
            echo "<p>Error: An exoplanet with the name '{$name}' already exists.</p>";
            $db_conn->rollBack();
            return;
        }

        // Ensure the SpaceAgency exists or insert it
        $querySpaceAgency = "SELECT Name FROM SpaceAgency WHERE Name = :spaceAgencyName";
        $stmt = $db_conn->prepare($querySpaceAgency);
        $stmt->execute([':spaceAgencyName' => $spaceAgencyName]);
        if (!$stmt->fetch()) {
            $insertSpaceAgency = "INSERT INTO SpaceAgency(Name) VALUES (:spaceAgencyName)";
            $stmtInsertAgency = $db_conn->prepare($insertSpaceAgency);
            $stmtInsertAgency->execute([':spaceAgencyName' => $spaceAgencyName]);
        }

        // Ensure the ExoplanetDimensions exists or insert it
        $queryDimensions = "SELECT * FROM ExoplanetDimensions WHERE Mass = :mass AND Radius = :radius";
        $stmtDimensions = $db_conn->prepare($queryDimensions);
        $stmtDimensions->execute([':mass' => $mass, ':radius' => $radius]);
        if (!$stmtDimensions->fetch()) {
            $insertDimensions = "INSERT INTO ExoplanetDimensions(Mass, Radius) VALUES (:mass, :radius)";
            $stmtInsertDimensions = $db_conn->prepare($insertDimensions);
            $stmtInsertDimensions->execute([':mass' => $mass, ':radius' => $radius]);
        }

        // Insert the Exoplanet
        $insertExoplanet = "INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, \"Discovery Year\", \"Light Years from Earth\", \"Orbital Period\", Eccentricity, SpaceAgencyName, \"Discovery Method\") 
                             VALUES (:name, :type, :mass, :radius, :discoveryYear, :lightYears, :orbitalPeriod, :eccentricity, :spaceAgencyName, :discoveryMethod)";
        $stmtExoplanet = $db_conn->prepare($insertExoplanet);
        $stmtExoplanet->execute([
            ':name' => $name,
            ':type' => $type,
            ':mass' => $mass,
            ':radius' => $radius,
            ':discoveryYear' => $discoveryYear,
            ':lightYears' => $lightYears,
            ':orbitalPeriod' => $orbitalPeriod,
            ':eccentricity' => $eccentricity,
            ':spaceAgencyName' => $spaceAgencyName,
            ':discoveryMethod' => $discoveryMethod
        ]);

        $db_conn->commit();

        // Display the updated table
        if (function_exists('displayTable')) {
            displayTable("Exoplanet_DiscoveredAt");
        }
        echo "<p>Exoplanet '{$name}' successfully inserted.</p>";

    } catch (PDOException $e) {
        $db_conn->rollBack();
        echo "<p>Error inserting exoplanet: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
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
				handleDisplayRequest();
			} elseif (array_key_exists('projectionSubmit', $_GET)){
				handleProjectionRequest();
			} elseif (array_key_exists('groupTuplesRequest', $_GET)){
				handleGroupRequest();
			} elseif (array_key_exists('havingTuplesRequest', $_GET)){
				handleHavingRequest();
			} elseif (array_key_exists('divisionRequest', $_GET)){ //divisionSubmit
				handleDivisionRequest();
			} elseif (array_key_exists('nestedRequest', $_GET)){
				handleNestedRequest();
			} elseif (array_key_exists('selectQueryRequest', $_GET)) {
				handleSelectRequest();
			} elseif (array_key_exists('joinQueryRequest', $_GET)) {
				handleJoinRequest();
			} 
			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) ) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || isset($_GET['groupSubmit']) || isset($_GET['havingSubmit']) || isset($_GET['joinSubmit']) || isset($_GET['selectQuerySubmit']) || isset($_GET['divisionSubmit']) || isset($_GET['nestedSubmit']))
     {
		handleGETRequest();
    }

	// End PHP parsing and send the rest of the HTML content
	?>
	
</body>

</html>
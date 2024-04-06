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

		<input type="submit" value="Insert" name="deleteSubmit"></p>
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

	<h2>Select from Exoplanet_DiscoveredAt WHERE</h2>
	</p>

	<form method="POST" action="exoplanet-explorer.php">
		<input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
        Name: 
    <select name="NameOperator">
        <option value="=">=</option>
    </select>
    <input type="text" name="Name"> <br><br>
	<select name="NameLogicalOperator">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Type: 
    <select name="TypeOperator">
        <option value="=">=</option>
    </select>
    <input type="text" name="Type"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Mass: 
    <select name="MassOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="Mass"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Radius: 
    <select name="RadiusOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="Radius"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Discovery Year: 
    <select name="DiscoveryYearOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="DiscoveryYear"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Light Years From Earth: 
    <select name="LightYearsFromEarthOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="LightYearsFromEarth"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Orbital Period: 
    <select name="OrbitalPeriodOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="OrbitalPeriod"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Eccentricity: 
    <select name="EccentricityOperator">
        <option value="=">=</option>
        <option value="<">&lt;</option>
        <option value="<=">&le;</option>
        <option value=">">&gt;</option>
        <option value=">=">&ge;</option>
    </select>
    <input type="text" name="Eccentricity"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    SpaceAgency Name: 
    <select name="SpaceAgencyNameOperator">
        <option value="=">=</option>
    </select>
    <input type="text" name="SpaceAgencyName"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>
    Discovery Method: 
    <select name="DiscoveryMethodOperator">
        <option value="=">=</option>
    </select>
    <input type="text" name="DiscoveryMethod"> <br><br>
	<select name="SelectLogicalOperator
	">
		<option value=""></option>
        <option value="AND">AND</option>
        <option value="OR">OR</option>
    </select><br><br>

		<input type="submit" value="Submit" name="selectQuerySubmit"></p>
	</form>

	<hr />

	<h2>Join Star_BelongsTo and StellarClass</h2>
	<form method="POST" action="exoplanet-explorer.php">
		<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
		StellarClass Class: <input type="text" name="StellarClassClass"><br><br>

		<input type="submit" value="Submit" name="joinSubmit"></p>
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

		// executePlainSQL("DROP TABLE Orbits");
		// executePlainSQL("DROP TABLE Star_BelongsTo");
		// executePlainSQL("DROP TABLE StellarClass");
		// executePlainSQL("DROP TABLE Galaxy");
		// executePlainSQL("DROP TABLE WrittenBy");
		// executePlainSQL("DROP TABLE DiscoveredBy");
		// executePlainSQL("DROP TABLE Researcher_WorksAt");
		// executePlainSQL("DROP TABLE InitiatedBy");
		// executePlainSQL("DROP TABLE WrittenIn");
		// executePlainSQL("DROP TABLE Exoplanet_DiscoveredAt");
		// executePlainSQL("DROP TABLE SpaceAgency");
		// executePlainSQL("DROP TABLE Observatory");
		// executePlainSQL("DROP TABLE Mission");
		// executePlainSQL("DROP TABLE SpaceProgram");
		// executePlainSQL("DROP TABLE JournalArticle");
		// executePlainSQL("DROP TABLE ConferenceProceeding");
		// executePlainSQL("DROP TABLE BookChapter");
		// executePlainSQL("DROP TABLE Publication");
		// executePlainSQL("DROP TABLE ExoplanetDimensions");
		// executePlainSQL("CREATE TABLE StellarClass (Class VARCHAR2(200) PRIMARY KEY, TemperatureRange NUMBER, Colour VARCHAR2(200))");
		// executePlainSQL("CREATE TABLE Galaxy(Name VARCHAR2(200) PRIMARY KEY, Age NUMBER, Size_T NUMBER, \"Distance from milky way\" NUMBER)");
		// executePlainSQL("CREATE TABLE Star_BelongsTo (Name VARCHAR2(200) PRIMARY KEY, GalaxyName VARCHAR2(200) NOT NULL, Radius NUMBER, Mass NUMBER, StellarClassClass VARCHAR2(200), FOREIGN KEY (GalaxyName) REFERENCES Galaxy(Name) ON DELETE CASCADE, FOREIGN KEY (StellarClassClass) REFERENCES StellarClass(Class) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE SpaceAgency (Name VARCHAR2(200) PRIMARY KEY, Acronym CHAR(100), Region VARCHAR2(200))");
		// executePlainSQL("CREATE TABLE SpaceProgram (Name VARCHAR2(200) PRIMARY KEY, Objective VARCHAR2(200))");
		// executePlainSQL("CREATE TABLE Observatory (SpaceProgramName VARCHAR2(200) PRIMARY KEY, Location VARCHAR2(200), FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE Mission (SpaceProgramName VARCHAR2(200) PRIMARY KEY, LaunchYear INT, Status VARCHAR2(200), FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE Publication (ID INT PRIMARY KEY, Title VARCHAR2(200) NOT NULL, PeerReviewed NUMBER(1), Citation VARCHAR2(200) UNIQUE)");
		// executePlainSQL("CREATE TABLE JournalArticle (PublicationID INT PRIMARY KEY, DOI VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE ConferenceProceeding (PublicationID INT PRIMARY KEY, Location VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE BookChapter (PublicationID INT PRIMARY KEY, BookName VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE ExoplanetDimensions (Radius NUMBER, Mass NUMBER, Density NUMBER, Volume NUMBER, PRIMARY KEY (Radius, Mass))");
		// executePlainSQL("CREATE TABLE Researcher_WorksAt (ID VARCHAR2(200) PRIMARY KEY, Name VARCHAR2(200), Affiliation VARCHAR2(200), EmailAddress VARCHAR2(200) UNIQUE, SpaceAgencyName VARCHAR2(200), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE InitiatedBy (SpaceAgencyName VARCHAR2(200), SpaceProgramName VARCHAR2(200), PRIMARY KEY (SpaceAgencyName, SpaceProgramName), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE, FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE WrittenBy (PublicationID INT, ResearcherID VARCHAR2(200), PRIMARY KEY (PublicationID, ResearcherID), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE, FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE Exoplanet_DiscoveredAt (Name VARCHAR2(200) PRIMARY KEY, Type VARCHAR2(200), Mass NUMBER, Radius NUMBER, \"Discovery Year\" INT, \"Light Years from Earth\" NUMBER, \"Orbital Period\" NUMBER, Eccentricity NUMBER, SpaceAgencyName VARCHAR2(200), \"Discovery Method\" VARCHAR2(200), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE, FOREIGN KEY (Mass, Radius) REFERENCES ExoplanetDimensions(Mass, Radius) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE DiscoveredBy (ResearcherID VARCHAR2(200), ExoplanetName VARCHAR2(200), PRIMARY KEY (ResearcherID, ExoplanetName), FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID) ON DELETE CASCADE, FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE Orbits (ExoplanetName VARCHAR2(200), StarName VARCHAR2(200), PRIMARY KEY (ExoplanetName, StarName), FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE, FOREIGN KEY (StarName) REFERENCES Star_BelongsTo(Name) ON DELETE CASCADE)");
		// executePlainSQL("CREATE TABLE WrittenIn (PublicationID INT, ResearcherID VARCHAR2(200), ExoplanetName VARCHAR2(200), PRIMARY KEY (PublicationID, ExoplanetName), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE, FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE)");
		// executePlainSQL("INSERT INTO ExoplanetDimensions (Radius, Mass, Density, Volume) VALUES (1.17, 1.1, 0.05465441321, 20.12646254)");
		// executePlainSQL("INSERT INTO ExoplanetDimensions (Radius, Mass, Density, Volume) VALUES (7, 1, 0.05465441321, 20.12646254)");
		// executePlainSQL("INSERT INTO SpaceProgram(Name, Objective) VALUES ('Kepler', 'Discover Earth-like planets orbiting other stars.')");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Samsung Galaxy', 5, 6, 7)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Andromeda Galaxy (M31)', 10, 220000, 2.537)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Triangulum Galaxy (M33)', 13, 60000, 2.73)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Whirlpool Galaxy (M51)', 13, 60000, 23)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Sombrero Galaxy (M104)', 11, 50000, 29.3)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Pinwheel Galaxy (M101)', 13, 170000, 21)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Large Magellanic Cloud (LMC)', 13.5, 14000, 0.163)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Small Magellanic Cloud (SMC)', 13, 7000, 0.2)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Messier 87 (M87)', 13.5, 98000, 53.5)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Milky Way Galaxy', 13.51, 105700, 0)");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('National Aeronautics and Space Administration', 'NASA', 'USA')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('European Space Agency', 'ESA', 'Europe')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Canadian Space Agency', 'CSA', 'Canada')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Indian Space Research Organisation', 'ISRO', 'India')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Japan Aerospace Exploration Agency', 'JAXA', 'Japan')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('French Space Agency', 'CNES', 'France')");
		

	
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

		// executePlainSQL("INSERT INTO ExoplanetDimensions (Radius, Mass, Density, Volume) VALUES (1.17, 1.1, 0.05465441321, 20.12646254)");
		// executePlainSQL("INSERT INTO ExoplanetDimensions (Radius, Mass, Density, Volume) VALUES (7, 1, 0.05465441321, 20.12646254)");
		// executePlainSQL("INSERT INTO SpaceProgram(Name, Objective) VALUES ('Kepler', 'Discover Earth-like planets orbiting other stars.')");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Samsung Galaxy', 5, 6, 7)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Andromeda Galaxy (M31)', 10, 220000, 2.537)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Triangulum Galaxy (M33)', 13, 60000, 2.73)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Whirlpool Galaxy (M51)', 13, 60000, 23)");
		// executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way\") VALUES ('Sombrero Galaxy (M104)', 11, 50000, 29.3)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Pinwheel Galaxy (M101)', 13, 170000, 21)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Large Magellanic Cloud (LMC)', 13.5, 14000, 0.163)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Small Magellanic Cloud (SMC)', 13, 7000, 0.2)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Messier 87 (M87)', 13.5, 98000, 53.5)");
		// // executePlainSQL("INSERT INTO Galaxy(Name, Age, Size_T, \"Distance from milky way (light years)\") VALUES ('Milky Way Galaxy', 13.51, 105700, 0)");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('National Aeronautics and Space Administration', 'NASA', 'USA')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('European Space Agency', 'ESA', 'Europe')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Canadian Space Agency', 'CSA', 'Canada')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Indian Space Research Organisation', 'ISRO', 'India')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Japan Aerospace Exploration Agency', 'JAXA', 'Japan')");
		// executePlainSQL("INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('French Space Agency', 'CNES', 'France')");
		

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

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['insName'],
			":bind2" => $_POST['insType'],
			":bind3" => $_POST['insMass'],
			":bind4" => $_POST['insRadius'],
			":bind5" => $_POST['insYear'],
			":bind6" => $_POST['insLight'],
			":bind7" => $_POST['insOrb'],
			":bind8" => $_POST['insEcc'],
			":bind9" => $_POST['insSpace'],
			":bind10" => $_POST['insDisc']
		);

		$alltuples = array(
			$tuple
		);
		
		$checkSpaceAgencyExists = executeBoundSQL("SELECT Name FROM SpaceAgency WHERE Name = :bind9");
		if (!oci_fetch($checkSpaceAgencyExists)) { //checking if returned result is empty
			executeBoundSQL("INSERT INTO SpaceAgency(Name) VALUES (:bind9)");
		}

		$checkDimensionsExist = executeBoundSQL("SELECT (Mass, Radius) FROM ExoplanetDimensions WHERE Mass = :bind3 AND Radius = :bind4");
		if (!oci_fetch($checkDimensionsExist)) { //checking if returned result is empty
			executeBoundSQL("INSERT INTO ExoplanetDimensions (Mass, Radius) VALUES (:bind3, :bind4)");
		}

		executeBoundSQL("INSERT INTO Exoplanet_DiscoveredAt VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8, :bind9, :bind10)", $alltuples);
		oci_commit($db_conn);
	}

	function handleDeleteRequest()
	{
		global $db_conn;

		$SpaceAgencyName = $_POST['insName'];

		$alltuples = array(
			$tuple
		);

		$result = executePlainSQL("DELETE FROM SpaceAgency WHERE Name ='" . $SpaceAgencyName . "'");

		oci_commit($db_conn);
	}

	function handleSelectRequest()
	{
		global $db_conn;

			$whereClause = "";
			$logicalOperator = "";
	
			$fields = array(
				"Name" => array("Operator" => $_POST["NameOperator"], "Value" => $_POST["Name"]),
				"Type" => array("Operator" => $_POST["TypeOperator"], "Value" => $_POST["Type"]),
				"Mass" => array("Operator" => $_POST["MassOperator"], "Value" => $_POST["Mass"]),
				"Radius" => array("Operator" => $_POST["RadiusOperator"], "Value" => $_POST["Radius"]),
				"DiscoveryYear" => array("Operator" => $_POST["DiscoveryYearperator"], "Value" => $_POST["DiscoveryYear"]),
				"LightYearsFromEarth" => array("Operator" => $_POST["LightYearsFromEarthOperator"], "Value" => $_POST["LightYearsFromEarth"]),
				"OrbitalPeriod" => array("Operator" => $_POST["OrbitalPeriodOperator"], "Value" => $_POST["OrbitalPeriod"]),
				"Eccentricity" => array("Operator" => $_POST["EccentricityOperator"], "Value" => $_POST["Eccentricity"]),
				"SpaceAgencyName" => array("Operator" => $_POST["SpaceAgencyNameOperator"], "Value" => $_POST["SpaceAgencyName"]),
				"DiscoveryMethod" => array("Operator" => $_POST["DiscoveryMethodOperator"], "Value" => $_POST["DiscoveryMethod"]),
			);
	
			foreach ($fields as $field => $options) {
				$operator = $options["Operator"];
				$value = $options["Value"];
	
				if (!empty($value)) {
					if (!empty($whereClause)) {
						$whereClause .= $logicalOperator;
					}
					$whereClause .= "$field $operator '$value'";
					$logicalOperator = $_POST[$field . "LogicalOperator"];
				}
			}
	
			$query = "SELECT * FROM Exoplanet_DiscoveredAt";
			if (!empty($whereClause)) {
				$query .= " WHERE $whereClause";
			}
	
			$result = executePlainSQL($query);

		oci_commit($db_conn);
		displayTable
	}

	function handleJoinRequest()
	{
		global $db_conn;

		$stellarClass = $_POST['StellarClassClass'];

		if (!empty($stellarClass)) {
            $whereClause = "WHERE StellarClassClass = '$stellarClass'";
        } else {
            $whereClause = "";
        }

		$result = executePlainSQL("SELECT * FROM Star_BelongsTo NATURAL JOIN StellarClass $whereClause");

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
			} else if (array_key_exists('selectQueryRequest', $_POST)) {
				handleSelectRequest();
			} else if (array_key_exists('joinQueryRequest', $_POST)) {
				handleJoinRequest();
			}
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
			}

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
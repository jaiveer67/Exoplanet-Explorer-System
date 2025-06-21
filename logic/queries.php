<?php
require_once 'helpers.php';

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

?>
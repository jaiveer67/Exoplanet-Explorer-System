<?php
require_once 'helpers.php';

function handleJoinRequest($db, $stellarClass) {
    if (!empty($stellarClass)) {
        $whereClause = "WHERE Star_BelongsTo.StellarClassClass = StellarClass.Class AND Star_BelongsTo.StellarClassClass = :class";
    } else {
        $whereClause = "WHERE Star_BelongsTo.StellarClassClass = StellarClass.Class";
    }

    $sql = "SELECT * FROM Star_BelongsTo, StellarClass $whereClause";
    $stmt = $db->prepare($sql);

    if (!empty($stellarClass)) {
        $stmt->bindValue(':class', $stellarClass);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'results' => $rows,
        'message' => count($rows) > 0 ? "Join successful." : "No matching rows found."
    ];
}


	function handleUpdateRequest($db, $post) {
    $id = $post['ID'] ?? '';
    $newName = $post['newName'] ?? '';
    $newAffiliation = $post['newAffiliation'] ?? '';
    $newEmailAddress = $post['newEmailAddress'] ?? '';
    $newSpaceAgencyName = $post['newSpaceAgencyName'] ?? '';

    if (empty($id)) {
        return ["error" => "ID cannot be empty."];
    }

    $setClause = [];
    $params = [];

    if (!empty($newName)) {
        $setClause[] = "Name = :name";
        $params[':name'] = $newName;
    }
    if (!empty($newAffiliation)) {
        $setClause[] = "Affiliation = :affiliation";
        $params[':affiliation'] = $newAffiliation;
    }
    if (!empty($newEmailAddress)) {
        $setClause[] = "EmailAddress = :email";
        $params[':email'] = $newEmailAddress;
    }
    if (!empty($newSpaceAgencyName)) {
        $setClause[] = "SpaceAgencyName = :agency";
        $params[':agency'] = $newSpaceAgencyName;
    }

    if (empty($setClause)) {
        return ["error" => "No fields to update."];
    }

    $query = "UPDATE Researcher_WorksAt SET " . implode(", ", $setClause) . " WHERE ID = :id";
    $stmt = $db->prepare($query);
    $params[':id'] = $id;

    if (!$stmt->execute($params)) {
        return ["error" => "Invalid input. Check your values."];
    }

    // Optionally return updated table
    $res = $db->query("SELECT * FROM Researcher_WorksAt")->fetchAll(PDO::FETCH_ASSOC);
    return ["message" => "Update successful.", "results" => $res];
}


	function handleDeleteRequest($db, $post) {
    $name = $post['insName'] ?? '';

    if (empty($name)) {
        return ["error" => "Name cannot be empty."];
    }

    $stmt = $db->prepare("DELETE FROM SpaceAgency WHERE Name = :name");
    $stmt->bindParam(':name', $name);

    if (!$stmt->execute()) {
        return ["error" => "Invalid input. Check your values."];
    }

    // Optionally return updated table
    $res = $db->query("SELECT * FROM SpaceAgency")->fetchAll(PDO::FETCH_ASSOC);
    return ["message" => "Deletion successful.", "results" => $res];
}

	function handleDisplayRequest($db, $tableName) {
    // Check if table exists
    $stmt = $db->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name = :name");
    $stmt->bindValue(":name", $tableName);
    $stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$exists) {
        return ["error" => "The table '{$tableName}' does not exist."];
    }

    $res = $db->query("SELECT * FROM $tableName")->fetchAll(PDO::FETCH_ASSOC);
    return ["message" => "Table '{$tableName}' displayed successfully.", "results" => $res];
}


	function handleProjectionRequest($conn, $attributes, $table) {
    if (!is_array($attributes) || empty($attributes)) {
        return ['error' => 'No attributes selected.'];
    }

    $columns = array_map(function($attr) {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $attr);
    }, $attributes);
    $columnList = implode(", ", $columns);

    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

    // ✅ Additional safety check
    if (empty($columnList) || empty($table)) {
        return ['error' => 'Invalid table or attributes.'];
    }

    $query = "SELECT $columnList FROM $table";

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'results' => $rows,
            'message' => "Projection successful for $table"
        ];
    } catch (PDOException $e) {
        return [
            'error' => "Query failed: " . $e->getMessage()
        ];
    }
}

	function handleGroupRequest($db) {
    $query = "SELECT SpaceProgramName, COUNT(*) AS NumMissions FROM Mission GROUP BY SpaceProgramName";
    $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    return ["message" => "Grouped by SpaceProgramName.", "results" => $res];
}


	function handleHavingRequest($db) {
    $query = "SELECT sc.Class, COUNT(*) AS NumStars FROM StellarClass sc 
              JOIN Star_BelongsTo sb ON sc.Class = sb.StellarClassClass 
              GROUP BY sc.Class 
              HAVING COUNT(*) >= 2";

    $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    return ["message" => "HAVING COUNT >= 2 executed.", "results" => $res];
}


	function handleDivisionRequest($db) {
    $query = "SELECT g.Name AS GalaxyName 
              FROM Galaxy g 
              WHERE NOT EXISTS (
                  SELECT s.Name 
                  FROM Star_BelongsTo s 
                  WHERE NOT EXISTS (
                      SELECT * 
                      FROM Star_BelongsTo sb 
                      WHERE sb.GalaxyName = g.Name AND sb.Name = s.Name
                  )
              )";

    try {
        $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return ["message" => "Division query successful.", "results" => $res];
    } catch (PDOException $e) {
        return ["error" => "Error executing division query: " . $e->getMessage()];
    }
}


	function handleNestedRequest($db) {
    $query = 'SELECT AVG(Exoplanet_discovery_count) AS AverageDiscoveries 
              FROM (
                  SELECT "Discovery Year" as year, COUNT(*) as Exoplanet_discovery_count 
                  FROM Exoplanet_DiscoveredAt 
                  GROUP BY "Discovery Year"
              )';

    try {
        $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return ["message" => "Nested aggregation query successful.", "results" => $res];
    } catch (PDOException $e) {
        return ["error" => "Error executing nested query: " . $e->getMessage()];
    }
}


	function handleSelectRequest($db, $whereClause) {
    if (empty($whereClause)) {
        return ["error" => "WHERE clause cannot be empty."];
    }

    $query = "SELECT * FROM Exoplanet_DiscoveredAt WHERE $whereClause";

    try {
        $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return ["message" => "Conditional SELECT successful.", "results" => $res];
    } catch (PDOException $e) {
        return ["error" => "Error in WHERE clause: " . $e->getMessage()];
    }
}


function handleResetRequest($db) {
    $filename = __DIR__ . '/../sql/sql_ddl.sql';

    if (!file_exists($filename)) {
        return ["error" => "Schema file not found at $filename."];
    }

    $sql = file_get_contents($filename);
    try {
        $db->exec($sql);
        return ["message" => "Tables reset successfully."];
    } catch (PDOException $e) {
        return ["error" => "Error resetting tables: " . $e->getMessage()];
    }
}


function handleInsertRequest($db, $post) {
    $requiredFields = ['insName', 'insMass', 'insRadius', 'insSpace'];
    foreach ($requiredFields as $field) {
        if (empty($post[$field])) {
            return ["error" => ucfirst($field) . " is required."];
        }
    }

    extract($post); // safely assuming names are unique keys

    // Validate types
    if (!is_numeric($insMass) || !is_numeric($insRadius)) {
        return ["error" => "Mass and Radius must be numeric."];
    }

    try {
        $db->beginTransaction();

        // Check if planet already exists
        $stmt = $db->prepare("SELECT Name FROM Exoplanet_DiscoveredAt WHERE Name = :name");
        $stmt->execute([':name' => $insName]);
        if ($stmt->fetch()) {
            $db->rollBack();
            return ["error" => "An exoplanet named '{$insName}' already exists."];
        }

        // Insert SpaceAgency if not exists
        $stmt = $db->prepare("SELECT Name FROM SpaceAgency WHERE Name = :agency");
        $stmt->execute([':agency' => $insSpace]);
        if (!$stmt->fetch()) {
            $stmt = $db->prepare("INSERT INTO SpaceAgency(Name) VALUES (:agency)");
            $stmt->execute([':agency' => $insSpace]);
        }

        // Insert ExoplanetDimensions if not exists
        $stmt = $db->prepare("SELECT * FROM ExoplanetDimensions WHERE Mass = :mass AND Radius = :radius");
        $stmt->execute([':mass' => $insMass, ':radius' => $insRadius]);
        if (!$stmt->fetch()) {
            $stmt = $db->prepare("INSERT INTO ExoplanetDimensions(Mass, Radius) VALUES (:mass, :radius)");
            $stmt->execute([':mass' => $insMass, ':radius' => $insRadius]);
        }

        // Insert Exoplanet
        $stmt = $db->prepare(
            'INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") 
             VALUES (:name, :type, :mass, :radius, :year, :light, :orb, :ecc, :agency, :method)'
        );
        $stmt->execute([
            ':name' => $insName,
            ':type' => $insType,
            ':mass' => $insMass,
            ':radius' => $insRadius,
            ':year' => $insYear,
            ':light' => $insLight,
            ':orb' => $insOrb,
            ':ecc' => $insEcc,
            ':agency' => $insSpace,
            ':method' => $insDisc
        ]);

        $db->commit();

        $res = $db->query("SELECT * FROM Exoplanet_DiscoveredAt")->fetchAll(PDO::FETCH_ASSOC);
        return ["message" => "Exoplanet '{$insName}' inserted successfully.", "results" => $res];

    } catch (PDOException $e) {
        $db->rollBack();
        return ["error" => "Insertion failed: " . $e->getMessage()];
    }
}

?>
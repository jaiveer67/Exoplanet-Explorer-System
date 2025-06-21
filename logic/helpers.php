<?php
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
        echo "<div class='results'>";
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
        echo "</div>";
	}

    function displayTable($tableName) {
    global $db_conn;
    if (!checkTableExists($tableName)) {
        echo "<p>Error: The table '{$tableName}' does not exist.</p>";
        return;
    }
    echo "<div class='results'>";
    $query = "SELECT * FROM " . $tableName;
    $stmt = $db_conn->prepare($query);
    $stmt->execute();
    printResult($stmt);
    echo "</div>";
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
?>
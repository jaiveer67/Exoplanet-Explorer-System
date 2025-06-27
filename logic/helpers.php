<?php

function executePlainSQL($db, $cmdstr) {
    try {
        return $db->query($cmdstr);
    } catch (PDOException $e) {
        return false;
    }
}

function executeBoundSQL($db, $cmdstr, $list) {
    try {
        $stmt = $db->prepare($cmdstr);
        foreach ($list as $tuple) {
            $stmt->execute($tuple);
        }
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function printResult($stmt) {
    if (!$stmt) return "<p>No results.</p>";

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) return "<p>No data found.</p>";

    $html = "<div class='results'><table border='1'><tr>";
    foreach (array_keys($rows[0]) as $colName) {
        $html .= "<th>" . htmlspecialchars($colName, ENT_QUOTES, 'UTF-8') . "</th>";
    }
    $html .= "</tr>";

    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $item) {
            $html .= "<td>" . htmlspecialchars($item ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</table></div>";
    return $html;
}

function displayTable($db, $tableName) {
    if (!checkTableExists($db, $tableName)) {
        return "<p>Error: The table '{$tableName}' does not exist.</p>";
    }

    $query = "SELECT * FROM " . $tableName;
    $stmt = $db->prepare($query);
    $stmt->execute();
    return printResult($stmt);
}

function checkTableExists($db, $tableName) {
    try {
        $stmt = $db->prepare("SELECT 1 FROM " . $tableName . " LIMIT 1");
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function printResultArray($rows, $message = null) {
    if (!$rows || count($rows) === 0) return "<div class='results'><p>No data found.</p></div>";

    $html = "<div class='results'>";

    if ($message) {
        $html .= "<div class='message success'>" . htmlspecialchars($message) . "</div>";
    }

    $html .= "<table border='1'><tr>";
    foreach (array_keys($rows[0]) as $colName) {
        $html .= "<th>" . htmlspecialchars($colName, ENT_QUOTES, 'UTF-8') . "</th>";
    }
    $html .= "</tr>";

    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $item) {
            $html .= "<td>" . htmlspecialchars($item ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</table></div>";
    return $html;
}

function getColumnValues(PDO $conn, string $table, string $column): array {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
    try {
        $stmt = $conn->prepare("SELECT DISTINCT $column FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        return [];
    }
}

function getCommonStellarClasses($conn) {
    $stmt = $conn->prepare("
        SELECT DISTINCT sb.StellarClassClass
        FROM Star_BelongsTo sb
        INNER JOIN StellarClass sc ON sb.StellarClassClass = sc.Class
        ORDER BY sb.StellarClassClass ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


?>

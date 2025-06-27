<?php
require_once(__DIR__ . "/logic/connection.php");
global $db_conn;

header('Content-Type: application/json');

if (!isset($_GET['table'])) {
    echo json_encode([]);
    exit;
}

$table = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']);

try {
    $stmt = $db_conn->prepare("PRAGMA table_info($table)");
    $stmt->execute();
    $columns = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $columns[] = $row['name'];
    }
    echo json_encode($columns);
} catch (Exception $e) {
    echo json_encode([]);
}
?>

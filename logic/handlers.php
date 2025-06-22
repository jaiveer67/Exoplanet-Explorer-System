<?php
require_once 'queries.php';
require_once 'connection.php';
require_once 'helpers.php';

// Handle all POST and GET routes
if (
    isset($_POST['reset']) || isset($_POST['updateSubmit']) || 
    isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])
) {
    handlePOSTRequest();
} elseif (
    isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) ||
    isset($_GET['projectionRequest']) || isset($_GET['groupSubmit']) ||
    isset($_GET['havingSubmit']) || isset($_GET['joinSubmit']) ||
    isset($_GET['selectQuerySubmit']) || isset($_GET['divisionSubmit']) ||
    isset($_GET['nestedSubmit'])
) {
    handleGETRequest();
}

function handlePOSTRequest() {
    if (connectToDB()) {
        global $db_conn;

        if (isset($_POST['resetTablesRequest'])) {
            $res = handleResetRequest($db_conn);
        } elseif (isset($_POST['updateQueryRequest'])) {
            $res = handleUpdateRequest($db_conn, $_POST);
        } elseif (isset($_POST['insertQueryRequest'])) {
            $res = handleInsertRequest($db_conn, $_POST);
        } elseif (isset($_POST['deleteQueryRequest'])) {
            $res = handleDeleteRequest($db_conn, $_POST);
        }

        disconnectFromDB();
        finalizeAndRedirect($res);
    }
}

function handleGETRequest() {
    if (connectToDB()) {
        global $db_conn;

        if (isset($_GET['displayTuples'])) {
            $res = handleDisplayRequest($db_conn, $_GET["tableNameForDisplay"]);
        } elseif (isset($_GET['projectionSubmit'])) {
            $res = handleProjectionRequest($db_conn, $_GET["attributes"], $_GET["tableNameForDisplay"]);
        } elseif (isset($_GET['groupTuplesRequest'])) {
            $res = handleGroupRequest($db_conn);
        } elseif (isset($_GET['havingTuplesRequest'])) {
            $res = handleHavingRequest($db_conn);
        } elseif (isset($_GET['divisionRequest'])) {
            $res = handleDivisionRequest($db_conn);
        } elseif (isset($_GET['nestedRequest'])) {
            $res = handleNestedRequest($db_conn);
        } elseif (isset($_GET['selectQueryRequest'])) {
            $res = handleSelectRequest($db_conn, $_GET["Where"]);
        } elseif (isset($_GET['joinQueryRequest'])) {
            $res = handleJoinRequest($db_conn, $_GET["StellarClassClass"]);
        }

        disconnectFromDB();
        finalizeAndRedirect($res);
    }
}

function finalizeAndRedirect($res) {
    $_SESSION['message'] = $res['message'] ?? null;
    $_SESSION['results'] = $res['results'] ?? null;
    $_SESSION['error'] = $res['error'] ?? null;
    header("Location: index.php");
    exit;
}
?>

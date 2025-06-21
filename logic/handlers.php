<?php
    require_once 'queries.php';
    require_once 'connection.php';

    // Debugging messages
    $show_debug_alert_messages = false;

// HANDLE ALL POST ROUTES

if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) ) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest']) || isset($_GET['projectionRequest']) || isset($_GET['groupSubmit']) || isset($_GET['havingSubmit']) || isset($_GET['joinSubmit']) || isset($_GET['selectQuerySubmit']) || isset($_GET['divisionSubmit']) || isset($_GET['nestedSubmit']))
     {
		handleGETRequest();
    }
    
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
?>
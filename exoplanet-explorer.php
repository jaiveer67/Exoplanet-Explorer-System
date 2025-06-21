<?php
require_once("logic/connection.php");
require_once("logic/helpers.php");
require_once("logic/handlers.php");
require_once("logic/queries.php");
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
</html>
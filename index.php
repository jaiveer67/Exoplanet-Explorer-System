<?php
session_start();
require_once("logic/connection.php");
require_once("logic/helpers.php");
require_once("logic/queries.php");
require_once("logic/handlers.php");
$spaceAgencies = getColumnValues($db_conn, 'SpaceAgency', 'Name');
$researcherIDs = getColumnValues($db_conn, 'Researcher_WorksAt', 'ID');
$commonStellarClasses = getCommonStellarClasses($db_conn);
sort($researcherIDs, SORT_NUMERIC);
?>

<html>
<head>
    <title>Exoplanet Explorer</title>
	<link rel="stylesheet" type="text/css" href="style.css?v=<?= time() ?>">
</head>
<body>
	<div class="container">
<?php if (
    isset($_SESSION['results']) || 
    isset($_SESSION['message']) || 
    isset($_SESSION['error'])
): ?>
    <div class="results">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php elseif (isset($_SESSION['message'])): ?>
            <div class="message success"><?= htmlspecialchars($_SESSION['message']) ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php
        if (isset($_SESSION['results']) && is_array($_SESSION['results']) && count($_SESSION['results']) > 0) {
            echo printResultArray($_SESSION['results']);
            unset($_SESSION['results']);
        }
        ?>
    </div>
<?php endif; ?>


    <h2>Reset</h2>
    <p>If this is your first time running this page, you MUST click reset.</p>
    <form method="POST" action="index.php">
        <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
        <p><input type="submit" value="Reset" name="reset"></p>
    </form>
    <hr />

    <h2>Insert Values for Exoplanets</h2>
    <form method="POST" action="index.php">
        <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
        Name: <input type="text" name="insName" placeholder="e.g. Kepler-22b"> <br /><br />
        Type: <input type="text" name="insType" placeholder="e.g. Gas Giant"> <br /><br />
        Mass (Earth masses): <input type="number" step="0.01" name="insMass" placeholder="e.g. 5.97"> <br /><br />
        Radius (Earth radii): <input type="number" step="0.01" name="insRadius" placeholder="e.g. 1.12"> <br /><br />
        Discovery Year: <input type="number" name="insYear" step="1" placeholder="e.g. 2020"> <br /><br />
        Light Years from Earth: <input type="number" step="0.01" name="insLight" placeholder="e.g. 1200"> <br /><br />
        Orbital Period (days): <input type="number" step="0.01" name="insOrb" placeholder="e.g. 365"> <br /><br />
        Eccentricity (0-1): <input type="number" step="0.01" name="insEcc" placeholder="e.g. 0.05"> <br /><br />
        Space Agency Name: <input type="text" name="insSpace" placeholder="e.g. NASA"> <br /><br />
        Discovery Method: <input type="text" name="insDisc" placeholder="e.g. Transit"> <br /><br />
        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>
    <hr />

    <h2>Delete a Space Agency</h2>
<form method="POST" action="index.php">
    <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
    <label for="agencySelect">Space Agency:</label>
    <select name="insName" id="agencySelect" required style="width: 350px;">
        <option value="" disabled selected>Select an agency</option>
        <?php foreach ($spaceAgencies as $agency): ?>
            <option value="<?= htmlspecialchars($agency) ?>"><?= htmlspecialchars($agency) ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Delete" name="deleteSubmit">
</form>
<hr />


    <h2>Update Researcher Information</h2>
    <p>Leave blank to retain current value. Case sensitive.</p>
    <form method="POST" action="index.php">
        <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
        <label for="ID">Researcher ID:</label>
<select name="ID" id="ID" required>
  <option value="" disabled selected>Select a Researcher</option>
  <?php foreach ($researcherIDs as $id): ?>
    <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($id) ?></option>
  <?php endforeach; ?>
</select><br><br>

        New Name: <input type="text" name="newName" placeholder="e.g. Jane Doe"> <br /><br />
        New Affiliation: <input type="text" name="newAffiliation" placeholder="e.g. Harvard"> <br /><br />
        New Email Address: <input type="email" name="newEmailAddress" placeholder="e.g. jane@astro.org"> <br /><br />
        New Space Agency Name: <input type="text" name="newSpaceAgencyName" placeholder="e.g. CSA"> <br /><br />
        <input type="submit" value="Update" name="updateSubmit"></p>
    </form>
    <hr />

    <h2>Run a SELECT Query</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
        WHERE condition: <input type="text" name="Where" placeholder="e.g. Mass = 1.1"> <br><br>
        <input type="submit" value="Submit" name="selectQuerySubmit"></p>
    </form>
    <hr />

    <h2>Join Star_BelongsTo and StellarClass</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
        <label for="StellarClassClass">Stellar Class (filter):</label>
       <select name="StellarClassClass" required>
        <option value="" disabled selected>Select Stellar Class</option>
        <?php foreach ($commonStellarClasses as $Class): ?>
            <option value="<?= htmlspecialchars($Class) ?>"><?= htmlspecialchars($Class) ?></option>
        <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="Join" name="joinSubmit">
    </form>
    <hr />

    <h2>Display a Table</h2>
<form method="GET" action="index.php">
    <input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
    <label for="tableNameForDisplay">Choose a table to display:</label><br>
    <select name="tableNameForDisplay" id="tableNameForDisplay" required>
        <option value="" disabled selected>Select a table</option>
        <option value="StellarClass">StellarClass</option>
        <option value="Galaxy">Galaxy</option>
        <option value="Star_BelongsTo">Star_BelongsTo</option>
        <option value="SpaceAgency">SpaceAgency</option>
        <option value="SpaceProgram">SpaceProgram</option>
        <option value="Observatory">Observatory</option>
        <option value="Mission">Mission</option>
        <option value="Publication">Publication</option>
        <option value="JournalArticle">JournalArticle</option>
        <option value="ConferenceProceeding">ConferenceProceeding</option>
        <option value="BookChapter">BookChapter</option>
        <option value="ExoplanetDimensions">ExoplanetDimensions</option>
        <option value="Researcher_WorksAt">Researcher_WorksAt</option>
        <option value="InitiatedBy">InitiatedBy</option>
        <option value="WrittenBy">WrittenBy</option>
        <option value="Exoplanet_DiscoveredAt">Exoplanet_DiscoveredAt</option>
        <option value="DiscoveredBy">DiscoveredBy</option>
        <option value="Orbits">Orbits</option>
        <option value="WrittenIn">WrittenIn</option>
    </select><br><br>
    <input type="submit" value="Submit" name="displayTuples">
</form>
<hr />


    <h2>Projection Query</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="projectionRequest" name="projectionRequest">

        Table Name: <select name="projectionTableName" id="projectionTableName" required>
        <option value="" disabled selected>Select a table</option>
        <option value="StellarClass">StellarClass</option>
        <option value="Galaxy">Galaxy</option>
        <option value="Star_BelongsTo">Star_BelongsTo</option>
        <option value="SpaceAgency">SpaceAgency</option>
        <option value="SpaceProgram">SpaceProgram</option>
        <option value="Observatory">Observatory</option>
        <option value="Mission">Mission</option>
        <option value="Publication">Publication</option>
        <option value="JournalArticle">JournalArticle</option>
        <option value="ConferenceProceeding">ConferenceProceeding</option>
        <option value="BookChapter">BookChapter</option>
        <option value="ExoplanetDimensions">ExoplanetDimensions</option>
        <option value="Researcher_WorksAt">Researcher_WorksAt</option>
        <option value="InitiatedBy">InitiatedBy</option>
        <option value="WrittenBy">WrittenBy</option>
        <option value="Exoplanet_DiscoveredAt">Exoplanet_DiscoveredAt</option>
        <option value="DiscoveredBy">DiscoveredBy</option>
        <option value="Orbits">Orbits</option>
        <option value="WrittenIn">WrittenIn</option>
    </select><br><br>
Attribute 1:
<select name="attribute1" id="attribute1" required>
  <option value="" disabled selected>Select attribute</option>
</select><br><br>

Attribute 2:
<select name="attribute2" id="attribute2" required>
  <option value="" disabled selected>Select attribute</option>
</select>
        <br><br>
        <input type="submit" value="Project" name="projectionSubmit">
    </form>
    <hr />

    <h2>Group by Space Program</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="groupTuplesRequest" name="groupTuplesRequest">
        <input type="submit" value="Submit" name="groupSubmit"></p>
    </form>
    <hr />

    <h2>HAVING: Stellar Classes with More Than 2 Stars</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="havingTuplesRequest" name="havingTuplesRequest">
        <input type="submit" value="Submit" name="havingSubmit"></p>
    </form>
    <hr />

    <h2>DIVISION: Galaxies with All Stars</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="divisionRequest" name="divisionRequest">
        <input type="submit" value="Submit" name="divisionSubmit"></p>
    </form>
    <hr />

    <h2>NESTED AGGREGATION: Average Exoplanets per Year</h2>
    <form method="GET" action="index.php">
        <input type="hidden" id="nestedRequest" name="nestedRequest">
        <input type="submit" value="Submit" name="nestedSubmit"></p>
    </form>
    <hr />
</div>

<script>
  document.getElementById("projectionTableName").addEventListener("change", function () {
    const tableName = this.value;
    const attr1 = document.getElementById("attribute1");
    const attr2 = document.getElementById("attribute2");

    attr1.innerHTML = '<option value="" disabled selected>Select attribute</option>';
    attr2.innerHTML = '<option value="" disabled selected>Select attribute</option>';

    fetch(`logic/get_columns.php?table=${encodeURIComponent(tableName)}`)
      .then(res => res.json())
      .then(columns => {
        if (Array.isArray(columns)) {
          columns.forEach(col => {
            const option1 = document.createElement("option");
            const option2 = document.createElement("option");

            option1.value = col;
            option1.textContent = col;

            option2.value = col;
            option2.textContent = col;

            attr1.appendChild(option1);
            attr2.appendChild(option2);
          });
        }
      })
      .catch(err => {
        console.error("Failed to fetch columns:", err);
      });
  });
</script>
</body>
</html>
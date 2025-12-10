<?php
// --- CONFIGURATION ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include your connection file
// Make sure db.php has the function getSQLServer() inside it!
include "db.php"; 

echo "<div style='font-family: sans-serif; padding: 20px;'>";
echo "<h1>SQL Server's Database Inspector</h1>";

// 1. CONNECT TO SQL Server
$pdo = getSQLServer();

if (!$pdo) {
    die("<h2 style='color:red'>Connection Failed. Check SQL Server's IP/User/Pass in db.php</h2>");
}

echo "<h3 style='color:green'>Success! Connected to SQL Server. Fetching data...</h3><hr>";

try {
    // 2. GET ALL TABLES AUTOMATICALLY
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($tables) == 0) {
        echo "<p>Connected, but <strong>no tables found</strong> in SQL Server's database.</p>";
    }

    // 3. LOOP THROUGH TABLES AND SHOW DATA
    foreach ($tables as $tableName) {
        echo "<h2>Table: <span style='color:blue'>$tableName</span></h2>";

        // Fetch all rows
        $sql = "SELECT * FROM $tableName";
        $dataStmt = $pdo->query($sql);
        $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%; margin-bottom: 30px;'>";
            
            // Headers
            echo "<thead style='background-color: #f2f2f2;'><tr>";
            $columnNames = array_keys($rows[0]);
            foreach ($columnNames as $col) {
                echo "<th>" . htmlspecialchars($col) . "</th>";
            }
            echo "</tr></thead>";

            // Data Rows
            echo "<tbody>";
            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p style='color: gray; font-style: italic;'>Table is empty.</p><br>";
        }
    }

} catch (Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
}

echo "</div>";
?>
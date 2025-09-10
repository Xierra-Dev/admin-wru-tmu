<?php
// Simple script to add letter column to m_loc table

try {
    $pdo = new PDO("mysql:host=localhost;dbname=wru_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if letter column already exists
    $checkColumn = $pdo->query("SHOW COLUMNS FROM m_loc LIKE 'letter'");
    if ($checkColumn->rowCount() == 0) {
        // Add letter column
        $sql = "ALTER TABLE m_loc ADD COLUMN letter TINYINT(1) DEFAULT 0 COMMENT 'Letter flag: 0 = No, 1 = Yes'";
        $pdo->exec($sql);
        echo "Letter column added successfully to m_loc table.\n";
    } else {
        echo "Letter column already exists in m_loc table.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
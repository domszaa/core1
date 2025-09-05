
<?php
require 'db.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
    echo "✅ Database connected! Tables found:<br>";
    while ($row = $stmt->fetch()) {
        echo $row[0] . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

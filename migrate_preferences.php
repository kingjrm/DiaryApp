<?php
// Migration to update user_preferences table with new columns
require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getInstance()->getConnection();

    // Check if columns exist and add them if they don't
    $columns = [
        'avatar_path' => "VARCHAR(500) NULL",
        'bio' => "TEXT NULL",
        'timezone' => "VARCHAR(50) DEFAULT 'UTC'",
        'date_format' => "VARCHAR(20) DEFAULT 'Y-m-d'"
    ];

    foreach ($columns as $column => $definition) {
        $stmt = $db->prepare("SHOW COLUMNS FROM user_preferences LIKE ?");
        $stmt->execute([$column]);
        $result = $stmt->fetch();

        if (!$result) {
            $db->exec("ALTER TABLE user_preferences ADD COLUMN $column $definition");
            echo "Added column: $column\n";
        } else {
            echo "Column $column already exists\n";
        }
    }

    echo "Migration completed successfully!\n";

} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?>
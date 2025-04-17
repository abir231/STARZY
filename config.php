<?php
// config.php in root directory (C:\xamppa\htdocs\chaima\config.php)
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'collaboration_module');
define('DB_USER', 'root');
define('DB_PASS', '');
// Site configuration
define('SITE_URL', 'http://localhost/chaima');
define('BASE_PATH', __DIR__);
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// PDO Database connection
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // Log the error but don't display it to users
        error_log("Database Connection Error: " . $e->getMessage());
        die("Sorry, there was a problem connecting to the database. Please try again later.");
    }
}

// Create the global connection variable that models use
$conn = getDbConnection();
?>
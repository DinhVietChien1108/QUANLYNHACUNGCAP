<?php
// Database initialization script
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Create connection
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully<br>";
    
    // Read SQL file
    $sql = file_get_contents('database.sql');
    
    // Execute SQL
    $conn->exec($sql);
    
    echo "Database and tables created successfully<br>";
    echo "You can now <a href='index.php'>login</a> to the application.<br>";
    echo "Default login: username: <strong>admin</strong>, password: <strong>admin123</strong>";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
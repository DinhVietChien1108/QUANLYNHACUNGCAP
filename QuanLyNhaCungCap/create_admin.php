<?php
// Script to create admin user with correct password hash
require_once 'config/database.php';

// Database connection
$database = new Database();
$conn = $database->getConnection();

// Admin user details
$username = 'admin';
$password = 'admin123';
$full_name = 'Administrator';
$email = 'admin@example.com';
$role = 'admin';

// Hash password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Check if user already exists
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $username);
$stmt->execute();

if($stmt->rowCount() > 0) {
    // Update existing user
    $query = "UPDATE users SET password = ?, full_name = ?, email = ?, role = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $password_hash);
    $stmt->bindParam(2, $full_name);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $role);
    $stmt->bindParam(5, $username);
    
    if($stmt->execute()) {
        echo "Admin user updated successfully.<br>";
        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Password Hash: " . $password_hash . "<br>";
    } else {
        echo "Failed to update admin user.";
    }
} else {
    // Create new user
    $query = "INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $password_hash);
    $stmt->bindParam(3, $full_name);
    $stmt->bindParam(4, $email);
    $stmt->bindParam(5, $role);
    
    if($stmt->execute()) {
        echo "Admin user created successfully.<br>";
        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Password Hash: " . $password_hash . "<br>";
    } else {
        echo "Failed to create admin user.";
    }
}

echo "<br><a href='index.php'>Go to login page</a>";
?>

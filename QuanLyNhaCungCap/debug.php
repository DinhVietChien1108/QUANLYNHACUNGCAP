<?php
// Debug script to check database connection and users table
require_once 'config/database.php';

// Database connection
$database = new Database();
$conn = $database->getConnection();

if($conn) {
    echo "Database connection successful.<br>";
    
    // Check if users table exists
    try {
        $query = "SELECT * FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        echo "Users table exists.<br>";
        echo "Number of users: " . $stmt->rowCount() . "<br><br>";
        
        // Display users (without password)
        echo "<h3>Users:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Full Name</th><th>Email</th><th>Role</th></tr>";
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Check admin user
        $query = "SELECT * FROM users WHERE username = 'admin'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<br><h3>Admin User:</h3>";
            echo "Username: " . $admin['username'] . "<br>";
            echo "Password Hash: " . $admin['password'] . "<br>";
            
            // Test password verification
            $test_password = 'admin123';
            if(password_verify($test_password, $admin['password'])) {
                echo "Password 'admin123' is valid for this hash.<br>";
            } else {
                echo "Password 'admin123' is NOT valid for this hash.<br>";
            }
        } else {
            echo "<br>Admin user not found.<br>";
        }
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "Database connection failed.<br>";
}

echo "<br><a href='create_admin.php'>Create/Update Admin User</a> | ";
echo "<a href='index.php'>Go to Login Page</a>";
?>

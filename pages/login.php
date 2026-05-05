
<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "clinic";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prevent SQL Injection
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

// Query
$sql = "SELECT * FROM cridentials WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

// Check login
if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();

    echo "Login successful!";
    $_SESSION['user'] =  $row['username'];
        header("Location: dashboard.php");
        exit;
    
} else {
    header("Location: index.php");
}

$conn->close();
?>
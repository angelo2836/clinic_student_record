<?php
$conn = new mysqli("localhost", "root", "", "clinic");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// GET ID FROM FORM
$id = $_POST['record_id'] ?? null;

if ($id) {

    // SAFE QUERY (prevents SQL injection)
    $stmt = $conn->prepare("UPDATE student SET  status = '' WHERE id = ?");
    $stmt->bind_param("i", $id); // use "i" if ID is integer

    if ($stmt->execute()) {
        // success → redirect back
       header("Location: dashboard.php?section=records&deletemodal=deleted");
        exit;
    } else {
        echo "Error deleting record.";
    }

    $stmt->close();

} else {
    echo "No ID received.";
}

$conn->close();
?>
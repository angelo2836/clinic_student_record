<?php
// connect to database
$conn = new mysqli("localhost", "root", "", "clinic");

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get form data
$stud_id = $_POST['stud_id'];
$bdate = $_POST['bdate'];
$name = $_POST['name'];
$age = $_POST['age'];
$program = $_POST['program'];
$pnumber = $_POST['pnumber'];

// insert query
$sql = "INSERT INTO student VALUES ('', '$name', '$stud_id', '$program', 'active', '$bdate', '$age', '$pnumber', '')";
echo $sql;

// execute query
if ($conn->query($sql) === TRUE) {
    echo "New record added successfully!";
     header("Location: dashboard.php?section=records&add=1");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

?>

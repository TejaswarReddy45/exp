<?php
$servername = "localhost"; // Update with your server name
$username = "root"; // Update with your username
$password = ""; // Update with your password
$dbname = "marks_databases"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$student_id = $_POST['student_id'];
$semester = $_POST['semester'];
$sub1 = $_POST['sub1'];
$sub2 = $_POST['sub2'];
$sub3 = $_POST['sub3'];
$sub4 = $_POST['sub4'];
$sub5 = $_POST['sub5'];
$sub6 = $_POST['sub6'];
$sub7 = $_POST['sub7'];
$sub8 = $_POST['sub8'];
$sub9 = $_POST['sub9'];
$sub10 = $_POST['sub10'];
$sub11 = $_POST['sub11'];

// Check if the record already exists
$sql_check = "SELECT * FROM internal_marks WHERE student_id = ? AND semester = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $student_id, $semester);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Record exists, update the existing record
    $sql_update = "UPDATE internal_marks SET 
        sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, 
        sub6 = ?, sub7 = ?, sub8 = ?, sub9 = ?, 
        sub10 = ?, sub11 = ? WHERE student_id = ? AND semester = ?";
    
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssssssss", $sub1, $sub2, $sub3, $sub4, $sub5, 
        $sub6, $sub7, $sub8, $sub9, 
        $sub10, $sub11, $student_id, $semester);
    
    if ($stmt_update->execute()) {
        echo "Marks updated successfully.";
    } else {
        echo "Error updating record: " . $stmt_update->error;
    }
    
    $stmt_update->close();
} else {
    // Record does not exist, insert a new record
    $sql_insert = "INSERT INTO internal_marks (student_id, semester, sub1, sub2, sub3, sub4, sub5, sub6, sub7, sub8, sub9, sub10, sub11) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssssssss", $student_id, $semester, $sub1, $sub2, $sub3, $sub4, $sub5, $sub6, $sub7, $sub8, $sub9, $sub10, $sub11);
    
    if ($stmt_insert->execute()) {
        echo "New marks record created successfully.";
    } else {
        echo "Error: " . $stmt_insert->error;
    }
    
    $stmt_insert->close();
}

// Close connections
$stmt_check->close();
$conn->close();
?>
<a href="#" onclick="history.back()">Back</a>

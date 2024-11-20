<?php
// Database connection details
$host = 'localhost';
$db = 'marks_databases'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo 'Database connection failed.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $external_marks = $_POST['external'];
    $total_marks = $_POST['total'];

    $success = true; // Flag to track overall success
    $message = '';   // Message to return

    foreach ($external_marks as $index => $external) {
        $total = $total_marks[$index];

        // Prepare an SQL statement (Insert or Update)
        $sql = "INSERT INTO external3_marks (student_id, semester, subject, external, total) 
                VALUES (?, ?, '601', ?, ?)
                ON DUPLICATE KEY UPDATE external = VALUES(external), total = VALUES(total)";

        $stmt = $conn->prepare($sql);

        // Check for preparation errors
        if (!$stmt) {
            $success = false;
            $message = 'Error preparing statement: ' . $conn->error;
            break; // Exit the loop if there was an error
        }

        // Bind parameters
        $stmt->bind_param('ssii', $student_id, $semester, $external, $total);

        if (!$stmt->execute()) {
            $success = false;
            $message = 'Some marks were not inserted or updated: ' . $stmt->error;
            break; // Exit the loop if there was an error
        }
    }

    // Determine final message based on success
    if ($success) {
        $message = 'Marks submitted successfully!';
    } else {
        $message = 'Marks not inserted or updated due to an error: ' . $message;
    }

    // Display the message and back button
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Submission Result</title>
    </head>
    <body>
        <h1>$message</h1>
        <a href='#' onclick='history.back()'>Back</a>
    </body>
    </html>";
    exit;
}

$conn->close();
?>

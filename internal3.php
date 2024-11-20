<?php
// Database connection details
$host = 'localhost';
$db = 'marks_databases'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo 'Database connection failed: ' . $conn->connect_error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $internal_marks = $_POST['internal'];
    $total_marks = $_POST['total'];

    $success = true; // Flag to track overall success
    $message = '';   // Message to return

    foreach ($internal_marks as $index => $internal) {
        $total = $total_marks[$index];
        
        // Prepare an SQL statement (Insert or Update)
        $sql = "INSERT INTO internal3_marks (student_id, semester, subject, internal, total) 
                VALUES (?, ?, '601', ?, ?)
                ON DUPLICATE KEY UPDATE internal = VALUES(internal), total = VALUES(total)";
        
        $stmt = $conn->prepare($sql);

        // Check for preparation errors
        if (!$stmt) {
            $success = false;
            $message = 'Error preparing statement: ' . $conn->error;
            break; // Exit the loop if there was an error
        }

        // Bind parameters
        $stmt->bind_param('ssii', $student_id, $semester, $internal, $total);

        if (!$stmt->execute()) {
            $success = false;
            $message = 'Error executing statement: ' . $stmt->error;
            break; // Exit the loop if there was an error
        }

        // Debugging: Output the SQL query for logging (remove in production)
        error_log("Executed query: " . $sql);
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
        <h4>$message</h4>
        <a href='#' onclick='history.back()'>Back</a>
    </body>
    </html>";
    exit;
}

$conn->close();
?>

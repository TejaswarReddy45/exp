<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'marks_databases';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from URL parameter
$student_id = $_GET['student_id'];

// Function to determine the correct table and column based on subject number
function getMarks($student_id, $subject_num, $conn, $type) {
    if ($subject_num >= 1 && $subject_num <= 11) {
        $table = ($type == 'internal') ? 'internal_marks' : 'external_marks';
        $column = "sub{$subject_num}";

        // Fetch the data from the database
        $sql = "SELECT $column FROM $table WHERE student_id = '$student_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row[$column];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

// Create a CSV file
$filename = "marks_$student_id.csv";
$fp = fopen($filename, "w");

// Write header row
fputcsv($fp, array("Student ID", "Subject", "Internal Marks", "External Marks", "Total Marks", "Result"));

// Write marks data for all subjects (1 to 11)
for ($i = 1; $i <= 11; $i++) {
    // Get internal and external marks for the subject
    $internal = getMarks($student_id, $i, $conn, 'internal');
    $external = getMarks($student_id, $i, $conn, 'external');
    
    // Only process if we have marks for both internal and external
    if ($internal !== null && $external !== null) {
        $total_marks = $internal + $external;
        $pass_fail = (($internal < 7) || ($external < 28) || ($total_marks < 35)) ? 'Fail' : 'Pass';
        fputcsv($fp, array($student_id, "Subject $i", $internal, $external, $total_marks, $pass_fail));
    }
}

// Close the file
fclose($fp);

// Send the file to the user
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: text/csv");
readfile($filename);

// Delete the file after sending
unlink($filename);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Page</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Marks Display</h2>
    <table id="marksTable">
        <!-- Table content will be dynamically inserted or hardcoded if needed -->
    </table>

    <!-- Only Back and Screenshot buttons -->
    <div class="buttons">
        <a href="#" onclick="history.back()">Back</a>
        <a href="#" onclick="takeScreenshot()">Screenshot</a>
    </div>

    <script>
        // Function to take a screenshot using html2canvas
        function takeScreenshot() {
            html2canvas(document.getElementById("marksTable")).then(function (canvas) {
                var link = document.createElement('a');
                link.href = canvas.toDataURL();
                link.download = 'marks_screenshot.png';
                link.click();
            });
        }
    </script>
</body>
</html>

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

// Get student ID and semester from form submission
$student_id = $_POST['student_id'];
$semester = $_POST['semester'];

// Escape special characters in inputs
$student_id = $conn->real_escape_string($student_id);
$semester = $conn->real_escape_string($semester);

// Retrieve external marks
$sql_ext = "SELECT * FROM external_marks WHERE student_id = '$student_id' AND semester = '$semester'";
$result_ext = $conn->query($sql_ext);

// Retrieve internal marks
$sql_int = "SELECT * FROM internal_marks WHERE student_id = '$student_id' AND semester = '$semester'";
$result_int = $conn->query($sql_int);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- Include html2canvas -->
</head>
<body>

<?php
// Check if both queries returned results
if ($result_ext->num_rows > 0 && $result_int->num_rows > 0) {
    $ext_marks = $result_ext->fetch_assoc();
    $int_marks = $result_int->fetch_assoc();

    // Display student ID and semester
    echo "<h2>Student ID: {$ext_marks['student_id']}</h2>";
    echo "<h3>Semester: {$ext_marks['semester']}</h3>";

    // Initialize total marks
    $total_ext_marks = 0;
    $total_int_marks = 0;
    $total_marks = 0;
    $has_fail = false; // Track if there's any fail

    // Display marks in a table
    echo "<table>";
    echo "<tr><th>Subject</th><th>External Marks</th><th>Internal Marks</th><th>Total Marks</th><th>Result</th></tr>";

    for ($i = 1; $i <= 11; $i++) { // Loop for 11 subjects
        $ext_mark = isset($ext_marks['sub' . $i]) ? $ext_marks['sub' . $i] : 0;
        $int_mark = isset($int_marks['sub' . $i]) ? $int_marks['sub' . $i] : 0;
        $total_mark = $ext_mark + $int_mark;

        // Update total marks
        $total_ext_marks += $ext_mark;
        $total_int_marks += $int_mark;
        $total_marks += $total_mark;

        // Determine result based on external marks
        $result = ($ext_mark > 35) ? "<span class='pass'>Pass</span>" : "<span class='fail'>Fail</span>";
        if ($ext_mark <= 35) {
            $has_fail = true; // Mark as fail if any subject has failed
        }

        echo "<tr>";
        echo "<td>Subject $i</td>";
        echo "<td>$ext_mark</td>";
        echo "<td>$int_mark</td>";
        echo "<td>$total_mark</td>";
        echo "<td>$result</td>";
        echo "</tr>";
    }

    // Overall result
    $overall_result = $has_fail ? "<span class='overall-fail'><strong>Fail</strong></span>" : "<span class='overall-pass'><strong>Pass</strong></span>";

    // Calculate percentage
    $total_possible_marks = 100 * 11; // Assuming each subject has a maximum of 100 marks (external + internal) and 11 subjects
    $percentage = ($total_marks / $total_possible_marks) * 100;

    echo "<tr>";
    echo "<td><strong>Total</strong></td>";
    echo "<td><strong>$total_ext_marks</strong></td>";
    echo "<td><strong>$total_int_marks</strong></td>";
    echo "<td><strong>$total_marks</strong></td>";
    echo "<td>$overall_result</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='5'><strong>Percentage: " . number_format($percentage, 2) . "%</strong></td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "No data found for the given student ID and semester.";
}

$conn->close();
?>

<!-- Buttons -->
<div class="button-container">
    <a href="javascript:history.back()">Back</a>
   
    <!-- Screenshot button -->
    <button id="screenshotBtn">Screenshot</button>
    <p id="screenshotMessage" style="display:none;">Screenshot taken!</p> <!-- Message for feedback -->
</div>

<script>
// JavaScript for capturing screenshot of the entire page
document.getElementById("screenshotBtn").addEventListener("click", function() {
    html2canvas(document.body).then(function(canvas) {
        // Convert canvas to a downloadable image
        var link = document.createElement('a');
        link.download = 'marks_screenshot.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
        
        // Show a message to indicate the screenshot has been taken
        var message = document.getElementById('screenshotMessage');
        message.style.display = 'block';
        
        // Hide the message after 2 seconds
        setTimeout(function() {
            message.style.display = 'none';
        }, 2000);
    });
});
</script>

</body>
</html>

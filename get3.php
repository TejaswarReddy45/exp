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

// Get student ID and semester from URL or form submission
$student_id = $_POST['student_id'];
$semester = $_POST['semester'];

// Escape special characters in inputs
$student_id = $conn->real_escape_string($student_id);
$semester = $conn->real_escape_string($semester);

// Retrieve external marks from external3_marks table
$sql_ext = "SELECT * FROM external3_marks WHERE student_id = '$student_id' AND semester = '$semester'";
$result_ext = $conn->query($sql_ext);

// Retrieve internal marks from internal3_marks table
$sql_int = "SELECT * FROM internal3_marks WHERE student_id = '$student_id' AND semester = '$semester'";
$result_int = $conn->query($sql_int);

$external_marks = [];
$internal_marks = [];

// Fetch external marks
while ($row = $result_ext->fetch_assoc()) {
    $external_marks[$row['subject']] = $row['external'];
}

// Fetch internal marks
while ($row = $result_int->fetch_assoc()) {
    $internal_marks[$row['subject']] = $row['total'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks</title>
    <link rel="stylesheet" href="css.css"> <!-- Link to the external CSS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- Updated html2canvas version -->
    <style>
        /* Add some basic styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .pass {
            color: green;
        }
        .fail {
            color: red;
        }
        .overall-pass {
            color: green;
        }
        .overall-fail {
            color: red;
        }
        .button-container {
            margin-top: 20px;
        }
        #screenshot {
            display: none; /* Hide screenshot area */
        }
    </style>
</head>
<body>

<?php
// Check if there are any marks
if (!empty($external_marks) || !empty($internal_marks)) {
    echo "<h2>Student ID: $student_id</h2>";
    echo "<h3>Semester: $semester</h3>";

    // Initialize total marks
    $total_ext_marks = 0;
    $total_int_marks = 0;
    $total_marks = 0;
    $has_fail = false; // Track if there's any fail

    // Display marks in a table
    echo "<table>";
    echo "<tr><th>Subject</th><th>External Marks</th><th>Internal Marks</th><th>Total Marks</th><th>Result</th></tr>";

    foreach ($external_marks as $subject => $ext_mark) {
        $int_mark = isset($internal_marks[$subject]) ? $internal_marks[$subject] : 0;
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
        echo "<td>$subject</td>";
        echo "<td>$ext_mark</td>";
        echo "<td>$int_mark</td>";
        echo "<td>$total_mark</td>";
        echo "<td>$result</td>";
        echo "</tr>";
    }

    // Overall result
    $overall_result = $has_fail ? "<span class='overall-fail'><strong>Fail</strong></span>" : "<span class='overall-pass'><strong>Pass</strong></span>";

    echo "<tr>";
    echo "<td><strong>Total</strong></td>";
    echo "<td><strong>$total_ext_marks</strong></td>";
    echo "<td><strong>$total_int_marks</strong></td>";
    echo "<td><strong>$total_marks</strong></td>";
    echo "<td>$overall_result</td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "No data found for the given student ID and semester.";
}
?>

<!-- Screenshot Button -->
<button id="screenshot-button">Take Screenshot</button>

<!-- Back button -->
<div class="button-container">
    <a href="javascript:history.back()">Back</a>
</div>

<script>
document.getElementById('screenshot-button').addEventListener('click', function() {
    html2canvas(document.body).then(function(canvas) {
        // Create a link to download the image
        var link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'screenshot.png';
        link.click();

        // Optionally, display the screenshot
        var screenshotContainer = document.createElement('div');
        screenshotContainer.id = 'screenshot';
        screenshotContainer.appendChild(canvas);
        document.body.appendChild(screenshotContainer);
    });
});
</script>

</body>
</html>

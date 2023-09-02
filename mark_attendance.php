<?php
session_start();
include('config.php');

// Check if a member is logged in
if (!isset($_SESSION["member_id"])) {
    header("Location: ogin.php");
    exit;
}

$memberID = $_SESSION["member_id"];

// Check if the class ID is provided as a parameter
if (isset($_GET["class_id"])) {
    $classID = $_GET["class_id"];
} else {
    // Redirect to the member dashboard or display an error message
    header("Location: member_dashboard.php");
    exit;
}

// Check if the class exists and is available for the member's level
$sql = "SELECT * FROM Classes WHERE ClassID = $classID AND Level_id = (
    SELECT membership_level FROM members WHERE MemberID = $memberID
)";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    // Redirect to the member dashboard or display an error message
    header("Location: member_dashboard.php");
    exit;
}

$classRow = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendanceDate = $_POST['attendance_date'];
    $checkInTime = $_POST['check_in_time'];
    $checkOutTime = $_POST['check_out_time'];

    // SQL query to insert attendance data into the database
    $sql = "INSERT INTO Attendance (MemberID, ClassID, Attendance_Date, Check_in_Time, Check_out_Time)
            VALUES ($memberID, $classID, '$attendanceDate', '$checkInTime', '$checkOutTime')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the member dashboard with a success message
        header("Location: member_dashboard.php?attendance_success=1");
        exit;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Mark Attendance for <?php echo $classRow["Class_Name"]; ?></h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?class_id=$classID"; ?>" method="post">
        <div class="form-group">
            <label for="attendance_date">Attendance Date:</label>
            <input type="date" class="form-control" id="attendance_date" name="attendance_date" required>
        </div>

        <div class="form-group">
            <label for="check_in_time">Check-in Time:</label>
            <input type="time" class="form-control" id="check_in_time" name="check_in_time" required>
        </div>

        <div class="form-group">
            <label for="check_out_time">Check-out Time:</label>
            <input type="time" class="form-control" id="check_out_time" name="check_out_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Mark Attendance</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

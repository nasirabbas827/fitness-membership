<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch attendance records for all members
$sql = "SELECT a.AttendanceID, m.Name AS MemberName, c.Class_Name, a.Attendance_Date, a.Check_in_Time, a.Check_out_Time
        FROM Attendance AS a
        INNER JOIN members AS m ON a.MemberID = m.MemberID
        INNER JOIN Classes AS c ON a.ClassID = c.ClassID
        ORDER BY a.Attendance_Date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Attendance</title>
    <!-- Include Bootstrap CSS and custom CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>Attendance Records for All Members</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Attendance ID</th>
                <th>Member Name</th>
                <th>Class Name</th>
                <th>Attendance Date</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['AttendanceID'] . "</td>";
                echo "<td>" . $row['MemberName'] . "</td>";
                echo "<td>" . $row['Class_Name'] . "</td>";
                echo "<td>" . $row['Attendance_Date'] . "</td>";
                echo "<td>" . $row['Check_in_Time'] . "</td>";
                echo "<td>" . $row['Check_out_Time'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

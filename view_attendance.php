<?php
session_start();
include('config.php');

// Check if a member is logged in
if (!isset($_SESSION["member_id"])) {
    header("Location: login.php");
    exit;
}

$memberID = $_SESSION["member_id"];
$memberName = $_SESSION["member_name"];

// Fetch the member's attendance history
$sql = "SELECT a.AttendanceID, c.Class_Name, a.Attendance_Date, a.Check_in_Time, a.Check_out_Time
        FROM Attendance AS a
        INNER JOIN Classes AS c ON a.ClassID = c.ClassID
        WHERE a.MemberID = $memberID
        ORDER BY a.Attendance_Date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Attendance History for <?php echo $memberName; ?></h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Attendance ID</th>
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

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

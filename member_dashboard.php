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
$memberEmail = $_SESSION["member_email"];

// Fetch the member's level
$sql = "SELECT membership_level FROM members WHERE MemberID = $memberID";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $memberLevel = $row["membership_level"];
} else {
    // Handle the case where the member's level is not found
    $memberLevel = -1; // Set a default value or show an error
}

// Fetch member's subscribed level
$levelSql = "SELECT level_name FROM membership_levels WHERE LevelID = $memberLevel";
$levelResult = $conn->query($levelSql);

if ($levelResult->num_rows == 1) {
    $levelRow = $levelResult->fetch_assoc();
    $memberSubscribedLevel = $levelRow["level_name"];
} else {
    // Handle the case where the subscribed level is not found
    $memberSubscribedLevel = "N/A"; // Set a default value or show an error
}

// Fetch classes for the member's level
$classSql = "SELECT ClassID, Class_Name, Instructor_Name, Schedule FROM Classes WHERE Level_id = $memberLevel";
$classResult = $conn->query($classSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Welcome to the Member Dashboard, <?php echo $memberName; ?></h2>
    
    <!-- Display the member's subscribed level -->
    <p>Your Subscribed Level: <?php echo $memberSubscribedLevel; ?></p>

    <h3>Your Classes</h3>

    <div class="row">
        <?php
        while ($classRow = $classResult->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $classRow["Class_Name"] . '</h5>';
            echo '<p class="card-text">Instructor: ' . $classRow["Instructor_Name"] . '</p>';
            echo '<p class="card-text">Schedule: ' . $classRow["Schedule"] . '</p>';
            echo '<a href="mark_attendance.php?class_id=' . $classRow["ClassID"] . '" class="btn btn-primary">Mark Attendance</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

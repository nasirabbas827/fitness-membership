<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete class if the delete action is triggered
if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["class_id"])) {
    $classID = $_GET["class_id"];
    
    // SQL query to delete the class by ClassID
    $deleteSql = "DELETE FROM Classes WHERE ClassID = $classID";
    
    if ($conn->query($deleteSql) === TRUE) {
        echo "Class deleted successfully!";
    } else {
        echo "Error deleting class: " . $conn->error;
    }
}

// Fetch all classes
$sql = "SELECT c.ClassID, ml.level_name, c.Class_Name, c.Instructor_Name, c.Schedule, c.Maximum_Capacity, c.Description
        FROM Classes AS c
        INNER JOIN membership_levels AS ml ON c.Level_id = ml.LevelID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classes</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include your custom style.css file -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>View Classes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class ID</th>
                <th>Level</th>
                <th>Class Name</th>
                <th>Instructor Name</th>
                <th>Schedule</th>
                <th>Maximum Capacity</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ClassID'] . "</td>";
                echo "<td>" . $row['level_name'] . "</td>";
                echo "<td>" . $row['Class_Name'] . "</td>";
                echo "<td>" . $row['Instructor_Name'] . "</td>";
                echo "<td>" . $row['Schedule'] . "</td>";
                echo "<td>" . $row['Maximum_Capacity'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>
                        <a href='edit_classes.php?class_id=" . $row['ClassID'] . "' class='mb-2 btn btn-primary'>Edit</a>
                        <a href='view_classes.php?action=delete&class_id=" . $row['ClassID'] . "' class='btn btn-danger'>Delete</a>
                      </td>";
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


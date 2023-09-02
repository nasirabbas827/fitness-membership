<?php
session_start();
include('config.php');

// Check if a member is logged in
if (!isset($_SESSION["member_id"])) {
    header("Location: member_login.php");
    exit;
}

$memberID = $_SESSION["member_id"];
$memberName = $_SESSION["member_name"];

// Handle delete action if requested
if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["progress_id"])) {
    $progressID = $_GET["progress_id"];
    // Add additional validation and security checks before performing the deletion
    $deleteSql = "DELETE FROM progress_tracking WHERE ProgressID = $progressID AND MemberID = $memberID";
    if ($conn->query($deleteSql) === TRUE) {
        // Redirect back to the progress tracking page after deletion
        header("Location: view_progress.php");
        exit;
    } else {
        $deleteError = "Error deleting progress record: " . $conn->error;
    }
}

// Fetch the member's progress tracking records
$sql = "SELECT * FROM progress_tracking WHERE MemberID = $memberID ORDER BY Date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking for <?php echo $memberName; ?></title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Progress Tracking for <?php echo $memberName; ?></h2>

    <?php
    if (isset($deleteError)) {
        echo "<p style='color: red;'>$deleteError</p>";
    }
    ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight (kg)</th>
                <th>Body Measurements</th>
                <th>Fitness Achievements</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . $row['Weight'] . "</td>";
                echo "<td>" . $row['Body_Measurements'] . "</td>";
                echo "<td>" . $row['Fitness_Achievements'] . "</td>";
                echo "<td>
                        <a href='edit_progress.php?progress_id=" . $row['ProgressID'] . "' class='btn btn-primary'>Edit</a>
                        <a href='view_progress.php?action=delete&progress_id=" . $row['ProgressID'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                      </td>";
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


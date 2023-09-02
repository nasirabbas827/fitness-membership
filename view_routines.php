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
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["routine_id"])) {
    $routineID = $_GET["routine_id"];
    
    // Add additional validation and security checks before performing the deletion
    $deleteSql = "DELETE FROM fitness_training_routines WHERE RoutineID = $routineID AND MemberID = $memberID";
    
    if ($conn->query($deleteSql) === TRUE) {
        // Redirect back to the fitness training routines page after deletion
        header("Location: view_routines.php");
        exit;
    } else {
        $deleteError = "Error deleting routine: " . $conn->error;
    }
}

// Fetch the member's fitness training routines
$sql = "SELECT * FROM fitness_training_routines WHERE MemberID = $memberID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Training Routines for <?php echo $memberName; ?></title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Fitness Training Routines for <?php echo $memberName; ?></h2>

    <?php
    if (isset($deleteError)) {
        echo "<p style='color: red;'>$deleteError</p>";
    }
    ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Routine Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Routine_Name'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>
                        <a href='edit_routines.php?routine_id=" . $row['RoutineID'] . "' class='btn btn-primary'>Edit</a>
                        <a href='view_routines.php?action=delete&routine_id=" . $row['RoutineID'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this routine?\");'>Delete</a>
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


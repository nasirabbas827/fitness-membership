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

// Ensure that the routine_id is provided in the URL
if (!isset($_GET["routine_id"])) {
    header("Location: view_routines.php");
    exit;
}

$routineID = $_GET["routine_id"];

// Fetch the existing routine data
$sql = "SELECT * FROM fitness_training_routines WHERE RoutineID = $routineID AND MemberID = $memberID";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    // Redirect if the routine does not exist or does not belong to the member
    header("Location: view_routines.php");
    exit;
}

$row = $result->fetch_assoc();

// Handle routine update if requested
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_routine"])) {
    $editedRoutineName = $_POST["edited_routine_name"];
    $editedDescription = $_POST["edited_description"];
    $editedDate = $_POST["edited_date"];
    
    // Add additional validation and security checks before performing the update
    $updateSql = "UPDATE fitness_training_routines SET Routine_Name = '$editedRoutineName', Description = '$editedDescription', Date = '$editedDate' WHERE RoutineID = $routineID AND MemberID = $memberID";
    
    if ($conn->query($updateSql) === TRUE) {
        // Redirect back to the fitness training routines page after update
        header("Location: view_routines.php");
        exit;
    } else {
        $updateError = "Error updating routine: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fitness Training Routine</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Edit Fitness Training Routine</h2>

    <?php
    if (isset($updateError)) {
        echo "<p style='color: red;'>$updateError</p>";
    }
    ?>

    <form method="post">
        <div class="form-group">
            <label for="edited_routine_name">Routine Name:</label>
            <input type="text" class="form-control" id="edited_routine_name" name="edited_routine_name" value="<?php echo $row['Routine_Name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="edited_description">Description:</label>
            <textarea class="form-control" id="edited_description" name="edited_description" rows="4" cols="50" required><?php echo $row['Description']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="edited_date">Date:</label>
            <input type="date" class="form-control" id="edited_date" name="edited_date" value="<?php echo $row['Date']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="edit_routine">Save Changes</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


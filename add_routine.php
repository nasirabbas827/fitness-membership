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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $routineName = $_POST['routine_name'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // SQL query to insert fitness training routine data into the database
    $sql = "INSERT INTO fitness_training_routines (MemberID, Routine_Name, Description, Date)
            VALUES ($memberID, '$routineName', '$description', '$date')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the member's fitness training routines page after adding
        header("Location: add_routine.php");
        exit;
    } else {
        $addError = "Error adding fitness training routine: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Fitness Training Routine</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Add Fitness Training Routine for <?php echo $memberName; ?></h2>

    <?php
    if (isset($addError)) {
        echo "<p style='color: red;'>$addError</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="routine_name">Routine Name:</label>
            <input type="text" class="form-control" id="routine_name" name="routine_name" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Routine</button>
        <a href="view_routines.php" class="btn btn-secondary">View Routines</a>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


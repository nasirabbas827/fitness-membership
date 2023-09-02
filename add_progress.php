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

// Process the form submission for adding progress details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $bodyMeasurements = $_POST['body_measurements'];
    $fitnessAchievements = $_POST['fitness_achievements'];

    // SQL query to insert progress details into the database
    $sql = "INSERT INTO progress_tracking (MemberID, Date, Weight, Body_Measurements, Fitness_Achievements)
            VALUES ($memberID, '$date', '$weight', '$bodyMeasurements', '$fitnessAchievements')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the member's progress tracking page or show a success message
        header("Location: add_progress.php?progress_added=1");
        exit;
    } else {
        $error = "Error adding progress details: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Progress Details</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Add Progress Details for <?php echo $memberName; ?></h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="weight">Weight (in kg):</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="body_measurements">Body Measurements:</label>
            <input type="text" class="form-control" id="body_measurements" name="body_measurements" required>
        </div>

        <div class="form-group">
            <label for="fitness_achievements">Fitness Achievements:</label>
            <textarea class="form-control" id="fitness_achievements" name="fitness_achievements" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Progress</button>
        <a href="view_progress.php" class="btn btn-secondary">View Progress</a>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


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

// Handle edit action if requested
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $progressID = $_POST['progress_id'];
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $bodyMeasurements = $_POST['body_measurements'];
    $fitnessAchievements = $_POST['fitness_achievements'];

    // SQL query to update progress details
    $updateSql = "UPDATE progress_tracking 
                  SET Date = '$date', Weight = '$weight', Body_Measurements = '$bodyMeasurements', Fitness_Achievements = '$fitnessAchievements'
                  WHERE ProgressID = $progressID AND MemberID = $memberID";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect back to the progress tracking page after updating
        header("Location: view_progress.php");
        exit;
    } else {
        $updateError = "Error updating progress record: " . $conn->error;
    }
}

// Fetch progress details based on progress_id
if (isset($_GET['progress_id'])) {
    $progressID = $_GET['progress_id'];
    $sql = "SELECT * FROM progress_tracking WHERE ProgressID = $progressID AND MemberID = $memberID";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $date = $row['Date'];
        $weight = $row['Weight'];
        $bodyMeasurements = $row['Body_Measurements'];
        $fitnessAchievements = $row['Fitness_Achievements'];
    } else {
        // Redirect back to the progress tracking page if the record is not found
        header("Location: view_progress.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Progress Details</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Edit Progress Details for <?php echo $memberName; ?></h2>

    <?php
    if (isset($updateError)) {
        echo "<p style='color: red;'>$updateError</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="progress_id" value="<?php echo $progressID; ?>">

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" required>
        </div>

        <div class="form-group">
            <label for="weight">Weight (in kg):</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="<?php echo $weight; ?>" required>
        </div>

        <div class="form-group">
            <label for="body_measurements">Body Measurements:</label>
            <input type="text" class="form-control" id="body_measurements" name="body_measurements" value="<?php echo $bodyMeasurements; ?>" required>
        </div>

        <div class="form-group">
            <label for="fitness_achievements">Fitness Achievements:</label>
            <textarea class="form-control" id="fitness_achievements" name="fitness_achievements" rows="4" required><?php echo $fitnessAchievements; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Progress</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


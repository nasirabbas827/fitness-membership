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

// Handle diet plan submission if requested
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_diet_plan"])) {
    $planName = $_POST["plan_name"];
    $description = $_POST["description"];
    $date = $_POST["date"];
    
    // Add additional validation and security checks before inserting
    $insertSql = "INSERT INTO diet_plans (MemberID, Plan_Name, Description, Date)
                  VALUES ($memberID, '$planName', '$description', '$date')";
    
    if ($conn->query($insertSql) === TRUE) {
        // Redirect back to the diet plans page after submission
        header("Location: view_plans.php");
        exit;
    } else {
        $insertError = "Error adding diet plan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Diet Plan</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Add Diet Plan</h2>

    <?php
    if (isset($insertError)) {
        echo "<p style='color: red;'>$insertError</p>";
    }
    ?>

    <form method="post">
        <div class="form-group">
            <label for="plan_name">Plan Name:</label>
            <input type="text" class="form-control" id="plan_name" name="plan_name" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" cols="50" required></textarea>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <button type="submit" class="btn btn-primary" name="add_diet_plan">Add Diet Plan</button>
        <a href="view_plans.php" class="btn btn-secondary">View Diet Plans</a>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


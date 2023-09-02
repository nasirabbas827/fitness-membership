<?php
session_start();
include('config.php');

// Check if a member is logged in
if (!isset($_SESSION["member_id"])) {
    header("Location: member_login.php");
    exit;
}

$memberID = $_SESSION["member_id"];

// Check if the diet plan ID is provided in the URL
if (!isset($_GET["diet_plan_id"])) {
    header("Location: view_diet_plans.php");
    exit;
}

$dietPlanID = $_GET["diet_plan_id"];

// Fetch the member's diet plan data
$sql = "SELECT * FROM diet_plans WHERE DietPlanID = $dietPlanID AND MemberID = $memberID";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    // Diet plan not found or unauthorized access
    header("Location: view_plans.php");
    exit;
}

$row = $result->fetch_assoc();

// Handle form submission for editing the diet plan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_diet_plan"])) {
    $editedPlanName = $_POST["edited_plan_name"];
    $editedDescription = $_POST["edited_description"];
    $editedDate = $_POST["edited_date"];
    
    // Add additional validation and security checks before performing the update
    $updateSql = "UPDATE diet_plans SET Plan_Name = '$editedPlanName', Description = '$editedDescription', Date = '$editedDate' WHERE DietPlanID = $dietPlanID AND MemberID = $memberID";
    
    if ($conn->query($updateSql) === TRUE) {
        // Redirect back to the diet plans page after update
        header("Location: view_plans.php");
        exit;
    } else {
        $updateError = "Error updating diet plan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Diet Plan</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Edit Diet Plan</h2>

    <?php
    if (isset($updateError)) {
        echo "<p style='color: red;'>$updateError</p>";
    }
    ?>

    <form method="post">
        <div class="form-group">
            <label for="edited_plan_name">Plan Name:</label>
            <input type="text" class="form-control" id="edited_plan_name" name="edited_plan_name" value="<?php echo $row['Plan_Name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="edited_description">Description:</label>
            <textarea class="form-control" id="edited_description" name="edited_description" rows="4" cols="50" required><?php echo $row['Description']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="edited_date">Date:</label>
            <input type="date" class="form-control" id="edited_date" name="edited_date" value="<?php echo $row['Date']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="edit_diet_plan">Save Changes</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

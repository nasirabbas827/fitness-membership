<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $levelID = $_POST['level_id'];
    $levelName = $_POST['level_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $features = $_POST['features'];
    $duration = $_POST['duration'];

    // SQL query to update level data
    $updateSql = "UPDATE membership_levels
                  SET level_name = '$levelName', description = '$description', price = '$price',
                      features = '$features', duration = '$duration'
                  WHERE LevelID = $levelID";

    if ($conn->query($updateSql) === TRUE) {
        echo "Level updated successfully!";
        header('location:view_levels.php');
        exit();
    } else {
        echo "Error updating level: " . $conn->error;
    }
}

// Fetch level details for editing
if (isset($_GET['level_id'])) {
    $levelID = $_GET['level_id'];
    $selectSql = "SELECT * FROM membership_levels WHERE LevelID = $levelID";
    $result = $conn->query($selectSql);
    $levelData = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Membership Level</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5 mb-5">
    <h2>Edit Membership Level</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="level_id" value="<?php echo $levelData['LevelID']; ?>">

        <div class="form-group">
            <label for="level_name">Level Name:</label>
            <input type="text" class="form-control" id="level_name" name="level_name" value="<?php echo $levelData['level_name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $levelData['description']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $levelData['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="features">Features (comma-separated):</label>
            <input type="text" class="form-control" id="features" name="features" value="<?php echo $levelData['features']; ?>" required>
        </div>

        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $levelData['duration']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Level</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

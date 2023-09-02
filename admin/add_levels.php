<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get data from the form
    $levelName = $_POST['level_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $features = $_POST['features'];
    $duration = $_POST['duration'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO membership_levels (level_name, description, price, features, duration)
            VALUES ('$levelName', '$description', '$price', '$features', '$duration')";

    if ($conn->query($sql) === TRUE) {
        echo "Membership level added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Membership Level</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5 mb-5">
    <h2>Add Membership Level</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="level_name">Level Name:</label>
                    <input type="text" class="form-control" id="level_name" name="level_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="features">Features (comma-separated):</label>
                    <input type="text" class="form-control" id="features" name="features" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration:</label>
                    <input type="text" class="form-control" id="duration" name="duration" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Add Level</button>
                <a href="view_levels.php" class="btn btn-secondary">View Levels</a>
            </div>
        </div>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

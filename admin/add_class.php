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
    $levelID = $_POST['level_id'];
    $className = $_POST['class_name'];
    $instructorName = $_POST['instructor_name'];
    $schedule = $_POST['schedule'];
    $maxCapacity = $_POST['max_capacity'];
    $description = $_POST['description'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO Classes (Level_id, Class_Name, Instructor_Name, Schedule, Maximum_Capacity, Description)
            VALUES ('$levelID', '$className', '$instructorName', '$schedule', '$maxCapacity', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "Class added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>Add Class</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="level_id">Level:</label>
                    <select class="form-control" id="level_id" name="level_id" required>
                        <!-- Fetch and populate the level names from the membership_levels table -->
                        <?php
                        include('config.php');
                        $levelQuery = "SELECT LevelID, level_name FROM membership_levels";
                        $levelResult = $conn->query($levelQuery);
                        while ($row = $levelResult->fetch_assoc()) {
                            echo "<option value='" . $row['LevelID'] . "'>" . $row['level_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="class_name">Class Name:</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="instructor_name">Instructor Name:</label>
                    <input type="text" class="form-control" id="instructor_name" name="instructor_name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="schedule">Schedule:</label>
                    <input type="datetime-local" class="form-control" id="schedule" name="schedule" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="max_capacity">Maximum Capacity:</label>
                    <input type="number" class="form-control" id="max_capacity" name="max_capacity" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Add Class</button>
                <a href="view_classes.php" class="btn btn-secondary">View Classes</a>
            </div>
        </div>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

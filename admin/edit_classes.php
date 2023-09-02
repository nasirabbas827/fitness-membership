<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["class_id"])) {
    $classID = $_GET["class_id"];
    
    // Retrieve class data by ClassID
    $sql = "SELECT * FROM Classes WHERE ClassID = $classID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $levelID = $row['Level_id'];
        $className = $row['Class_Name'];
        $instructorName = $row['Instructor_Name'];
        $schedule = $row['Schedule'];
        $maxCapacity = $row['Maximum_Capacity'];
        $description = $row['Description'];
    } else {
        echo "Class not found.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["class_id"])) {
    // Handle form submission for editing class data
    $classID = $_POST["class_id"];
    $levelID = $_POST["level_id"];
    $className = $_POST["class_name"];
    $instructorName = $_POST["instructor_name"];
    $schedule = $_POST["schedule"];
    $maxCapacity = $_POST["max_capacity"];
    $description = $_POST["description"];
    
    // Update class data in the database
    $sql = "UPDATE Classes SET
            Level_id = '$levelID',
            Class_Name = '$className',
            Instructor_Name = '$instructorName',
            Schedule = '$schedule',
            Maximum_Capacity = '$maxCapacity',
            Description = '$description'
            WHERE ClassID = $classID";
    
    if ($conn->query($sql) === TRUE) {
        echo "Class data updated successfully!";
    } else {
        echo "Error updating class data: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5 mb-5">
    <h2>Edit Class</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="class_id" value="<?php echo $classID; ?>">
        
        <div class="form-group">
            <label for="level_id">Level:</label>
            <select class="form-control" id="level_id" name="level_id" required>
                <!-- Fetch and populate the level names from the membership_levels table -->
                <?php
                include('config.php');
                $levelQuery = "SELECT LevelID, level_name FROM membership_levels";
                $levelResult = $conn->query($levelQuery);
                while ($row = $levelResult->fetch_assoc()) {
                    $selected = ($row['LevelID'] == $levelID) ? 'selected' : '';
                    echo "<option value='" . $row['LevelID'] . "' $selected>" . $row['level_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="class_name">Class Name:</label>
            <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo $className; ?>" required>
        </div>

        <div class="form-group">
            <label for="instructor_name">Instructor Name:</label>
            <input type="text" class="form-control" id="instructor_name" name="instructor_name" value="<?php echo $instructorName; ?>" required>
        </div>

        <div class="form-group">
            <label for="schedule">Schedule:</label>
            <input type="datetime-local" class="form-control" id="schedule" name="schedule" value="<?php echo date("Y-m-d\TH:i:s", strtotime($schedule)); ?>" required>
        </div>

        <div class="form-group">
            <label for="max_capacity">Maximum Capacity:</label>
            <input type="number" class="form-control" id="max_capacity" name="max_capacity" value="<?php echo $maxCapacity; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $description; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all membership levels from the database
$sql = "SELECT * FROM membership_levels";
$result = $conn->query($sql);

// Process form submission for editing or deleting a level
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_level'])) {
        // Code to update the level's data based on form input
    } elseif (isset($_POST['delete_level'])) {
        $levelID = $_POST['level_id'];
        $deleteSql = "DELETE FROM membership_levels WHERE LevelID = $levelID";
        if ($conn->query($deleteSql) === TRUE) {
            echo "Level deleted successfully!";
        } else {
            echo "Error deleting level: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Membership Levels</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5">
    <h2>Manage Membership Levels</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Level Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Features</th>
                <th>Duration</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['level_name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['features'] . "</td>";
                echo "<td>" . $row['duration'] . "</td>";
                echo "<td><a href='edit_levels.php?level_id=" . $row['LevelID'] . "' class='btn btn-primary btn-sm'>Edit</a></td>";
                echo "<td>
                        <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this level?\")'>
                            <input type='hidden' name='level_id' value='" . $row['LevelID'] . "'>
                            <button type='submit' name='delete_level' class='btn btn-danger btn-sm'>Delete</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include('config.php');

// Check if a member is logged in
if (!isset($_SESSION["member_id"])) {
    header("Location: login.php");
    exit;
}

$memberID = $_SESSION["member_id"];
$memberName = $_SESSION["member_name"];

// Fetch the member's existing profile information
$sql = "SELECT * FROM members WHERE MemberID = $memberID";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Store existing profile information in variables
    $existingName = $row['name'];
    $existingEmail = $row['email'];
    $existingPhone = $row['phone'];
    $existingAddress = $row['address'];
} else {
    // Handle the case where the member's profile is not found
    // You can redirect or show an error message
}

// Process the form submission for updating the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedName = $_POST['name'];
    $updatedEmail = $_POST['email'];
    $updatedPhone = $_POST['phone'];
    $updatedAddress = $_POST['address'];

    // Update the member's profile information in the database
    $updateSql = "UPDATE members
                  SET name = '$updatedName', email = '$updatedEmail', phone = '$updatedPhone', address = '$updatedAddress'
                  WHERE MemberID = $memberID";

    if ($conn->query($updateSql) === TRUE) {
        // Update the session variables with the new profile information
        $_SESSION["member_name"] = $updatedName;
        $_SESSION["member_email"] = $updatedEmail;

        // Redirect to the member dashboard or show a success message
        header("Location: member_dashboard.php?profile_updated=1");
        exit;
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Update Your Profile, <?php echo $memberName; ?></h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $existingName; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $existingEmail; ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $existingPhone; ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $existingAddress; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

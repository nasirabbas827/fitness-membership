<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["member_id"])) {
    $memberID = $_GET["member_id"];
    
    // Retrieve member data by ID
    $sql = "SELECT * FROM members WHERE MemberID = $memberID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $gender = $row['gender'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];
        $membershipStartDate = $row['membership_start_date'];
        $membershipExpiryDate = $row['membership_expiry_date'];
        $membershipLevel = $row['membership_level'];

    } else {
        echo "Member not found.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["member_id"])) {
    // Handle form submission for editing member data
    $memberID = $_POST["member_id"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $membershipStartDate = $_POST["membership_start_date"];
    $membershipExpiryDate = $_POST["membership_expiry_date"];
    $membershipLevel = $_POST["membership_level"];
    
    // Update member data in the database
    $sql = "UPDATE members SET
            name = '$name',
            gender = '$gender',
            email = '$email',
            phone = '$phone',
            address = '$address',
            membership_start_date = '$membershipStartDate',
            membership_expiry_date = '$membershipExpiryDate',
            membership_level = $membershipLevel
            WHERE MemberID = $memberID";
    
    if ($conn->query($sql) === TRUE) {
        echo "Member data updated successfully!";
    } else {
        echo "Error updating member data: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>Edit Member</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="member_id" value="<?php echo $memberID; ?>">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="gender">Gender:</label>
                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $gender; ?>" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="membershipStartDate">Membership Start Date:</label>
                <input type="date" class="form-control" id="membershipStartDate" name="membership_start_date" value="<?php echo $membershipStartDate; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="membershipExpiryDate">Membership Expiry Date:</label>
                <input type="date" class="form-control" id="membershipExpiryDate" name="membership_expiry_date" value="<?php echo $membershipExpiryDate; ?>" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="membershipLevel">Membership Level:</label>
            <input type="number" class="form-control" id="membershipLevel" name="membership_level" value="<?php echo $membershipLevel; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

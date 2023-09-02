<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch member data and fee information
$sql = "SELECT m.MemberID, m.profileimage, m.name, m.gender, m.email, m.phone, m.address, 
        m.membership_start_date, m.membership_expiry_date, ml.level_name, ml.price, p.PaymentAmount, p.PaymentDate
        FROM members AS m
        JOIN membership_levels AS ml ON m.membership_level = ml.LevelID
        LEFT JOIN payments AS p ON m.MemberID = p.MemberID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>

    <a href="member_register.php" class="float-right btn btn-primary">Add Members</a>
    <div class="table-responsive mt-3">

    
    <table class=" table table-bordered">
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Membership Start Date</th>
                <th>Membership Expiry Date</th>
                <th>Membership Level</th>
                <th>Price</th>
                <th>Payment Date</th>
                <th>Payment Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MemberID'] . "</td>";
                echo "<td><img src='./uploads/" . $row['profileimage'] . "' alt='Profile Image' width='50'></td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['membership_start_date'] . "</td>";
                echo "<td>" . $row['membership_expiry_date'] . "</td>";
                echo "<td>" . $row['level_name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['PaymentDate'] . "</td>";
                echo "<td>" . $row['PaymentAmount'] . "</td>";
                echo "<td>
                        <a href='edit_member.php?member_id=" . $row['MemberID'] . "' class='mb-2 btn btn-info'>Edit Member</a>
                        <a href='edit_fee.php?member_id=" . $row['MemberID'] . "' class='mb-2 btn btn-warning'>Edit Fee</a>
                        <a href='delete_member.php?member_id=" . $row['MemberID'] . "' class='btn btn-danger'>Delete Member</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

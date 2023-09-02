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

// Fetch the member's payment history
$sql = "SELECT p.PaymentID, ml.level_name, p.PaymentDate, p.PaymentAmount, p.PaymentMethod
        FROM payments AS p
        INNER JOIN membership_levels AS ml ON p.LevelID = ml.LevelID
        WHERE p.MemberID = $memberID
        ORDER BY p.PaymentDate DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Payment History for <?php echo $memberName; ?></h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Membership Level</th>
                <th>Payment Date</th>
                <th>Payment Amount</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['PaymentID'] . "</td>";
                echo "<td>" . $row['level_name'] . "</td>";
                echo "<td>" . $row['PaymentDate'] . "</td>";
                echo "<td>" . $row['PaymentAmount'] . "</td>";
                echo "<td>" . $row['PaymentMethod'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


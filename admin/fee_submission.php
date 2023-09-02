<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberID = $_POST['member_id'];
    $levelID = $_POST['level_id'];
    $paymentAmount = $_POST['payment_amount'];
    $paymentMethod = $_POST['payment_method'];
    $paymentDate = date('Y-m-d'); // Current date

    // SQL query to insert payment data into the database
    $sql = "INSERT INTO payments (MemberID, LevelID, PaymentDate, PaymentAmount, PaymentMethod)
            VALUES ($memberID, $levelID, '$paymentDate', '$paymentAmount', '$paymentMethod')";

    if ($conn->query($sql) === TRUE) {
        echo "Payment successful!";
        header('location:view_members.php');
        exit();
        // You can add further logic here, such as updating membership expiry date, sending confirmation emails, etc.
    } else {
        echo "Error processing payment: " . $conn->error;
    }
}

// Retrieve member and membership level information from the URL
if (isset($_GET['member_id']) && isset($_GET['level_id'])) {
    $memberID = $_GET['member_id'];
    $levelID = $_GET['level_id'];

    // Fetch member and membership level details for display
    $memberSql = "SELECT * FROM members WHERE MemberID = $memberID";
    $memberResult = $conn->query($memberSql);
    $memberData = $memberResult->fetch_assoc();

    $levelSql = "SELECT * FROM membership_levels WHERE LevelID = $levelID";
    $levelResult = $conn->query($levelSql);
    $levelData = $levelResult->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payment</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5">
    <h2>Fee Payment</h2>

    <p><strong>Member Details:</strong></p>
    <ul>
        <li><strong>Name:</strong> <?php echo $memberData['name']; ?></li>
        <li><strong>Email:</strong> <?php echo $memberData['email']; ?></li>
        <li><strong>Membership Level:</strong> <?php echo $levelData['level_name']; ?></li>
        <li><strong>Membership Level Price:</strong> <?php echo $levelData['price']; ?></li>
    </ul>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="member_id" value="<?php echo $memberID; ?>">
        <input type="hidden" name="level_id" value="<?php echo $levelID; ?>">

        <div class="form-group">
            <label for="payment_amount">Payment Amount:</label>
            <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01" required>
            <small class="text-muted">Maximum: <?php echo $levelData['price']; ?></small>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="Physical">Physical</option>
                <option value="Online">Online</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Make Payment</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Add JavaScript to ensure payment amount is not greater than membership level price
    document.getElementById('payment_amount').addEventListener('input', function () {
        var maxAmount = parseFloat(<?php echo $levelData['price']; ?>);
        var paymentAmount = parseFloat(this.value);
        if (paymentAmount > maxAmount) {
            this.value = maxAmount;
        }
    });
</script>

</body>
</html>

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
    
    // Retrieve fee data for the member
    $sql = "SELECT * FROM payments WHERE MemberID = $memberID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $paymentAmount = $row['PaymentAmount'];
        $paymentDate = $row['PaymentDate'];
    } else {
        echo "Fee data not found for this member.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["member_id"])) {
    // Handle form submission for editing fee data
    $memberID = $_POST["member_id"];
    $paymentAmount = $_POST["payment_amount"];
    $paymentDate = $_POST["payment_date"];
    
    // Update fee data in the database
    $sql = "UPDATE payments SET
            PaymentAmount = '$paymentAmount',
            PaymentDate = '$paymentDate'
            WHERE MemberID = $memberID";
    
    if ($conn->query($sql) === TRUE) {
        echo "Fee data updated successfully!";
    } else {
        echo "Error updating fee data: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fee</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>Edit Fee</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="member_id" value="<?php echo $memberID; ?>">
        
        <div class="mb-3">
            <label for="paymentAmount">Payment Amount:</label>
            <input type="number" class="form-control" id="paymentAmount" name="payment_amount" value="<?php echo $paymentAmount; ?>" step="0.01" required>
        </div>
        
        <div class="mb-3">
            <label for="paymentDate">Payment Date:</label>
            <input type="date" class="form-control" id="paymentDate" name="payment_date" value="<?php echo $paymentDate; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


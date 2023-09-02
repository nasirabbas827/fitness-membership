<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch data for dashboard
$totalMembers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM members"))['total'];

$totalMembersLevel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM members"))['total']; // You'll need to adjust this query based on your database structure.

$totalPayment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(PaymentAmount) AS total FROM payments"))['total'];

$totalClasses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM classes"))['total'];

$totalAttendance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance"))['total'];

$totalOffers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM offers"))['total'];

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM events"))['total'];

$totalDiscounts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM discounts"))['total'];

$totalMessages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM messages"))['total'];

$totalMessagesForReply = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM messages WHERE reply_text IS NULL"))['total'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include('admin_navbar.php');
?>
<div class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>

    <div class="row">
        <!-- Total Members Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="card-text"><?php echo $totalMembers; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Members Level Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Members Level</h5>
                    <p class="card-text"><?php echo $totalMembersLevel; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Payment Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Payment</h5>
                    <p class="card-text">$<?php echo number_format($totalPayment, 2); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Classes Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text"><?php echo $totalClasses; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Attendance Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Attendance</h5>
                    <p class="card-text"><?php echo $totalAttendance; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Offers Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Offers</h5>
                    <p class="card-text"><?php echo $totalOffers; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text"><?php echo $totalEvents; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Discounts Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Discounts</h5>
                    <p class="card-text"><?php echo $totalDiscounts; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Messages Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Messages</h5>
                    <p class="card-text"><?php echo $totalMessages; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Messages for Reply Card -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Messages Held for Reply</h5>
                    <p class="card-text"><?php echo $totalMessagesForReply; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

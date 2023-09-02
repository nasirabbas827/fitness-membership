<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Handle offer, event, and discount deletions if requested
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && isset($_GET["id"])) {
    $action = $_GET["action"];
    $id = $_GET["id"];

    if ($action === "delete") {
        // Determine the table based on the 'type' query parameter
        $type = $_GET["type"];
        $table = "";

        if ($type === "offer") {
            $table = "offers";
        } elseif ($type === "event") {
            $table = "events";
        } elseif ($type === "discount") {
            $table = "discounts";
        }

        if (!empty($table)) {
            // Delete the selected item from the respective table
            $deleteSql = "DELETE FROM $table WHERE {$type}ID = $id";

            if ($conn->query($deleteSql) === TRUE) {
                // Redirect back to the offers/events/discounts page after deletion
                header("Location: view_offers_events_discounts.php?type=$type");
                exit;
            } else {
                $deleteError = "Error deleting $type: " . $conn->error;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS and custom CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>

    <!-- Display offers, events, and discounts -->
    <h3>Offers</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $offersSql = "SELECT * FROM offers";
            $offersResult = $conn->query($offersSql);

            while ($offer = $offersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$offer['OfferID']}</td>";
                echo "<td>{$offer['offer_details']}</td>";
                echo "<td>
                        <a href='?type=offer&action=delete&id={$offer['OfferID']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this offer?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Events</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $eventsSql = "SELECT * FROM events";
            $eventsResult = $conn->query($eventsSql);

            while ($event = $eventsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$event['EventID']}</td>";
                echo "<td>{$event['event_details']}</td>";
                echo "<td>
                        <a href='?type=event&action=delete&id={$event['EventID']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this event?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Discounts</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $discountsSql = "SELECT * FROM discounts";
            $discountsResult = $conn->query($discountsSql);

            while ($discount = $discountsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$discount['DiscountID']}</td>";
                echo "<td>{$discount['discount_details']}</td>";
                echo "<td>
                        <a href='?type=discount&action=delete&id={$discount['DiscountID']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this discount?');\">Delete</a>
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


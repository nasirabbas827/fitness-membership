<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $eventType = $_POST['event_type'];
    $eventDetails = $_POST['event_details'];

    // Insert event, offer, or discount details into the database based on the selected type
    if ($eventType == 'event') {
        $sql = "INSERT INTO events (event_details) VALUES ('$eventDetails')";
    } elseif ($eventType == 'offer') {
        $sql = "INSERT INTO offers (offer_details) VALUES ('$eventDetails')";
    } elseif ($eventType == 'discount') {
        $sql = "INSERT INTO discounts (discount_details) VALUES ('$eventDetails')";
    }

    if ($conn->query($sql) === TRUE) {
        // Get a list of all registered member emails
        $emailSql = "SELECT email FROM members";
        $emailResult = $conn->query($emailSql);

        if ($emailResult->num_rows > 0) {
            $mail = new PHPMailer(true);

            try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
                    $mail->SMTPAuth = true;
                    $mail->Username = 'nasiryt.827@gmail.com'; // Replace with your SMTP username
                    $mail->Password = "YOUR_OWN_API_KEY"; // Replace with your SMTP password
                    $mail->Port = 587; // Replace with your SMTP port (usually 587)
        
                    // Email content
                    $mail->setFrom('nasiryt.827@gmail.com', 'NASIR ABBAS'); // Replace with your email and name


                // Customize the email subject and body
                $mail->Subject = 'New Offer Alert';
                $mail->Body    = 'Check out our latest offer: ' . $eventDetails;

                while ($row = $emailResult->fetch_assoc()) {
                    $email = $row['email'];
                    $mail->addAddress($email);
                    $mail->send();
                    $mail->clearAddresses();
                }

                echo "Event/offer/discount created and emails sent successfully!";
            } catch (Exception $e) {
                echo "Error: Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event/Offer/Discount</title>
    <!-- Include Bootstrap CSS and custom CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-5">
    <h2>Create Event, Offer, or Discount</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="event_type">Select Type:</label>
            <select class="form-control" id="event_type" name="event_type" required>
                <option value="event">Event</option>
                <option value="offer">Offer</option>
                <option value="discount">Discount</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="event_details">Details:</label>
            <textarea class="form-control" id="event_details" name="event_details" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="view_offers.php" class="btn btn-secondary">View Offers</a>
    </form>
</div>

<!-- Include Bootstrap JS and Popper.js (for Bootstrap functionality) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


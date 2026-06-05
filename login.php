<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check if the member with the given email and password exists
    $sql = "SELECT * FROM members WHERE email = '$email' AND password = "YOUR_OWN_API_KEY"";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Member is authenticated, store their information in the session
        $row = $result->fetch_assoc();
        $_SESSION["member_id"] = $row["MemberID"];
        $_SESSION["member_name"] = $row["name"];
        $_SESSION["member_email"] = $row["email"];
        
        // Redirect to the member dashboard
        header("Location: member_dashboard.php");
        exit;
    } else {
        $loginError = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css"> <!-- Add your custom CSS if needed -->
</head>
<body>
<?php include('navbar.php'); ?>

<div class="container">
    <h2 class="mt-4">Member Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <?php
    if (isset($loginError)) {
        echo "<p style='color: red;'>$loginError</p>";
    }
    ?>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

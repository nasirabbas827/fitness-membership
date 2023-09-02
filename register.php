<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profileImage = $_FILES['profile_image']['name'];
    $tempImage = $_FILES['profile_image']['tmp_name'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $membershipStartDate = $_POST['membership_start_date'];
    $membershipLevel = $_POST['membership_level']; // The level ID

// Upload the profile image to a directory (you may need to create the 'uploads' directory)
$uploadDirectory = './admin/uploads/';
$profileImageName = $_FILES['profile_image']['name']; // Get the image name
$profileImagePath = $uploadDirectory . $profileImageName;
move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileImagePath);

// Generate the membership expiry date based on the selected level (You may adjust this logic)
$membershipExpiryDate = date('Y-m-d', strtotime($membershipStartDate . ' +365 days'));

// SQL query to insert member data into the database
$sql = "INSERT INTO members (profileimage, name, gender, email, password, phone, address, membership_start_date, membership_expiry_date, membership_level)
        VALUES ('$profileImageName', '$name', '$gender', '$email', '$password', '$phone', '$address', '$membershipStartDate', '$membershipExpiryDate', $membershipLevel)";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the fee payment page with the membership level information in the URL
        header("Location: fee_submission.php?level_id=$membershipLevel&member_id=" . $conn->insert_id);
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php
include('navbar.php');
?>

<div class="container">
    <h2 class="mt-4">Member Registration</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image:</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="male" name="gender" value="Male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="female" name="gender" value="Female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="membership_start_date" class="form-label">Membership Start Date:</label>
                    <input type="date" class="form-control" id="membership_start_date" name="membership_start_date" required>
                </div>
                <div class="mb-3">
                    <label for="membership_level" class="form-label">Membership Level:</label>
                    <select class="form-control" id="membership_level" name="membership_level" required>
                        <?php
                        // Fetch membership levels from the database and populate the dropdown options
                        $sql = "SELECT * FROM membership_levels";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['LevelID'] . "'>" . $row['level_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Add Member">
        </div>
    </form>
</div>

<!-- Include Bootstrap JavaScript (optional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>





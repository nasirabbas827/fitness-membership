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
        // Delete member data
        $deleteMemberSql = "DELETE FROM members WHERE MemberID = $memberID";
        if ($conn->query($deleteMemberSql) === TRUE) {
            // Delete fee data for the member
            $deleteFeeSql = "DELETE FROM payments WHERE MemberID = $memberID";
            if ($conn->query($deleteFeeSql) === TRUE) {
                echo "Member and fee data deleted successfully!";
            } else {
                echo "Error deleting fee data: " . $conn->error;
            }
        } else {
            echo "Error deleting member data: " . $conn->error;
        }
    } else {
        echo "Member not found.";
    }
}

$conn->close();
?>

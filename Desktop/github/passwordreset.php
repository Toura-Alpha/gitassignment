<?php
// Start session
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "steronenombie";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Check if new password and confirm password match
            if ($newPassword == $confirmPassword) {
                // Hash new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update password in database
                $sql = "UPDATE users SET password = '$hashedNewPassword' WHERE email = '$email'";
                $conn->query($sql);
                echo "Password reset successfully!";
                header("Location: settings.html");
                exit;
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Old password is incorrect.";
        }
    } else {
        echo "Email does not exist.";
    }
}

$conn->close();
?>
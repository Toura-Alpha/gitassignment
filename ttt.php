
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

// Retrieve user information from database
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $email = $_SESSION["email"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $gender = $row["gender"];
        $age = $row["age"];

        echo "<p>First Name: $firstname</p>";
        echo "<p>Last Name: $lastname</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Gender: $gender</p>";
        echo "<p>Age: $age</p>";
    } else {
        echo "No user information found.";
    }
} else {
    // Update user information in database
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];

    $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', gender = '$gender', age = '$age' WHERE email = '$email'";
    $conn->query($sql);

    // Retrieve updated user information
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $gender = $row["gender"];
        $age = $row["age"];

        echo "<p>First Name: $firstname</p>";
        echo "<p>Last Name: $lastname</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Gender: $gender</p>";
        echo "<p>Age: $age</p>";
    } else {
        echo "No user information found.";
    }
}

$conn->close();
?>

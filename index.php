
<?php
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

// Handle registration form submission
if (isset($_POST["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    // Query the database to insert the new user
    $sql = "INSERT INTO users (firstname, lastname, email, password, gender, age) VALUES ('$firstname', '$lastname', '$email', '$hashedPassword', '$gender', '$age')";
    $conn->query($sql);

    // Redirect to index page for login
    header("Location: index.html");
    exit;
}

// Handle login form submission
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];
        // User exists, start a session and redirect to home page
        if (password_verify($password,$hashedPassword)){         
            $_SESSION["email"] = $email;
            header("Location: home.html");
            exit;
        }else{
            echo "incorrect password";
        }
    } else {
        // User does not exist, display error message
        echo "Invalid email or password";
    }
}

$conn->close();
?>
```
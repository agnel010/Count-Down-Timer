<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CountDownTimer"; // Updated database name
$port = "3307";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Insert data into the database
    $sql = "INSERT INTO users (username, password) 
            VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Signup successful!');
                window.location.href='microsign.php'; // Redirect to login page
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href='signup.php';
              </script>";
    }
}
$conn->close();
?>

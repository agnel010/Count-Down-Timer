<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password (if storing in plain text, use $password == $row["password"])
        if ($password == $row["password"]) { 
            $_SESSION["username"] = $username; // Store username in session
            $_SESSION["success"] = "Login successful!"; // Store success message
            header("Location: home.php"); // Redirect to home page
            exit();
        } else {
            $_SESSION["error"] = "Incorrect password!"; // Set error message
            header("Location: login.php"); // Redirect back to login page
            exit();
        }
    } else {
        $_SESSION["error"] = "Username not found!"; // Set error message
        header("Location: login.php"); // Redirect back to login page
        exit();
    }
}
?>

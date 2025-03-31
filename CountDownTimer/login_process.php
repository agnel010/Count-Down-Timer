<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION["error"] = "Please fill in all fields!";
        header("Location: login.php");
        exit();
    }

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION["error"] = "Database error: " . $conn->error;
        header("Location: login.php");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify password (Note: Should use password_hash/password_verify in production)
        if ($password === $row["password"]) { 
            $_SESSION["user_id"] = $row["id"]; // Store user ID instead of username
            $_SESSION["username"] = $row["username"];
            $_SESSION["success"] = "Login successful!";
            header("Location: countdown_form.php"); 
            exit();
        } else {
            $_SESSION["error"] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Username not found!";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
} else {
    $_SESSION["error"] = "Invalid request method!";
    header("Location: login.php");
    exit();
}

$conn->close();
?>
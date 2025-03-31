<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

ob_start();

try {
    if (!file_exists('db_connect.php')) {
        throw new Exception('db_connect.php not found');
    }
    include 'db_connect.php';
    
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Please log in to create a countdown',
            'session_debug' => [
                'session_id' => session_id(),
                'session_data' => $_SESSION
            ]
        ]);
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
        exit();
    }

    $name = trim($_POST["countdown_name"] ?? '');
    $hours = (int) ($_POST["hours"] ?? 0);
    $minutes = (int) ($_POST["minutes"] ?? 0);
    $seconds = (int) ($_POST["seconds"] ?? 0);

    if (empty($name)) {
        echo json_encode([
            'success' => false,
            'message' => 'Countdown name is required'
        ]);
        exit();
    }

    if ($hours == 0 && $minutes == 0 && $seconds == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Countdown time cannot be zero!'
        ]);
        exit();
    }

    $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    $server_time = date('Y-m-d H:i:s', time());
    $end_time = date('Y-m-d H:i:s', time() + $total_seconds);

    $sql = "INSERT INTO countdowns (user_id, countdown_name, hours, minutes, seconds, end_time, remaining_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("isiiisi", $user_id, $name, $hours, $minutes, $seconds, $end_time, $total_seconds);
    
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $countdown_id = $conn->insert_id; // Get the newly inserted ID

    $stmt->close();
    $conn->close();

    ob_end_clean();

    echo json_encode([
        'success' => true,
        'message' => 'Countdown saved successfully!',
        'user_id' => $user_id,
        'countdown_id' => $countdown_id,
        'total_seconds' => $total_seconds,
        'server_time' => $server_time,
        'end_time' => $end_time
    ]);

} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
    ]);
    exit();
}
?>
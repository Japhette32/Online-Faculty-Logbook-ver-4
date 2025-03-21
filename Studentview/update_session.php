<?php
// filepath: c:\xampp\htdocs\Website\Studentview\update_session.php
session_start();
include 'db_connection.php';  // Add this line to connect to database

error_log("Session update request received. POST data: " . json_encode($_POST));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['close_notification'])) {
    $sessionId = session_id();
    $beforeHasNewUpdates = isset($_SESSION['hasNewUpdates']) ? $_SESSION['hasNewUpdates'] : 'not set';
    $beforeLastSeen = isset($_SESSION['last_seen_update']) ? $_SESSION['last_seen_update'] : 'not set';
    
    error_log("Session ID: $sessionId");
    error_log("Before update: hasNewUpdates=$beforeHasNewUpdates, last_seen_update=$beforeLastSeen");
    
    // Find the latest registration timestamp
    $max_timestamp = time() + 3600;  // Default: current time + buffer
    
    if ($conn) {
        $user_id = $_SESSION['user_id'];
        $current_registration_ids = [];
        
        $stmt = $conn->prepare("SELECT registration_id FROM registrations WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $current_registration_ids[] = $row['registration_id'];
            }
            $stmt->close();
        }
        
        // Mark all current registrations as seen
        $_SESSION['seen_registrations'] = $current_registration_ids;
        error_log("Marked " . count($current_registration_ids) . " registrations as seen");
    }
    
    // Try to get the actual max timestamp from the database
    if ($conn) {
        $user_id = $_SESSION['user_id'];
        // Get the maximum timestamp of any registration for this user
        $stmt = $conn->prepare("SELECT MAX(UNIX_TIMESTAMP(CONCAT(date, ' ', start_time))) as max_time FROM registrations WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                if ($row['max_time'] && $row['max_time'] > $max_timestamp) {
                    $max_timestamp = $row['max_time'] + 10; // Add buffer
                    error_log("Using database max timestamp: $max_timestamp");
                }
            }
            $stmt->close();
        }
        $conn->close();
    }
    
    // Update the session variables
    $_SESSION['hasNewUpdates'] = false;
    $_SESSION['last_seen_update'] = $max_timestamp; 
    
    // Force session write
    session_write_close();
    
    error_log("After update: hasNewUpdates=false, last_seen_update=$max_timestamp");
    
    echo 'Session updated successfully';
} else {
    error_log("Invalid request. Method: " . $_SERVER['REQUEST_METHOD'] . ", close_notification set: " . (isset($_POST['close_notification']) ? 'yes' : 'no'));
    echo 'Invalid request';
}
?>
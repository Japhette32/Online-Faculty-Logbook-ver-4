<?php
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $registration_id = isset($data['registration_id']) ? $data['registration_id'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $cancelReason = isset($data['cancelReason']) ? $data['cancelReason'] : '';

    if ($registration_id === null || $status === null) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }

    if ($status === 'Cancelled' || $status === 'Rejected') {
        // Update the registration status to 'Cancelled' or 'Rejected' and set the cancel reason
        $stmt = $conn->prepare("UPDATE registrations SET status = ?, cancel_reason = ? WHERE registration_id = ?");
        if ($stmt) {
            $stmt->bind_param("ssi", $status, $cancelReason, $registration_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registration ' . strtolower($status) . ' successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        }
    } elseif ($status === 'DeleteCancelled' || $status === 'DeleteRejected') {
        // Delete the registration after it has been cancelled or rejected
        $stmt = $conn->prepare("DELETE FROM registrations WHERE registration_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $registration_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cancelled or rejected registration removed successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        }
    }
}

$conn->close();
?>
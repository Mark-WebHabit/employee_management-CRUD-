<?php
session_start();
require '../Db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $newUsername = trim($_POST['username']);
    
    if ($id > 0 && !empty($newUsername)) {
        $query = "UPDATE users SET username = :username WHERE id = :id";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([':username' => $newUsername, ':id' => $id]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Record updated successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Record not found or no changes made.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID or username.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

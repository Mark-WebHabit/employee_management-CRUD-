<?php
session_start();
require '../Db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    
    if ($id > 0) {
        $query = "DELETE FROM users WHERE id = :id";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

<?php
require '../Db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : null;
    $salary = isset($_POST['salary']) ? floatval($_POST['salary']) : null;

    // Ensure all required fields are provided
    if ($id && $firstName && $lastName && $email && $address && $gender && $salary) {
        $query = "UPDATE employee SET first_name = :first_name, last_name = :last_name, email = :email, address = :address, gender = :gender, salary = :salary WHERE id = :id";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':address' => $address,
                ':gender' => $gender,
                ':salary' => $salary,
                ':id' => $id
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Employee updated successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No changes made or employee not found.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

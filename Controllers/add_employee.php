<?php
require '../Db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $salary = isset($_POST['salary']) ? $_POST['salary'] : null;

    // Check if all required fields are provided
    if ($firstName && $lastName && $email && $address && $gender && $salary) {
        $query = "INSERT INTO employee (first_name, last_name, email, address, gender, salary) 
                  VALUES (:first_name, :last_name, :email, :address, :gender, :salary)";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':address' => $address,
                ':gender' => $gender,
                ':salary' => $salary
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Employee added successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add employee.']);
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

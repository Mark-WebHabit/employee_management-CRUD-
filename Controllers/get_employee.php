<?php
require '../Db/db.php';

$id = intval($_GET['id']);

// Query to get a single user based on ID
$query = "SELECT * FROM employee WHERE id = :id LIMIT 1";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user) {
         echo json_encode($user);
    } else {
        echo "Employee not found.";
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>

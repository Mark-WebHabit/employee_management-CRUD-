<?php
require '../Db/db.php';

$id = intval($_POST['id']); // Assuming you pass the user ID via a GET parameter

// Query to get a single user based on ID
$query = "SELECT * FROM users WHERE id = :id LIMIT 1";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo $user["username"];
    } else {
        echo "User not found.";
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>

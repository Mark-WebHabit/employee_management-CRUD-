<?php
require './Db/db.php';

// query to get all users
$query = "SELECT * FROM users";

try{
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
        exit($e->getMessage());
}
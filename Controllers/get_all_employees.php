<?php
require './Db/db.php';

// query to get all users
$query = "SELECT * FROM employee";

try{
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
        exit($e->getMessage());
}
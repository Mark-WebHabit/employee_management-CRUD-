<?php
session_start();
require '../Db/db.php';

// check if http method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // assign payload to a varibales
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $cpass = trim($_POST["confirm_password"]);

    // make sure the username and password isnt empty
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and Password cannot be empty.";

        // go back to page
        header("Location: ../?page=register");
        exit();
    }

    // make sure the password and confirm password matches
    if($password != $cpass)
    {
        $_SESSION['error'] = "Password do not macthed";

        // go back to page
        header("Location: ../?page=register");
        exit();
    }

    // query to check if username already exists
     $query = "SELECT count(*) FROM users WHERE username = :username";

    //  kapag may ni return then taken na 
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);
        $userCount = $stmt->fetchColumn();

        if ($userCount > 0) {
            $_SESSION['error'] = "Username already exists.";
            header("Location: ../?page=register");
            exit();
        } else {
          
        // hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // if username not taken, proceed to register
        // insert the crated account to db
        $query = "INSERT INTO users (username, password) values (:username, :password)"; 
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username, ':password' => $hashedPassword]);

        // check if a new user is created by getting the row count or the added new row
        if($stmt->rowCount() > 0){
            header("Location:  ../?page=login");
        }else{
            $_SESSION['error'] = "Failed to register.";
            header("Location: ../?page=register");
        }

        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        // Go back to page
        header("Location: ../?page=register");
        exit();
    }
}

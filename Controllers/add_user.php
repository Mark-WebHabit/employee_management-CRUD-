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
        $_SESSION['add-user-error'] = "Username and Password cannot be empty.";
        // go back to page
        header("Location: ../?home=users");
        exit();
    }

    // make sure the password and confirm password matches
    if($password != $cpass)
    {
        $_SESSION['add-user-error'] = "Password do not macthed";

        // go back to page
        header("Location: ../?home=users");
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
            $_SESSION['add-user-error'] = "Username already exists.";
            header("Location: ../?home=users");
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
            header("Location:  ../?home=users");
        }else{
            $_SESSION['add-user-error'] = "Failed to register.";
            header("Location: ../?home=users");
        }

        }
    } catch (PDOException $e) {
        $_SESSION['add-user-error'] = $e->getMessage();
        // Go back to page
        header("Location: ../?home=users");
        exit();
    }
}

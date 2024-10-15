<?php
session_start();
require '../Db/db.php';

// check if http method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // make sure username and password isnt empty
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and Password cannot be empty.";
        header("Location: ../?page=login");
        exit();
    }



    try
    {
        // query to get user from users table with matching username
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);

        // get the user returned if there is a match
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // check if theres a user
        if($user)
        {

            // check if raw password matches the hashed password
            if(password_verify($password, $user['password']))
            {
                // pass the user data to session variable
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // redirect
                header("Location: ../?page=home ");
            }else{
                $_SESSION['error'] = "Wrong username or password.";
                header("Location: ../?page=login");
                exit();
            }


        }else{
            $_SESSION['error'] = "Wrong username or password.";
            header("Location: ../?page=login");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        // Go back to page
        header("Location: ../?page=register");
        exit();
    }

}

<?php

// ansure the user is authenticated
    if(!isset($_SESSION['userid']))
    {
     $page = 'login.php';   
    }
    $username = $_SESSION['username'];

    // intiaal page for home
    $currentPage = "employees";

    // if theres a home in the URI
    if(isset($_GET['home']))
    {
        // if home is not users then it shuld alwyas be employees
        if($_GET['home'] != 'users')
        {
            $currentPage = "employees";
        }else{
            $currentPage = $_GET['home'];
        }
    }else{
        $currentPage = "employees";
    }
    
?>

<main class="container">

    <header class="header">
        <h3>
            <a href="#">
                <?= $username ?>
            </a>
        </h3>

        <div class="nav">
            <a href="./?home=employees">Employee</a>
            <a href="./?home=users">Users</a>
            <a href="./Controllers/logout.php">Logout</a>
        </div>
    </header>

    <?php if($currentPage == "users"): ?>
        <?php include './Views/users.php'; ?>
    <?php else: ?>
        <?php include './Views/employees.php'; ?>
    <?php endif ?>

</main>
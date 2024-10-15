<?php
session_start();

$page = "login.php"; // Default page

//if naka set yung global variable na GET and mayroong data na nang pangalan is "page" then iassign yun sa variable na $page
if (isset($_GET["page"])) { 
    $page = $_GET["page"] . ".php";
}

// dito tinitignan if naka login na ba user gamit yung global variable na session tas hinahanap yung data na "userid"
// if true yung condition it means authenticated na si user
if (isset($_SESSION["userid"])) {

    // if authenticated na si user bawal na sya sa loginor register hanggat disya nag lalogout
    if ($page == "login.php" || $page == "register.php") {
        $page = "home.php";
    }
} else {

    // dito naman if unautenticated si user bawal sya sa home kaya gagawing login yung $page para maredrect sya
    if ($page == "home.php") {
        $page = "login.php";
    }
}

// eto yung list ng page na inaallow natin, if  nag redirect si user sa page na wala dto sa array dadalin sya sa 404
$validPages = ["login.php", "register.php", "home.php", "404.php"];
if (!in_array($page, $validPages)) {
    $page = "404.php";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- dito nag lilink lang ng css file based sa kung ano yung active page -->
    <?php if ($page == "404.php"): ?>
        <link rel="stylesheet" href="./public/404.css">
    <?php elseif($page == "login.php" || $page == "register.php"): ?>
         <link rel="stylesheet" href="./public/auth.css">
    <?php elseif($page == 'home.php'): ?>
         <link rel="stylesheet" href="./public/home.css">
    <?php endif; ?>



    <title>Employee Management</title>
</head>
<body>

    <input type="hidden" id="currentUser"  value="<?= $_SESSION['userid'] !== null ? $_SESSION['userid'] : 0 ?>">
<!-- eto naman dinidisplay na yung corresponding page based sa value nung $page variable -->
    <?php include("./Views/$page"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>





    <!-- dito nag lilink lang ng js file based sa kung ano yung active page -->
    <?php if($page == "login.php" || $page == "register.php"): ?>
         <script src="./Script/auth.js"></script>
    <?php elseif ($page == 'home.php'): ?>
         <script src="./Script/home.js"></script>
    <?php endif; ?>
</body>
</html>

<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_secure_token();
}
$title = "Burroughs Farms Calendar";

if ($pageName !== 'Index') {
    $title = $pageName;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <meta name="description" content="Burroughs Farms Calendar">
        <meta name="keywords" content="Website, Development, Design, HTML, CSS, PHP Object-Oriented Programming, JQuery, Ajax, JSON">
        <meta name="robots" content="index, nofollow">
        <meta name="web_author" content="John Pepp, Developer, Livonia, MI">
        <meta name="language" content="English">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="lib/css/stylesheet.css">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <header id="heading" class="container">
            <h3>Burroughs Farms</h3>
        </header>
        <nav id="navigation" class="container nav-bar">
            <ul class="topnav" id="myTopnav">
                <li><a class="top-link" href="#" >&nbsp;</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Upload</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li class="icon">
                    <a href='#'>&#9776;</a>
                </li>    
            </ul>
        </nav>

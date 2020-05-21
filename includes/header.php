<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Evan Holmberg -->
<head>
<?php
    $title = ucfirst(basename($_SERVER['PHP_SELF'], '.php'));
    if (lcfirst($title) === 'index')
    $title = "Home";
?>
    <title><?php echo $title; ?> - KittyGram</title>
    <link rel="stylesheet" href="./css/gallery.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="icon" href="./images/purple-cat.png">
    </head>
    <body>
    <header id="container">

            <img id="logoLeft" src="./images/kitty.jpg" alt="cat logo">
            
        <div id="siteName"><h1><a href="index.php">KittyGram</a></h1></div>

            <img id="logoRight" src="./images/kitty.jpg" alt="cat logo">
    </header>

<div id="wrapper">
    <?php require './includes/menu.php'; ?>
</div>

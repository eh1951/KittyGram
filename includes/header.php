<!DOCTYPE html>
<html lang="en">
    <!-- Evan Holmberg -->
<head>
<?php
    $title = ucfirst(basename($_SERVER['PHP_SELF'], '.php'));
    if ($title === 'index')
    $title = "home";
?>
    <title><?php echo $title; ?> - KittyGram</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="icon" href="./images/purple-cat.png">
    </head>
    <body>
    <header id="container">

            <img id="logoLeft" src="./images/kitty.jpg" alt="cat logo">
            
        <div id="siteName"><h1>KittyGram</h1></div>

            <img id="logoRight" src="./images/kitty.jpg" alt="cat logo">
    </header>

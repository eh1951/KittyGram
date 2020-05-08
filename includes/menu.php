
<?php if (isset($_SESSION['type'])) { ?>
<nav id="adminMenu">
    <div id="addDelete">
        <a href="addDelete.php"><p>Add/Delete Admins</p></a>
    </div>
    <div id="uploadAdmin">
        <a href="site_image.php"><p>Upload Site Files</p></a>
    </div>
    <div id="adminLogout">
        <a href="logged_out.php"><p>Logout</p></a>
    </div> 
    </nav>
<?php } else { ?>

<?php if (isset($_SESSION['fn'])) { ?>
        <nav id="userMenu">
        <div id="home">
            <a href="index.php"><p>Home</p></a>
        </div>
        <div id="uploadUser">
            <a href="upload_user_image.php"><p>Upload Image</p></a>
        </div>
        <div id="logout">
            <a href = "logged_out.php"><p>Logout</p></a>
        </div>
        </nav>
        
<?php } else { ?>  
        <nav id="loginMenu">
        <div id="signup">
            <a href="registration.php"><p>Signup</p></a>
        </div>
        <div id="login">
            <a href="login.php"><p>Login</p></a>
        </div>
        </nav>
<?php }} ?>


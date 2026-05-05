<?php
session_start();

if (isset($_SESSION['user'])) {
  header("Location: pages/dashboard.php");
  exit;
}
else{
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>

    <div class="box-login">
        <?php
            if (isset($_GET['id'])) {
                ?>
                <div class="alert alert-danger boxalert" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>Aww yeah, you successfully read this important alert message. This example 
                            text is going to run a bit longer so that you can see how spacing within 
                            an alert works with this kind of content.</p>
                </div>
                <?php
                }
        ?>
        <div class="container">
            <h2>Login</h2>

            <form action="pages/login.php" method="POST">
                <div class="input-box">
                    <input type="text" name="username" required>
                    <label>Username</label>
                    <span>👤</span>
                </div>

                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <span>🔒</span>
                </div>

                <div class="options">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit">Login</button>
            </form>
            <div class="register">
                Don't have an account? <a href="#">Register</a>
            </div>
        </div>
    </div>

</body>
</html>
<?php
}
?>
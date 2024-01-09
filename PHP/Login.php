<?php
session_start();
if (!isset ($_SESSION["user"])) {
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        require 'connection.php';
        if(!empty($_SESSION['id'])){
            header("location:dashboard.php");
        }
        if (isset($_POST["Login"])) {
            $Email = $_POST["Email"];
            $Password = $_POST["Password"];
            require_once "connection.php";
            $sql = "SELECT * FROM useres WHERE Email = '$Email'";
            $result = mysqli_query($conn,$sql);
            $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
            if($user){
                if(password_verify($Password,$user["Password"])){
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("location:dashboard.php");
                    die();
                }
                else{
                    echo"<div class ='alert alert-danger'>Password does not exist</div>";
                }
            }else{
                echo"<div class ='alert alert-danger'>Email does not exist</div>";
            }
        }
        ?>
        <form action="Login.php" method="POST">
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="Email" name ="Email" class = "form-control">
        </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="Password" name ="Password" class = "form-control">
        </div>
        <div class="form-btn">
            <input type="submit" name ="Login" value="Login" class="btn btn-primary">
    <a href="sign-up.php">Don't Have an account?</a>
        </div>
    </form>
    </div>
</body>
</html>
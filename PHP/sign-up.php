<?php
session_start();
if (!isset ($_SESSION["user"])) {
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SignUp</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php
        require 'connection.php';
        if(!empty($_SESSION['id'])){
            header("location:dashboard.php");
        }
     if (isset($_POST["submit"])) {
        $FirstName = $_POST["First_Name"];
        $LastName = $_POST["Last_Name"];
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];
        $gender = $_POST["gender"];
        $password_repeat = $_POST["password_repeat"];

        $passwordHash = password_hash($Password,PASSWORD_DEFAULT);

        $errors = array();

        if (empty($FirstName) OR empty($LastName) OR empty($Email) OR empty($Password)) {
            array_push($errors,"All Field are required");
        }
        if (!filter_var($Email,FILTER_VALIDATE_EMAIL)) {
            array_push($errors,"Email is Not valid");
        }
        if (strlen($Password,)<4) {
            array_push($errors,"Password must be longer 4 character");
        }
        require_once "connection.php";
        $sql = "SELECT * FROM useres WHERE Email ='$Email'";
        $result = mysqli_query($conn,$sql);
        $rowCount = mysqli_num_rows($result);

        if ($rowCount >0) {
            array_push($errors,"Email Already Exist");
        }
        if ($password_repeat!==$Password) {
            array_push($errors,"Password Does Not Match");
        }
        if (count($errors)>0) {
            foreach ($errors as $error) {
                echo"<div class='alert alert-danger'>$error</div>";
            }
        }else {
            $sql = "INSERT INTO useres (First_Name,Last_Name,Email,Password,gender) VALUE (?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssss",$FirstName,$LastName,$Email,$passwordHash,$gender);
                mysqli_stmt_execute($stmt);
                echo"<div class ='alert alert-success'>Your Register Successfully</div>";
            }else{
                echo"someting wrong";
            }
        }
    }
    ?>
        <form action="sign-up.php" method="POST">
            <div class="form-group">
                <label for="First name">First Name</label>
                <input class="form-control" type="text" name="First_Name">
            </div>
            
            <div class="form-group">
                <label for="Last name">Last Name</label>
                <input class="form-control" type="text" name="Last_Name">
            </div>
            
            <div class="form-group">
                <label for="Email">Email</label>
                <input class="form-control" type="email" name="Email">
            </div>
            
            <div class="form-group">
                <label for="Password">Password</label>
                <input class="form-control" type="password" name="Password">
            </div>

            <div class="form-group">
            <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
            </div>

            <div class="form-group">
                <label for="password repeat">Password repeat</label>
                <input class="form-control" type="password" name="password_repeat">
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Register">
                <a href="Login.php">Login now</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
session_start();
if (!isset ($_SESSION["user"])) {
    header("Location: Login.php");
}else {
    $id = $_SESSION['id'];
    $result = mysqli_query($connection, "SELECT * FROM tb_users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
 <div class="container">
    <h1>HEllO <?php echo $row["nama_depan"];?></h1>
    <a href="logout.php" class ="btn btn-warning">Logout</a>
 </div>
</body>

</html>

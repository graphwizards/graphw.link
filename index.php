<?php
include('./database.php');
session_start();
if (isset($_SESSION['name'])) {   
}
else{
    session_destroy();
    header('location:login.php');
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>graphLinks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1>hello  <?php echo $_SESSION['name'] ?> </h1>
</body>

</html>
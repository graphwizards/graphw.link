<?php
if (isset($_SESSION['name'])) {
    header('location:index.php');
}

if (isset($_POST['submit_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    session_start();
    $id = session_id();
    $_SESSION['name'] = $username;
    session_commit();
    header('location:index.php');
   
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="h-screen w-screen flex flex-wrap justify-center content-center">
        <div class="w-1/4  p-4">
            <h1 class="text-2xl font-semibold text-zinc-800">Admin Login</h1>
            <form action="#" method="POST" autocomplete="off" class="mt-4">
                <div class="py-2">
              
                    <input type="text" name="username" id="username" placeholder="Username" class=" placeholder:text-sm placeholder:text-zinc-400  w-full border    px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <div class="py-2">
                 
                    <input type="text" name="password" id="password" placeholder="Password" class="placeholder:text-sm placeholder:text-zinc-400   w-full border    px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <button type="submit" name="submit_login" class="px-2 py-2 bg-zinc-800 text-white w-full   mt-1    hover:bg-zinc-900 hover:shadow-lg">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
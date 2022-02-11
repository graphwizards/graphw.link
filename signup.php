<?php
session_start();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/flowbite.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="h-screen w-screen flex flex-wrap justify-center content-center">
        <div class="w-1/4  p-4">
            <h1 class="text-2xl font-semibold text-zinc-800">Admin Signup</h1>
            <?php
            include('./database.php');

            if (isset($_SESSION['name'])) {
                header('location:index.php');
            }
            if (isset($_POST['submit_login'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $re_password = $_POST['re_password'];

                if (!$username == '' && !$email == '' && !$password == '' && !$re_password == '' ) {
                    if ($password == $re_password) {
                        $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    
                        $sql = "CREATE TABLE IF NOT EXISTS `admin`(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(50) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        pass VARCHAR(50) NOT NULL
                        )";
                        if (mysqli_query($con, $sql)) {
                            $query = "INSERT INTO `admin`(`username`,`email`,`pass`) VALUES ('$username', '$email', '$hash_pass')";
                            if (mysqli_query($con, $query)) {
                                $last_id = $con->insert_id;
                                echo "  <div class='bg-green-50 border border-green-500 my-3 px-3 text-green-500 py-2'>
                                Admin Registered success ! </div>";
                                session_start();
                                $_SESSION['id'] = $last_id;
                                $_SESSION['name'] = $username;
                                session_commit();
                                header('location:index.php');
                            } else {
                                echo mysqli_error($con);
                            }
                        } else {
                            echo mysqli_error($con);
                        }
                    } else {
                        echo " <div id='toast-danger' class='absolute bottom-10 right-10 flex items-center w-full max-w-xs p-4 mb-4 text-white bg-red-700  rounded-lg shadow dark:text-gray-400 dark:bg-gray-800' role='alert'>
                        <div class='inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200'>
                            <svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
                        </div>
                        <div class='ml-3 text-sm font-normal'>Password dosent match</div>
                        <button type='button' class='ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' data-collapse-toggle='toast-danger' aria-label='Close'>
                            <span class='sr-only'>Close</span>
                            <svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
                        </button>
                    </div>";
                    }
                }
              
            }
            ?>
            
            <form action="#" method="POST" autocomplete="off" class="mt-4">
                <div class="py-2">
                    <input type="text" name="username" id="username" placeholder="Username" class=" placeholder:text-sm placeholder:text-zinc-400  w-full border ring-none   px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <div class="py-2">

                    <input type="email" name="email" id="email" placeholder="Email" class=" placeholder:text-sm placeholder:text-zinc-400  w-full border    px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <div class="py-2">

                    <input type="password" name="password" id="password" placeholder="Password" class="placeholder:text-sm placeholder:text-zinc-400   w-full border    px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <div class="py-2">
                    <input type="password" name="re_password" id="re_password" placeholder="Re-Password" class="placeholder:text-sm placeholder:text-zinc-400   w-full border    px-2 py-2 outline-none focus:border-zinc-800">
                </div>
                <button type="submit" name="submit_login" class="px-2 py-2 bg-zinc-800 text-white w-full   mt-1    hover:bg-zinc-900 hover:shadow-lg">Signup</button>
                
                <a href="./login.php" class="text-center mt-2   ">Login</a>

            </form>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
</body>

</html>
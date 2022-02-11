<?php
include('./database.php');
session_start();
if (isset($_SESSION['name'])) {
} else {
    session_destroy();
    header('location:login.php');
}

function fetch($dir)
{
    $scan = scandir($dir);
    for ($i = 2; $i < count($scan); $i++) {
        $name =  $scan[$i];


        echo " <div class='border p-4 bg-white  hover:shadow duration-7 cursor-pointer text-center'>
        <a href='?folder=/$name'>
                        <div class='w-full flex justify-center'>
                            <img src='./folder-icon.svg'>
                        </div>
                        <p class='mt-2 text-slate-600  '> $name  </p>
                        </a>
        
                    </div>";
    }
}

function fetchSubfolder($dir, $location)
{
    $scan = scandir($dir);
    for ($i = 2; $i < count($scan); $i++) {
        $name =  $scan[$i];


        echo " <div class='border p-4 bg-white  hover:shadow duration-7 cursor-pointer text-center'>
        <a href='?folder=$location/$name'>
                        <div class='w-full flex justify-center'>
                            <img src='./folder-icon.svg'>
                        </div>
                        <p class='mt-2 text-slate-600  '> $name  </p>
                        </a>
        
                    </div>";
    }
}


function folderSize($dir)
{
    $count_size = 0;
    $count = 0;
    $dir_array = scandir($dir);
    foreach ($dir_array as $key => $filename) {
        if ($filename != ".." && $filename != ".") {
            if (is_dir($dir . "/" . $filename)) {
                $new_foldersize = foldersize($dir . "/" . $filename);
                $count_size = $count_size + $new_foldersize;
            } else if (is_file($dir . "/" . $filename)) {
                $count_size = $count_size + filesize($dir . "/" . $filename);
                $count++;
            }
        }
    }
    return $count_size;
}



if (isset($_GET['folder'])) {
    $location = $_GET['folder'];
    $dir = 'storage' . $location;
} else {
    $location = '';
    $dir = 'storage';
}

function getSymbolByQuantity($bytes)
{
    if($bytes > 0){
        $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $exp = floor(log($bytes) / log(1024));
        return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
    }
    else{
        return sprintf('0 B');
    }
   
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/flowbite.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/74999862f8.js" crossorigin="anonymous"></script>

</head>

<body class="bg-zinc-50">

    <header>
        <nav class="px-12 bg-white border-b   py-3 flex justify-between flex-wrap items-center">
            <h1 class="text-xl font-semibold text-zinc-700">graphw.link</h1>
            <div class="flex items-center">
                <p class="text-zinc-700 mx-5">Welcome ! <?php echo $_SESSION['name']  ?> </p>
                <a class="px-5 py-2 text-sm text-white font-semibold bg-blue-600   rounded-full" href="./logout.php">Logout</a>

            </div>
        </nav>
    </header>
    <div class="px-12 py-1 bg-zinc-100 border-b ">
        <div class="bg-zinc-50 p-1 px-4 border rounded-full">
            <p id="url" class="text-zinc-500">www.graphw.link/storage<?php if (isset($_GET['folder'])) {
                                                                            echo $_GET['folder'];
                                                                        }  ?> </p>
        </div>
    </div>

    <div class="px-12 ">
        <div class="  py-8  flex justify-between flex-wrap items-center">
            <?php
            if (isset($_GET['folder'])) {
                $url = $_GET['folder'];
                $url = substr($url, 0, strrpos($url, '/'));
                echo "<a href='?folder=$url' class='px-5 py-1 text-semibold   '><i class='fa-solid fa-arrow-left-long'></i> Back</a>";
            }

            ?>



        </div>
        <div class=" grid grid-cols-8 gap-3">
            <div class="col-span-2">
                <div class="border bg-white p-4">
                    <?php
                    $size =  disk_total_space($dir);
                    echo getSymbolByQuantity($size);
                    // Free Space
                    echo "<br/>";
                    $freespace = disk_free_space($dir);
                    echo getSymbolByQuantity($freespace);
                    // Folder size
                    echo "<br/>";
                    $foldersize =  folderSize($dir);
                    echo getSymbolByQuantity($foldersize);
                    ?>
                </div>

            </div>
            <div class="col-span-6">
                <div class="grid grid-cols-6 gap-3">
                    <?php
                    if (is_dir($dir)) {
                        fetchSubfolder($dir, $location);
                    } else {
                        $myfile = fopen($dir, 'r');
                        echo "<div class='col-span-6 bg-white p-10 border shadow'>" . fread($myfile, filesize($dir)) . "</div> ";
                    }
                    ?>
                </div>

                <div class="mt-5">

                </div>


            </div>





        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
</body>

</html>
<?php
// include('./database.php');
session_start();
if (isset($_SESSION['name'])) {
} else {
    session_destroy();
    header('location:login.php');
}
// fetch Folders
function fetchFolders($dir, $location)
{
    $scan = scandir($dir);
    for ($i = 2; $i < count($scan); $i++) {
        $name =  $scan[$i];
        $folder = $dir . '/' . $name;
        $path = $location.'/'.$name;
        if (is_dir($folder)) {
            echo "   <div class='rounded    p-4'>
            <a   href='?path=$path'>
            <div class='flex justify-center '>
            <svg xmlns='http://www.w3.org/2000/svg' width='80' height='62' viewBox='0 0 131.742 105.394'>
                <path id='Path_2' class='fill-blue-400 hover:fill-blue-700 duration-700' data-name='Path 2' d='M56.7,8H17.174A13.115,13.115,0,0,0,4.066,21.174L4,100.219a13.171,13.171,0,0,0,13.174,13.174H122.568a13.171,13.171,0,0,0,13.174-13.174V34.348a13.171,13.171,0,0,0-13.174-13.174h-52.7Z' transform='translate(-4 -8)'/>
            </svg>
            
            </div>
            <p class='mt-2 font-semibold text-lg text-zinc-500 text-center'>$name</p>
            <p class='text-center text-sm text-zinc-400'> " . getSymbolByQuantity(folderSize('storage/'.$path)) .  " </p>
            </a>
          
        </div>";
        } elseif (is_file($folder)) {
            $extention = pathinfo($folder, PATHINFO_EXTENSION);
            if ($extention == 'txt' || 'pdf') {
                echo " <div class='border p-4 bg-white  hover:shadow duration-7 cursor-pointer text-center'>
                <a href='?path=$location/$name'>
                                <div class='w-full flex justify-center'>
                                <img src='./assets/icons/file.svg' class='h-12'>
                                </div>
                                <p class='mt-2 text-slate-600  '> $name  </p>
                                
                                </a>
                            </div>";
            } elseif ($extention == 'jpg') {
                echo " <div class='border p-4 bg-white  hover:shadow duration-7 cursor-pointer text-center'>
                <a href='?path=$location/$name'>
                                <div class='w-full flex justify-center h-12 overflow-hidden'>
                                <img src='$folder' class=''>
                                </div>
                                <p class='mt-2 text-slate-600  '> $name  </p>
                                
                                </a>
                            </div>";
            }
        }
    }
}
// get folder size
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
// Translate Bytes into human readable
function getSymbolByQuantity($bytes)
{
    if ($bytes > 0) {
        $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $exp = floor(log($bytes) / log(1024));
        return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
    } else {
        return sprintf('0 B');
    }
}
// space percentage
function getPerc($total, $free)
{
    $total = round(preg_replace("/[^0-9.\s]/", "", $total));
    $free = round(preg_replace("/[^0-9.\s]/", "", $free));
    $sum = 100 - ($free / $total) * 100;
    return round($sum) . "%";
}
function usedSpapce($total, $free)
{
    $total = round(preg_replace("/[^0-9.\s]/", "", $total));
    $free = round(preg_replace("/[^0-9.\s]/", "", $free));
    $sum = $total - $free;
    return round($sum);
}
// Scan Directory
if (isset($_GET['path'])) {
    $location = $_GET['path'];
    $dir = 'storage' . $location;
} else {
    $location = '';
    $dir = 'storage';
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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    gridTemplateRows: {
                        // Simple 8 row grid
                        '7': 'repeat(7, minmax(0, 1fr))',

                        // Complex site-specific row configuration
                        'layout': '200px minmax(900px, 1fr) 100px',
                    }
                }
            }
        }
    </script>
</head>

<body>
  <!-- Create Folder -->

  <div data-modal-toggle="authentication-modal" class="absolute cursor-pointer   px-4 py-2 bg-white border flex flex-wrap content-center justify-center items-center shadow rounded-full" style=" bottom:10%; right:5%; ">
   
    <p class="font-semibold text-zinc-700">New Folder</p>

</div>


<!-- Main modal -->
<div id="authentication-modal" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
    <div class="relative px-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" action="./createFolder.php" method="POST">
                <!-- <h3 class="text-xl font-medium text-gray-900 dark:text-white">Create Folder</h3> -->
                <div>
                  
                    <input type="text" name="folderName" id="folderName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white outline-none" placeholder="Enter Folder Name" required/>
                    <input type="hidden" name="path" value="<?php echo $location; ?>" />
                    
                </div>
                
              
                <button type="submit" name='createFolder' class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create Folder</button>
                
            </form>
        </div>
    </div>
</div>



<!-- end of create folder -->



    <div class="h-screen">
        <div class="grid grid-rows-7 h-screen grid-flow-col">
            <div class="    flex flex-wrap content-center px-10">
                <div class="flex justify-between items-center w-full">
                    <h1 class="text-3xl font-semibold text-blue-700">Graph.Link</h1>
                    <div class="bg-zinc-100 px-5 py-2 rounded-full   flex items-center" style="width: 40%;">
                        <p><i class="fa-solid fa-magnifying-glass text-zinc-400  "></i></p>
                        <input type="text" name="search" id="search" class="w-full bg-transparent px-3 outline-none placeholder:text-zinc-400 " placeholder="Search File">
                    </div>
                    <div class="flex items-center">
                        <p class="mr-3 text-lg text-zinc-700"><?php echo $_SESSION['name']  ?></p>
                        <div class="flex justify-center flex-wrap content-center text-white bg-blue-800 rounded-full h-10 w-10">M</div>
                    </div>
                </div>
            </div>
            <div class="  row-span-6">
                <div class="grid grid-cols-6 h-full">
                    <div class="bg-blue-700   min-h-full rounded-tr-3xl p-10 flex flex-wrap content-between">
                        <button class="w-full bg-white py-2  font-semibold rounded-full shadow-lg shadow-blue-800 hover:shadow-xl duration-200 easy-in-out hover:shadow-blue-900 text-blue-700">Upload File</button>
                        <div class="w-full">
                            <p class="text-sm tracking-wider text-blue-200">STORAGE DETAIL</p>
                            <div class="h-px bg-blue-500   my-3 w-full  "></div>
                            <?php
                            if (is_dir($dir)) {
                                $size =  disk_total_space($dir);
                                $total = getSymbolByQuantity($size);
                                // Free Space
                                $freespace = disk_free_space($dir);
                                $free = getSymbolByQuantity($freespace);
                                // Folder size
                                $foldersize =  folderSize($dir);
                                //  Bar
                                $perc =  getPerc($total, $free);
                                // used
                                $usedSpace = usedSpapce($size, $freespace);
                                $used = getSymbolByQuantity($usedSpace);
                                echo "   <p class='text-sm text-blue-300 font-bold'>$used / $total </p>
                                <div class='bg-blue-100 w-full rounded-full  '>
                                    <div class='h-2 bg-blue-500 mt-2 rounded-full' style='width: $perc;'></div>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-span-5 p-10">
                        <h1 class="text-lg text-zinc-700 font-semibold"> 
                            <?php
                            if (isset($_GET['path'])) {
                                $url = $_GET['path'];
                                if($url == ''){
                                    echo "Stroage";
                                }
                                else{
                                    $url = substr($url, 0, strrpos($url, '/'));
                                    echo  "<a href='?path=$url'>Home" .$_GET['path'] . "</a>";
                                }
                            }
                            else{
                                echo "Stroage";
                            }
                            ?>
                        </h1>
                        <div class=" h-px bg-zinc-200 my-4"></div>
                        <!-- Folders -->
                        <div class="grid grid-cols-7 gap-6 ">
                            <!-- <div class="rounded    p-4">
                                <div class="flex justify-center  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="62" viewBox="0 0 131.742 105.394">
                                        <path id="Path_2" class="fill-blue-400 hover:fill-blue-700" data-name="Path 2" d="M56.7,8H17.174A13.115,13.115,0,0,0,4.066,21.174L4,100.219a13.171,13.171,0,0,0,13.174,13.174H122.568a13.171,13.171,0,0,0,13.174-13.174V34.348a13.171,13.171,0,0,0-13.174-13.174h-52.7Z" transform="translate(-4 -8)" />
                                    </svg>
                                </div>
                                <p class="mt-2 font-semibold text-lg text-zinc-500 text-center">Document</p>
                            </div> -->
                            <?php
                            fetchFolders($dir, $location);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

    <!-- Show Folders -->
    <!-- <?php
            if (is_dir($dir)) {
                fetchFolders($dir, $location);
            } else {
                $myfile = fopen($dir, 'r');
                $ext = pathinfo($dir, PATHINFO_EXTENSION);
                if ($ext == 'jpg') {
                    echo "<div class='col-span-6 bg-white 5 border shadow'><img src='$dir' class='w-full border'/> </div> ";
                } elseif ($ext == 'txt') {
                    echo "<div class='col-span-6 bg-white p-10 border shadow'>" . fread($myfile, filesize($dir)) . "</div> ";
                } elseif ($ext == 'pdf') {
                    echo " <div class='col-span-6 bg-white p-5 border shadow'><iframe src='$dir' class='w-full h-screen' /> </div> ";
                }
            }
            ?> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
    <script src="./assets/script.js"></script>
</body>

</html>
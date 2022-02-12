<?php
session_start();
if (isset($_SESSION['name'])) {
} else {
    session_destroy();
    header('location:login.php');
}

if(isset($_POST['createFolder'])){
    $path = $_POST['path'];
    $folderName = $_POST['folderName'];
    
    $folder =  'storage/'. $path."/".$folderName;
    

    $createFolder = mkdir($folder,0777, true);
    if($createFolder){
        header('location:index.php?path='.$path);
    }

}



?>
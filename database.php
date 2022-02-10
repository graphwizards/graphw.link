 
<?php

$hostname = 'sql177.main-hosting.eu';
$username = 'u924875114_graph';
$password = 'Glink@7700';
$database = 'u924875114_glink';

$con = new mysqli($hostname, $username, $password, $database);
if($con->connect_errno){
    die('Error ' . $con->connect_error);
}

?>

 
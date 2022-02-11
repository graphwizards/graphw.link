<?php
header('Access-Control-Allow-Origin: *');
include('./api-key.php');

if (isset($_GET['api-key'])) {

    $key = $_GET['api-key'];
    $verify =  verify($key);
    if ($verify == true) {
        header('Content-type: application/json');
        $response = array();
        $response[0] = array(
            'id' => '1',
            'value1'=> 'value1',
            'value2'=> 'value2'
        );
    
    echo json_encode($response);
    }
    else{
        echo "invalid Key";
    }
}
else{
    echo "Invalid Api Key";
}

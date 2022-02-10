<?php
header('Access-Control-Allow-Origin: *');

if (isset($_GET['api-key'])) {
    $key = $_GET['api-key'];
    if ($key == '250753') {
        header('Content-type: application/json');
        $response = array();
        $response[0] = array(
            'id' => '1',
            'value1'=> 'value1',
            'value2'=> 'value2'
        );
    
    echo json_encode($response);
    }
}
else{
    echo "Invalid Api Key";
}

 
?>
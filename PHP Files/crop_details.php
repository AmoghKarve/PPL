<?php
        error_reporting(0);
 mysql_set_charset('utf8');
/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
$json = file_get_contents('php://input');
$json_array = json_decode($json,true);

$name = 'wheat';

// check for post data
if($json_array["action"] == "GetCropDetails"){
       $name = $json_array["name"];
   }
 
    // get a product from products table
    $result = mysql_query("SELECT description FROM crops WHERE (name = '$name') ");
    //echo $result;
    if (!empty($result)) {
        // check for empty result
        //mysql_num_rows($result) > 0) {
            //echo 1;
            
            $result = mysql_fetch_assoc($result);
            //echo $result["description"];
            $response["success"] = 1;
            $response["message"] = "Succesfull";
            $response["description"] = $result["description"];
            // echo $response["description"];

            echo json_encode($response);

        
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "Crop details not found";
 
        // echo no users JSON
        echo json_encode($response);
    }
//}
?>

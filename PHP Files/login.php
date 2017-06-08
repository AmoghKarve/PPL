<?php
     error_reporting(0);

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

$json = file_get_contents('php://input');
$json_array = json_decode($json,true);

// check for required fields


    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

$username = "PPL";
$password = "somestring";

if($json_array["action"] == "Login"){
    $username = $json_array["username"];
    $password = $json_array["password"];}

    //if($username && $password){
    // mysql inserting a new row
        $result = mysql_query("SELECT password FROM users WHERE (username = '$username')");
        // check if row inserted or not
        if ($result) {
            $result = mysql_fetch_assoc($result);
            //echo $result;
            if($result["password"] == $password){
            // successfully inserted into database
                $response["success"] = 1;
                $response["message"] = "Login successfull.";
            }else{
                $response["success"] = 0;
                $response["message"] = "Login failed.";
            }

            // echoing JSON response
            echo json_encode($response);
        } else {
            // failed to insert row
            $response["success"] = 0;
            $response["message"] = "Oops! An error occurred.";

            // echoing JSON response
            echo json_encode($response);
        }
    /*} else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";

        // echoing JSON response
        echo json_encode($response);
    }*/
//}
?>
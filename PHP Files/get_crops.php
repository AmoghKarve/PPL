<?php
    error_reporting(0);
 
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
 
// check for post data
$json = file_get_contents('php://input');
$json_array = json_decode($json,true);

    //$latitude = 9.0;
    //$longitude = 2.0;
    //$latitude = $_GET["latitude"];
    //$longitude = $_GET["longitude"];
    if($json_array["action"] == "GetCrops"){
       $latitude = $json_array["lng"];
       $longitude = $json_array["lat"];}
        $latitude = 9;
        $longitude = 2;
    
    // get a product from products table
    $result = mysql_query("SELECT crop FROM regions WHERE st_contains(poly, st_geomfromtext('POINT($longitude $latitude)'))");
 
    //echo $result;
    //echo mysql_num_rows($result);
    if (!empty($result)) {
        // check for empty resu
        if (mysql_num_rows($result) > 0) {
           $response["result"] = array();
 
            while($row = mysql_fetch_array($result)){
                $crops = split(" ", $row["crop"]);
                foreach ($crops as $crop) {
                    # code...
                    array_push($response["result"], $crop);
                }
        
            }
        
 //           $result = $result["crop"];
	//       $result = split(" ",$result);

/*            $product = array();
            $product["pid"] = $result["pid"];
            $product["name"] = $result["name"];
            $product["price"] = $result["price"];
            $product["description"] = $result["description"];
            $product["created_at"] = $result["created_at"];
            $product["updated_at"] = $result["updated_at"];
*/            // success
            $response["success"] = 1;
            $response["message"] = "Succesfull";
            // user node
  
//            array_push($response["result"], $result);
 
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no crop found
            $response["success"] = 0;
            $response["message"] = "No crop found";
 
            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no crop found
        $response["success"] = 0;
        $response["message"] = "No crop found";
 
        // echo no users JSON
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

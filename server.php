<?php
require_once "src/nusoap.php";

//Connect to the database
$host = "127.0.0.1";
$user = "mungyoyo";                                 //Your Cloud 9 username
$pass = "";                                         //Remember, there is NO password by default!
$db = "eldercare";                                  //Your database name you want to connect to
$port = 3306;                                       //The port #. It is always 3306
$connection = mysql_connect($host, $user, $pass);
if (!mysql_select_db($db)) {                        //debug choosing db access denied
    die('Could not select database: ' . mysql_error());
}

function getElderData($id_array){
        $query = "SELECT * FROM elder";
        $result = mysql_query($query); 
        $xml = "<elderdata>";                       //open Tag
        if (!$result) {
         die('Could not query:' . mysql_error());
        }
        while($data = mysql_fetch_assoc($result)) { //Read all Rows
            $xml .= "<elder>";                      //open inner Tag
            foreach($data as $key => $value) {      //each element data
                $xml .= "<$key>$value</$key>";      //append to xml
            }
            $xml .= "</elder>";                     //close inner tag
        }
        $xml .= "</elderdata>";                     //close  tag
        return $xml;                                // outputs rows of elder data
}

// function getProd($category) {
//     if ($category == "books") {
//         return join(",", array(
//             "The WordPress Anthology",
//             "PHP Master: Write Cutting Edge Code",
//             "Build Your Own Website the Right Way"));
//     }
//     else {
//         return "No products listed under that category";
//     }
// }

$server = new soap_server();
$server->configureWSDL("eldercare", "urn:eldercare");

$server->register("getElderData",
    array("id" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#getElderData",
    "rpc",
    "encoded",
    "Get a Elder data in database");

// $server->register("getProd",
//     array("category" => "xsd:string"),
//     array("return" => "xsd:string"),
//     "urn:productlist",
//     "urn:productlist#getProd",
//     "rpc",
//     "encoded",
//     "Get a listing of products by category");
    
$server->service($HTTP_RAW_POST_DATA);
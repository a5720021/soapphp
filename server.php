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

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
 
    if ($_SERVER['PHP_AUTH_USER'] == "admin" && $_SERVER['PHP_AUTH_PW'] == "1234")
        return true;
    else
        return false;
    }
}

function getElderData($id_array){
        $query = "SELECT * FROM elder where e_id = ".$id_array;//.$id_array["id"];
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
        return $xml;                                //outputs all of elder data
}

function getAllElder($id_array){
        $query = "SELECT * FROM elder"; 			//.$id_array["id"];
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
        return $xml;                                //outputs all of elder data
}

function deleteElder($id_array){
    $query = "DELETE FROM elder where e_id = ".$id_array;//.$id_array["id"];
    $result = mysql_query($query); 
    $xml = "<elderdata>";                       //open Tag
    if (!$result) {
        die('Could not query:' . mysql_error());
    }
    return getAllElder('0');
}

function addElder($id,$name){
     $query = "INSERT INTO elder(e_id,e_name) VALUES(". $id .",'". $name ."')";
     $result = mysql_query($query);
     if (!$result) {
        die('Could not query:' . mysql_error());
     }
     return getAllElder('0');
}

function updateElder($id,$name){
     $query = "UPDATE elder SET e_name = '". $name ."' WHERE e_id = ". $id;
     $result = mysql_query($query);
     if (!$result) {
        die('Could not query:' . mysql_error());
     }
     return getAllElder('0');
}

$server = new nusoap_server();
$server->configureWSDL("eldercare", "urn:eldercare");

$server->register("getElderData",
    array("id" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#getElderData",
    "rpc",
    "encoded",
    "Get a Elder data in database");
    
$server->register("getAllElder",
    array("id" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#getAllElder",
    "rpc",
    "encoded",
    "Get all Elder data in database");
    
$server->register("deleteElder",
    array("id" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#deleteElder",
    "rpc",
    "encoded",
    "Delete one Elder data from id");
    
$server->register("addElder",
    array("id" => "xsd:string", "name" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#addElder",
    "rpc",
    "encoded",
    "Add one Elder to db");
    
$server->register("updateElder",
    array("id" => "xsd:string", "name" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:eldercare",
    "urn:eldercare#updateElder",
    "rpc",
    "encoded",
    "Update Elder's name from id");
    
$server->service($HTTP_RAW_POST_DATA);
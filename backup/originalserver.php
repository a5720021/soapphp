<?php

class server{

    public function __construct(){
        //Connect to the database
        $host = "127.0.0.1";
        $user = "mungyoyo";                          //Your Cloud 9 username
        $pass = "";                                  //Remember, there is NO password by default!
        $db = "eldercare";                                  //Your database name you want to connect to
        $port = 3306;                                //The port #. It is always 3306
        $connection = mysql_connect($host, $user, $pass);
        if (!mysql_select_db($db)) {
            die('Could not select database: ' . mysql_error());
        }
    }
   
    public function getElderData($id_array){
        $query = "SELECT e_name FROM elder";
        $result = mysql_query($query);
        if (!$result) {
         die('Could not query:' . mysql_error());
        }
        return mysql_result($result, 0); // outputs third employee's name
    }
}

$params = array('uri' => '/server.php');
$server = new SoapServer(NULL, $params);
$server->setClass('server');
$server->handle();

?>
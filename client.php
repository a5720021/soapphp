<head>
  <title>Eldercare Database</title>
  <h1>Welcome to Eldercare Database</h1>
</head>
<?php
require_once "src/nusoap.php";

$client = new nusoap_client("https://elderservice-185817.appspot.com/wsdl.php?wsdl");

$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}
?>
<h2>Search by id</h2>
<form action="client.php" method="post" name="form1">
  <input type="text" name="elderid">
  <input name="searchid" type="submit" value="Search by id">
  <input name="deleteid" type="submit" value="Delete by id">
  <input name="getall" type="submit" value="Get All Data">
<h2>Create data</h2>
  id : <input type="text" name="elderid2">
  name : <input type="text" name="eldername">
  <input name="createdata" type="submit" value="Create">
  <input name="updatedata" type="submit" value="Update">
</form>
<?php
//Use basic authentication method
$client->setCredentials("admin22", "1234", "basic");
// $resultAuthentication = "";

//Call function from server
if($_POST["getall"] == "Get All Data"){
  $result = $client->call("getAllElder", array("id" => $_POST["elderid"]));
}elseif($_POST["deleteid"] == "Delete by id"){
  $result = $client->call("deleteElder", array("id" => $_POST["elderid"]));
}elseif($_POST["createdata"] == "Create"){
  $e_id = $_POST["elderid2"];
  $e_name = $_POST["eldername"];
  $result = $client->call("addElder", array("id" => $e_id, "name" => $e_name) );
}elseif($_POST["updatedata"] == "Update"){
  $e_id = $_POST["elderid2"];
  $e_name = $_POST["eldername"];
  $result = $client->call("updateElder", array("id" => $e_id, "name" => $e_name) );
}else{
  $result = $client->call("getElderData", array("id" => $_POST["elderid"]));
}

//if return soap false messages
// if ($client->fault) {
//     echo "<h2>Fault</h2><pre>";
//     print_r($result);
//     echo "</pre>";
// }
// else {
//     $error = $client->getError();
//     if ($error) {
//         echo "<h2>Error</h2><pre>" . $error . "</pre>";
//     }
//     else {
//         echo "<h2>Result</h2>";
//         echo '<pre>',htmlentities($result),'</pre>';
//     }
// }

// //Debugging on SOAP messages req/res
// echo "<h2>Request</h2>";
// echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
// echo "<h2>Response</h2>";
// echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

//xsl doc for display xml
$xslDoc = new DOMDocument();
$xslDoc->load("elderdata.xsl");

$xmlDoc = new DOMDocument();
$xmlDoc->loadXML($result);

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);
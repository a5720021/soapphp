<?php
require_once "src/nusoap.php";

$client = new nusoap_client("https://soap-php-mungyoyo.c9users.io/server.php");

$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

//Call function from server
$result = $client->call("getElderData", array("id" => "0"));

//if return soap false messages
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Result</h2>";
        echo '<pre>',htmlentities($result),'</pre>';
    }
}

//Debugging on SOAP messages req/res
echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
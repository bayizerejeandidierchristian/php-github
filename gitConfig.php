<?php
// Start session
if(!session_id()){
    session_start();
}
require_once 'Github_OAuth_Client.php';
$clientID         = 'a0ced929e429f1402e47';
$clientSecret     = 'e729826a3a6f3f8d4b25207c66e5a65c1e0875d3';
$redirectURL     = 'http://localhost/didier';
$gitClient = new Github_OAuth_Client(array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectURL,
));
if(isset($_SESSION['access_token'])){
    $accessToken = $_SESSION['access_token'];
}

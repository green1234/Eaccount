<?php
// import of xmlrpc library for php
// Prueba para duplicar Base de Datos
include('lib/xmlrpc.inc');

/* identifiants of the new database  */
$user = 'admin';
$password = 'admin';
$dbname = 'admin';
$lang="es_MX";

    $server_url = 'http://localhost:7069'; //server url with security verification
    $client = new xmlrpc_client($server_url . "/xmlrpc/db");
    $client->setSSLVerifyPeer(0);
    
    $msg = new xmlrpcmsg('duplicate_database'); // method create_database allow us to create a new database on openerp
    $msg->addParam(new xmlrpcval("admin", "string")); //Super Pass
    $msg->addParam(new xmlrpcval($dbname, "string"));
    $msg->addParam(new xmlrpcval($dbname."2", "string"));
    
    $response = $client->send($msg);
    
    echo "<pre>";
    print_r($response);
    echo "</pre>";
?>
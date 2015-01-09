<?php

require_once( '../lib/xmlrpc.inc' );

$dbname = 'eaccount';
$user = 'admins';
$password = 'admin';
$server_url = 'http://localhost:7069/';

$connexion = new xmlrpc_client($server_url . "xmlrpc/common");
$connexion->setSSLVerifyPeer(0);

$c_msg = new xmlrpcmsg('login');
$c_msg->addParam(new xmlrpcval($dbname, "string"));
$c_msg->addParam(new xmlrpcval($user, "string"));
$c_msg->addParam(new xmlrpcval($password, "string"));
$c_response = $connexion->send($c_msg);

var_dump($c_response);

if ($c_response->errno != 0){
    echo  '<p>error : ' . $c_response->faultString() . '</p>';
}
else{
	$uid = $c_response->value()->scalarval();
	//var_dump($uid);

	/*$val = array ( 
	    "name" => new xmlrpcval("Godin", "string")	    
    );

    $client = new xmlrpc_client($server_url . "xmlrpc/object");
    $client->setSSLVerifyPeer(0);

    $msg = new xmlrpcmsg('execute'); 
    $msg->addParam(new xmlrpcval($dbname, "string")); 
    $msg->addParam(new xmlrpcval($uid, "int")); 
    $msg->addParam(new xmlrpcval($password, "string")); 
    $msg->addParam(new xmlrpcval("res.partner", "string")); 
    $msg->addParam(new xmlrpcval("create", "string")); 
    $msg->addParam(new xmlrpcval($val, "struct")); 
    $response = $client->send($msg);

	echo 'Partner created - partner_id = ' . $response->value()->scalarval();*/

	$domain_filter = array ( 
        new xmlrpcval(
            array(new xmlrpcval('is_company' , "string"), 
                  new xmlrpcval('!=',"string"), 
                  new xmlrpcval('True',"string")
                  ),"array"             
            ),
        );

	$client = new xmlrpc_client($server_url . "xmlrpc/object");
    $client->setSSLVerifyPeer(0);

    $msg = new xmlrpcmsg('execute'); 
    $msg->addParam(new xmlrpcval($dbname, "string")); 
    $msg->addParam(new xmlrpcval($uid, "int")); 
    $msg->addParam(new xmlrpcval($password, "string")); 
    $msg->addParam(new xmlrpcval("res.partner", "string")); 
    $msg->addParam(new xmlrpcval("search", "string")); 
    $msg->addParam(new xmlrpcval($domain_filter, "array")); 
    $response = $client->send($msg);
    
    $result = $response->value();
    $ids = $result->scalarval();

    $id_list = array();
    
    for($i = 0; $i < count($ids); $i++){
        $id_list[]= new xmlrpcval($ids[$i]->me['int'], 'int');
    }



     $field_list = array(
        new xmlrpcval("name", "string"),
        /*new xmlrpcval("email", "string"),
        new xmlrpcval("street", "string"),
        new xmlrpcval("city", "string"),
        new xmlrpcval("zip", "string"),*/
    );

     
    $msg = new xmlrpcmsg('execute');
    $msg->addParam(new xmlrpcval($dbname, "string"));
    $msg->addParam(new xmlrpcval($uid, "int"));
    $msg->addParam(new xmlrpcval($password, "string"));
    $msg->addParam(new xmlrpcval("res.partner", "string"));
    $msg->addParam(new xmlrpcval("read", "string")); 
    $msg->addParam(new xmlrpcval($id_list, "array")); 
    $msg->addParam(new xmlrpcval($field_list, "array")); 

    $resp = $client->send($msg);
    var_dump($resp);


    if ($resp->faultCode()){
        echo $resp->faultString();
    }

    $result = $resp->value()->scalarval();

    for($i = 0; $i < count($result); $i++){
        echo '<h1>' . $result[$i]->me['struct']['name']->me['string'] . '</h1>';
           /*. '<ol>'
           . '<li><strong>Email</strong> : ' . $result[$i]->me['struct']['email']->me['string'] . '</li>'
           . '<li><strong>Street</strong> : ' . $result[$i]->me['struct']['street']->me['string'] . '</li>'
           . '<li><strong>City</strong> : ' . $result[$i]->me['struct']['city']->me['string'] . '</li>'
           . '<li><strong>Zip code</strong> : ' . $result[$i]->me['struct']['zip']->me['string'] . '</li>'
           . '</ol>'     
           . '<hr />';*/
    }
    /*var_dump($result);*/
}

?>
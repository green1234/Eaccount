<?php

	require_once "../lib/xmlrpc.inc";

	$user = 'admin';
	$password = 'admin';
	$dbname = 'eaccount';
	$server_url = 'http://localhost:7069/xmlrpc/';


	if(isset($_COOKIE["user_id"]) == true)  {
	   if($_COOKIE["user_id"]>0) {
	   
	   // return $_COOKIE["user_id"];
	   }
	}


	$sock = new xmlrpc_client($server_url.'common');
	$msg = new xmlrpcmsg('login');
	$msg->addParam(new xmlrpcval($dbname, "string"));
	$msg->addParam(new xmlrpcval($user, "string"));
	$msg->addParam(new xmlrpcval($password, "string"));
	$resp =  $sock->send($msg);


	$val = $resp->value();
	$id = $val->scalarval();

	var_dump($id);

	setcookie("user_id",$id,time()+3600);
	if($id > 0) {
	   return $id;
	}else{
	   return -1;
}
	 
	

	
?>
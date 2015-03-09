<?
session_start();
//var_dump($_SESSION["login"]); exit();
if (isset($_SESSION["login"]))
{
	header('Location: inbox.php');
}
else
{
	header('Location: login.php');	
}
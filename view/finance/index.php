<?

if (isset($_GET["action"]))
{
	if ($_GET["action"] == "detail" && isset($_GET["cfdi"]))
	{
		include_once "detail.php";	
	}	
}
else
{
	include_once "tabla.php";
}
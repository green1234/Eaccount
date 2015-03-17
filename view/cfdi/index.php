<?

if (isset($_GET["action"]))
{
	if ($_GET["action"] == "detail" && isset($_GET["cfdi"]))
	{
		include_once "cfdi_detail.php";	
	}	
}
else
{
	include_once "tabla_cfdi.php";
}
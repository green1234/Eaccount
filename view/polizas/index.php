<?

if (isset($_GET["action"]))
{
	if ($_GET["action"] == "detail" && isset($_GET["pid"]))
	{
		include_once "poliza_detail.php";	
	}
	else if($_GET["action"] == "new")
	{
		include_once "poliza_new.php";		
	}
}
else
{
	include_once "tabla_poliza.php";
}
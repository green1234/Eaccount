<?php
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/UsuarioService.php";

// $admin_user = "admin";
// $admin_pw = "admin";
// $_POST["Action"] = "add";
if(isset($_SESSION["login"]))
{
	$cid = $_SESSION["login"]["cid"][0];
}

function registrar_cuenta_bancaria($cid, $p)
{
	$model = "res.company";		
	$method = "registrar_cuenta_bancaria";
	$params = array(
		"cid" => model($cid, "int"),
		"banco" => model($p["cta_banco"], "string"),
		"cuenta" => model($p["cta_numero"], "string"),
		"pais" => model($p["cta_pais"], "string"),
		"moneda" => model($p["cta_moneda"], "string"),
		"clabe" => model($p["cta_clabe"], "string"),
		"tipo" => model($p["cta_tipo"], "string")
	);

	$obj = new MainObject();
	$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);		
	return $response;
}

function verificar_data_received($data, $type="post")
{
	$tmp = array();
	foreach ($data as $key => $value) {		
		if ($type == "get")
		{
			$tmp[$value] = isset($_GET[$value]) ? $_GET[$value] : "";
		}
		else
		{
			$tmp[$value] = isset($_POST[$value]) ? $_POST[$value] : "";		
		}
	}
	return $tmp;
}

if (isset($_GET["section"]))
{
	switch ($_GET["section"]) {
		case 'perfil':
		case 'plan':
		case 'cuentas':	
		case 'permisos':	

			if ($_GET["section"] == "perfil")
				$data = array("Nombre", "Email", "Telefono", "Movil");
			else if ($_GET["section"] == "plan")
				$data = array("Id", "Capacidad", "Vigencia");
			else if ($_GET["section"] == "cuentas")
				$data = array("Id", "Nombre", "Email", "Telefono", "Movil");
			else if ($_GET["section"] == "permisos")
				$data = array("Id", "Id_plan", "Id_permisos");

			$data[] = "Action";
			$data = verificar_data_received($data);
			
			if ($data["Action"] == "add")
			{				
				$added = true;
				$id = "";
				foreach ($data as $idx => $value) {
					if ($value == "")
					{	
						$added = false;					
						$id = $idx;
						break;
					}					
				}	
				if ($added)
				{
					$res = array("success"=>true, "data"=>"El dato fue agregado");
				}			
				else
				{
					$res = array("success"=>false, "error"=>"El dato $id no puede ser vacio");
				}
			}
			else if ($data["Action"] == "write")
			{	
				$editable = false;
				$id = "";
				foreach ($data as $idx => $value) {
					if ($value != "" && $idx != "Action")
					{
						$editable = true;
						$id = $idx;
						break;				
					}					
				}
				if ($editable)
				{
					$res = array("success"=>true, "data"=>"El dato fue modificado");
				}
				else
				{
					$res = array("success"=>false, "error"=>"No hay ningun dato para editar");						
				}

			}
			else
			{
				$res = array("success"=>false, "error"=>"La accion enviada no esta disponible");
			}

			echo json_encode($res);

			break;
		
		default:
			# code...
			break;
	}
}
else if(isset($_GET["update"]) && isset($_GET["uid"]) && isset($_GET["pwd"]))
{
	$uid = $_GET["uid"];
	$pwd = $_GET["pwd"];
	$params = array();
		
	switch($_GET["update"])
	{
		case "perfil": 
			
			if (isset($_GET["email"]))
	  		{
	  			$params["email"] = $_GET["email"];
	  		}
	  		if (isset($_GET["phone"]))
	  		{
	  			$params["phone"] = $_GET["phone"];
	  		}
	  		if (isset($_GET["mobile"]))
	  		{
	  			$params["mobile"] = $_GET["mobile"];
	  		}

			$usuarioService = new UsuarioService($uid, $pwd);
			$res = $usuarioService->actualizar_perfil($params);

		break;

		case "empresa":

			if (isset($_GET["cid"]))
	  		{
	  			
	  			$params["id"] = $_GET["cid"];

	  			switch ($_GET["tipo"]) 
	  			{
	  				case 'profile':
	  					$params["name"] = $_GET["empresa_name"];
	  					break;

	  				case 'fiscales':
	  					$params["gl_razon_social"] = $_GET["razon_social"];
	  					$params["gl_rfc"] = $_GET["rfc"];
	  					$params["gl_regimen"] = $_GET["regimen"];
	  					$params["gl_giro"] = $_GET["giro"];
	  					$params["street"] = $_GET["domicilio"];	  					
	  					break;

	  				case 'representante':
	  					$params["gl_rlegal_name"] = $_GET["rep_nombre"];
	  					$params["gl_rlegal_rfc"] = $_GET["rep_rfc"];
	  					$params["gl_rlegal_curp"] = $_GET["rep_curp"];	  					  					
	  					break;

	  				case 'registros':
	  					$params["gl_rpatronal"] = $_GET["patronal"];
	  					$params["gl_restatal"] = $_GET["estatal"];	  						  					
	  					break;

	  				case 'adicionales':
	  					$params["gl_curp"] = $_GET["ad_curp"];
	  					$params["gl_imss"] = $_GET["ad_imss"];	  										
	  					break;


	  				
	  				default:
	  					# code...
	  					break;
	  			}
	  			

	  			
	  		}

	//  		echo json_encode($params);

	  		$usuarioService = new UsuarioService($uid, $pwd);
			$res = $usuarioService->actualizar_empresa($params);
		break;
	}

	echo json_encode($res);	
}
else if (isset($_GET["add"]))
{
	if ($_GET["add"] == "ctaban")
	{
		$keys = array(
			"cta_nac", 
			"cta_pais", 
			"cta_banco", 
			"cta_moneda",
			"cta_tipo",
			"cta_numero",
			"cta_clabe");

		$data = verificar_datos($_GET, $keys);

		if ($data)
		{
			$res = registrar_cuenta_bancaria($cid, $data);
		}
		else
		{
			$res = array("success"=>"error");
		}		
		echo json_encode($res);
	}
}
else
{
	if (isset($_GET["uid"]) && isset($_GET["pwd"]) &&  isset($_GET["cid"]))
	{
		$uid = $_GET["uid"];
  		$pwd = $_GET["pwd"];
  		$cid = $_GET["cid"];

		$empresaService = new EmpresaService(USER_ID, md5(PASS));
		$res = $empresaService->obtener_datos_empresa($cid);		
		
		echo json_encode($res);		
	}

	else if (isset($_GET["uid"]) && isset($_GET["pwd"]))
	{
		$uid = $_GET["uid"];
  		$pwd = $_GET["pwd"];

		$usuarioService = new UsuarioService($uid, $pwd);
		$res = $usuarioService->obtener_datos($uid);		
		
		echo json_encode($res);		
	}
}


?>
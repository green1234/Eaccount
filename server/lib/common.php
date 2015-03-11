<?php

	function obtener_periodo($id = "")
	{
		if ($id == "")
		{
			date_default_timezone_set("America/Mexico_City");
			return date("m");			
		}
		else
		{
			$periodos = array(
				"01" => "Enero",
				"02" => "Febrero",
				"03" => "Marzo",
				"04" => "Abril",
				"05" => "Mayo",
				"06" => "Junio",
				"07" => "Julio",
				"08" => "Agosto",
				"09" => "Septiembre",
				"10" => "Octubre",
				"11" => "Noviembre",
				"12" => "Diciembre",
			);

			return $periodos[$id];
		}
	}

	function verificar_datos($origin, $values)
	{
		$data = array();
		foreach ($values as $idx => $value) {
			if (!isset($origin[$value]))
			{
				return false;
			}
			else
			{
				$data[$value] = $origin[$value];
				continue;
			}
		}
		return $data;
	}
	
	function logg($value, $exit=false){
		echo "<pre>";
		var_dump($value);
		echo "</pre>";
		if ($exit)
			exit();
	}

	function codificar_utf8($res, $pre=array())
	{
		logg($res);
		foreach ($res as $index => $value) {

			if (is_array($value))
			{
				$pre[$index] = array();
				codificar_utf8($value, $pre[$index]);
			}
			else
			{
				$pre[$index] = utf8_encode($value);				
			}
		}

		$res = $pre;
		return $res;
	}

	function model($valor, $tipo)
	{
		return new xmlrpcval($valor, $tipo);
	}

	/*
	* Funciona para generar los objetos necesarios para enviar estructuras
	*/
	function prepare_params($params)
	{
		$keys = array();
		
		foreach ($params as $index => $value) {
			if (is_int($value))
				$keys[$index] = model($value, "int");	
			else if (is_bool($value))		
				$keys[$index] = model($value, "boolean");
			else if (is_string($value))
				$keys[$index] = model($value, "string");
		}		
		
		return $keys;
	}

	function prepare_tupla($ids)
	{

		foreach ($ids as $idx => $val) {
			$ids[$idx] = model($val, "int");
		}
				
		$tupla = array(
			model(array(			
					model(6, "int"), 
					model(0, "int"), 
					model($ids, "array"), 			
				), "array"),
			);

		return model($tupla, "array");

	}

	function prepare_ids($array)
	{
		$ids = array();
		foreach ($array as $key => $value) 
		{
			$ids[] = model($value, "int");
		}		
		return $ids;
	}	

	function prepare_domain($data)
	{
		$domain = array();
		foreach ($data as $key => $row) 
		{		
			$domain[$key] = model($row, "array");		
		}		
		return $domain;
	}

	function prepare_response($data, $vals=array())
	{	
		foreach ($data as $idx => $val) 
		{			
			if (is_object($val))
			{				
				$vals[$idx] = $val->me;
			
				if(isset($val->me["string"]))
				{
					$vals[$idx] = utf8_encode($val->me["string"]);
					/*$vals[$idx] = utf8_encode(data)*/
				}
				else if(isset($val->me["int"]))
				{
					$vals[$idx] = $val->me["int"];	
				}
				else if(isset($val->me["boolean"]))
				{
					if (!$val->me["boolean"])
						$vals[$idx] = "Pendiente";
					else
						$vals[$idx] = $val->me["boolean"];	
				}
				else if(isset($val->me["double"]))
				{
					if (!$val->me["double"])
						$vals[$idx] = 0.0;
					else
						$vals[$idx] = $val->me["double"];	
				}
				else if(isset($val->me["array"]))
				{	
					$vals[$idx] = prepare_response($val->me["array"]);
				}
				else if(isset($val->me["struct"]))
				{					
					#logg($val->me["struct"], 1);
					$vals[$idx] = prepare_response($val->me["struct"]);
				}
			}
			else if (is_array($val)){
				
				if(isset($val["string"]))
				{					
					$vals = utf8_decode($val["string"]);
				}
				else if(isset($val["int"]))
				{
					$vals = $val["int"];	
				}
				else if(isset($val["boolean"]))
				{
					if (!$val["boolean"])
						$vals = "Pendiente";
					else
						$vals = $val["boolean"];	
				}
				else if(isset($val["double"]))
				{
					if (!$val["double"])
						$vals = 0.0;
					else
						$vals = $val["double"];	
				}
			}
		}		

		return $vals;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php

function conectar(){
	
		$server="mysql.hostinger.es";
		$user="u616761031_teleu";
		$password="123456";
		$nameDataBase="u616761031_teleu";
  		$conexion=mysql_connect($server,$user,$password);
        mysql_select_db($nameDataBase,$conexion);
        return $conexion;
	}


	function getQuery($consulta)
	{
		$query=mysql_query($consulta);
		$resultado=mysql_fetch_array($query);
		return $resultado;
	}

	function getConsulta($consulta){
		$query=mysql_query($consulta);
		return $query;
	}
	function getInsert($consulta,$conexion)
	{
		if(mysql_query($consulta,$conexion)or die(mysql_error())){
			return true;
		}
		else {
			return false;
		}
	}

	function getUpdate($consulta,$conexion)
	{
		if(mysql_query($consulta,$conexion)or die(mysql_error())){
			return true;
		}
		else {
			return false;
		}
	}

	function getDelete($consulta,$conexion)
	{
		if(mysql_query($consulta,$conexion)or die(mysql_error())){
			return true;
		}
		else {
			return false;
		}
	}


?>

</body>
</html>
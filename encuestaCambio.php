<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php 
include('conexion.php'); 
 $conexion=conectar();
//-----------------------------------------------------------------------------
//código para obtener el id de la ultima encuesta creada para guardar prosteriormente la encuesta respuesta por el paciente

$SQLquery2 = "SELECT idEncuesta FROM Encuesta ORDER BY  `idEncuesta` ASC "; 
$SQLresult2=mysql_query($SQLquery2,$conexion) or mysql_error();
$datos2 = array(); 
$cont=0;
//se recorre el array de resultados para obtener el id de la ultima encuesta creada
while($row2 = mysql_fetch_array($SQLresult2)) {

$datos2[] = $row2["idEncuesta"];

    }

    $ultimoIdEncuesta=$datos2[sizeof($datos2)-1];
//-------------------------------------------------------------------------------
//código para obtner la fecha del sistema
    date_default_timezone_set('America/bogota');
    $fechaH=date("Y-m-d H:i:s");
    $fechaA=date("Y-m-d");
//------------------------------------------------------------------------
//codigo para obtener el id del paciente que realiza la encuesta
$user =& JFactory::getUser();
// almaceno el id en la variable llamada $idPacienteLogueado
$idPacienteLogueado  = $user->id;
//------------------------------------------------------------------------

//código para cargar las preguntas de la encuesta
$SQLquery = "SELECT idPregunta,descripcion
FROM  `Pregunta` 
WHERE idEncuesta =$ultimoIdEncuesta ORDER BY  `idPregunta` ASC "; 
$SQLresult=mysql_query($SQLquery,$conexion) or mysql_error();

$idPreguntas=array();
$datos = array(); 
while($row = mysql_fetch_array($SQLresult)) {
$idPreguntas[]=$row["idPregunta"];
$datos[] = $row["descripcion"];

    }
//--------------------------------------------------------------------------------------
    //código para cargar las opciones de respuesta

$SQLqueryO = "SELECT  `descripcion` ,  `idPregunta` 
FROM  `Opciones_Respuesta` "; 
$SQLresultOpc=mysql_query($SQLqueryO,$conexion) or mysql_error();
$opcionesR = array(); 
while($rowO = mysql_fetch_array($SQLresultOpc)) {
$opcionesR[]=$rowO["descripcion"];
}

?>
<?
//------------------------------------------------------------------------------------------------------------------------

//se crea un nuevo registro para la tabla encuesta_paciente, la cual es la encuesta respuesta por el paciente
if(isset($_POST['EnviarEncuesta'])){

    if(!(isset($_POST['UnaUna'])) or !(isset($_POST['DosUno'])) or !(isset($_POST['SeisUno']))or !(isset($_POST['SieteUno']))or !(isset($_POST['OchoUno']))or !(isset($_POST['NueveUno']))or !(isset($_POST['DiezUno']))or $_POST['TresUno'] == ''or $_POST['CuatroUno'] == ''or $_POST['CincoUno'] == '')
 {
      $cadena = "Por favor Responda todas las preguntas."; //puedes recibirla por POST o lo que quieras 
      $color = "#FF0000"; //lo mismo que antes 
      echo "<p><font color='".$color."'>".$cadena."</font></p>";  
        //Si los campos están vacíos muestra el siguiente mensaje, caso contrario sigue el siguiente codigo. 

}
else{

//Si se el paciente respondió todas las preguntas se procede a crear la encuesta_paciente    

//Se verifica que el id del paciente y de la encuesta no se repitan
$datos3=array();
$SQLquery3 = "SELECT idEncuestaP FROM  `Encuesta_Paciente` WHERE FechaR ='$fechaA'"; 
$SQLresult3=mysql_query($SQLquery3,$conexion) or mysql_error();
while($row3 = mysql_fetch_array($SQLresult3)) {

$datos3[] = $row3["idEncuestaP"];

    }
if(sizeof($datos3)==0)
{
//Si el paciente no ha realizado la encuesta de hoy, se envia de lo contrario no le premite enviar la encuesta
$SQLquery4 = "INSERT INTO `u616761031_teleu`.`Encuesta_Paciente` (`id`, `fechaR`, `idEncuestaP`, `idEncuesta`) VALUES ($idPacienteLogueado,'$fechaA',NULL,$ultimoIdEncuesta);"; 
$SQLresult4=mysql_query($SQLquery4,$conexion) or mysql_error();

//_-----------------------------------------------------------------------------
//se obtiene el id de la encuesta_Paciente anteriromente creada para posteriormente crear un registro en la tabla Respuesta_Personal
$datos5=array();
$SQLquery5 = "SELECT idEncuestaP, id, idEncuesta FROM  `Encuesta_Paciente` WHERE id =$idPacienteLogueado AND idEncuesta =$ultimoIdEncuesta"; 
$SQLresult5=mysql_query($SQLquery5,$conexion) or mysql_error();
while($row5 = mysql_fetch_array($SQLresult5)) {

$datos5[] = $row5["idEncuestaP"];

    }

    $ultimoIdEncuestaPaciente=$datos5[sizeof($datos5)-1];
 
//---------------------------------------------------------------------------------------------------------------------------------------------
  // crea un nuevo registro con la respuestas personales del paciente  
$respuesta1=$_POST['UnaUna'];
$respuesta2=$_POST['DosUno'];
$respuesta3=$_POST['TresUno'];
$respuesta4=$_POST['CuatroUno'];
$respuesta5=$_POST['CincoUno'];
$respuesta6=$_POST['SeisUno'];
$respuesta7=$_POST['SieteUno'];
$respuesta8=$_POST['OchoUno'];
$respuesta9=$_POST['NueveUno'];
$respuesta10=$_POST['DiezUno'];
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta1

$SQLqueryRespuesta1="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[0],$ultimoIdEncuestaPaciente,'$respuesta1');";
$SQLresult6=mysql_query($SQLqueryRespuesta1,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta2
$SQLqueryRespuesta2="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[1],$ultimoIdEncuestaPaciente,'$respuesta2');";
$SQLresult7=mysql_query($SQLqueryRespuesta2,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta3
$SQLqueryRespuesta3="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[2],$ultimoIdEncuestaPaciente,'$respuesta3');";
$SQLresult8=mysql_query($SQLqueryRespuesta3,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta4
$SQLqueryRespuesta4="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[3],$ultimoIdEncuestaPaciente,'$respuesta4');";
$SQLresult9=mysql_query($SQLqueryRespuesta4,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta5
$SQLqueryRespuesta5="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[4],$ultimoIdEncuestaPaciente,'$respuesta5');";
$SQLresult10=mysql_query($SQLqueryRespuesta5,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta6
$SQLqueryRespuesta6="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[5],$ultimoIdEncuestaPaciente,'$respuesta6');";
$SQLresult11=mysql_query($SQLqueryRespuesta6,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta7
$SQLqueryRespuesta7="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[6],$ultimoIdEncuestaPaciente,'$respuesta7');";
$SQLresult12=mysql_query($SQLqueryRespuesta7,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta8
$SQLqueryRespuesta8="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[7],$ultimoIdEncuestaPaciente,'$respuesta8');";
$SQLresult13=mysql_query($SQLqueryRespuesta8,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta9
$SQLqueryRespuesta9="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[8],$ultimoIdEncuestaPaciente,'$respuesta9');";
$SQLresult14=mysql_query($SQLqueryRespuesta9,$conexion) or mysql_error();
//----------------------------------------------------------------------------------------------------------------------------------------------------
//Se crea un nuevo registro para la respuesta personal a la pregunta10
$SQLqueryRespuesta10="INSERT INTO `u616761031_teleu`.`Respuesta_Personal` (`idRespuestaP`, `idPregunta`, `idEncuestaP`, `descripcionR`) VALUES (NULL,$idPreguntas[9],$ultimoIdEncuestaPaciente,'$respuesta10');";
$SQLresult15=mysql_query($SQLqueryRespuesta10,$conexion) or mysql_error();


echo '<script>alert("Se ha enviado la encuesta correctamente")</script>';

}else{

echo '<script>alert("Usted ya realizó la encuesta de hoy")</script>';

}

}}
?>


<form action="" method="post" class="encuesta" name="encuestaDiaria"> 

<p style="text-align: center; font-family: georgia, palatino;">
	<span style="font-size:22px;"><span style="font-family:georgia,serif;"><strong>ENCUESTA DIARIA</strong></span></span></p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">1. <?echo $datos[0]?>
</span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="UnaUna" type="radio" value="Si" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[0]?></span></span></span></p>

<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="UnaUna" type="radio" value="No" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[1]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">2. <?echo $datos[1]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="DosUno" type="radio" value="Si" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[2]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="DosUno" type="radio" value="No" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[3]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">3. <?echo $datos[2]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify; margin-left: 40px;">
	<textarea cols="100" name="TresUno" rows="5"></textarea></p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">4. <?echo $datos[3]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><textarea cols="100" name="CuatroUno" rows="5"></textarea></span></span></p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">5. <?echo $datos[4]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><textarea cols="100" name="CincoUno" rows="5"></textarea></span></span></p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">6. <?echo $datos[5]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-family: georgia, serif; font-size: 14px;"><input name="SeisUno" type="radio" value="1" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[4]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SeisUno" type="radio" value="3" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[5]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SeisUno" type="radio" value="5" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[6]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">7. <?echo $datos[6]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SieteUno" type="radio" value="Nunca" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[7]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SieteUno" type="radio" value="Algunas" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[8]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SieteUno" type="radio" value="Bastantes veces" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[9]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SieteUno" type="radio" value="Casi siempre" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[10]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="SieteUno" type="radio" value="Siempre" /><span style="font-size:16px;">&nbsp;<?echo $opcionesR[11]?></span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">8. <?echo $datos[7]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="OchoUno" type="radio" value="Nunca" /><span style="font-size:16px;">&nbsp;Nunca</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="OchoUno" type="radio" value="Algunas" /><span style="font-size:16px;">&nbsp;Algunas veces</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="OchoUno" type="radio" value="Bastantes veces" /><span style="font-size:16px;">&nbsp;Bastantes veces</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="OchoUno" type="radio" value="Casi siempre" /><span style="font-size:16px;">&nbsp;Casi siempre</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="OchoUno" type="radio" value="Siempre" /><span style="font-size:16px;">&nbsp;Siempre</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">9. <?echo $datos[8]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="NueveUno" type="radio" value="Si" /><span style="font-size:16px;">&nbsp;Si</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="NueveUno" type="radio" value="No" /><span style="font-size:16px;">&nbsp;No</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="text-align: justify;">
	<span style="font-size:16px;"><span style="font-family:georgia,serif;">10. <?echo $datos[9]?></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="DiezUno" type="radio" value="Si" /><span style="font-size:16px;">&nbsp;Si</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	<span style="font-size:14px;"><span style="font-family:georgia,serif;"><input name="DiezUno" type="radio" value="No" /><span style="font-size:16px;">&nbsp;No</span></span></span></p>
<p style="text-align: justify; margin-left: 40px;">
	&nbsp;</p>
<p style="margin-left: 40px; text-align: center;">
	<span style="font-family:georgia,serif;"><input name="EnviarEncuesta" type="submit" value="Enviar Encuesta" /></span></p>


</form>
</body>
</html>
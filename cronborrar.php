<?php
require_once 'mysql-wrapper.php';
//require_once 'config.inc.php';
//Gestion de Base de datos
$db_host = "";
$db_user = "";
$db_pass = "";
$db_name = "";

$cn = mysql_connect($db_host, $db_user, $db_pass) or die("Cannot connect to DB" . mysql_error());
    mysql_select_db($db_name) or die("Error accessing DB");
//Gestion de fechas
$cal = 60; //Cantidad de dias a trabajar
$date = date("Y-m-d");
echo "Fecha actual = ".$date. "<br>";

$fecha = date('Y-m-j');
$fechamuestrad = date('Y-m-j', strtotime('-1 year', strtotime($fecha)));
$fechamuestrah = date('Y-m-j', strtotime('-60 day', strtotime ($fechamuestrad)));
echo "Calculo de nueva fecha desde = ".$fechamuestrad. " hasta = ".$fechamuestrah."<br>";
echo "------------------------------------------------------------------------------------------------------------------<br>";
$ruta = "/home/coavisolisto/public_html/_thumbs/";
$nuevafecha  = date("Y-m-j",strtotime('-1 year', strtotime($fecha)));;
$cantidad = 0;
echo "<br>";
if (true)
	{
	for ($i=0; $i <$cal; $i++) { 
	$sql = "SELECT COUNT(*) FROM xzclf_adpics WHERE `timestamp` LIKE '$nuevafecha%'";
	$res = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_row($res)){
       	echo "Imagenes totales para la fecha =  ".$nuevafecha." Son un total de = ". $row[0]. "<br>";
       	echo "Imagenes encontradas en la lista = ".$i. " Imagenes borradas = ".$row[0]. "<br>";
       	
       	if ($row[0] > 0) {
       		$cantidad = $cantidad + $row[0]; 
       	}
	}//while1
	//echo "<br>";
	$sql = "SELECT picfile FROM xzclf_adpics WHERE `timestamp` LIKE '$nuevafecha%'";
	$res = mysql_query($sql) or die(mysql_error());
	echo "Id de imagenes en fecha ".$nuevafecha." = ";
	while ($row = mysql_fetch_row($res)){
	if (file_exists($ruta,$row[0])) {
	  		echo "<mark style='background-color: green;'>".$row[0]."</mark> - ";
	  	}
	  	else{
	  		echo "<mark style='background-color: red;'>".$row[0]."</mark> - ";
	  		//echo $ruta,$row[0];
	  	}
	//echo $row[0]." - ";
	}//while2
	$nuevafecha = date("Y-m-d",strtotime('+1 day', strtotime($nuevafecha)));
	echo "<br> Imagenes en rojo todas reemplazadas por imagen default <br>";
	echo "--------------------------------------------------------------------------------------<br>";
	}//forfecha
	echo "<br>";
	if ($cantidad > 0) {
		echo "Cantidad de imagenes a borrar = ".$cantidad. "<br> Guardando en db";
	}//if
	else{
		echo "No hay imagenes que borrar para las fechas <br> Sin actualizacion en db";
	}//else
}//if
?>
<?php
@session_start();
require_once('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);



if (isset($id)){
	
	$eliminar = "DELETE FROM laboratorios WHERE id = ".$id;
	if($mysqli->query($eliminar))
	{
		$error_ins = false;
	}
	else
	{
		$error_ins = true;
	    $mysqli->rollBack();
	}
	
	$mysqli->commit();
  
  
	  if ($error_ins == true)
	  {
	    echo 'El laboratorio no pudo ser eliminado';
	  }
	  else {
	    echo 'Laboratorio eliminado con exito';
	  }
}
else {
	echo 'No sirve';
}
?>
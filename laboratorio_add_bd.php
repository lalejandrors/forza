<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($nom))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();
  $fotoArchivo = $nombreArchivo ='';

  

  if(!empty($_FILES['foto']['name'])){

    $extensiones_aceptadas = array("jpg","gif","png");
    //ADJUNTAMOS LA IMAGEN
    $carpetaAdjunta="assets/logos/";

    // El nombre y nombre temporal del archivo que vamos para adjuntar
    $fotoArchivo=$_FILES['foto']['name'];
    $fotoTemporal=$_FILES['foto']['tmp_name'];

    $extension = strtolower(substr(strrchr($fotoArchivo, '.'), 1));
    
    $info = @getimagesize($_FILES['foto']['tmp_name']); 
    $var_rand=rand(10000,999999)* rand(10000,999999); 
    $nombre_tem=md5($var_rand.$_FILES['foto']['name']); 
    $fotoArchivo=$nombre_tem.'.'.$extension; 

    $rutaArchivo=$carpetaAdjunta.$fotoArchivo;

    if (in_array($extension, $extensiones_aceptadas)) {
      //Subimos defintivamente la foto
      move_uploaded_file($fotoTemporal,$rutaArchivo);
    }
    else
    {
       $fotoArchivo = ''; 
    }
  }



  $insertar = "INSERT INTO `laboratorios` (`nomlaboratorio`,`imagen`) VALUES (UPPER('$nom'), '$fotoArchivo')";


  if($mysqli->query($insertar))
  { 

    $error_ins = false;   
  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }

  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $insertar;
  }
  else {
    echo "Laboratorio creado con exito";
  }

}

mysqli_close($mysqli);
?>
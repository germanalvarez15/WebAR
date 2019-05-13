<?php

//Creación de la base de datos en PhpMyAdmin
// CREATE DATABASE usuariosAr;
// CREATE TABLE datos(usuarioId int NOT NULL AUTO_INCREMENT, nombre VARCHAR(50), apellido VARCHAR(50), descripcion VARCHAR(50), imagen VARCHAR(50), PRIMARY KEY (usuarioId));


//Variables conexión a BBDD
// $host = "localhost";
// $user = "id9088686_root";
// $pass = "german";
// $db = "id9088686_usuariosar";

$host = "localhost";
$user = "id9088686_root";
$pass = "german";
$db = "id9088686_usuariosar";

//Conexión a Mysql 
$con = mysqli_connect($host, $user, $pass, $db) or die("No se puedo conectar con motor de base datos");


//Datos del formulario
$nombre =  $_POST['nombre'];
$apellido = $_POST['apellido'];
$descripcion = $_POST['descripcion'];
$imagen = $_FILES['pic']['name'];

//Directorio donde se subirán las imágenes
$directorio = 'upload/';
$archivo = $directorio . basename($_FILES['pic']['name']);
$tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));


$validacionImg = getimagesize($_FILES['pic']['tmp_name']);


if ($validacionImg) {
    $size = $_FILES['pic']['name'];

    if ($size > 500000) {
        echo 'La imagen debe ser menor a 500 KB';
    } else {
        if ($tipoArchivo == 'jpg' || $tipoArchivo == 'jpeg') {
            if (move_uploaded_file($_FILES['pic']['tmp_name'], $archivo)) {
                
                //Query Insert de datos
                $sql = "INSERT INTO datos (nombre, apellido, descripcion, imagen) VALUES ('$nombre', '$apellido', '$descripcion', '$imagen')";

                //Se ejecuta Insert
                $ejecutar = mysqli_query($con, $sql);

                //Verificación de inserción de datos
                if (!$ejecutar) {
                    echo 'Ups! No se pudieron guardar los datos';
                } else {
                    echo "Datos guardados correctamente! <br> <a href='index.php'>Volver</a>";
                }

            } else {
                echo 'No se pudo subir la imagen';
            }
        } else {
            echo 'Solo se admiten archivos jpg/jpeg';
        }
    }
} else {
    echo 'El archivo no es una imagen';
}

?>
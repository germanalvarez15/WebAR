<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Escaneo</title>
</head>

<body>

    <!-- MUESTRO DATOS DE USUARIOS REGISTRADOS -->
    <div id="tablaUsuarios">
        <?php

        //get parameters
        $usuarioId = $_GET['id'];

        //Variables conexión a BBDD
        $host = "localhost";
        $user = "id9088686_root";
        $pass = "german";
        $db = "id9088686_usuariosar";

        //Conexión a Mysql 
        $con = mysqli_connect($host, $user, $pass, $db) or die("No se puedo conectar con motor de base datos");


        //Query Select datos
        $sql = "SELECT nombre, apellido, descripcion, imagen FROM datos WHERE usuarioId = '$usuarioId'";

        //Se ejecuta Select
        $ejecutar = mysqli_query($con, $sql);

        $arrayUsuarios = mysqli_fetch_array($ejecutar);
        ?>

        <h2 id="tituloUsuario">Datos de <?php echo $arrayUsuarios['nombre'] . " " . $arrayUsuarios['apellido'] ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <?php
            
                echo "<tr>";
                echo "<td>";
                echo $arrayUsuarios['nombre'];
                echo "</td>";

                echo "<td>";
                echo $arrayUsuarios['apellido'];
                echo "</td>";
                
                echo "<td>";
                echo $arrayUsuarios['descripcion'];
                echo "</td>";
                echo "</tr>";
                echo "<br>";
                
                echo "<div id=imagenUsuario>";
                echo  "<img src='upload/" . $arrayUsuarios['imagen'] . "' />"; 
                echo "</div>";
           ?>
            
           
        </table>
    </div>

</body>

</html>
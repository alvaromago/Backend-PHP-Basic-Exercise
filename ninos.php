<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/ninos.css">
    <title>Datos de los niños</title>
</head>

<body class="text-center py-3 px-0">
    <h1>Datos de los niños</h1>
    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once 'conexion.php';

    // Clase Niños que maneja la funcionalidad relacionada con los niños
    class Ninos
    {
        // Método para obtener todos los niños desde la base de datos
        public function obtenerNinos()
        {
            $conexion = Conexion::conectar();

            $sql = "select * from ninos order by nombreNino";
            $resultados = $conexion->query($sql);

            // Verificar si hay resultados
            if ($resultados->num_rows > 0) {
    ?>
                <div class="container">
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Bueno</th>
                            <th>Editar / Borrar</th>
                        </tr>
                        <?php
                        // Mostrar datos de cada niño
                        while ($fila = $resultados->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $fila['idNino'] ?></td>
                                <td><?php echo $fila['nombreNino'] ?></td>
                                <td><?php echo $fila['apellidosNino'] ?></td>
                                <td><?php echo $fila['fechaNacimientoNino'] ?></td>
                                <td><?php if ($fila['buenoNino'] == 1) {
                                        echo "Sí";
                                    } else {
                                        echo "No";
                                    } ?></td>
                                <td>
                                    <a href="editarNino.php?id=<?php echo $fila['idNino'] ?>" class="btn btn-warning">Editar</a>
                                    <a href="borrarNino.php?id=<?php echo $fila['idNino'] ?>" class="btn btn-danger">Borrar</a>
                                </td>
                            </tr>
                        <?php }

                        ?>
                    </table>
                    <a href="addNino.php" class="btn btn-success mt-3">Añadir</a>
                </div>
    <?php
            } else {
                echo '<p>No hay niños registrados.</p>';
            }
        }
    }

    // Mostrar la tabla de niños en el navegador
    $ninos = new Ninos();
    $ninos->obtenerNinos();
    ?>
</body>

</html>
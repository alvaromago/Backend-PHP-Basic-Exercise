<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/regalos.css">
    <title>Datos de los regalos</title>
</head>

<body class="text-center py-3 px-0">
    <h1>Datos de los regalos</h1>
    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once 'conexion.php';

    // Clase Juguetes que maneja la funcionalidad relacionada con los juguetes
    class Juguetes
    {
        // Método para obtener todos los juguetes desde la base de datos
        public function obtenerJuguetes()
        {
            $conexion = Conexion::conectar();

            $sql = "select * from juguetes order by idJuguete";
            $resultados = $conexion->query($sql);

            // Verificar si hay resultados
            if ($resultados->num_rows > 0) {
    ?>
                <div class="container">
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Editar / Borrar</th>
                        </tr>
                        <?php
                        // Mostrar datos de cada juguete
                        while ($fila = $resultados->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $fila['idJuguete'] ?></td>
                                <td><?php echo $fila['nombreJuguete'] ?></td>
                                <td><?php echo $fila['precioJuguete'] . "€" ?></td>
                                <td>
                                    <a href="editarJuguete.php?id=<?php echo $fila['idJuguete'] ?>" class="btn btn-warning">Editar</a>
                                    <a href="borrarJuguete.php?id=<?php echo $fila['idJuguete'] ?>" class="btn btn-danger">Borrar</a>
                                </td>
                            </tr>
                        <?php }

                        ?>
                    </table>
                    <a href="addJuguete.php" class="btn btn-success mt-3">Añadir</a>
                </div>
    <?php
            } else {
                echo '<p>No hay juguetes registrados.</p>';
            }
        }
    }

    // Mostrar la tabla de juguetes en el navegador
    $juguetes = new Juguetes();
    $juguetes->obtenerJuguetes();
    ?>
</body>

</html>
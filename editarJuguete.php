<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Editar Juguete</title>
</head>

<body class="text-center px-0">
    <h1 class="py-3">Editar Juguete</h1>
    <?php
    require_once "conexion.php";

    // Verificar si se recibió el ID del juguete a editar
    if (isset($_GET["id"])) {
        $idJuguete = $_GET["id"];

        // Lógica para cargar los datos del juguete con el ID proporcionado
        $conexion = Conexion::conectar();
        $sql = "select * from juguetes where idJuguete = $idJuguete";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows == 1) {
            $juguete = $resultado->fetch_assoc();
    ?>
            <!-- Formulario HTML para editar los datos del niño -->
            <form action="editarJuguete.php?id=<?php echo $idJuguete; ?>" method="post">
                <input type="hidden" name="idJuguete" value="<?php echo $idJuguete; ?>">

                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" value="<?php echo $juguete['nombreJuguete'] ?>" class="my-2" required><br>

                <label for="precio">Precio: </label>
                <input type="text" name="precio" value="<?php echo $juguete['precioJuguete'] ?>" class="my-2" required>€<br>

                <input type="submit" value="Actualizar Juguete" class="btn btn-success">
                <a href="regalos.php" class="my-3 btn btn-danger">Cancelar</a>
            </form>
    <?php
            // Verificar si se enviaron los datos del formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validar y escapar los datos proporcionados
                $idJuguete = $conexion->real_escape_string($_POST['idJuguete']);
                $nombre = $conexion->real_escape_string($_POST['nombre']);
                $precio = $conexion->real_escape_string($_POST['precio']);

                // Query para actualizar los datos del niño
                $sql_update = "update juguetes set 
                            nombreJuguete = '$nombre',
                            precioJuguete = '$precio'
                            where idJuguete = $idJuguete";

                if ($conexion->query($sql_update) === TRUE) {
                    echo "<p>Juguete actualizado exitosamente.</p>";
                } else {
                    echo "<p>Error al actualizar el juguete: " . $conexion->error . "</p>";
                }
            }
        } else {
            echo "<p>Juguete no encontrado.</p>";
        }
    } else {
        echo "<p>ID del juguete no proporcionado.</p>";
    }
    ?>

</body>

</html>
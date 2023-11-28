<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Añadir Juguete</title>
</head>

<body class="text-center px-0">
    <h1 class="py-3">Añadir un nuevo Juguete</h1>
    <?php
    require_once "conexion.php";

    class AddJuguete
    {
        // Método para agregar un nuevo juguete a la base de datos
        public static function agregarJuguete($nombre, $precio)
        {
            $conexion = Conexion::conectar();

            // Escapar y validar los datos proporcionados
            $nombre = $conexion->real_escape_string($nombre);
            $precio = $conexion->real_escape_string($precio);

            // Query para insertar un nuevo juguete
            $sql = "insert into juguetes (nombreJuguete, precioJuguete) values ('$nombre', '$precio')";

            if ($conexion->query($sql) === TRUE) {
                echo "<p>Juguete añadido exitosamente.</p>";
            } else {
                echo "<p>Error al añadir el juguete: " . $conexion->error . "</p>";
            }
        }
    }
    ?>
    <form action="addJuguete.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Playstation 5" class="my-2" required><br>

        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" placeholder="459.99" class="my-2" required>€<br>

        <input type="submit" value="Añadir Juguete" class="my-3 btn btn-success">
        <input type="reset" value="Limpiar" class="my-3 btn btn-warning">
        <a href="regalos.php" class="my-3 btn btn-danger">Cancelar</a>

    </form>
    <?php
    // Verificar si se recibieron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se enviaron todos los datos necesarios
        if (isset($_POST['nombre']) && isset($_POST['precio'])) {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];

            // Llamar al método para agregar un nuevo juguete
            AddJuguete::agregarJuguete($nombre, $precio);
        } else {
            echo "<p>Todos los campos son obligatorios.</p>";
        }
    }
    ?>
</body>

</html>
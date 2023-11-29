<?php
require_once 'conexion.php';

class Busqueda
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getNinos()
    {
        $sql = "SELECT idNino, nombreNino FROM ninos";
        $resultados = $this->conexion->query($sql);

        $ninos = array();

        while ($fila = $resultados->fetch_assoc()) {
            $ninos[] = $fila;
        }

        return $ninos;
    }

    public function getRegalosPorNino($idNino)
    {
        $sql = "SELECT j.nombreJuguete AS Regalo
                FROM regalos r
                JOIN juguetes j ON r.idJugueteFK = j.idJuguete
                WHERE r.idNinoFK = $idNino";

        $resultados = $this->conexion->query($sql);

        $regalos = array();

        while ($fila = $resultados->fetch_assoc()) {
            $regalos[] = $fila;
        }

        return $regalos;
    }

    public function getJuguetesDisponibles()
    {
        $sql = "SELECT idJuguete, nombreJuguete FROM juguetes";
        $resultados = $this->conexion->query($sql);

        $juguetes = array();

        while ($fila = $resultados->fetch_assoc()) {
            $juguetes[] = $fila;
        }

        return $juguetes;
    }

    public function agregarRegalo($idNino, $idJuguete)
    {
        // Verificar si el regalo ya ha sido agregado para este niño
        $sqlVerificar = "SELECT COUNT(*) AS count FROM regalos WHERE idNinoFK = $idNino AND idJugueteFK = $idJuguete";
        $resultadoVerificar = $this->conexion->query($sqlVerificar);
        $filaVerificar = $resultadoVerificar->fetch_assoc();
        $count = $filaVerificar['count'];

        if ($count == 0) {
            // Si el regalo no ha sido agregado, se procede a insertar
            $sqlInsertar = "INSERT INTO regalos (idNinoFK, idJugueteFK) VALUES ($idNino, $idJuguete)";
            $resultadoInsertar = $this->conexion->query($sqlInsertar);

            return $resultadoInsertar;
        } else {
            // Si el regalo ya ha sido agregado, se devuelve falso
            return false;
        }
    }
}

// Crear una instancia de la clase Busqueda
$conexion = Conexion::conectar();
$busqueda = new Busqueda($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/busqueda.css">
    <title>Busqueda de Regalos</title>
</head>

<body class="text-center px-0">
    <h1 class="py-3">Busqueda de Regalos</h1>

    <div class="container">
        <h2>Seleccionar Niño</h2>
        <form action="" method="post">
            <label for="nino">Niño: </label>
            <select name="nino" id="nino" required>
                <option value="">Seleccionar niño</option>
                <?php
                $ninos = $busqueda->getNinos();
                foreach ($ninos as $nino) {
                    echo "<option value='{$nino['idNino']}'>{$nino['nombreNino']}</option>";
                }
                ?>
            </select>
            <button type="submit">Buscar Regalos</button>
        </form>
    </div>

    <div class="container mt-4">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nino'])) {
            // Si se ha enviado el formulario y se ha seleccionado un niño, mostrar los regalos del niño seleccionado
            $idNinoSeleccionado = $_POST['nino'];
            $regalosNino = $busqueda->getRegalosPorNino($idNinoSeleccionado);

            if (!empty($regalosNino)) {
                echo "<ul>";
                foreach ($regalosNino as $regalo) {
                    echo "<li>{$regalo['Regalo']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay regalos para este niño.</p>";
            }

            // Mostrar formulario para agregar más regalos al niño
            $juguetesDisponibles = $busqueda->getJuguetesDisponibles();
            echo "<h2>Agregar Regalo</h2>";
            echo "<form action='busqueda.php' method='post'>";
            echo "<label for='juguetes'>Juguete:</label>";
            echo "<select name='juguetes' id='juguetes' required>";
            foreach ($juguetesDisponibles as $juguete) {
                echo "<option value='{$juguete['idJuguete']}'>{$juguete['nombreJuguete']}</option>";
            }
            echo "</select>";
            echo "<input type='hidden' name='nino' value='$idNinoSeleccionado'>"; // Cambio en el nombre del campo
            echo "<button type='submit'>Agregar Regalo</button>";
            echo "</form>";

            // Procesar el formulario de agregar regalo
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['juguetes'])) {
                $idJuguete = $_POST['juguetes'];
                $idNino = $_POST['nino']; // Cambio en el nombre del campo

                $resultado = $busqueda->agregarRegalo($idNino, $idJuguete);

                if ($resultado) {
                    echo "<p>Regalo agregado con éxito.</p>";
                } else {
                    echo "<p>Este regalo ya ha sido agregado para este niño.</p>";
                }
            }
        }
        ?>
    </div>

</body>

</html>
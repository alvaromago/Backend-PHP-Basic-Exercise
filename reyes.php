<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Reyes Magos</title>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <link rel="stylesheet" href="styles/reyes.css">
            <title>Datos de los Reyes Magos</title>
        </head>

    <body class="text-center px-0">
        <h1 class="py-3">Datos de los Reyes Magos</h1>

        <?php
        require_once 'conexion.php';

        class Reyes
        {
            private $conexion;

            public function __construct($conexion)
            {
                $this->conexion = $conexion;
            }

            public function getRegalosPorRey($idRey)
            {
                $sql = "SELECT n.nombreNino AS Niño, j.nombreJuguete AS Regalo, j.precioJuguete AS precio
            FROM juguetes j
            JOIN regalos r ON j.idJuguete = r.idJugueteFK
            JOIN ninos n ON r.idNinoFK = n.idNino
            WHERE j.idReyFK = $idRey AND n.buenoNino = 1";

                if ($idRey == 3) {
                    $sql .= " UNION ALL
              SELECT n.nombreNino AS Niño, 'Carbón' AS Regalo, 0 AS precio
              FROM ninos n
              LEFT JOIN regalos r ON n.idNino = r.idNinoFK
              WHERE r.idNinoFK IS NULL OR n.buenoNino = 0";
                }

                $resultados = $this->conexion->query($sql);

                $regalos = array();

                while ($fila = $resultados->fetch_assoc()) {
                    $regalos[] = $fila;
                }

                return $regalos;
            }

            public function getTotalGastadoPorRey($idRey)
            {
                $sql = "SELECT SUM(IF(n.buenoNino = 1, j.precioJuguete, 0)) AS totalGastado
            FROM regalos r
            JOIN juguetes j ON r.idJugueteFK = j.idJuguete
            JOIN ninos n ON r.idNinoFK = n.idNino
            WHERE j.idReyFK = $idRey";

                $resultado = $this->conexion->query($sql);

                if ($resultado->num_rows == 1) {
                    $fila = $resultado->fetch_assoc();
                    return $fila['totalGastado'];
                }

                return 0;
            }
        }

        // Suponiendo que $conexion es tu objeto de conexión a la base de datos
        $conexion = Conexion::conectar();
        $reyes = new Reyes($conexion);

        // Obtener regalos por un Rey Mago específico
        $regalosMelchor = $reyes->getRegalosPorRey(1);
        $totalGastadoMelchor = $reyes->getTotalGastadoPorRey(1);

        $regalosGaspar = $reyes->getRegalosPorRey(2);
        $totalGastadoGaspar = $reyes->getTotalGastadoPorRey(2);

        $regalosBaltasar = $reyes->getRegalosPorRey(3);
        $totalGastadoBaltasar = $reyes->getTotalGastadoPorRey(3);
        ?>

        <div class="container">
            <!-- Tabla para Melchor -->
            <h2>Melchor</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Regalo</th>
                        <th>Niño</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regalosMelchor as $regalo) : ?>
                        <tr>
                            <td><?php echo $regalo['Regalo']; ?></td>
                            <td><?php echo $regalo['Niño']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="bg-dark text-white">Total gastado por Melchor: <?php echo $totalGastadoMelchor; ?>€</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="container">
            <!-- Tabla para Gaspar -->
            <h2>Gaspar</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Regalo</th>
                        <th>Niño</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regalosGaspar as $regalo) : ?>
                        <tr>
                            <td><?php echo $regalo['Regalo']; ?></td>
                            <td><?php echo $regalo['Niño']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="bg-dark text-white">Total gastado por Gaspar: <?php echo $totalGastadoGaspar; ?>€</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="container">
            <!-- Tabla para Baltasar -->
            <h2>Baltasar</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Regalo</th>
                        <th>Niño</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regalosBaltasar as $regalo) : ?>
                        <tr>
                            <td><?php echo $regalo['Regalo']; ?></td>
                            <td><?php echo $regalo['Niño']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="bg-dark text-white">Total gastado por Baltasar: <?php echo $totalGastadoBaltasar; ?>€</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <footer class="py-5">
            <a href="ninos.php" class="btn btn-primary">Niños</a>
            <a href="regalos.php" class="btn btn-primary">Juguetes</a>
            <a href="busqueda.php" class="btn btn-primary">Búsqueda</a>
        </footer>
    </body>

    </html>
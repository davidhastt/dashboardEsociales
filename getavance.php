<?php
header("Content-Type: application/json");

// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'nombre_de_tu_base_de_datos';
$username = 'tu_usuario';
$password = 'tu_contraseña';

try {
    // Conexión a la base de datos con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL proporcionada
    $sql = "SELECT usuarios.id_usuario, usuarios.nombre, COUNT(*) AS NoCapturas 
            FROM archivos 
            INNER JOIN usuarios ON archivos.actualizo=usuarios.id_usuario 
            GROUP BY actualizo 
            ORDER BY NoCapturas";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Obtener resultados en un array asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir resultados a JSON
    echo json_encode($resultados, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    // Manejo de errores
    echo json_encode(["error" => $e->getMessage()]);
}
?>

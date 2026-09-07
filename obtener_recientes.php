<?php
header('Content-Type: application/json');
include 'incluir/conexion.php';

$limit = 6;

// Obtener dinosaurios recientes
$sqlDinos = "SELECT id, nombre, 'dinosaurio' as tipo, imagen, fecha_registro as fecha FROM dinosaurio ORDER BY fecha_registro DESC LIMIT $limit";
$dinos = $pdo->query($sqlDinos)->fetchAll(PDO::FETCH_ASSOC);

// Obtener noticias recientes
$sqlNoticias = "SELECT id, titulo as nombre, 'noticia' as tipo, imagen, created_at as fecha FROM noticia ORDER BY created_at DESC LIMIT $limit";
$noticias = $pdo->query($sqlNoticias)->fetchAll(PDO::FETCH_ASSOC);

// Unir y ordenar por fecha
$recientes = array_merge($dinos, $noticias);
usort($recientes, function($a, $b) {
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});

$recientes = array_slice($recientes, 0, $limit);

echo json_encode([
    'success' => true,
    'recientes' => $recientes
]);
?>
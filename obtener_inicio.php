<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include 'incluir/conexion.php';

$limit = 10;

try {
    $sqlDinos = "SELECT id, nombre, nombre_en, 'dinosaurio' as tipo, imagen, fecha_registro as fecha, periodo, periodo_en, dieta, dieta_en, descripcion, descripcion_en FROM dinosaurio ORDER BY fecha_registro DESC LIMIT $limit";
    $dinos = $pdo->query($sqlDinos)->fetchAll();
    
    $sqlNoticias = "SELECT id, titulo, titulo_en, 'noticia' as tipo, imagen, created_at as fecha, contenido, contenido_en FROM noticia ORDER BY created_at DESC LIMIT $limit";
    $noticias = $pdo->query($sqlNoticias)->fetchAll();
    
    $inicioItems = array_merge($dinos, $noticias);
    usort($inicioItems, function($a, $b) {
        return strtotime($b['fecha']) - strtotime($a['fecha']);
    });
    
    $inicioItems = array_slice($inicioItems, 0, $limit);
    
    echo json_encode(['success' => true, 'items' => $inicioItems]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
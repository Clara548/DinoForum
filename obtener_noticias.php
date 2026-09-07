<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include 'incluir/conexion.php';

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 5;
$offset = ($pagina - 1) * $por_pagina;

try {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM noticia WHERE id = ?");
        $stmt->execute([$id]);
        $noticia = $stmt->fetchAll();
        echo json_encode(['success' => true, 'noticias' => $noticia]);
        exit();
    }
    
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM noticia");
    $total = $totalStmt->fetchColumn();
    $total_paginas = ceil($total / $por_pagina);
    
    $stmt = $pdo->prepare("SELECT * FROM noticia ORDER BY fecha DESC LIMIT $offset, $por_pagina");
    $stmt->execute();
    $noticias = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'noticias' => $noticias,
        'total' => $total,
        'pagina' => $pagina,
        'total_paginas' => $total_paginas
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
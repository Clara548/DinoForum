<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT imagen FROM dinosaurio WHERE id = ?");
$stmt->execute([$id]);
$dino = $stmt->fetch();

if($dino) {
    // Eliminar imagen si existe
    if($dino['imagen'] && file_exists("../img/" . $dino['imagen'])) {
        unlink("../img/" . $dino['imagen']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM dinosaurio WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php");
exit();
?>
<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM dinosaurio WHERE id = ?");
$stmt->execute([$id]);
$dino = $stmt->fetch();

if(!$dino) {
    header("Location: dashboard.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cientifico = $_POST['cientifico'];
    $periodo = $_POST['periodo'];
    $dieta = $_POST['dieta'];
    $tamano = $_POST['tamano'];
    $peso = $_POST['peso'];
    $descripcion = $_POST['descripcion'];
    
    $imagen = $dino['imagen'];
    if($_FILES['imagen']['name']) {
        // Eliminar imagen anterior
        if($imagen && file_exists("../img/" . $imagen)) {
            unlink("../img/" . $imagen);
        }
        $imagen = time() . '_' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/" . $imagen);
    }
    
    $sql = "UPDATE dinosaurio SET nombre=?, nombre_cientifico=?, periodo=?, dieta=?, tamano=?, peso=?, descripcion=?, imagen=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $cientifico, $periodo, $dieta, $tamano, $peso, $descripcion, $imagen, $id]);
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Dinosaurio</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="formulario">
        <h1>✏️ Editar dinosaurio</h1>
        <form method="post" enctype="multipart/form-data">
            <label>Nombre *</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($dino['nombre']) ?>" required>
            
            <label>Nombre científico</label>
            <input type="text" name="cientifico" value="<?= htmlspecialchars($dino['nombre_cientifico']) ?>">
            
            <label>Período</label>
            <select name="periodo">
                <option value="">Seleccionar</option>
                <option value="Triásico" <?= $dino['periodo'] == 'Triásico' ? 'selected' : '' ?>>Triásico</option>
                <option value="Jurásico" <?= $dino['periodo'] == 'Jurásico' ? 'selected' : '' ?>>Jurásico</option>
                <option value="Cretácico" <?= $dino['periodo'] == 'Cretácico' ? 'selected' : '' ?>>Cretácico</option>
            </select>
            
            <label>Dieta</label>
            <select name="dieta">
                <option value="">Seleccionar</option>
                <option value="Carnívoro" <?= $dino['dieta'] == 'Carnívoro' ? 'selected' : '' ?>>Carnívoro</option>
                <option value="Herbívoro" <?= $dino['dieta'] == 'Herbívoro' ? 'selected' : '' ?>>Herbívoro</option>
                <option value="Omnívoro" <?= $dino['dieta'] == 'Omnívoro' ? 'selected' : '' ?>>Omnívoro</option>
            </select>
            
            <label>Tamaño</label>
            <input type="text" name="tamano" value="<?= htmlspecialchars($dino['tamano']) ?>">
            
            <label>Peso</label>
            <input type="text" name="peso" value="<?= htmlspecialchars($dino['peso']) ?>">
            
            <label>Descripción</label>
            <textarea name="descripcion" rows="5"><?= htmlspecialchars($dino['descripcion']) ?></textarea>
            
            <label>Imagen actual</label>
            <?php if($dino['imagen']): ?>
                <img src="../img/<?= $dino['imagen'] ?>" width="100">
            <?php endif; ?>
            <label>Cambiar imagen</label>
            <input type="file" name="imagen" accept="image/*">
            
            <button type="submit">Guardar cambios</button>
            <a href="dashboard.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
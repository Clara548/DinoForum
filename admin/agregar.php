<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cientifico = $_POST['cientifico'];
    $periodo = $_POST['periodo'];
    $dieta = $_POST['dieta'];
    $tamano = $_POST['tamano'];
    $peso = $_POST['peso'];
    $descripcion = $_POST['descripcion'];
    
    // Subir imagen
    $imagen = '';
    if($_FILES['imagen']['name']) {
        $imagen = time() . '_' . basename($_FILES['imagen']['name']);
        $ruta = "../img/" . $imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }
    
    $sql = "INSERT INTO dinosaurio (nombre, nombre_cientifico, periodo, dieta, tamano, peso, descripcion, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $cientifico, $periodo, $dieta, $tamano, $peso, $descripcion, $imagen]);
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Dinosaurio</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="formulario">
        <h1>➕ Agregar nuevo dinosaurio</h1>
        <form method="post" enctype="multipart/form-data">
            <label>Nombre *</label>
            <input type="text" name="nombre" required>
            
            <label>Nombre científico</label>
            <input type="text" name="cientifico">
            
            <label>Período</label>
            <select name="periodo">
                <option value="">Seleccionar</option>
                <option value="Triásico">Triásico</option>
                <option value="Jurásico">Jurásico</option>
                <option value="Cretácico">Cretácico</option>
            </select>
            
            <label>Dieta</label>
            <select name="dieta">
                <option value="">Seleccionar</option>
                <option value="Carnívoro">Carnívoro</option>
                <option value="Herbívoro">Herbívoro</option>
                <option value="Omnívoro">Omnívoro</option>
            </select>
            
            <label>Tamaño</label>
            <input type="text" name="tamano" placeholder="Ej: 12 metros">
            
            <label>Peso</label>
            <input type="text" name="peso" placeholder="Ej: 7 toneladas">
            
            <label>Descripción</label>
            <textarea name="descripcion" rows="5"></textarea>
            
            <label>Imagen</label>
            <input type="file" name="imagen" accept="image/*">
            
            <button type="submit">Guardar dinosaurio</button>
            <a href="dashboard.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
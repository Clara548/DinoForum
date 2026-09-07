<?php include 'incluir/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Dinosaurio</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM dinosaurio WHERE id = ?");
    $stmt->execute([$id]);
    $dino = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($dino):
    ?>
    <div class="detalle">
        <h1><?php echo $dino['nombre']; ?></h1>
        <?php if($dino['imagen']): ?>
            <img src="img/<?php echo $dino['imagen']; ?>" alt="<?php echo $dino['nombre']; ?>" width="400">
        <?php endif; ?>
        
        <p><strong>Nombre científico:</strong> <?php echo $dino['nombre_cientifico']; ?></p>
        <p><strong>Período:</strong> <?php echo $dino['periodo']; ?></p>
        <p><strong>Dieta:</strong> <?php echo $dino['dieta']; ?></p>
        <p><strong>Tamaño:</strong> <?php echo $dino['tamano']; ?></p>
        <p><strong>Peso:</strong> <?php echo $dino['peso']; ?></p>
        <p><strong>Descripción:</strong> <?php echo nl2br($dino['descripcion']); ?></p>
        
        <a href="index.php">← Volver al inicio</a>
    </div>
    <?php else: ?>
        <p>Dinosaurio no encontrado</p>
        <a href="index.php">Volver</a>
    <?php endif; ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM noticia WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();

if (!$noticia) {
    header("Location: listar_noticias.php");
    exit();
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $titulo_en = $_POST['titulo_en'];
    $contenido = $_POST['contenido'];
    $contenido_en = $_POST['contenido_en'];
    $autor = $_POST['autor'];
    $fecha = $_POST['fecha'];
    
    $imagen = $noticia['imagen'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        if ($imagen && file_exists('../img/' . $imagen)) {
            unlink('../img/' . $imagen);
        }
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = time() . '_noticia_' . uniqid() . '.' . $ext;
        $ruta = '../img/' . $imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }
    
    $sql = "UPDATE noticia SET 
            titulo = ?, titulo_en = ?, 
            contenido = ?, contenido_en = ?, 
            autor = ?, fecha = ?, imagen = ? 
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$titulo, $titulo_en, $contenido, $contenido_en, $autor, $fecha, $imagen, $id])) {
        $mensaje = '<div class="success">✅ Noticia actualizada correctamente</div>';
        $stmt = $pdo->prepare("SELECT * FROM noticia WHERE id = ?");
        $stmt->execute([$id]);
        $noticia = $stmt->fetch();
    } else {
        $mensaje = '<div class="error">❌ Error al actualizar</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Noticia</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3a2a, #0a1a10);
            padding: 40px;
            font-family: 'Montserrat', sans-serif;
        }
        .form-container {
            max-width: 1100px;
            margin: 0 auto;
            background: rgba(30, 20, 15, 0.95);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #e6b422;
        }
        h1 { color: #e6b422; text-align: center; margin-bottom: 30px; font-family: 'Cinzel', serif; }
        label { display: block; margin: 15px 0 5px; color: white; font-weight: 600; }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #e6b422;
            background: rgba(0,0,0,0.5);
            color: white;
            font-family: 'Montserrat', sans-serif;
        }
        .lang-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .lang-col {
            flex: 1;
            min-width: 280px;
        }
        .lang-col h3 {
            color: #e6b422;
            font-size: 1rem;
            margin-bottom: 15px;
            border-bottom: 2px solid #e6b422;
            display: inline-block;
            padding-bottom: 5px;
        }
        button {
            background: #e6b422;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s;
        }
        button:hover {
            background: #c49a1a;
            transform: scale(1.02);
        }
        .success { background: #2d5a3b; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .error { background: #8b4513; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .back { display: inline-block; margin-top: 20px; color: #e6b422; text-decoration: none; }
        .imagen-actual {
            margin: 10px 0;
            padding: 10px;
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
            text-align: center;
        }
        .imagen-actual img {
            max-width: 150px;
            border-radius: 10px;
            margin-top: 5px;
        }
        .separator { margin: 20px 0; border-top: 1px solid rgba(230, 180, 34, 0.3); }
        textarea { min-height: 200px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>✏️ Editar Noticia</h1>
        <?php echo $mensaje; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="lang-row">
                <div class="lang-col">
                    <h3>🇪🇸 Español</h3>
                    <label>Título *</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>" required>
                    <label>Contenido *</label>
                    <textarea name="contenido" rows="10"><?= htmlspecialchars($noticia['contenido']) ?></textarea>
                </div>
                <div class="lang-col">
                    <h3>🇬🇧 English</h3>
                    <label>Title *</label>
                    <input type="text" name="titulo_en" value="<?= htmlspecialchars($noticia['titulo_en']) ?>" required>
                    <label>Content *</label>
                    <textarea name="contenido_en" rows="10"><?= htmlspecialchars($noticia['contenido_en']) ?></textarea>
                </div>
            </div>
            
            <div class="separator"></div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>👤 Autor</label>
                    <input type="text" name="autor" value="<?= htmlspecialchars($noticia['autor']) ?>">
                </div>
                <div class="lang-col">
                    <label>📅 Fecha *</label>
                    <input type="date" name="fecha" value="<?= $noticia['fecha'] ?>" required>
                </div>
            </div>
            
            <div class="separator"></div>
            
            <?php if ($noticia['imagen']): ?>
            <div class="imagen-actual">
                <label>Imagen actual:</label><br>
                <img src="../img/<?= $noticia['imagen'] ?>" alt="Imagen actual">
            </div>
            <?php endif; ?>
            
            <label>🖼️ Cambiar imagen (opcional)</label>
            <input type="file" name="imagen" accept="image/*">
            <small style="color:#aaa">Formatos: JPG, PNG, GIF, WEBP</small>
            
            <button type="submit">💾 Guardar cambios</button>
        </form>
        <a href="listar_noticias.php" class="back">← Volver a la lista</a>
    </div>
</body>
</html>
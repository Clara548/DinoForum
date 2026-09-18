<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$noticias = $pdo->query("SELECT * FROM noticia ORDER BY fecha DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Listar Noticias</title>
    <style>
        body { background: #1a3a2a; padding: 40px; font-family: Arial; color: white; }
        table { width: 100%; border-collapse: collapse; background: rgba(0,0,0,0.5); border-radius: 15px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e6b422; }
        th { background: #e6b422; color: #1a3a2a; }
        .acciones a { margin: 0 5px; color: #e6b422; text-decoration: none; }
        .back { display: inline-block; margin-bottom: 20px; color: #e6b422; text-decoration: none; }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back">← Volver al panel</a>
    <h1>📋 Lista de Noticias</h1>
    <table>
        <thead>
            <tr><th>ID</th><th>Título</th><th>Fecha</th><th>Autor</th><th>Acciones</th</thead>
        </thead>
        <tbody>
            <?php foreach ($noticias as $n): ?>
            <tr>
                <td><?= $n['id'] ?></td>
                <td><?= htmlspecialchars($n['titulo']) ?></td>
                <td><?= $n['fecha'] ?></td>
                <td><?= htmlspecialchars($n['autor'] ?: 'Admin') ?></td>
                <td class="acciones">
                    <a href="editar_noticia.php?id=<?= $n['id'] ?>">✏️ Editar</a>
                    <a href="eliminar_noticia.php?id=<?= $n['id'] ?>" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
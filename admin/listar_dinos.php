<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$dinos = $pdo->query("SELECT * FROM dinosaurio ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Listar Dinosaurios</title>
    <style>
        body { background: #1a3a2a; padding: 40px; font-family: Arial; color: white; }
        table { width: 100%; border-collapse: collapse; background: rgba(0,0,0,0.5); border-radius: 15px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e6b422; }
        th { background: #e6b422; color: #1a3a2a; }
        .acciones a { margin: 0 5px; color: #e6b422; text-decoration: none; }
        .acciones a:hover { text-decoration: underline; }
        .back { display: inline-block; margin-bottom: 20px; color: #e6b422; text-decoration: none; }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back">← Volver al panel</a>
    <h1>📋 Lista de Dinosaurios</h1>
    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Período</th><th>Dieta</th><th>Acciones</th</thead>
        </thead>
        <tbody>
            <?php foreach ($dinos as $d): ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= htmlspecialchars($d['nombre']) ?></td>
                <td><?= $d['periodo'] ?></td>
                <td><?= $d['dieta'] ?></td>
                <td class="acciones">
                    <a href="editar_dino.php?id=<?= $d['id'] ?>">✏️ Editar</a>
                    <a href="eliminar_dino.php?id=<?= $d['id'] ?>" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirmar']) && $_POST['confirmar'] == 'SI') {
        $id = $_SESSION['admin_id'];
        
        // Guardar log de eliminación
        if (!is_dir('../logs')) {
            mkdir('../logs', 0777, true);
        }
        $log = "Usuario ID $id eliminó sus datos el " . date('Y-m-d H:i:s') . " - IP: " . $_SERVER['REMOTE_ADDR'];
        file_put_contents('../logs/eliminaciones.log', $log . PHP_EOL, FILE_APPEND);
        
        // Eliminar datos personales del admin (conservamos usuario y contraseña para el login)
        $stmt = $pdo->prepare("UPDATE admin SET email = NULL, datos_extra = NULL WHERE id = ?");
        $stmt->execute([$id]);
        
        // Cerrar sesión
        session_destroy();
        
        $mensaje = '<div class="success">✅ Tus datos personales han sido eliminados. Serás redirigido...</div>';
        echo '<meta http-equiv="refresh" content="3; url=login.php">';
    } else {
        $mensaje = '<div class="error">❌ Debes escribir "SI" para confirmar la eliminación.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar mis datos</title>
    <style>
        body { background: #1a3a2a; padding: 40px; font-family: Arial; color: white; }
        .container { max-width: 500px; margin: 0 auto; background: rgba(0,0,0,0.5); padding: 30px; border-radius: 20px; }
        input, button { padding: 10px; margin: 10px 0; border-radius: 10px; border: none; }
        button { background: #e6b422; cursor: pointer; font-weight: bold; }
        .warning { color: #ff6b6b; }
        .success { background: #2d5a3b; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .error { background: #8b4513; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        a { color: #e6b422; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗑️ Eliminar mis datos personales</h1>
        <p>Esta acción eliminará tus datos personales (email, etc.) de nuestra base de datos.</p>
        <p class="warning"><strong>⚠️ Esta acción es irreversible.</strong></p>
        <form method="post">
            <p>Escribe <strong>SI</strong> para confirmar:</p>
            <input type="text" name="confirmar" placeholder="SI" required>
            <button type="submit">Eliminar mis datos</button>
        </form>
        <a href="dashboard.php">← Cancelar</a>
        <?php echo $mensaje; ?>
    </div>
</body>
</html>
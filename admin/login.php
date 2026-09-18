<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ruta absoluta a conexion.php
$conexion_path = dirname(__DIR__) . '/incluir/conexion.php';

if (!file_exists($conexion_path)) {
    die("❌ No se encuentra conexion.php en: " . $conexion_path);
}

require_once $conexion_path;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_usuario'] = $admin['usuario'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Usuario o contraseña incorrectos";
        }
    } catch (PDOException $e) {
        $error = "❌ Error de base de datos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin DinoForum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a3a2a, #0a1a10);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: rgba(30, 20, 15, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 30px;
            border: 2px solid #e6b422;
            width: 380px;
            text-align: center;
        }
        .login-card h1 {
            color: #e6b422;
            font-family: 'Cinzel', serif;
            margin: 20px 0;
        }
        .login-card input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 30px;
            border: 1px solid #e6b422;
            background: rgba(0,0,0,0.5);
            color: white;
            font-size: 16px;
        }
        .login-card button {
            width: 100%;
            padding: 14px;
            background: #e6b422;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }
        .error {
            color: #ff6b6b;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255,0,0,0.2);
            border-radius: 10px;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #e6b422;
            text-decoration: none;
        }
        i { font-size: 50px; }
    </style>
</head>
<body>
    <div class="login-card">
        <i>🦕</i>
        <h1>DinoForum Admin</h1>
        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="usuario" placeholder="Usuario" required autofocus>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <a href="../index.html" class="back-link">← Volver al sitio</a>
    </div>
</body>
</html>
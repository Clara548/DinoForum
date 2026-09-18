<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - DinoForum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #1a3a2a, #0a1a10);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            min-height: 100vh;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #e6b422;
            text-align: center;
            margin-bottom: 10px;
            font-family: 'Cinzel', serif;
        }
        .subtitle {
            text-align: center;
            color: #ccc;
            margin-bottom: 40px;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .card {
            background: rgba(30, 20, 15, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(230, 180, 34, 0.3);
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            border-color: #e6b422;
            box-shadow: 0 0 20px rgba(230, 180, 34, 0.2);
        }
        .card i {
            font-size: 3rem;
            color: #e6b422;
            margin-bottom: 15px;
        }
        .card h3 {
            color: #e6b422;
            margin-bottom: 10px;
        }
        .card p {
            color: #ccc;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background: #e6b422;
            color: #1a3a2a;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            margin: 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #c49a1a;
            transform: scale(1.05);
        }
        .btn-secondary {
            background: rgba(230, 180, 34, 0.2);
            color: #e6b422;
            border: 1px solid #e6b422;
        }
        .btn-danger {
            background: #8b4513;
            color: white;
        }
        .logout-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        .footer-links {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(230, 180, 34, 0.3);
        }
        .footer-links a {
            color: #e6b422;
            text-decoration: none;
            margin: 0 15px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <h1>🦕 DinoForum - Panel de Administración</h1>
        <p class="subtitle">Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_usuario'] ?? 'Admin'); ?></p>

        <div class="cards-grid">
            <!-- Dinosaurios -->
            <div class="card">
                <i class="fas fa-bone"></i>
                <h3>🦕 Dinosaurios</h3>
                <p>Gestiona la enciclopedia de dinosaurios: añade, edita o elimina especies.</p>
                <a href="agregar_dino.php" class="btn">➕ Agregar</a>
                <a href="listar_dinos.php" class="btn btn-secondary">📋 Listar</a>
            </div>

            <!-- Noticias -->
            <div class="card">
                <i class="fas fa-newspaper"></i>
                <h3>📰 Noticias</h3>
                <p>Publica y administra las últimas novedades del mundo jurásico.</p>
                <a href="agregar_noticia.php" class="btn">➕ Agregar</a>
                <a href="listar_noticias.php" class="btn btn-secondary">📋 Listar</a>
            </div>

            <!-- Ayuda -->
            <div class="card">
                <i class="fas fa-question-circle"></i>
                <h3>ℹ️ Ayuda</h3>
                <p>Consejos para usar el panel de administración correctamente.</p>
                <a href="ayuda.php" class="btn btn-secondary">📖 Ver Guía</a>
            </div>
        </div>

        <div class="logout-btn">
            <a href="logout.php" class="btn btn-danger">🚪 Cerrar sesión</a>
        </div>

        <div class="footer-links">
            <a href="../index.html">← Volver al sitio web</a>
            <a href="ayuda.php">📖 Ayuda</a>
            <a href="../politica-privacidad.html">Política de privacidad</a>
        </div>
    </div>
</body>
</html>
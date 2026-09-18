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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - Panel Admin DinoForum</title>
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
            color: #f0ecd8;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(30, 20, 15, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px;
            border: 1px solid #e6b422;
        }
        h1 {
            color: #e6b422;
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Cinzel', serif;
        }
        h2 {
            color: #e6b422;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        h3 {
            color: #cd7f32;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            background: rgba(230, 180, 34, 0.2);
            border: 1px solid #e6b422;
            padding: 10px 25px;
            border-radius: 30px;
            color: #e6b422;
            text-decoration: none;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: #e6b422;
            color: #1a3a2a;
        }
        ul, ol {
            margin-left: 30px;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .tip {
            background: rgba(230, 180, 34, 0.1);
            border-left: 4px solid #e6b422;
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
        }
        code {
            background: rgba(0,0,0,0.5);
            padding: 2px 8px;
            border-radius: 5px;
            font-family: monospace;
        }
        .warning {
            background: rgba(205, 127, 50, 0.2);
            border-left: 4px solid #cd7f32;
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
        }
        hr {
            border-color: rgba(230, 180, 34, 0.3);
            margin: 20px 0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-question-circle"></i> Guía de Ayuda</h1>
        <p style="text-align: center; margin-bottom: 20px;">Panel de Administración de DinoForum</p>

        <h2><i class="fas fa-bone"></i> Gestión de Dinosaurios</h2>
        <ul>
            <li><strong>➕ Agregar Dinosaurio:</strong> Completa todos los campos (nombre, período, dieta, tamaño, peso, descripción). La imagen es opcional. Si no subes imagen, se mostrará el icono por defecto.</li>
            <li><strong>✏️ Editar Dinosaurio:</strong> Puedes modificar cualquier campo de un dinosaurio existente. También puedes cambiar la imagen.</li>
            <li><strong>🗑️ Eliminar Dinosaurio:</strong> Se eliminará el dinosaurio y su imagen asociada del servidor. <span style="color: #ff6b6b;">☠️ Esta acción no se puede deshacer.</span></li>
            <li><strong>📋 Listar Dinosaurios:</strong> Muestra todos los dinosaurios con opciones de editar y eliminar.</li>
        </ul>

        <h2><i class="fas fa-newspaper"></i> Gestión de Noticias</h2>
        <ul>
            <li><strong>➕ Agregar Noticia:</strong> Escribe un título, contenido, autor y fecha. La imagen es opcional.</li>
            <li><strong>✏️ Editar Noticia:</strong> Modifica el título, contenido, fecha o autor de una noticia existente.</li>
            <li><strong>🗑️ Eliminar Noticia:</strong> Elimina permanentemente la noticia y su imagen asociada. <span style="color: #ff6b6b;">☠️ Esta acción no se puede deshacer.</span></li>
            <li><strong>📋 Listar Noticias:</strong> Muestra todas las noticias con opciones de editar y eliminar.</li>
        </ul>

        <h2><i class="fas fa-image"></i> Imágenes</h2>
        <ul>
            <li>Las imágenes se guardan automáticamente en la carpeta <code>../img/</code>.</li>
            <li>Formatos admitidos: <strong>JPG, PNG, GIF, WEBP</strong>.</li>
            <li>Si no subes una imagen al agregar, se mostrará el icono de garra por defecto.</li>
            <li>Al editar, puedes cambiar la imagen y la anterior se eliminará automáticamente.</li>
        </ul>

        <h2><i class="fas fa-search"></i> Búsqueda y Filtros (Página pública)</h2>
        <ul>
            <li>Los visitantes pueden buscar dinosaurios por nombre.</li>
            <li>Filtros disponibles: <strong>Período</strong> (Triásico, Jurásico, Cretácico) y <strong>Dieta</strong> (Carnívoro, Herbívoro, Omnívoro).</li>
            <li>Las noticias se pueden buscar por título y filtrar por fecha.</li>
        </ul>

        <h2><i class="fas fa-home"></i> Página Principal</h2>
        <ul>
            <li>La sección <strong>"NUEVO"</strong> muestra los últimos 20 elementos añadidos (dinosaurios + noticias mezclados).</li>
            <li>Cada tarjeta muestra la fecha de publicación y un badge indicando el tipo de contenido.</li>
            <li>Al hacer clic en una tarjeta se abre un modal con la información completa.</li>
        </ul>

        <div class="tip">
            <i class="fas fa-lightbulb" style="color: #e6b422;"></i>
            <strong>Consejo:</strong> Los dinosaurios y noticias que añadas aparecerán automáticamente en la página principal y en la sección "NUEVO" en el orden más reciente.
        </div>

        <div class="warning">
            <i class="fas fa-exclamation-triangle" style="color: #cd7f32;"></i>
            <strong>Nota importante:</strong> Las acciones de eliminar son irreversibles. Asegúrate antes de eliminar cualquier contenido.
        </div>

        <h2><i class="fas fa-lock"></i> Seguridad</h2>
        <ul>
            <li>Tu contraseña está cifrada en la base de datos (hash seguro).</li>
            <li>No compartas tus credenciales de acceso con nadie.</li>
            <li>Usa una contraseña segura (mínimo 8 caracteres, con mayúsculas, números y símbolos).</li>
            <li>Si sospechas que alguien ha accedido a tu cuenta, cambia tu contraseña inmediatamente.</li>
            <li><strong>Derecho al olvido:</strong> Puedes solicitar la eliminación de tus datos personales desde el panel.</li>
        </ul>

        <h2><i class="fas fa-question-circle"></i> Solución de problemas</h2>
        <ul>
            <li><strong>No se ven las imágenes:</strong> Verifica que la carpeta <code>../img/</code> tenga permisos 755.</li>
            <li><strong>Error 404 al agregar:</strong> Asegúrate de que los archivos PHP estén en la carpeta correcta.</li>
            <li><strong>No se cargan dinosaurios:</strong> Verifica la conexión a la base de datos en <code>incluir/conexion.php</code>.</li>
            <li><strong>El menú no se abre:</strong> Recarga la página con <kbd>Ctrl</kbd> + <kbd>F5</kbd> para limpiar la caché.</li>
        </ul>

        <hr>

        <p style="text-align: center; font-size: 0.85rem; opacity: 0.7;">
            <i class="fas fa-paw"></i> DinoForum v1.0 - Sistema de gestión de contenido
        </p>

        <div style="text-align: center;">
            <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al panel</a>
        </div>
    </div>
</body>
</html>
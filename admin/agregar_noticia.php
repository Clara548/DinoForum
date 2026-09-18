<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $titulo_en = $_POST['titulo_en'];
    $contenido = $_POST['contenido'];
    $contenido_en = $_POST['contenido_en'];
    $autor = $_POST['autor'];
    $fecha = $_POST['fecha'];
    
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = time() . '_noticia_' . uniqid() . '.' . $ext;
        $ruta = '../img/' . $imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }
    
    $sql = "INSERT INTO noticia (titulo, titulo_en, contenido, contenido_en, autor, fecha, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$titulo, $titulo_en, $contenido, $contenido_en, $autor, $fecha, $imagen])) {
        $mensaje = '<div class="success">✅ Noticia agregada correctamente</div>';
    } else {
        $mensaje = '<div class="error">❌ Error al agregar</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Noticia - Con Traducción</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a3a2a, #0a1a10);
            padding: 40px;
            font-family: 'Montserrat', sans-serif;
        }
        .form-container {
            max-width: 1300px;
            margin: 0 auto;
            background: rgba(30, 20, 15, 0.95);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #e6b422;
        }
        h1 { color: #e6b422; text-align: center; margin-bottom: 10px; font-family: 'Cinzel', serif; }
        .subtitle { text-align: center; color: #aaa; margin-bottom: 30px; font-size: 0.9rem; }
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
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .lang-col {
            flex: 1;
            min-width: 320px;
        }
        .lang-col h3 {
            color: #e6b422;
            font-size: 1.1rem;
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
        .separator { margin: 20px 0; border-top: 1px solid rgba(230, 180, 34, 0.3); }
        
        .editor-toolbar {
            background: #2d5a3b;
            padding: 8px;
            border-radius: 10px 10px 0 0;
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            border: 1px solid #e6b422;
            border-bottom: none;
        }
        .editor-toolbar button {
            background: #1a3a2a;
            border: 1px solid #e6b422;
            color: #e6b422;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            margin: 0;
            width: auto;
        }
        .editor-toolbar button:hover {
            background: #e6b422;
            color: #1a3a2a;
            transform: none;
        }
        .editor-textarea {
            width: 100%;
            padding: 12px;
            border-radius: 0 0 10px 10px;
            border: 1px solid #e6b422;
            background: rgba(0,0,0,0.5);
            color: white;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            resize: vertical;
            min-height: 250px;
        }
        .editor-info {
            font-size: 11px;
            color: #aaa;
            margin-top: 5px;
            text-align: right;
        }
        
        .auto-translate {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        .translate-btn {
            background: linear-gradient(135deg, #4285f4, #34a853);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            margin-top: 0;
            width: auto;
        }
        .translate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3);
        }
        .translate-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .translate-all {
            background: linear-gradient(135deg, #f4b942, #e6b422);
            color: #1a3a2a;
        }
        .translate-all:hover {
            box-shadow: 0 5px 15px rgba(230, 180, 34, 0.3);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>📰 Agregar Noticia</h1>
        <p class="subtitle"><i class="fas fa-language"></i> Escribe en español y usa los botones de traducción automática para inglés</p>
        <?php echo $mensaje; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="lang-row">
                <div class="lang-col">
                    <h3><i class="fas fa-flag"></i> 🇪🇸 Español</h3>
                    <label>Título *</label>
                    <input type="text" name="titulo" id="titulo_es" required>
                    <label>Contenido *</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('contenido_es', 'bold')"><b>N</b> Negrita</button>
                        <button type="button" onclick="formatText('contenido_es', 'italic')"><i>K</i> Cursiva</button>
                        <button type="button" onclick="formatText('contenido_es', 'underline')"><u>S</u> Subrayado</button>
                        <button type="button" onclick="formatText('contenido_es', 'insertOrderedList')">1. Lista</button>
                        <button type="button" onclick="formatText('contenido_es', 'insertUnorderedList')">• Lista</button>
                    </div>
                    <textarea id="contenido_es" name="contenido" class="editor-textarea" placeholder="Contenido en español..."></textarea>
                    <div class="editor-info"><i class="fas fa-info-circle"></i> Selecciona texto y haz clic en los botones</div>
                </div>
                <div class="lang-col">
                    <h3><i class="fas fa-flag"></i> 🇬🇧 English</h3>
                    <label>Title *</label>
                    <input type="text" name="titulo_en" id="titulo_en" required>
                    <label>Content *</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('contenido_en', 'bold')"><b>B</b> Bold</button>
                        <button type="button" onclick="formatText('contenido_en', 'italic')"><i>I</i> Italic</button>
                        <button type="button" onclick="formatText('contenido_en', 'underline')"><u>U</u> Underline</button>
                        <button type="button" onclick="formatText('contenido_en', 'insertOrderedList')">1. List</button>
                        <button type="button" onclick="formatText('contenido_en', 'insertUnorderedList')">• List</button>
                    </div>
                    <textarea id="contenido_en" name="contenido_en" class="editor-textarea" placeholder="Content in English..."></textarea>
                    <div class="editor-info"><i class="fas fa-info-circle"></i> Select text and click buttons</div>
                </div>
            </div>
            
            <div class="auto-translate">
                <button type="button" id="translateContenido" onclick="translateContenido()" class="translate-btn">
                    <i class="fas fa-language"></i> Traducir contenido al inglés
                </button>
                <button type="button" id="translateAll" onclick="translateAllNews()" class="translate-btn translate-all">
                    <i class="fas fa-globe"></i> Traducir TODO al inglés
                </button>
            </div>
            
            <div class="separator"></div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>👤 Autor</label>
                    <input type="text" name="autor" id="autor" placeholder="Ej: Admin DinoForum">
                </div>
                <div class="lang-col">
                    <label>📅 Fecha *</label>
                    <input type="date" name="fecha" id="fecha" required>
                </div>
            </div>
            
            <div class="separator"></div>
            
            <label>🖼️ Imagen (opcional)</label>
            <input type="file" name="imagen" accept="image/*">
            <small style="color:#aaa">Formatos: JPG, PNG, GIF, WEBP</small>
            
            <button type="submit">💾 Guardar Noticia</button>
        </form>
        <a href="dashboard.php" class="back">← Volver al panel</a>
    </div>
    
    <script>
        async function translateText(text, targetLang = 'en', sourceLang = 'es') {
            if (!text.trim()) return '';
            try {
                const url = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=${sourceLang}|${targetLang}`;
                const response = await fetch(url);
                const data = await response.json();
                return data.responseData.translatedText;
            } catch (error) {
                console.error('Error de traducción:', error);
                return text;
            }
        }
        
        async function translateContenido() {
            const espanolText = document.getElementById('contenido_es').value;
            if (!espanolText.trim()) {
                alert('Primero escribe algo en español en el campo de contenido.');
                return;
            }
            const btn = document.getElementById('translateContenido');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traduciendo contenido...';
            try {
                const translated = await translateText(espanolText);
                document.getElementById('contenido_en').value = translated;
                alert('¡Contenido traducido al inglés!');
            } catch (error) {
                alert('Error al traducir. Intenta de nuevo.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-language"></i> Traducir contenido al inglés';
            }
        }
        
        async function translateAllNews() {
            const tituloEs = document.getElementById('titulo_es').value;
            const contenidoEs = document.getElementById('contenido_es').value;
            
            if (!tituloEs.trim()) {
                alert('Primero escribe el título de la noticia en español.');
                return;
            }
            
            const btn = document.getElementById('translateAll');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traduciendo todo...';
            
            try {
                if (tituloEs.trim()) {
                    const tituloEn = await translateText(tituloEs);
                    document.getElementById('titulo_en').value = tituloEn;
                }
                if (contenidoEs.trim()) {
                    const contenidoEn = await translateText(contenidoEs);
                    document.getElementById('contenido_en').value = contenidoEn;
                }
                alert('¡Todo el contenido ha sido traducido al inglés!');
            } catch (error) {
                alert('Error al traducir. Intenta de nuevo.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-globe"></i> Traducir TODO al inglés';
            }
        }
        
        function formatText(textareaId, command) {
            const textarea = document.getElementById(textareaId);
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            let insertText = '';
            let newStart = start;
            let newEnd = end;
            
            switch(command) {
                case 'bold':
                    insertText = '**' + selectedText + '**';
                    newStart = start + 2;
                    newEnd = end + 2;
                    break;
                case 'italic':
                    insertText = '_' + selectedText + '_';
                    newStart = start + 1;
                    newEnd = end + 1;
                    break;
                case 'underline':
                    insertText = '__' + selectedText + '__';
                    newStart = start + 2;
                    newEnd = end + 2;
                    break;
                case 'insertOrderedList':
                    insertText = (start > 0 ? '\n' : '') + '1. ' + selectedText + (selectedText ? '\n' : '');
                    newStart = start + (start > 0 ? 4 : 3);
                    newEnd = end + (start > 0 ? 4 : 3) + (selectedText ? 1 : 0);
                    break;
                case 'insertUnorderedList':
                    insertText = (start > 0 ? '\n' : '') + '- ' + selectedText + (selectedText ? '\n' : '');
                    newStart = start + (start > 0 ? 3 : 2);
                    newEnd = end + (start > 0 ? 3 : 2) + (selectedText ? 1 : 0);
                    break;
                default:
                    insertText = selectedText;
            }
            
            textarea.value = textarea.value.substring(0, start) + insertText + textarea.value.substring(end);
            textarea.focus();
            if (selectedText) {
                textarea.setSelectionRange(newStart, newEnd);
            } else {
                textarea.setSelectionRange(newStart, newStart);
            }
        }
    </script>
</body>
</html>
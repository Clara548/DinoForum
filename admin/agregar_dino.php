<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../incluir/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nombre_en = $_POST['nombre_en'];
    $cientifico = $_POST['cientifico'];
    $cientifico_en = $_POST['cientifico_en'];
    $anio_descubrimiento = $_POST['anio_descubrimiento'];
    $periodo = $_POST['periodo'];
    $periodo_en = $_POST['periodo_en'];
    $dieta = $_POST['dieta'];
    $dieta_en = $_POST['dieta_en'];
    $tamano = $_POST['tamano'];
    $tamano_en = $_POST['tamano_en'];
    $peso = $_POST['peso'];
    $peso_en = $_POST['peso_en'];
    $descripcion = $_POST['descripcion'];
    $descripcion_en = $_POST['descripcion_en'];
    
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = time() . '_' . uniqid() . '.' . $ext;
        $ruta = '../img/' . $imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }
    
    $sql = "INSERT INTO dinosaurio (nombre, nombre_en, nombre_cientifico, nombre_cientifico_en, anio_descubrimiento, 
            periodo, periodo_en, dieta, dieta_en, tamano, tamano_en, peso, peso_en, descripcion, descripcion_en, imagen, fecha_registro) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nombre, $nombre_en, $cientifico, $cientifico_en, $anio_descubrimiento, 
        $periodo, $periodo_en, $dieta, $dieta_en, $tamano, $tamano_en, $peso, $peso_en, $descripcion, $descripcion_en, $imagen])) {
        $mensaje = '<div class="success">✅ Dinosaurio agregado correctamente</div>';
    } else {
        $mensaje = '<div class="error">❌ Error al agregar</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Dinosaurio - Con Traducción</title>
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
        
        /* Estilos del editor */
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
            min-height: 200px;
        }
        .editor-info {
            font-size: 11px;
            color: #aaa;
            margin-top: 5px;
            text-align: right;
        }
        
        /* Botón de traducción automática */
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
        <h1>➕ Agregar Dinosaurio</h1>
        <p class="subtitle"><i class="fas fa-language"></i> Escribe en español y usa los botones de traducción automática para inglés</p>
        <?php echo $mensaje; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="lang-row">
                <div class="lang-col">
                    <h3><i class="fas fa-flag"></i> 🇪🇸 Español</h3>
                    <label>Nombre *</label>
                    <input type="text" name="nombre" id="nombre_es" required>
                    <label>Nombre científico</label>
                    <input type="text" name="cientifico" id="cientifico_es">
                    <label>Descripción</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('descripcion_es', 'bold')"><b>N</b> Negrita</button>
                        <button type="button" onclick="formatText('descripcion_es', 'italic')"><i>K</i> Cursiva</button>
                        <button type="button" onclick="formatText('descripcion_es', 'underline')"><u>S</u> Subrayado</button>
                        <button type="button" onclick="formatText('descripcion_es', 'insertOrderedList')">1. Lista</button>
                        <button type="button" onclick="formatText('descripcion_es', 'insertUnorderedList')">• Lista</button>
                    </div>
                    <textarea id="descripcion_es" name="descripcion" class="editor-textarea" placeholder="Descripción en español..."></textarea>
                    <div class="editor-info"><i class="fas fa-info-circle"></i> Selecciona texto y haz clic en los botones</div>
                </div>
                <div class="lang-col">
                    <h3><i class="fas fa-flag"></i> 🇬🇧 English</h3>
                    <label>Name *</label>
                    <input type="text" name="nombre_en" id="nombre_en" required>
                    <label>Scientific name</label>
                    <input type="text" name="cientifico_en" id="cientifico_en">
                    <label>Description</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('descripcion_en', 'bold')"><b>B</b> Bold</button>
                        <button type="button" onclick="formatText('descripcion_en', 'italic')"><i>I</i> Italic</button>
                        <button type="button" onclick="formatText('descripcion_en', 'underline')"><u>U</u> Underline</button>
                        <button type="button" onclick="formatText('descripcion_en', 'insertOrderedList')">1. List</button>
                        <button type="button" onclick="formatText('descripcion_en', 'insertUnorderedList')">• List</button>
                    </div>
                    <textarea id="descripcion_en" name="descripcion_en" class="editor-textarea" placeholder="Description in English..."></textarea>
                    <div class="editor-info"><i class="fas fa-info-circle"></i> Select text and click buttons</div>
                </div>
            </div>
            
            <!-- Botones de traducción automática -->
            <div class="auto-translate">
                <button type="button" id="translateDescripcion" onclick="translateDescripcion()" class="translate-btn">
                    <i class="fas fa-language"></i> Traducir descripción al inglés
                </button>
                <button type="button" id="translateAll" onclick="translateAll()" class="translate-btn translate-all">
                    <i class="fas fa-globe"></i> Traducir TODO al inglés
                </button>
            </div>
            
            <div class="separator"></div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>📅 Año de descubrimiento</label>
                    <input type="text" name="anio_descubrimiento" id="anio" placeholder="Ej: 1889">
                </div>
                <div class="lang-col">
                    <label>🌿 Período</label>
                    <input type="text" name="periodo" id="periodo" placeholder="Ej: Cretácico">
                </div>
            </div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>🍖 Dieta</label>
                    <input type="text" name="dieta" id="dieta" placeholder="Ej: Carnívoro">
                </div>
                <div class="lang-col">
                    <label>📏 Tamaño</label>
                    <input type="text" name="tamano" id="tamano" placeholder="Ej: 12 metros">
                </div>
            </div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>⚖️ Peso</label>
                    <input type="text" name="peso" id="peso" placeholder="Ej: 7 toneladas">
                </div>
                <div class="lang-col">
                    <label>🌿 Period (English)</label>
                    <input type="text" name="periodo_en" id="periodo_en" placeholder="Ex: Cretaceous">
                </div>
            </div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>🍖 Diet (English)</label>
                    <input type="text" name="dieta_en" id="dieta_en" placeholder="Ex: Carnivore">
                </div>
                <div class="lang-col">
                    <label>📏 Size (English)</label>
                    <input type="text" name="tamano_en" id="tamano_en" placeholder="Ex: 12 meters">
                </div>
            </div>
            
            <div class="lang-row">
                <div class="lang-col">
                    <label>⚖️ Weight (English)</label>
                    <input type="text" name="peso_en" id="peso_en" placeholder="Ex: 7 tons">
                </div>
                <div class="lang-col"></div>
            </div>
            
            <div class="separator"></div>
            
            <label>🖼️ Imagen / Image</label>
            <input type="file" name="imagen" accept="image/*">
            <small style="color:#aaa">Formatos: JPG, PNG, GIF, WEBP</small>
            
            <button type="submit">💾 Guardar Dinosaurio</button>
        </form>
        <a href="dashboard.php" class="back">← Volver al panel</a>
    </div>
    
    <script>
        // Función para traducir texto usando MyMemory API
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
        
        // Traducir solo la descripción
        async function translateDescripcion() {
            const espanolText = document.getElementById('descripcion_es').value;
            
            if (!espanolText.trim()) {
                alert('Primero escribe algo en español en el campo de descripción.');
                return;
            }
            
            const btn = document.getElementById('translateDescripcion');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traduciendo descripción...';
            
            try {
                const translated = await translateText(espanolText);
                document.getElementById('descripcion_en').value = translated;
                alert('¡Descripción traducida al inglés!');
            } catch (error) {
                alert('Error al traducir. Intenta de nuevo.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-language"></i> Traducir descripción al inglés';
            }
        }
        
        // Traducir todo el contenido
        async function translateAll() {
            const nombreEs = document.getElementById('nombre_es').value;
            const cientificoEs = document.getElementById('cientifico_es').value;
            const descripcionEs = document.getElementById('descripcion_es').value;
            const periodoEs = document.getElementById('periodo').value;
            const dietaEs = document.getElementById('dieta').value;
            const tamanoEs = document.getElementById('tamano').value;
            const pesoEs = document.getElementById('peso').value;
            
            if (!nombreEs.trim()) {
                alert('Primero escribe el nombre del dinosaurio en español.');
                return;
            }
            
            const btn = document.getElementById('translateAll');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traduciendo todo...';
            
            try {
                // Traducir nombre
                if (nombreEs.trim()) {
                    const nombreEn = await translateText(nombreEs);
                    document.getElementById('nombre_en').value = nombreEn;
                }
                
                // Traducir nombre científico
                if (cientificoEs.trim()) {
                    const cientificoEn = await translateText(cientificoEs);
                    document.getElementById('cientifico_en').value = cientificoEn;
                }
                
                // Traducir descripción
                if (descripcionEs.trim()) {
                    const descripcionEn = await translateText(descripcionEs);
                    document.getElementById('descripcion_en').value = descripcionEn;
                }
                
                // Traducir período
                if (periodoEs.trim()) {
                    const periodoEn = await translateText(periodoEs);
                    document.getElementById('periodo_en').value = periodoEn;
                }
                
                // Traducir dieta
                if (dietaEs.trim()) {
                    const dietaEn = await translateText(dietaEs);
                    document.getElementById('dieta_en').value = dietaEn;
                }
                
                // Traducir tamaño
                if (tamanoEs.trim()) {
                    const tamanoEn = await translateText(tamanoEs);
                    document.getElementById('tamano_en').value = tamanoEn;
                }
                
                // Traducir peso
                if (pesoEs.trim()) {
                    const pesoEn = await translateText(pesoEs);
                    document.getElementById('peso_en').value = pesoEn;
                }
                
                alert('¡Todo el contenido ha sido traducido al inglés!');
            } catch (error) {
                alert('Error al traducir. Intenta de nuevo.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-globe"></i> Traducir TODO al inglés';
            }
        }
        
        // Función para formato de texto
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
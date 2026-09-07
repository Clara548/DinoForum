<?php
$host = 'sql210.infinityfree.com';
$bd = 'if0_41744251_dinoforum';
$user = 'if0_41744251';
$pass = 'PFyOkUFexEhW';

echo "🔌 Probando conexión...<br><br>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión exitosa a la base de datos<br>";
    
    // Verificar si existen las tablas
    $tables = ['dinosaurio', 'noticia', 'admin'];
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            echo "✅ Tabla '$table' existe<br>";
        } else {
            echo "❌ Tabla '$table' NO existe<br>";
        }
    }
    
} catch(PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
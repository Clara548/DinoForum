<?php
$host = 'sql210.infinityfree.com';
$bd = 'if0_41744251_dinoforum';
$user = 'if0_41744251';
$pass = 'PFyOkUFexEhW';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die(json_encode(['error' => 'Conexión fallida: ' . $e->getMessage()]));
}
?>
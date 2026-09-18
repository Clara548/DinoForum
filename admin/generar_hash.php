<?php
// Contraseña que quieres usar
$password = 'Dinosaurio2004C?';

// Generar el hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Contraseña: " . $password . "<br>";
echo "Hash generado: " . $hash . "<br><br>";
echo "Copia este hash y actualiza la base de datos:<br>";
echo "<strong style='background:#333; color:#0f0; padding:10px; display:inline-block;'>" . $hash . "</strong>";
?>
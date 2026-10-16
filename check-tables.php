<?php
// Conectar a la base de datos (lee credenciales del entorno, sin hardcodear secretos)
$servername = getenv('WORDPRESS_DB_HOST') ?: "db";
$username = getenv('WORDPRESS_DB_USER') ?: "cuerpolibre_user";
$password = getenv('WORDPRESS_DB_PASSWORD') ?: "";
$dbname = getenv('WORDPRESS_DB_NAME') ?: "cuerpolibre_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<p style='color:red'><b>Error de conexión a la base de datos:</b> " . $conn->connect_error . "</p>");
}

echo "<h1>Tablas de la base de datos $dbname:</h1>";

// Obtener tablas
$result = $conn->query("SHOW TABLES");

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        $table = array_values($row)[0];
        echo "<li>$table</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:orange'><b>La base de datos no tiene tablas. Es una instalación nueva.</b></p>";
}

$conn->close();

echo "<h2>Iniciar instalación de WordPress:</h2>";
echo "<p>Si no hay tablas, debes instalar WordPress accediendo a <a href='http://localhost:9005/wp-admin/setup-config.php' style='color:blue'>http://localhost:9005/wp-admin/setup-config.php</a></p>";

<?php
// Habilitar debug
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

// Cargar WordPress
require __DIR__ . '/wp-load.php';

echo "<h1>Información de WordPress:</h1>";
echo "<p><b>Versión:</b> " . get_bloginfo('version') . "</p>";
echo "<p><b>Tema activo:</b> " . get_stylesheet() . "</p>";
echo "<p><b>Plugins activos:</b> " . count(get_option('active_plugins')) . "</p>";

echo "<h2>Plugins instalados:</h2>";
$plugins = get_plugins();
if (!empty($plugins)) {
    echo "<ul>";
    foreach ($plugins as $plugin_file => $plugin_data) {
        $status = is_plugin_active($plugin_file) ? "<span style='color:green'>Activo</span>" : "<span style='color:orange'>Inactivo</span>";
        echo "<li>" . $plugin_data['Name'] . " v" . $plugin_data['Version'] . " - " . $status . "</li>";
    }
    echo "</ul>";
}

echo "<h2>Errores de WordPress (wp-content/debug.log):</h2>";
if (file_exists(__DIR__ . '/wp-content/debug.log')) {
    $errors = file(__DIR__ . '/wp-content/debug.log');
    if (!empty($errors)) {
        echo "<div style='background:#f0f0f0; padding:10px; border:1px solid #ccc; max-height:300px; overflow-y:scroll;'>";
        foreach ($errors as $line) {
            echo nl2br(htmlspecialchars($line)) . "<br>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay errores en el log.</p>";
    }
} else {
    echo "<p>El archivo debug.log no existe. WordPress generará uno cuando haya errores.</p>";
}

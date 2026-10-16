<?php
// Habilitar debug
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

// Cargar WordPress
require __DIR__ . '/wp-load.php';

echo "<h1>Estado de Themes y Plugins</h1>";

// Verificar Themes
echo "<h2>Themes instalados:</h2>";
$themes = wp_get_themes();
if (!empty($themes)) {
    echo "<ul>";
    foreach ($themes as $theme) {
        $status = wp_get_theme()->get('Name') === $theme->get('Name') ? 
            "<span style='color:green'><b>Activo</b></span>" : 
            "<span style='color:orange'>Inactivo</span>";
        echo "<li>" . $theme->get('Name') . " v" . $theme->get('Version') . " - " . $status . "</li>";
    }
    echo "</ul>";
}

// Verificar Plugins
echo "<h2>Plugins instalados:</h2>";
$plugins = get_plugins();
$active_plugins = get_option('active_plugins');
if (!empty($plugins)) {
    echo "<ul>";
    foreach ($plugins as $plugin_file => $plugin_data) {
        $status = in_array($plugin_file, $active_plugins) ? 
            "<span style='color:green'><b>Activo</b></span>" : 
            "<span style='color:orange'>Inactivo</span>";
        echo "<li>" . $plugin_data['Name'] . " v" . $plugin_data['Version'] . " - " . $status . "</li>";
    }
    echo "</ul>";
}

// Verificar rutas de wp-content
echo "<h2>Rutas del sistema:</h2>";
echo "<p><b>ABSPATH:</b> " . ABSPATH . "</p>";
echo "<p><b>WP_CONTENT_DIR:</b> " . WP_CONTENT_DIR . "</p>";
echo "<p><b>WP_PLUGIN_DIR:</b> " . WP_PLUGIN_DIR . "</p>";
echo "<p><b>WP_CONTENT_URL:</b> " . WP_CONTENT_URL . "</p>";
echo "<p><b>Tema activo actual:</b> " . get_stylesheet() . "</p>";

// Verificar permisos
echo "<h2>Permisos:</h2>";
$wp_content_perms = substr(sprintf('%o', fileperms(WP_CONTENT_DIR)), -3);
$plugins_perms = substr(sprintf('%o', fileperms(WP_PLUGIN_DIR)), -3);
$themes_perms = substr(sprintf('%o', fileperms(get_theme_root())), -3);

echo "<p><b>wp-content/:</b> " . $wp_content_perms . "</p>";
echo "<p><b>wp-content/plugins/:</b> " . $plugins_perms . "</p>";
echo "<p><b>wp-content/themes/:</b> " . $themes_perms . "</p>";

// Verificar archivos de tema activo
echo "<h2>Archivos del tema activo:</h2>";
$theme_dir = get_template_directory();
if (is_dir($theme_dir)) {
    $theme_files = scandir($theme_dir);
    echo "<ul>";
    foreach ($theme_files as $file) {
        if ($file != '.' && $file != '..') {
            $file_path = $theme_dir . '/' . $file;
            $size = is_dir($file_path) ? ' - Carpeta' : ' - ' . filesize($file_path) . ' bytes';
            echo "<li>" . $file . $size . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>El directorio del tema activo no existe: " . $theme_dir . "</p>";
}

// Verificar errores en el log
echo "<h2>Errores de WordPress:</h2>";
$debug_log = WP_CONTENT_DIR . '/debug.log';
if (file_exists($debug_log)) {
    $errors = file($debug_log);
    if (!empty($errors)) {
        echo "<div style='background:#f0f0f0; padding:10px; border:1px solid #ccc; max-height:300px; overflow-y:scroll;'>";
        foreach ($errors as $line) {
            echo nl2br(htmlspecialchars($line)) . "<br>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay errores en el log de debug.</p>";
    }
} else {
    echo "<p>El archivo debug.log no existe. Generado al acceder a la página principal.</p>";
}

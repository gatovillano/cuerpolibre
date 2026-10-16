<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

$args = array(
    'post_type' => 'property',
    'name' => 'edificio-optimus',
    'posts_per_page' => 1
);
$posts = get_posts($args);
if ($posts) {
    $post = $posts[0];
    echo "ID: " . $post->ID . "\n";
    $meta = get_post_meta($post->ID);
    foreach ($meta as $key => $values) {
        if (strpos($key, 'gallery') !== false || strpos($key, 'image') !== false) {
            echo "$key: " . implode(', ', $values) . "\n";
        }
    }
} else {
    echo "Property not found\n";
}

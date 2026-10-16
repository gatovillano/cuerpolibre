<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

$args = array(
    'post_type' => 'property',
    'posts_per_page' => 10
);
$posts = get_posts($args);
foreach ($posts as $post) {
    echo "ID: " . $post->ID . " | Slug: " . $post->post_name . "\n";
}
